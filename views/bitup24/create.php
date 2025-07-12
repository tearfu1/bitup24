<?php


global $APPLICATION;

$APPLICATION->SetTitle("BitUp24");

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Создать событие</title>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/ui.vue@latest/dist/bundle.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/main.core@latest/dist/main.core.bundle.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/main.core.ajax@latest/dist/main.core.ajax.bundle.js"></script>
	<style>
		body {
			font-family: 'Segoe UI', 'Arial', sans-serif;
			margin: 0;
		}

		.container {
			width: 98vw;
			max-width: 1360px;
			margin: 8px auto;
			border-radius: 14px;
			padding-bottom: 32px;
			box-sizing: border-box;
			box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
		}

		.title {
			font-size: 2rem;
			font-weight: 400;
			margin: 0 0 10px 24px;
			padding-top: 32px;
		}

		.tabs {
			display: flex;
			gap: 24px;
			margin-left: 24px;
			margin-bottom: 14px;
		}

		.tab {
			background: none;
			border: none;
			padding: 0;
			font-size: 1.05rem;
			color: #232c2d;
			opacity: 0.7;
			cursor: pointer;
			border-bottom: 2px solid transparent;
			margin-right: 16px;
		}

		.tab.active {
			font-weight: 600;
			opacity: 1;
			border-bottom: 2px solid #232c2d;
		}

		.main-form {
			display: flex;
			gap: 24px;
			margin: 0 24px 32px 24px;
		}

		.left, .right {
			border-radius: 14px;
			box-shadow: 0 1px 6px rgba(0, 0, 0, 0.02);
			padding: 24px;
		}

		.left {
			flex: 1.1;
			display: flex;
			flex-direction: column;
			gap: 22px;
		}

		.right {
			flex: 2;
			min-width: 370px;
			display: flex;
			flex-direction: column;
			min-height: 300px;
		}

		fieldset {
			border: none;
			padding: 0;
			margin: 0;
		}

		legend {
			display: block;
			font-size: 1rem;
			color: #8f9ca5;
			margin-bottom: 10px;
			font-weight: 400;
			padding: 0;
		}

		.form-group {
			margin-bottom: 20px;
		}
		.form-group:last-child {
			margin-bottom: 0;
		}

		.form-group label:not(.radio):not(.checkbox) {
			display: block;
			font-size: 1rem;
			color: #8f9ca5;
			margin-bottom: 6px;
			font-weight: 400;
		}

		.input {
			width: 100%;
			padding: 9px 12px;
			font-size: 1rem;
			border-radius: 24px;
			border: 1.5px solid #e4e9ed;
			background: #fafbfc;
			outline: none;
			box-sizing: border-box;
			font-family: inherit;
			transition: border 0.2s;
		}

		.input:focus {
			border: 1.5px solid #00c2ff;
		}

		.input.small {
			width: 70px;
			display: inline-block;
			margin-left: 8px;
		}

		.input[type="number"] {
			text-align: center;
		}

		.date-range {
			display: flex;
			align-items: center;
			gap: 12px;
		}

		.date-sep {
			font-size: 1.2rem;
			color: #adb5bb;
		}

		.row {
			display: flex;
			align-items: center;
			gap: 18px;
			flex-wrap: wrap;
		}

		.charges-row {
			display: flex;
			gap: 18px;
			flex-wrap: wrap;
		}

		.radio,
		.checkbox {
			display: flex;
			align-items: center;
			position: relative;
			font-size: 1rem;
			cursor: pointer;
			padding-left: 28px;
			user-select: none;
			margin-bottom: 12px;
		}

		.radio input,
		.checkbox input {
			position: absolute;
			opacity: 0;
			cursor: pointer;
			height: 0;
			width: 0;
		}

		.custom-radio,
		.custom-checkbox {
			position: absolute;
			left: 0;
			top: 50%;
			transform: translateY(-45%);
			height: 18px;
			width: 18px;
			border-radius: 50%;
			border: 1.5px solid #dbe3e7;
			background: #f5f7fa;
			transition: border 0.2s, box-shadow 0.2s;
		}

		.checkbox .custom-checkbox {
			border-radius: 6px;
		}

		.radio input:checked ~ .custom-radio {
			border: 5px solid #c1f455;
			background: #fff;
		}

		.checkbox input:checked ~ .custom-checkbox {
			background: #c1f455;
			border: 1.5px solid #c1f455;
		}

		.caption {
			font-size: 0.85em;
			color: #b6b6b6;
			margin-left: 6px;
		}

		.desc-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 8px;
		}

		.color-picker {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 1em;
			color: #8f9ca5;
		}

		.color-square {
			display: inline-block;
			width: 16px;
			height: 16px;
			border-radius: 4px;
			border: 1.5px solid #dbe3e7;
			margin-left: 4px;
		}

		.desc-editor {
			background: #fff;
			border-radius: 16px;
			border: 1.5px solid #e4e9ed;
			padding: 6px 9px;
			min-height: 128px;
			display: flex;
			flex-direction: column;
			gap: 6px;
		}

		.toolbar {
			display: flex;
			gap: 7px;
			align-items: center;
			margin-bottom: 2px;
		}

		.toolbar button {
			background: none;
			border: none;
			font-size: 1.05rem;
			cursor: pointer;
			color: #444;
			padding: 3px 7px;
			border-radius: 6px;
			transition: background 0.14s;
		}

		.toolbar button:hover {
			background: #f1f8fa;
		}

		.desc-textarea {
			width: 100%;
			min-height: 88px;
			border: none;
			resize: vertical;
			padding: 6px 4px;
			font-size: 1rem;
			font-family: inherit;
			background: transparent;
			outline: none;
		}

		.form-actions {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 24px;
			padding: 26px 16px 0 16px;
			box-sizing: border-box;
			border-radius: 0 0 14px 14px;
			margin: 0 6px;
		}

		.btn {
			font-size: 1.15rem;
			font-weight: 500;
			padding: 10px 28px;
			border-radius: 22px;
			border: none;
			cursor: pointer;
			transition: background .15s, color .15s, border .15s;
		}

		.btn-green {
			background: #c1f455;
			color: #232c2d;
		}

		.btn-green:hover {
			background: #b1e94b;
		}

		.btn-green-outline {
			background: #fff;
			border: 2px solid #c1f455;
			color: #232c2d;
		}

		.btn-green-outline:hover {
			background: #c1f45522;
		}

		.btn-text {
			background: none;
			color: #232c2d;
			border: none;
			padding: 10px 16px;
			font-size: 1.08rem;
			opacity: 0.85;
		}

		.btn-text:hover {
			text-decoration: underline;
			opacity: 1;
		}

		@media (max-width: 900px) {
			.main-form {
				flex-direction: column;
				gap: 12px;
			}

			.left, .right {
				min-width: unset;
				max-width: unset;
				width: 100%;
				padding: 18px 11px;
			}

			.container {
				padding: 0 3px 32px 3px;
			}
		}
	</style>
</head>
<body>
<div class="container">
	<h1 class="title">Создать событие</h1>
	<div class="tabs">
		<button class="tab active">Общая информация</button>
	</div>
	<div class="main-form">
		<div class="left">
			<div class="form-group">
				<label for="event-title">Название</label>
				<input type="text" id="event-title" class="input" placeholder="">
			</div>
			<div class="form-group">
				<label for="start-date">Даты проведения</label>
				<div class="date-range">
					<input type="datetime-local" id="start-date" class="input">
					<span class="date-sep">—</span>
					<input type="datetime-local" id="end-date" class="input">
				</div>
			</div>
			<fieldset class="form-group">
				<legend>Количество участников</legend>
				<div class="row">
					<label class="radio">
						<input type="radio" name="participants">
						<span class="custom-radio"></span>
						Ограниченное
					</label>
					<input type="number" class="input small" id="min-participants" placeholder="от">
					<input type="number" class="input small" id="max-participants" placeholder="до">
				</div>
			</fieldset>
			<fieldset class="form-group">
				<legend>Назначать заряды</legend>
				<div class="charges-row">
					<label class="radio">
						<input type="radio" name="charges" value="5">
						<span class="custom-radio"></span>
						<span>5 зарядов <span class="caption">Регулярные</span></span>
					</label>
					<label class="radio">
						<input type="radio" name="charges" value="10">
						<span class="custom-radio"></span>
						<span>10 зарядов <span class="caption">Болельщик</span></span>
					</label>
					<label class="radio">
						<input type="radio" name="charges" value="15">
						<span class="custom-radio"></span>
						<span>15 зарядов <span class="caption">Участник</span></span>
					</label>
				</div>
			</fieldset>
			<div class="form-group">
				<label for="address">Место проведения</label>
				<input type="text" id="address" class="input" placeholder="Адрес">
			</div>
			<fieldset class="form-group">
				<legend>Дополнительные действия</legend>
				<div class="row">
					<label class="checkbox">
						<input type="checkbox" id="create-chat" checked>
						<span class="custom-checkbox"></span>
						Создать отдельный чат
					</label>
					<label class="checkbox">
						<input type="checkbox" id="chat-post">
						<span class="custom-checkbox"></span>
						Сделать пост в чате события
					</label>
				</div>
				<label class="checkbox">
					<input type="checkbox" id="feed-post">
					<span class="custom-checkbox"></span>
					Сделать пост в ленте
				</label>
			</fieldset>
		</div>
		<div class="right">
			<div class="desc-header">
				<label for="desc">Описание</label>
				<div class="color-picker">
					<span>Цвет</span>
					<span class="color-square" style="background: #00C2FF"></span>
				</div>
			</div>
			<div class="desc-editor">
				<div class="toolbar">
					<button type="button"><b>B</b></button>
					<button type="button"><i>I</i></button>
					<button type="button"><u>U</u></button>
					<button type="button"><s>S</s></button>
					<button type="button">&#8226;•&#8226;</button>
					<button type="button">&#35;</button>
					<button type="button">&#128279;</button>
					<button type="button" style="color: #BE2EFF">&#128247;</button>
				</div>
				<textarea id="desc" class="input desc-textarea"></textarea>
			</div>
		</div>
	</div>
	<div class="form-actions">
		<button class="btn btn-green" id="save-btn">СОХРАНИТЬ</button>
		<button class="btn btn-green-outline">ОТПРАВИТЬ НА ОДОБРЕНИЕ</button>
		<button class="btn btn-text">ОТМЕНИТЬ</button>
	</div>
</div>

<script>
	document.getElementById('save-btn').addEventListener('click', function () {
		const name = document.getElementById('event-title').value.trim();
		const description = document.getElementById('desc').value.trim();
		const startDate = document.getElementById('start-date').value.replace('T', ' ');
		const endDate = document.getElementById('end-date').value.replace('T', ' ');
		const location = document.getElementById('address').value.trim();

		const chargesRadio = document.querySelector('input[name="charges"]:checked');
		if (!chargesRadio) {
			alert('Пожалуйста, выберите количество зарядов.');
			return;
		}
		const points = parseInt(chargesRadio.value, 10);

		const maxParticipants = parseInt(document.getElementById('max-participants').value, 10) || 0;

		if (!name || !startDate || !endDate) {
			alert('Заполните все обязательные поля (Название, Даты проведения)!');
			return;
		}

		BX.ajax.runAction('bitup24.api.BitUp24.addEvent', {
			data: {
				data: {
					name: name,
					description: description,
					start_date: startDate,
					end_date: endDate,
					location: location,
					points_for_visit: points,
					max_participants: maxParticipants
				}
			}
		}).then(response => {
			console.log('Создано событие ID=', response.data.eventId);
			window.location.href = '/bitup24/'; // редирект на главную
		}).catch(error => {
			console.error(error);
			alert('Ошибка при создании события');
		});
	});
</script>
</body>
</html>