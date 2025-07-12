import {Type} from 'main.core';

export class BitupEventCard
{
	constructor(options = {name: 'BitupEventCard'})
	{
		this.name = options.name;
	}

	setName(name)
	{
		if (Type.isString(name))
		{
			this.name = name;
		}
	}

	getName()
	{
		return this.name;
	}

	render(): HTMLElement
	{
		return Tag.render`
			<div class="bitup-event-card">
			</div>
		`;
	}
}
