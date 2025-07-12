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
		return $this->renderView('bitup24/detail');
	}

	public function getCardsAction(): array
	{
		return [
				[
					"title" => 'aa33333aa',
					"date" => '123',
					"participantsCount" => '123321',
				],
				[
					"title" => 'aa33333aa',
					"date" => '123',
					"participantsCount" => '123321',
				],
				[
					"title" => 'aa33333aa',
					"date" => '123',
					"participantsCount" => '123321',
				],
		];
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
}
