<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');


CModule::IncludeModule('bitup24');
Bitrix\Main\UI\Extension::load(['bitup24.bitup-evend-card-prikol']);


?>

<script>
	BX.ready(function () {
		new BX.Bitup24.BitupEventCard();
	})
</script>