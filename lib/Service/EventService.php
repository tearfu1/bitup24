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


}
