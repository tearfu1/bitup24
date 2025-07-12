/* eslint-disable */
this.BX = this.BX || {};
(function (exports,main_core) {
	'use strict';

	var _templateObject;
	function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
	function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { babelHelpers.defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
	var BitupEventCard = /*#__PURE__*/function () {
	  function BitupEventCard() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
	    babelHelpers.classCallCheck(this, BitupEventCard);
	    this.container = document.getElementById(options.container);
	    this.render();
	  }
	  babelHelpers.createClass(BitupEventCard, [{
	    key: "setData",
	    value: function setData(data) {
	      this.data = _objectSpread(_objectSpread({}, this.data), data);
	      this.updateContent();
	    }
	  }, {
	    key: "updateContent",
	    value: function updateContent() {
	      if (this.element) {
	        var titleElement = this.element.querySelector('.bitup-event-card__title');
	        var dateElement = this.element.querySelector('.bitup-event-card__date');
	        var participantsElement = this.element.querySelector('.bitup-event-card__participants-count');
	        if (titleElement && this.data.title) {
	          titleElement.textContent = this.data.title;
	        }
	        if (dateElement && this.data.date) {
	          dateElement.textContent = this.data.date;
	        }
	        if (participantsElement && this.data.participantsCount !== undefined) {
	          participantsElement.textContent = this.data.participantsCount;
	        }
	      }
	    }
	  }, {
	    key: "setHasError",
	    value: function setHasError(value) {
	      this.hasError = value;
	      if (value === true) {
	        this.isLoading = false;
	      }
	    }
	  }, {
	    key: "isDisabled",
	    value: function isDisabled() {
	      return this.isLoading || this.data.title && this.data.title.trim() === '';
	    }
	  }, {
	    key: "handleClick",
	    value: function handleClick() {
	      if (!this.isDisabled()) {
	        this.isLoading = true;
	        this.onUpdateError(false);
	        this.onAddTask();
	        return;
	      }
	      this.highlightErrors();
	    }
	  }, {
	    key: "highlightErrors",
	    value: function highlightErrors() {
	      if (this.data.title && this.data.title.trim() === '') {
	        this.errorReason = 'Заголовок не может быть пустым';
	        console.warn('Title validation error:', this.errorReason);
	      }
	      this.showPopup();
	    }
	  }, {
	    key: "showPopup",
	    value: function showPopup() {
	      var _this = this;
	      var removeHighlight = function removeHighlight() {
	        _this.isPopupShown = false;
	        main_core.Event.unbind(window, 'keydown', removeHighlight);
	      };
	      main_core.Event.bind(window, 'keydown', removeHighlight);
	      this.isPopupShown = true;
	    }
	  }, {
	    key: "render",
	    value: function render() {
	      var _this2 = this;
	      console.log(this.container);
	      this.element = main_core.Tag.render(_templateObject || (_templateObject = babelHelpers.taggedTemplateLiteral(["\n            <div class=\"bitup-event-card ", "\">\n                <div class=\"bitup-event-card__title\">", "</div>\n                <div class=\"bitup-event-card__date\">", "</div>\n                <div class=\"bitup-event-card__participants\">\n                    <div class=\"bitup-event-card__participants-icon\">\uD83D\uDC65</div>\n                    <div class=\"bitup-event-card__participants-count\">", "</div>\n                </div>\n                ", "\n            </div>\n        "])), this.hasError ? 'bitup-event-card--error' : '', this.data.title || 'Название события', this.data.date || 'Дата события', this.data.participantsCount || 0, this.isLoading ? '<div class="bitup-event-card__loading">Загрузка...</div>' : '');

	      // Добавляем обработчик клика если нужно
	      if (main_core.Type.isFunction(this.onAddTask)) {
	        this.element.addEventListener('click', function () {
	          return _this2.handleClick();
	        });
	      }
	      this.container.appendChild(this.element);
	      console.log(this.container);
	      return this.element;
	    }
	  }, {
	    key: "destroy",
	    value: function destroy() {
	      if (this.element) {
	        if (this.element.parentNode) {
	          this.element.parentNode.removeChild(this.element);
	        }
	        this.element = null;
	      }
	    }
	  }]);
	  return BitupEventCard;
	}();

	exports.BitupEventCard = BitupEventCard;

}((this.BX.Bitup = this.BX.Bitup || {}),BX));
//# sourceMappingURL=bitup-event-card.bundle.js.map
