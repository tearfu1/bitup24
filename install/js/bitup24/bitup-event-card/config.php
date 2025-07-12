<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'css' => 'dist/bitup-event-card.bundle.css',
	'js' => 'dist/bitup-event-card.bundle.js',
	'rel' => [
		'main.core',
	],
	'skip_core' => false,
];
