import { BitrixVue } from 'ui.vue3';
// import type { Params } from './types';
import './bitup-event-card.css';

export class EventCardList
{
	constructor(params: Params)
	{
		BitrixVue.createApp({
			// components: {
			// 	UiButton,
			// 	Hint,
			// },
			props: {
				fruits: {
					type: Array,
					required: true,
				},
				gridEvents: {
					type: Array,
					required: false,
				},
			},
			template: `
				<ol class="bitup-main-events">
					<template v-for="event of gridEvents">
						<div class="event-card">
						</div>
					</template>
				</ol>
			`,
		}, params).mount(params.container);
	}
}