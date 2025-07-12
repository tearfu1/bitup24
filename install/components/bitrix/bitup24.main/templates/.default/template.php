<?php
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
?>

<h1>HEY-HEY</h1>
//<div>FDSLIHFDSAHF;OIHDAFD;OIHFDSOI</div>

<script>
	BX.ready(function () {
		if (top.BX.Account)
			top.BX.Account.closeSidebarWithReload();
		else
			top.location.reload();
	});
</script>