<?php

namespace Bitrix\BitUp24\Controller;

use Bitrix\Main\Engine\Controller;

final class BitUp24 extends Controller
{

	public function configureActions()
	{
		return [
			'view' => [
				'prefilters' => [],
			],
		];
	}

	public function viewAction(): mixed
	{
		return $this->renderView('bitup/index');
	}
}
