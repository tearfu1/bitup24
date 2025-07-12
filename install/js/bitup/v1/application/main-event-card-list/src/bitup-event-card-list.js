import { BitrixVue } from 'ui.vue3';
// import type { Params } from './types';
import './bitup-event-card.css';

export class BitupEventCardList
{
	constructor(params: Params)
	{
		BitrixVue.createApp({
			props: {
				mainEvents: {
					type: Array,
					required: true,
				},
			},
			template: `
				<ol class="bitup-main-events">
					<template v-for="event of mainEvents" :key="event.name">
						<div class="bitup-event-card">
						</div>
					</template>
				</ol>
			`,
		}, params).mount(params.container);
	}
}