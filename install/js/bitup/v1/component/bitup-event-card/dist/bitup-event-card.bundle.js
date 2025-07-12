/* eslint-disable */
this.BX = this.BX || {};
this.BX.Bitup = this.BX.Bitup || {};
this.BX.Bitup.V1 = this.BX.Bitup.V1 || {};
(function (exports,main_core) {
	'use strict';

	var _templateObject;
	var BitupEventCard = /*#__PURE__*/function () {
	  function BitupEventCard() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
	      name: 'BitupEventCard'
	    };
	    babelHelpers.classCallCheck(this, BitupEventCard);
	    this.name = options.name;
	  }
	  babelHelpers.createClass(BitupEventCard, [{
	    key: "setName",
	    value: function setName(name) {
	      if (main_core.Type.isString(name)) {
	        this.name = name;
	      }
	    }
	  }, {
	    key: "getName",
	    value: function getName() {
	      return this.name;
	    }
	  }, {
	    key: "render",
	    value: function render() {
	      return Tag.render(_templateObject || (_templateObject = babelHelpers.taggedTemplateLiteral(["\n\t\t\t<div class=\"bitup-event-card\">\n\t\t\t</div>\n\t\t"])));
	    }
	  }]);
	  return BitupEventCard;
	}();

	exports.BitupEventCard = BitupEventCard;

}((this.BX.Bitup.V1.Component = this.BX.Bitup.V1.Component || {}),BX));
//# sourceMappingURL=bitup-event-card.bundle.js.map
