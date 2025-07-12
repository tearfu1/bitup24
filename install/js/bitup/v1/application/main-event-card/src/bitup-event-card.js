import { Event } from 'main.core';

import { Button as UiButton, ButtonSize } from 'ui.vue3.components.button';

import { Hint } from 'tasks.v2.component.elements.hint';
import { Model } from 'tasks.v2.const';
import { titleMeta } from 'tasks.v2.component.fields.title';
import { filesMeta } from 'tasks.v2.component.fields.files';
import { checkListMeta } from 'tasks.v2.component.fields.check-list';
import { fieldHighlighter } from 'tasks.v2.lib.field-highlighter';
import type { TaskModel } from 'tasks.v2.model.tasks';
import { fileService, EntityTypes } from 'tasks.v2.provider.service.file-service';

import './add-task-button.css';

// @vue/component
export const BitupEventCard = {
	name: 'BitupEventCard',
	// components: {
	// 	UiButton,
	// 	Hint,
	// },
	// props: {
	// 	taskId: {
	// 		type: [Number, String],
	// 		required: true,
	// 	},
	// 	size: {
	// 		type: String,
	// 		default: ButtonSize.LARGE,
	// 	},
	// 	hasError: {
	// 		type: Boolean,
	// 		default: false,
	// 	},
	// },
	// emits: [
	// 	'addTask',
	// 	'update:hasError',
	// ],
	// data(): Object
	// {
	// 	return {
	// 		fieldContainer: null,
	// 		isPopupShown: false,
	// 		isLoading: false,
	// 		errorReason: null,
	// 	};
	// },
	// computed: {
	// 	task(): TaskModel
	// 	{
	// 		return this.$store.getters[`${Model.Tasks}/getById`](this.taskId);
	// 	},
	// 	isUploading(): boolean
	// 	{
	// 		return fileService.get(this.taskId).isUploading();
	// 	},
	// 	isCheckListUploading(): boolean
	// 	{
	// 		return this.task.checklist?.some((itemId) => fileService
	// 			.get(itemId, EntityTypes.CheckListItem).isUploading());
	// 	},
	// 	isDisabled(): boolean
	// 	{
	// 		return (
	// 			this.task.title.trim() === ''
	// 			|| this.isUploading
	// 			|| this.isCheckListUploading
	// 			|| this.isLoading
	// 		);
	// 	},
	// },
	// watch: {
	// 	hasError(value: boolean): void
	// 	{
	// 		if (value === true)
	// 		{
	// 			this.isLoading = false;
	// 		}
	// 	},
	// },
	// methods: {
	// 	handleClick(): void
	// 	{
	// 		if (!this.isDisabled)
	// 		{
	// 			this.isLoading = true;
	// 			this.$emit('update:hasError', false);
	// 			this.$emit('addTask');
	//
	// 			return;
	// 		}
	//
	// 		if (this.task.title.trim() === '')
	// 		{
	// 			setTimeout(() => this.highlightTitle());
	// 		}
	// 		else if (this.isUploading)
	// 		{
	// 			setTimeout(() => this.highlightFiles());
	// 		}
	// 		else if (this.isCheckListUploading)
	// 		{
	// 			setTimeout(() => this.highlightChecklist());
	// 		}
	// 	},
	// 	highlightTitle(): void
	// 	{
	// 		this.errorReason = this.loc('TASKS_V2_TITLE_IS_EMPTY');
	//
	// 		this.fieldContainer = fieldHighlighter
	// 			.setContainer(this.$root.$el)
	// 			.addHighlight(titleMeta.id)
	// 			.getFieldContainer(titleMeta.id)
	// 		;
	//
	// 		this.fieldContainer.querySelector('textarea').focus();
	//
	// 		this.showPopup();
	// 	},
	// 	highlightFiles(): void
	// 	{
	// 		this.errorReason = this.loc('TASKS_V2_FILE_IS_UPLOADING');
	//
	// 		this.fieldContainer = fieldHighlighter
	// 			.setContainer(this.$root.$el)
	// 			.addChipHighlight(filesMeta.id)
	// 			.getChipContainer(filesMeta.id)
	// 		;
	//
	// 		this.showPopup();
	// 	},
	// 	highlightChecklist(): void
	// 	{
	// 		this.errorReason = this.loc('TASKS_V2_FILE_IS_UPLOADING');
	//
	// 		this.fieldContainer = fieldHighlighter
	// 			.setContainer(this.$root.$el)
	// 			.addChipHighlight(checkListMeta.id)
	// 			.getChipContainer(checkListMeta.id)
	// 		;
	//
	// 		this.showPopup();
	// 	},
	// 	showPopup(): void
	// 	{
	// 		const removeHighlight = () => {
	// 			this.isPopupShown = false;
	// 			Event.unbind(window, 'keydown', removeHighlight);
	// 		};
	// 		Event.bind(window, 'keydown', removeHighlight);
	//
	// 		this.isPopupShown = true;
	// 	},
	// },
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
};
