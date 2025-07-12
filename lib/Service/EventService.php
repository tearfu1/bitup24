<?php

namespace Bitrix\BitUp24\Service;

use Bitrix\Main\Loader;
use Bitrix\Main\Result;
use Bitrix\Main\Error;
use Bitrix\BitUp24\Repository\BitUpRepository;

final class EventService
{
	private BitUpRepository $repository;

	public function __construct()
	{
		Loader::includeModule('main');
		$this->repository = new BitUpRepository();
	}

	/**
	 * Получить все данные для AJAX-дашборда
	 */
	public function getDashboardData(int $userId): array
	{
		$challenges = $this->repository->getActiveChallenges();
		$energy = $this->repository->getUserEnergy($userId);
		$invites = $this->repository->getUserInvites($userId);
		$userInfo = $this->repository->getUserInfo($userId);

		// Добавим статистику к каждому челленджу
		foreach ($challenges as &$challenge)
		{
			$challenge['stats'] = $this->repository->getChallengeStats($challenge['id']);
		}

		return [
			'challenges' => $challenges,
			'energy' => $energy,
			'invites' => $invites,
			'user' => $userInfo,
		];
	}

	/**
	 * Получить список активных челленджей
	 */
	public function getActiveChallenges(): array
	{
		return $this->repository->getActiveChallenges();
	}

	/**
	 * Получить текущую энергию пользователя
	 */
	public function getUserEnergy(int $userId): int
	{
		return $this->repository->getUserEnergy($userId);
	}

	/**
	 * Получить список приглашений пользователя
	 */
	public function getUserInvites(int $userId): array
	{
		return $this->repository->getUserInvites($userId);
	}

	/**
	 * Получить данные о пользователе
	 */
	public function getUserInfo(int $userId): array
	{
		return $this->repository->getUserInfo($userId);
	}

	/**
	 * Получить статистику по определенному челленджу
	 */
	public function getChallengeStats(int $challengeId): array
	{
		return $this->repository->getChallengeStats($challengeId);
	}

	/**
	 * Добавить новое событие
	 *
	 * @param array $data
	 * @param int $organizerId
	 * @return Result with "eventId" on success
	 */
	public function addEvent(array $data, int $organizerId): Result
	{
		$result = new Result();

		// базовая валидация
		if (empty($data['name']))
		{
			$result->addError(new Error('Название события обязательно'));
			return $result;
		}
		if (empty($data['start_date']))
		{
			$result->addError(new Error('Дата начала обязательна'));
			return $result;
		}

		// приводим к нужным типам
		$fields = [
			'NAME' => trim($data['name']),
			'DESCRIPTION' => trim($data['description'] ?? ''),
			'START_DATE' => trim($data['start_date']),
			'END_DATE' => trim($data['end_date'] ?? ''),
			'LOCATION' => trim($data['location'] ?? ''),
			'ORGANIZER_ID' => $organizerId,
			'POINTS_FOR_VISIT' => (int)($data['points_for_visit'] ?? 0),
			'MAX_PARTICIPANTS' => (int)($data['max_participants'] ?? 0),
			'STATUS' => 'active',
		];

		try
		{
			$eventId = $this->repository->createEvent($fields);
			$result->setData(['eventId' => $eventId]);
		}
		catch (\Throwable $e)
		{
			$result->addError(new Error('Ошибка при создании события: ' . $e->getMessage()));
		}

		return $result;
	}

	/**
	 * Получ��ть детальные данные события
	 *
	 * @param int $eventId
	 * @return array|null
	 */
	public function getEventDetail(int $eventId): ?array
	{
		return $this->repository->getEventById($eventId);
	}

	/**
	 * Зарегистрировать пользователя на событие
	 *
	 * @param int $userId
	 * @param int $eventId
	 * @return Result
	 */
	public function registerUserForEvent(int $userId, int $eventId): Result
	{
		$result = new Result();

		// Проверяем, существует ли событие
		$event = $this->repository->getEventById($eventId);
		if (!$event) {
			$result->addError(new Error('Событие не найдено'));
			return $result;
		}

		// Проверяем, не зарегистрирован ли уже пользователь
		if ($this->repository->isUserRegisteredForEvent($userId, $eventId)) {
			$result->addError(new Error('Вы уже зарегистрированы на это событие'));
			return $result;
		}

		// Проверяем лимит участников
		if ($event['max_participants'] > 0) {
			$currentCount = $this->repository->getEventParticipantsCount($eventId);
			if ($currentCount >= $event['max_participants']) {
				$result->addError(new Error('Достигнут максимальный лимит участников'));
				return $result;
			}
		}

		try {
			$registrationId = $this->repository->registerUserForEvent($userId, $eventId);
			$result->setData(['registrationId' => $registrationId]);
		} catch (\Throwable $e) {
			$result->addError(new Error('Ошибка при регистрации на событие: ' . $e->getMessage()));
		}

		return $result;
	}

	/**
	 * Отменить регистрацию пользователя на событие
	 *
	 * @param int $userId
	 * @param int $eventId
	 * @return Result
	 */
	public function unregisterUserFromEvent(int $userId, int $eventId): Result
	{
		$result = new Result();

		// Проверяем, зарегистрирован ли пользователь
		if (!$this->repository->isUserRegisteredForEvent($userId, $eventId)) {
			$result->addError(new Error('Вы не зарегистрированы на это событие'));
			return $result;
		}

		try {
			$this->repository->unregisterUserFromEvent($userId, $eventId);
			$result->setData(['success' => true]);
		} catch (\Throwable $e) {
			$result->addError(new Error('Ошибка при отмене регистрации: ' . $e->getMessage()));
		}

		return $result;
	}

	/**
	 * Проверить статус регистрации пользователя на событие
	 *
	 * @param int $userId
	 * @param int $eventId
	 * @return bool
	 */
	public function isUserRegisteredForEvent(int $userId, int $eventId): bool
	{
		return $this->repository->isUserRegisteredForEvent($userId, $eventId);
	}
}
