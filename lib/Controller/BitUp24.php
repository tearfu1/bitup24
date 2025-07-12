<?php

namespace Bitrix\BitUp24\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\Response\Render\View;

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
			'viewCreate' => [
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

	public function getCardsAction(): array
	{
		return [
			'cards'=>[
				[
					"name"=>'aaaa',
				],
				[
					"name"=>'bbbb',
				],
			]
		];
	}
}
