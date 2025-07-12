<?php

namespace Bitrix\BitUp24\Repository;

use Bitrix\Main\Application;
use Bitrix\Main\Type\DateTime;

class BitUpRepository
{
	private \Bitrix\Main\DB\Connection $db;
	private \Bitrix\Main\DB\SqlHelper $helper;

	public function __construct()
	{
		$this->db = Application::getConnection();
		$this->helper = $this->db->getSqlHelper();
	}

	/**
	 * Получить активные челленджи (мероприятия)
	 */
	public function getActiveChallenges(): array
	{
		$now = new DateTime();

		$sql = "
            SELECT e.id, e.name, e.description, e.start_date, e.end_date, e.points_for_visit,
                   e.max_participants, e.status, e.organizer_id
            FROM b_bitup_events e
            LEFT JOIN b_bitup_event_registrations r ON r.event_id = e.id AND r.status = 'approved'
            WHERE e.status = 'active'
              AND (e.end_date IS NULL OR e.end_date >= '{$now->format('Y-m-d H:i:s')}')
            GROUP BY e.id
            ORDER BY e.start_date ASC
        ";

		return $this->db->query($sql)->fetchAll();
	}

	/**
	 * Получить заряд пользователя (points_balance)
	 */
	public function getUserEnergy(int $userId): int
	{
		$userId = (int)$userId;
		$sql = "
			SELECT points_balance
			FROM b_bitup_user_points
			WHERE user_id = {$userId}
		";

		$result = $this->db->query($sql)->fetch();

		return $result? (int)$result['points_balance'] : 0;
	}

	/**
	 * Получить приглашения пользователя (на события со статусом pending)
	 */
	public function getUserInvites(int $userId): array
	{
		$userId = (int)$userId;
		$sql = "
			SELECT r.event_id, e.name AS event_name, e.organizer_id
			FROM b_bitup_event_registrations r
			JOIN b_bitup_events e ON e.id = r.event_id
			WHERE r.user_id = {$userId} AND r.status = 'pending'
		";

		return $this->db->query($sql)->fetchAll();
	}

	/**
	 * Получить информацию о пользователе (заглушка — обычно из Bitrix user table)
	 */
	public function getUserInfo(int $userId): array
	{
		$rsUser = \CUser::GetByID($userId);
		if ($user = $rsUser->Fetch())
		{
			return [
				'id' => $user['ID'],
				'name' => trim($user['NAME'] . ' ' . $user['LAST_NAME']),
				'avatar' => \CFile::GetPath($user['PERSONAL_PHOTO']),
			];
		}

		return [];
	}

	/**
	 * Получить статистику по мероприятию (likes, участники, макс. лимит и т.д.)
	 */
	public function getChallengeStats(int $eventId): array
	{
		$sql = "
			SELECT
				COUNT(*) AS total_participants,
				SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved_participants
			FROM b_bitup_event_registrations
			WHERE event_id = {$eventId}
		";

		$result = $this->db->query($sql)->fetch();

		return [
			'approved_participants' => (int)($result['approved_participants'] ?? 0),
		];
	}

	/**
	 * Вставить событие в бд и вернуть его ID
	 *
	 * @param array $fields [
	 *   'NAME', 'DESCRIPTION', 'START_DATE', 'END_DATE',
	 *   'LOCATION', 'ORGANIZER_ID', 'POINTS_FOR_VISIT',
	 *   'MAX_PARTICIPANTS', 'STATUS'
	 * ]
	 * @return int
	 * @throws \Bitrix\Main\Db\SqlQueryException
	 */
	public function createEvent(array $fields): int
	{
		// экранируем строковые поля
		$name = $this->helper->forSql($fields['NAME']);
		$description = $this->helper->forSql($fields['DESCRIPTION']);
		$start = $this->helper->forSql($fields['START_DATE']);
		$end = $fields['END_DATE']
			? "'" . $this->helper->forSql($fields['END_DATE']) . "'"
			: 'NULL';
		$location = $this->helper->forSql($fields['LOCATION']);
		$organizer = (int)$fields['ORGANIZER_ID'];
		$points = (int)$fields['POINTS_FOR_VISIT'];
		$maxPar = (int)$fields['MAX_PARTICIPANTS'];
		$status = $this->helper->forSql($fields['STATUS']);

		$sql = "
            INSERT INTO b_bitup_events
              (name, description, start_date, end_date, location,
               organizer_id, points_for_visit, max_participants, status)
            VALUES
              ('{$name}', '{$description}', '{$start}', {$end}, '{$location}',
               {$organizer}, {$points}, {$maxPar}, '{$status}')
        ";

		$this->db->query($sql);
		return (int)$this->db->getInsertedId();
	}

	/**
	 * Получить данные одного события по ID
	 *
	 * @param int $eventId
	 * @return array|null
	 */
	public function getEventById(int $eventId): ?array
	{
		$eventId = (int)$eventId;
		$sql = "
			SELECT 
				e.id, e.name, e.description, e.start_date, e.end_date, 
				e.location, e.points_for_visit, e.max_participants
			FROM b_bitup_events e
			WHERE e.id = {$eventId}
			  AND e.status = 'active'
		";

		$event = $this->db->query($sql)->fetch();
		if (!$event) {
			return null;
		}

		// Дополним статистикой участников
		$stats = $this->getChallengeStats($eventId);
		$event['APPROVED_PARTICIPANTS'] = $stats['approved_participants'];

		return $event;
	}

	/**
	 * Проверить, зарегистрирован ли пользователь на событие
	 */
	public function isUserRegisteredForEvent(int $userId, int $eventId): bool
	{
		$userId = (int)$userId;
		$eventId = (int)$eventId;

		$sql = "
			SELECT COUNT(*) as cnt
			FROM b_bitup_event_registrations
			WHERE user_id = {$userId} AND event_id = {$eventId}
		";

		$result = $this->db->query($sql)->fetch();
		return (int)$result['cnt'] > 0;
	}

	/**
	 * Получить количество зарегистрированных участников события
	 */
	public function getEventParticipantsCount(int $eventId): int
	{
		$eventId = (int)$eventId;

		$sql = "
			SELECT COUNT(*) as cnt
			FROM b_bitup_event_registrations
			WHERE event_id = {$eventId} AND status = 'approved'
		";

		$result = $this->db->query($sql)->fetch();
		return (int)$result['cnt'];
	}

	/**
	 * Зарегистрировать пользователя на событие
	 */
	public function registerUserForEvent(int $userId, int $eventId): int
	{
		$userId = (int)$userId;
		$eventId = (int)$eventId;
		$now = new DateTime();

		$fields = [
			'user_id' => $userId,
			'event_id' => $eventId,
			'status' => 'approved',
			'registration_date' => $now
		];

		return $this->db->add('b_bitup_event_registrations', $fields);
	}

	/**
	 * Отменить регистрацию пользователя на событие
	 */
	public function unregisterUserFromEvent(int $userId, int $eventId): bool
	{
		$userId = (int)$userId;
		$eventId = (int)$eventId;

		$sql = "
			DELETE FROM b_bitup_event_registrations
			WHERE user_id = {$userId} AND event_id = {$eventId}
		";

		$this->db->query($sql);
		return true;
	}
}
