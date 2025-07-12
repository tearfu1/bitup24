<?php ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Создать событие</title>
	<link rel="stylesheet" href="create-event.css">
	<style>
		body {
			background: #e6f1ee;
			font-family: 'Segoe UI', 'Arial', sans-serif;
			margin: 0;
		}

		.container {
			background: #f6f9fa;
			width: 98vw;
			max-width: 1360px;
			margin: 8px auto;
			border-radius: 14px;
			padding-bottom: 32px;
			box-sizing: border-box;
			box-shadow: 0 2px 12px rgba(0,0,0,0.06);
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
			background: #fff;
			border-radius: 14px;
			box-shadow: 0 1px 6px rgba(0,0,0,0.02);
			padding: 22px 28px 18px 20px;
		}

		.left {
			flex: 1.1;
			max-width: 440px;
			min-width: 380px;
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

		.form-group {
			margin-bottom: 10px;
		}

		.form-group label {
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
			padding-left: 25px;
			margin-right: 10px;
			user-select: none;
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

		.radio.checked .custom-radio {
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
			padding: 6px 9px 6px 9px;
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
		}

		.form-actions {
			background: #f6f9fa;
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
		<button class="tab">Рейтинг</button>
	</div>
	<div class="main-form">
		<div class="left">
			<div class="form-group">
				<label for="event-title">Название</label>
				<input type="text" id="event-title" class="input" placeholder="">
			</div>
			<div class="form-group">
				<label>Даты проведения</label>
				<div class="date-range">
					<input type="datetime-local" value="2025-07-17T10:15" class="input">
					<span class="date-sep">—</span>
					<input type="datetime-local" value="2025-07-23T12:15" class="input">
				</div>
			</div>
			<div class="form-group">
				<label>Количество участников</label>
				<div class="row">
					<label class="radio checked">
						<input type="radio" name="participants" checked>
						<span class="custom-radio"></span>
						Ограниченное
					</label>
					<input type="number" class="input small" placeholder="от">
					<input type="number" class="input small" placeholder="до">
				</div>
			</div>
			<div class="form-group">
				<label>Назначать заряды</label>
				<div class="charges-row">
					<label class="radio checked">
						<input type="radio" name="charges" checked>
						<span class="custom-radio"></span>
						5 зарядов
						<span class="caption">Регулярные</span>
					</label>
					<label class="radio">
						<input type="radio" name="charges">
						<span class="custom-radio"></span>
						10 зарядов
						<span class="caption">Болельщик</span>
					</label>
					<label class="radio">
						<input type="radio" name="charges">
						<span class="custom-radio"></span>
						15 зарядов
						<span class="caption">Участник</span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label for="address">Место проведения</label>
				<input type="text" id="address" class="input" placeholder="Адрес">
			</div>
			<div class="form-group">
				<div class="row">
					<label class="checkbox">
						<input type="checkbox" checked>
						<span class="custom-checkbox"></span>
						Создать отдельный чат
					</label>
					<label class="checkbox">
						<input type="checkbox">
						<span class="custom-checkbox"></span>
						Сделать пост в чате события
					</label>
				</div>
				<label class="checkbox">
					<input type="checkbox">
					<span class="custom-checkbox"></span>
					Сделать пост в ленте
				</label>
			</div>
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
		<button class="btn btn-green">СОХРАНИТЬ</button>
		<button class="btn btn-green-outline">ОТПРАВИТЬ НА ОДОБРЕНИЕ</button>
		<button class="btn btn-text">ОТМЕНИТЬ</button>
	</div>
</div>
</body>
</html>
