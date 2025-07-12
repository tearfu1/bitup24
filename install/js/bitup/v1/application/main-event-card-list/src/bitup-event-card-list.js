import { BitrixVue } from 'ui.vue3';
// import type { Params } from './types';
import './bitup-event-card.css';

export class BitupEventCard
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
<<<<<<< Updated upstream:install/js/bitup/v1/application/event-card/src/bitup-event-card.js
				<div class="bitup-event-card">
					<div class="title">Супер название</div>
					<div class="date">Супер дата</div>
					<div class="participants">
						<div class="icon">👥</div>
						<div>100</div>
					</div>
				</div>
=======
				<ol class="bitup-main-events">
					<template v-for="event of mainEvents" :key="event.name">
						<div class="bitup-event-card">
						</div>
					</template>
				</ol>
				<ol class="bitup-main-events">
					<template v-for="event of mainEvents" :key="event.name">
						<div class="bitup-event-card">
						</div>
					</template>
				</ol>
>>>>>>> Stashed changes:install/js/bitup/v1/application/main-event-card-list/src/bitup-event-card-list.js
			`,
		}, params).mount(params.container);
	}
}