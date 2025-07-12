<?php
// detail.php (шаблон)
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}


global $APPLICATION;

$APPLICATION->SetTitle("BitUp24 Детальная страница");

$eventId = isset($_GET['eventId']) ? (int)$_GET['eventId'] : 0;
if ($eventId <= 0) {
	throw new \Bitrix\Main\SystemException("Не передан eventId");
}

$event = (new \Bitrix\BitUp24\Service\EventService())->getEventDetail($eventId);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Событие - <?= htmlspecialchars($event['name'], ENT_QUOTES) ?></title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
			background-color: #f5f5f5;
			color: #333;
			line-height: 1.5;
		}

		.header {
			height: 120px;
			position: relative;
			overflow: hidden;
		}

		.header-background {
			width: 100%;
			height: 100%;
			background: linear-gradient(135deg, #2d5a3d 0%, #4a8c65 50%, #6bb88a 100%);
			position: relative;
		}

		.header-background::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-image:
				radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
				radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
				radial-gradient(circle at 40% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
		}

		.container {
			max-width: 1200px;
			margin: 0 auto;
			padding: 0 20px;
		}

		.main-content {
			margin-top: -60px;
			position: relative;
			z-index: 2;
		}

		.page-title {
			font-size: 32px;
			font-weight: 600;
			color: white;
			margin-bottom: 30px;
			padding-left: 10px;
		}

		.tabs {
			display: flex;
			gap: 2px;
			margin-bottom: 30px;
		}

		.tab-button {
			padding: 12px 24px;
			border: none;
			background-color: #e0e0e0;
			color: #666;
			font-size: 14px;
			cursor: pointer;
			border-radius: 8px 8px 0 0;
			transition: all 0.3s ease;
		}

		.tab-button.active {
			background-color: white;
			color: #333;
			font-weight: 500;
		}

		.tab-button:hover:not(.active) {
			background-color: #d0d0d0;
		}

		.event-content {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 30px;
		}

		.event-card, .description-card {
			background: white;
			border-radius: 12px;
			padding: 24px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.1);
		}

		.event-header {
			margin-bottom: 24px;
		}

		.event-label {
			font-size: 12px;
			color: #888;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			display: block;
			margin-bottom: 8px;
		}

		.event-title {
			font-size: 28px;
			font-weight: 600;
			color: #333;
		}

		.event-details {
			margin-bottom: 32px;
		}

		.detail-row {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 8px 0;
			border-bottom: 1px solid #f0f0f0;
		}

		.detail-row:last-child {
			border-bottom: none;
		}

		.detail-label {
			font-size: 14px;
			color: #666;
			font-weight: 500;
		}

		.detail-value {
			font-size: 14px;
			color: #333;
			font-weight: 600;
		}

		.location-section {
			margin-top: 24px;
		}

		.location-title {
			font-size: 16px;
			font-weight: 600;
			color: #333;
			margin-bottom: 16px;
		}

		.map-container {
			width: 100%;
			height: 200px;
			border-radius: 8px;
			overflow: hidden;
			background: linear-gradient(135deg, #a8d5ba 0%, #7cb88f 100%);
			position: relative;
		}

		.map-placeholder {
			width: 100%;
			height: 100%;
			background-image:
				radial-gradient(circle at 30% 40%, rgba(255,255,255,0.3) 1px, transparent 1px),
				radial-gradient(circle at 70% 20%, rgba(255,255,255,0.3) 1px, transparent 1px),
				radial-gradient(circle at 20% 80%, rgba(255,255,255,0.3) 1px, transparent 1px),
				radial-gradient(circle at 80% 70%, rgba(255,255,255,0.3) 1px, transparent 1px);
			background-size: 50px 50px, 30px 30px, 40px 40px, 35px 35px;
			position: relative;
		}

		.map-pin {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -100%);
			width: 24px;
			height: 36px;
			background: #2d5a3d;
			border-radius: 50% 50% 50% 0;
			transform: rotate(-45deg);
		}

		.map-pin::after {
			content: '';
			position: absolute;
			top: 6px;
			left: 6px;
			width: 12px;
			height: 12px;
			background: white;
			border-radius: 50%;
		}

		.description-title {
			font-size: 16px;
			font-weight: 600;
			color: #333;
			margin-bottom: 20px;
		}

		.description-content {
			font-size: 14px;
			line-height: 1.6;
			color: #555;
		}

		.description-content p {
			margin-bottom: 16px;
		}

		.description-content ol {
			margin: 16px 0;
			padding-left: 20px;
		}

		.description-content li {
			margin-bottom: 8px;
		}

		.description-content strong {
			color: #333;
		}

		/* Responsive design */
		@media (max-width: 768px) {
			.event-content {
				grid-template-columns: 1fr;
				gap: 20px;
			}

			.page-title {
				font-size: 24px;
			}

			.container {
				padding: 0 15px;
			}

			.event-card, .description-card {
				padding: 20px;
			}
		}

		@media (max-width: 480px) {
			.tabs {
				flex-direction: column;
			}

			.tab-button {
				border-radius: 8px;
				margin-bottom: 2px;
			}

			.detail-row {
				flex-direction: column;
				align-items: flex-start;
				gap: 4px;
			}
		}

		.custom-button {
			background-color: #41a65e;
			color: white;
			border: none;
			padding: 10px 20px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
			border-radius: 5px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 -1px 0 rgba(0, 0, 0, 0.2) inset;
		}

		.custom-button:hover {
			background-color: #378c4e;
		}

		.join-button {
			padding: 15px;
			opacity: 0.9;
			color: white;
			background-color: #41a65e;
			border: none;
			border-radius: 15px;
			height: 60px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 24px;
			cursor: pointer;
			position: relative;
		}

		.join-text {
			position: absolute;
			top: 70px;
			font-size: 16px;
			color: white;
			text-align: center;
			width: 100%;
		}
	</style>
</head>
<body>

<main class="main-content">
	<div class="container">
		<nav class="tabs">
			<button class="tab-button active">Общая информация</button>
		</nav>

		<div class="event-content">
			<div class="left-column">
				<div class="event-card">
					<div class="event-header">
						<span class="event-label">Название</span>
						<h2 class="event-title"><?= $event['name'] ?></h2>
					</div>

					<div class="event-details">
						<div class="detail-row">
							<span class="detail-label">Даты проведения:</span>
							<span class="detail-value">
                                <?= $event['start_date']->toString() ?>

                                <?php if ($event['END_DATE']): ?>
									<?= $event['end_date']->toString() ?>
								<?php else: ?>

								<?php endif; ?>
                            </span>
						</div>
						<div class="detail-row">
							<span class="detail-label">Участники:</span>
							<span class="detail-value">
                                <?= (int)$event['APPROVED_PARTICIPANTS'] ?> из <?= (int)$event['max_participants'] ?>
                            </span>
						</div>
						<div class="detail-row">
							<span class="detail-label">Баллы за участие:</span>
							<span class="detail-value"><?= (int)$event['points_for_visit'] ?></span>
						</div>
					</div>

					<div class="location-section">
						<h3 class="location-title">Место проведения</h3>
						<input
							type="text"
							class="detail-value"
							readonly
							value="<?= htmlspecialchars($event['location'], ENT_QUOTES) ?>"
							style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
						>
					</div>
				</div>
			</div>

			<div class="right-column">
				<div class="description-card">
					<h3 class="description-title">Описание</h3>
					<div class="description-content">
						<?= nl2br(htmlspecialchars($event['description'], ENT_QUOTES)) ?>
					</div>
				</div>

				<div style="text-align: center; margin-top: 50px;">
					<button class="join-button" onclick="joinEvent()">
						<span>+ Присоединиться</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</main>
</body>
</html>

<script>
	function joinEvent() {
		BX.ajax.runAction('bitup24.api.BitUp24.registerForEvent', {
			data: {
				eventId: <?= $eventId ?>
			}
		})
			.then((response) => {
				console.log('Успешно:', response);
			})
			.catch((error) => {
				console.error('Ошибка:', error);
			});
	}
</script>
