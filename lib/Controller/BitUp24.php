<?php

namespace Bitrix\BitUp24\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\Response\Render\View;
use Bitrix\BitUp24\Service\EventService;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Error;
use Bitrix\Main\Result;

final class BitUp24 extends Controller
{
	public function configureActions()
	{
		return [
			'view' => [
				'prefilters' => [],
			],
			'getCards' => [
				'prefilters' => [],
			],

			'getDashboard' => [
				'prefilters' => [],
			],
			'getUserEnergy' => [
				'prefilters' => [],
			],
			'getUserInvites' => [
				'prefilters' => [],
			],
			'getChallengeStats' => [
				'prefilters' => [],
			],
			'addEvent' => ['prefilters' => []],
			'registerForEvent' => ['prefilters' => []],
			'unregisterFromEvent' => ['prefilters' => []],
			'checkEventRegistration' => ['prefilters' => []],

			'viewCreate' => [
				'prefilters' => [],
			],
			'viewDetail' => [
				'prefilters' => [],
			],


		];
	}

	public function viewAction(): View
	{
		return $this->renderView('bitup24/index');
	}

	public function viewCreateAction(): View
	{
		return $this->renderView('bitup24/create');
	}

	public function viewDetailAction(int $eventId): View
	{
		$service = new EventService();
		$event = $service->getEventDetail($eventId);

		if (!$event) {
			throw new \Bitrix\Main\SystemException("Событие с ID {$eventId} не найдено");
		}

		// Передаем данные в шаблон
		return $this->renderView(
			'bitup24/detail',
			['EVENT' => $event]
		);
	}

	public function getCardsAction(): array
	{
		$userId = CurrentUser::get()->getId();
		$service = new EventService();

		$events = $service->getDashboardData($userId)['challenges'];

		$resultEventsData = [];
		foreach ($events as $event)
		{
			$resultEventsData[] = [
				"id" => $event['id'],
				"title" => $event['name'],
				"description" => $event['description'],
				"participantsCount" => $event['approved_participants'],
			];
		}

		return $resultEventsData;
	}

	public function getDashboardAction(): array
	{
		$userId = CurrentUser::get()->getId();
		$service = new EventService();

		return $service->getDashboardData($userId);
	}

	public function getUserEnergyAction(): array
	{
		$userId = CurrentUser::get()->getId();
		$service = new EventService();

		return [
			'energy' => $service->getUserEnergy($userId),
		];
	}

	public function getUserInvitesAction(): array
	{
		$userId = CurrentUser::get()->getId();
		$service = new EventService();

		return [
			'invites' => $service->getUserInvites($userId),
		];
	}

	public function getChallengeStatsAction(int $eventId): array
	{
		$service = new EventService();

		return [
			'stats' => $service->getChallengeStats($eventId),
		];
	}

	/**
	 * AJAX: добавить новое событие
	 *
	 * @param array $data [
	 *   "name"            => string,
	 *   "description"     => string,
	 *   "start_date"      => "YYYY-MM-DD HH:MI:SS",
	 *   "end_date"        => "YYYY-MM-DD HH:MI:SS" | null,
	 *   "location"        => string,
	 *   "points_for_visit"=> int,
	 *   "max_participants"=> int
	 * ]
	 *
	 * @return Result содержит поле "eventId"
	 */
	public function addEventAction(array $data): Result
	{
		$userId = CurrentUser::get()->getId();
		$service = new EventService();

		$result = $service->addEvent($data, $userId);
		if (!$result->isSuccess())
		{
			return $result;
		}

		return $result;
	}

	/**
	 * AJAX: зарегистрировать текущего пользователя на событие
	 *
	 * @param int $eventId ID события
	 * @return Result
	 */
	public function registerForEventAction(int $eventId): Result
	{
		$userId = CurrentUser::get()->getId();
		return (new EventService())->registerUserForEvent($userId, $eventId);
	}

	/**
	 * AJAX: отменить регистрацию текущего пользователя на событие
	 *
	 * @param int $eventId ID события
	 * @return Result
	 */
	public function unregisterFromEventAction(int $eventId): Result
	{
		$userId = CurrentUser::get()->getId();
		return (new EventService())->unregisterUserFromEvent($userId, $eventId);
	}

	/**
	 * AJAX: проверить статус регистрации текущего пользователя на событие
	 *
	 * @param int $eventId ID события
	 * @return array
	 */
	public function checkEventRegistrationAction(int $eventId): array
	{
		$userId = CurrentUser::get()->getId();
		$service = new EventService();

		return [
			'isRegistered' => $service->isUserRegisteredForEvent($userId, $eventId)
		];
	}
}
