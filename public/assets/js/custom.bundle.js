/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/custom/plugins/_init.js":
/*!**********************************************!*\
  !*** ./resources/js/custom/plugins/_init.js ***!
  \**********************************************/
/***/ (() => {

var ckeditorInstance = $("[data-control='ckeditor']");
if (ckeditorInstance.length > 0 && typeof ClassicEditor === 'undefined') {
  throw new Error("Please include ckeditor script");
}
ckeditorInstance.each(function () {
  var _$$data$toLowerCase,
    _$$data,
    _window$ArkatamaCkedi,
    _this = this;
  var componentId = $(this).attr('id');
  var editorType = (_$$data$toLowerCase = (_$$data = $(this).data('editor-type')) === null || _$$data === void 0 ? void 0 : _$$data.toLowerCase()) !== null && _$$data$toLowerCase !== void 0 ? _$$data$toLowerCase : "classic";
  window.ArkatamaCkeditor = (_window$ArkatamaCkedi = window.ArkatamaCkeditor) !== null && _window$ArkatamaCkedi !== void 0 ? _window$ArkatamaCkedi : {};
  if (!componentId) {
    throw new Error("Please define the id of editor");
  }
  switch (editorType) {
    case "classic":
      ClassicEditor.create($(this).get(0)).then(function (editor) {
        window.ArkatamaCkeditor[componentId] = editor;
        $(_this).parent().prev('.ckeditor-skeleton').fadeOut(200, function () {
          $(this).next('[data-at-editor]').removeClass('d-none');
          $(this).prev('.ckeditor-skeleton').remove();
        });
      })["catch"](function (err) {
        throw new Error(err);
      });
      break;
  }
});

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!**************************************!*\
  !*** ./resources/js/custom/index.js ***!
  \**************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _plugins_init__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./plugins/_init */ "./resources/js/custom/plugins/_init.js");
/* harmony import */ var _plugins_init__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_plugins_init__WEBPACK_IMPORTED_MODULE_0__);

window.getLivewireInstance = function (element) {
  var livewireId = $(element).closest("[wire\\:id]").attr("wire:id");
  return window.Livewire.find(livewireId);
};
$('.modal').on('hidden.bs.modal', function () {
  var livewireInstance = getLivewireInstance(this);
  if (livewireInstance) {
    livewireInstance.dispatch('reset');
  }
});
document.addEventListener("swal", function (e) {
  var _e$__livewire;
  var swalParam = e === null || e === void 0 || (_e$__livewire = e.__livewire) === null || _e$__livewire === void 0 ? void 0 : _e$__livewire.params[0];
  var icon, buttonStyle;
  switch (swalParam === null || swalParam === void 0 ? void 0 : swalParam.type) {
    case "success":
      icon = "success";
      buttonStyle = "btn btn-success";
      break;
    default:
      icon = "info";
      break;
  }
  Swal.fire({
    text: swalParam === null || swalParam === void 0 ? void 0 : swalParam.text,
    icon: icon,
    buttonsStyling: false,
    confirmButtonText: "Ok, got it!",
    customClass: {
      confirmButton: buttonStyle
    }
  });
});
})();

/******/ })()
;