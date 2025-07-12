import { BitrixVue } from 'ui.vue3';
// import type { Params } from './types';
import './bitup-event-card.css';

export class BitupEventCard
{
	constructor(params: Params)
	{
		BitrixVue.createApp({
			props: {
				fruits: {
					type: Array,
					required: true,
				},
			},
			template: `
				<div class="bitup-event-card">
					<div class="title">Супер название</div>
					<div class="date">Супер дата</div>
					<div class="participants">
						<div class="icon">👥</div>
						<div>100</div>
					</div>
				</div>
			`,
		}, params).mount(params.container);
	}
}