<?php

global $APPLICATION;

$APPLICATION->SetTitle("BitUp24");
?>

<style>
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

	/* Основные стили для карточки события */
	.bitup-event-card {
		background-color: #22a746;
		color: white;
		padding: 20px;
		border-radius: 10px;
		width: 400px;
		font-family: Arial, sans-serif;
		cursor: pointer;
		transition: all 0.3s ease;
		position: relative;
		min-width: 400px; /* Минимальная ширина каждой карточки */
		border: 1px solid #ccc; /* Пример границы */
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Пример теней для карточек */
		box-sizing: border-box;
	}

	.bitup-event-card:hover {
		background-color: #1e8e3f;
		transform: translateY(-2px);
	}

	.bitup-event-card--error {
		border: 2px solid #ff4757;
		box-shadow: 0 0 10px rgba(255, 71, 87, 0.3);
	}

	/* Элементы карточки */
	.bitup-event-card__title {
		font-size: 18px;
		font-weight: bold;
		margin-bottom: 5px;
	}

	.bitup-event-card__date {
		font-size: 14px;
		margin-bottom: 15px;
		opacity: 0.9;
	}

	.bitup-event-card__participants {
		display: flex;
		align-items: center;
		font-size: 16px;
	}

	.bitup-event-card__participants-icon {
		margin-right: 8px;
	}

	.bitup-event-card__participants-count {
		font-weight: bold;
	}

	.bitup-event-card__loading {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		background-color: rgba(0, 0, 0, 0.7);
		padding: 10px 15px;
		border-radius: 5px;
		font-size: 14px;
	}

	/* Обертка для карточки */
	.bitup-event-card-wrapper {
		margin-bottom: 15px;
	}

	/* Стили для списка карточек */
	.bitup-event-card-list {
		padding: 0;
		margin: 0;
	}

	.bitup-main-events,
	.bitup-grid-events,
	.bitup-all-events {
		list-style: none;
		padding: 0;
		margin: 0 0 20px 0;
		display: flex;
		flex-wrap: wrap;
		gap: 15px;
	}

	.bitup-main-event-item,
	.bitup-grid-event-item,
	.bitup-event-item {
		list-style: none;
	}

	/* Адаптивность */
	@media (max-width: 768px) {
		.bitup-event-card {
			width: 100%;
			max-width: 400px;
		}

		.bitup-main-events,
		.bitup-grid-events,
		.bitup-all-events {
			flex-direction: column;
			align-items: center;
		}
	}

	/* Анимации */
	@keyframes fadeIn {
		from {
			opacity: 0;
			transform: translateY(20px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	.bitup-event-card-wrapper {
		animation: fadeIn 0.3s ease;
	}

	/* Состояние загрузки */
	.bitup-event-card--loading {
		pointer-events: none;
		opacity: 0.7;
	}

	.bitup-event-card--loading::after {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
		animation: loading 1.5s infinite;
	}

	@keyframes loading {
		0% {
			transform: translateX(-100%);
		}
		100% {
			transform: translateX(100%);
		}
	}

	#air-workarea-content {
		background-color: rgba(0, 0, 0, 0);
	}

	#air-workarea-content * {
		opacity: 1;
	}

	.bitup-event-container {
		display: flex;
		flex-direction: row;
		overflow-x: auto;
		gap: 16px; /* Расстояние между карточками */
		padding: 16px; /* Внутренний отступ контейнера */
		box-sizing: border-box; /* Чтобы padding не повлиял на общую ширину контейнера */
		width: 100%; /* Убедитесь, что эта ширина позволяет горизонтальную прокрутку */
	}

	.bitup-event-card__title, .bitup-event-card__date, .bitup-event-card__participants {
		margin-bottom: 8px; /* Отступы между элементами внутри карточки */
	}

	.scroll-button {
		width: 40px;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.1);
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		z-index: 1;
		position: sticky;
	}

	.scroll-button.left {
		left: 0;
		height: 150px;
	}

	.scroll-button.right {
		right: 0;
		height: 150px;
	}

	.bitup-event-container {
		display: flex;
		overflow-x: hidden; /* Скрыть стандартный скроллбар */
		overflow-y: hidden;
		scrollbar-width: none; /* Для Firefox */
		-ms-overflow-style: none; /* Для для Internet Explorer и Edge */
	}

	.bitup-event-container::-webkit-scrollbar {
		display: none; /* Для Chrome, Safari и Opera */
	}

	.bitup-event-card {
		min-width: 400px;
		/* Другие стили карточек */
		margin: 0 5px; /* Отступы между карточками */
	}

	.scroll-container {
		display: flex;
		align-items: center;
	}

	.scroll-button.left::before {
		transform: rotate(135deg); /* Поворот для стрелки влево */
	}

	.scroll-button.right::before {
		transform: rotate(45deg); /* Поворот для стрелки вправо */
	}

	.bitup-event-container {
		display: flex;
		overflow-x: hidden; /* Скрыть стандартный скроллбар */
		scrollbar-width: none; /* Для Firefox */
		-ms-overflow-style: none; /* Для Internet Explorer и Edge */
	}

	.bitup-event-container::-webkit-scrollbar {
		display: none; /* Для Chrome, Safari и Opera */
	}

	.bitup-event-card {
		min-width: 400px;
		margin: 0 5px;
		/* Пример высоты карточек */
		height: 150px; /* Это значение должно быть таким же, как у стрелок */
		/* Другие стили */
	}

	.bitup-card-link {
		text-decoration: none; /* Убирает подчеркивание */
		color: inherit; /* Наследует цвет родителя */
	}
</style>

<a href="/bitup24/event/create/" style="margin-bottom: 10px" class="custom-button">Создать</a>

<div class="scroll-container">
	<div class="scroll-button left">&#9664;</div>
	<div class="bitup-event-container">
	</div>
	<div class="scroll-button right">&#9654;</div>
</div>

<style>
	.bitup-slider {
		position: relative;
		width: 100vw;                      /* именно весь viewport */
		margin: 0 calc(-50vw + 50%);       /* центрируем в контейнере */
		overflow: hidden;
	}

	/* 2) Трек растянем под три слайда */
	.bitup-slider-track {
		display: flex;
		transition: transform 0.5s ease;
		margin-top: 50px;
	}

	/* 3) Каждый слайд — ровно 100% от .bitup-slider */
	.bitup-slide {
		flex: 0 0 100%;                    /* занимать 100% от родителя (.bitup-slider) */
	}
	.bitup-slide img {
		display: block;
		width: 100%;
		height: 350px;
		object-fit: contain
	}

	/* Точки */
	.bitup-slider-dots {
		text-align: center;
		margin-top: 10px;
	}
	.bitup-slider-dot {
		display: inline-block;
		width: 12px;
		height: 12px;
		border-radius: 50%;
		background: #ccc;
		margin: 0 6px;
		cursor: pointer;
		transition: background 0.3s;
	}
	.bitup-slider-dot.active {
		background: #333;
	}
</style>

<div class="bitup-slider">
	<div class="bitup-slider-track">
		<div class="bitup-slide">
			<img src="/bitrix/js/crm/entity-editor/css/images/image1.png" alt="Описание 1">
		</div>
		<div class="bitup-slide">
			<img src="/bitrix/js/crm/entity-editor/css/images/image2.png" alt="Описание 2">
		</div>
		<div class="bitup-slide">
			<img src="/bitrix/js/crm/entity-editor/css/images/image3.png" alt="Описание 3">
		</div>
	</div>
</div>
<div class="bitup-slider-dots">
	<span class="bitup-slider-dot active" data-index="0"></span>
	<span class="bitup-slider-dot" data-index="1"></span>
	<span class="bitup-slider-dot" data-index="2"></span>
</div>

<script>
	(function() {
		const track = document.querySelector('.bitup-slider-track');
		const dots = Array.from(document.querySelectorAll('.bitup-slider-dot'));
		const slider = document.querySelector('.bitup-slider');
		let current = 0;

		function goToSlide(index) {
			current = index;
			// смещаем трек на количество экранов, а не процентов трека:
			const offset = index * slider.clientWidth;
			track.style.transform = `translateX(${-offset}px)`;
			dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
		}

		dots.forEach(dot => {
			dot.addEventListener('click', () => {
				goToSlide(parseInt(dot.dataset.index, 10));
			});
		});

		let auto = setInterval(() => {
			goToSlide((current + 1) % dots.length);
		}, 5000);

		slider.addEventListener('mouseenter', () => clearInterval(auto));
		slider.addEventListener('mouseleave', () => {
			auto = setInterval(() => goToSlide((current + 1) % dots.length), 5000);
		});
	})();

</script>

<script>
	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	document.addEventListener('DOMContentLoaded', () => {
		const scrollContainer = document.querySelector('.bitup-event-container');
		const leftButton = document.querySelector('.scroll-button.left');
		const rightButton = document.querySelector('.scroll-button.right');

		const scrollAmount = 250; // Количество пикселей для прокрутки

		leftButton.addEventListener('mouseenter', () => {
			scrollContainer.scrollBy({ left: -scrollContainer.scrollWidth, behavior: 'smooth' });
		});

		rightButton.addEventListener('mouseenter', () => {
			scrollContainer.scrollBy({ left: scrollContainer.scrollWidth, behavior: 'smooth' });
		});
	});

	BX.ajax.runAction('bitup24.api.BitUp24.getCards').then(response => {
		const container = document.querySelector('.bitup-event-container'); // Находим контейнер для карточек
		const cards = response.data; // Предполагаем, что данные находятся в response.data

		cards.forEach(card => {
			let cardDiv = document.createElement('div'); // Создайте div-элемент
			cardDiv.classList.add('bitup-event-card');

			// Заполняем данными
			cardDiv.innerHTML = `
			<a class="bitup-card-link" href="/bitup24/event/${escapeHtml(card.id)}/">
            <div class="bitup-event-card__title">${escapeHtml(card.title)}</div>
            <div class="bitup-event-card__date">${escapeHtml(card.date)}</div>
            <div class="bitup-event-card__participants">
                <div class="bitup-event-card__participants-icon">👥</div>
                <div class="bitup-event-card__participants-count">${escapeHtml(card.participantsCount) || 0}</div>
            </div>
			</a>
        `;

			// Добавляем созданный div в контейнер
			container.appendChild(cardDiv);
		});
	});
</script>