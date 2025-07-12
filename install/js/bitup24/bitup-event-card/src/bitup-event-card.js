import { Event, Tag, Type } from 'main.core';

export class BitupEventCard
{
	constructor(options = {})
	{
		this.container = document.getElementById(options.container);
		this.render();
	}

	setData(data)
	{
		this.data = { ...this.data, ...data };
		this.updateContent();
	}

	updateContent()
	{
		if (this.element)
		{
			const titleElement = this.element.querySelector('.bitup-event-card__title');
			const dateElement = this.element.querySelector('.bitup-event-card__date');
			const participantsElement = this.element.querySelector('.bitup-event-card__participants-count');

			if (titleElement && this.data.title)
			{
				titleElement.textContent = this.data.title;
			}

			if (dateElement && this.data.date)
			{
				dateElement.textContent = this.data.date;
			}

			if (participantsElement && this.data.participantsCount !== undefined)
			{
				participantsElement.textContent = this.data.participantsCount;
			}
		}
	}

	setHasError(value)
	{
		this.hasError = value;
		if (value === true)
		{
			this.isLoading = false;
		}
	}

	isDisabled()
	{
		return (
			this.isLoading ||
			(this.data.title && this.data.title.trim() === '')
		);
	}

	handleClick()
	{
		if (!this.isDisabled())
		{
			this.isLoading = true;
			this.onUpdateError(false);
			this.onAddTask();
			return;
		}

		this.highlightErrors();
	}

	highlightErrors()
	{
		if (this.data.title && this.data.title.trim() === '')
		{
			this.errorReason = 'Заголовок не может быть пустым';
			console.warn('Title validation error:', this.errorReason);
		}

		this.showPopup();
	}

	showPopup()
	{
		const removeHighlight = () => {
			this.isPopupShown = false;
			Event.unbind(window, 'keydown', removeHighlight);
		};
		Event.bind(window, 'keydown', removeHighlight);

		this.isPopupShown = true;
	}

	render()
	{
		console.log(this.container);
		this.element = Tag.render`
            <div class="bitup-event-card ${this.hasError ? 'bitup-event-card--error' : ''}">
                <div class="bitup-event-card__title">${this.data.title || 'Название события'}</div>
                <div class="bitup-event-card__date">${this.data.date || 'Дата события'}</div>
                <div class="bitup-event-card__participants">
                    <div class="bitup-event-card__participants-icon">👥</div>
                    <div class="bitup-event-card__participants-count">${this.data.participantsCount || 0}</div>
                </div>
                ${this.isLoading ? '<div class="bitup-event-card__loading">Загрузка...</div>' : ''}
            </div>
        `;

		// Добавляем обработчик клика если нужно
		if (Type.isFunction(this.onAddTask))
		{
			this.element.addEventListener('click', () => this.handleClick());
		}

		this.container.appendChild(this.element);
		console.log(this.container);
		return this.element;
	}

	destroy()
	{
		if (this.element)
		{
			if (this.element.parentNode)
			{
				this.element.parentNode.removeChild(this.element);
			}
			this.element = null;
		}
	}
}