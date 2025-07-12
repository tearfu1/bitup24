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
		];
	}

	public function viewAction(): View
	{
		return $this->renderView('bitup24/index');
	}
}
