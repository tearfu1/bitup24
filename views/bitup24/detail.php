<?php ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Событие - Йога-ланч</title>
	<link rel="stylesheet" href="styles.css">
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
	</style>
</head>
<body>
<!-- Header with green background -->
<header class="header">
	<div class="header-background"></div>
</header>

<!-- Main content -->
<main class="main-content">
	<div class="container">
		<!-- Page title -->
		<h1 class="page-title">Событие</h1>

		<!-- Navigation tabs -->
		<nav class="tabs">
			<button class="tab-button active">Общая информация</button>
			<button class="tab-button">Рейтинг</button>
		</nav>

		<!-- Event content -->
		<div class="event-content">
			<!-- Left column -->
			<div class="left-column">
				<!-- Event info card -->
				<div class="event-card">
					<div class="event-header">
						<span class="event-label">Название</span>
						<h2 class="event-title">Йога-ланч</h2>
					</div>

					<div class="event-details">
						<div class="detail-row">
							<span class="detail-label">Даты проведения:</span>
							<span class="detail-value">17 августа 2025 г. (10:15) - 23 августа 2025 г. (10:15)</span>
						</div>
						<div class="detail-row">
							<span class="detail-label">Количество участников:</span>
							<span class="detail-value">33 (из 35)</span>
						</div>
						<div class="detail-row">
							<span class="detail-label">Зарядка за событие:</span>
							<span class="detail-value">5</span>
						</div>
					</div>

					<div class="location-section">
						<h3 class="location-title">Место проведения</h3>
						<div class="map-container">
							<div class="map-placeholder">
								<div class="map-pin"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Right column -->
			<div class="right-column">
				<div class="description-card">
					<h3 class="description-title">Описание</h3>
					<div class="description-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt ipsum nulla, lobortis dapibus neque sollicitudin sed. Fusce cursus erat vitae metus accumsan placerat. Mauris et elementum mauris, sit amet vulputate felis. Suspendisse potenti. Quisque sagittis ultrices quam eget rhoncus. Nullam nec tempus nibh. Curabitur tellus leo, lobortis a massa et, tristique aliquet mi. Etiam lacinia pulvinar tortor at condimentum. In erat velit, suscipit non turpis sed, eleifend suscipit eros. Etiam interdum ipsum sapien, sit amet finibus urna pharetra nec.</p>

						<p>Nullam bibendum velit at mauris vulputate luctus quis a tellus. Aliquam non neque turpis. Vestibulum nisl erat, semper ac venenatis eget, ultrices non lectus. Nulla interdum justo eget nisl tempor venenatis.</p>

						<ol>
							<li><strong>Cras diam erat, finibus at dictum nec, varius suscipit ligula.</strong></li>
							<li><strong>Ut odio odio, consectetur at orci et, eleifend varius nunc.</strong></li>
							<li><strong>Sed orci est, mollis cursus porta sit amet, molestie et risus. Integer eget lorem a mauris dignissim ullamcorper.</strong></li>
						</ol>

						<p>Nulla blandit ligula vel turpis molestues, vel efficitur sapien porttitor. Ut maximus sollicitudin dolor in volupat. Etiam vestibulum ac odio in hendrerit. Vestibulum pretium vestibulum vehicula. Duis fermentum lorem eget libero commodo efficitur. Pellentesque et velit enim, finibus efficitur mi nec, vestibulum at elit. Donec gravida risus ligula, nec pretium magna et netus et malesuada fames ac turpis egestas. Donec tincidunt massa sed faucibus mattis. Aliquam posuere fermentum leo, in tempus nulla varius vehicula. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
</body>
</html>
