/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/custom/table/_init.js ***!
  \********************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
$('[data-action-delete]').each(function (element) {
  $(this).on('click', function () {
    var livewireInstance = getLivewireInstance($(this));
    var actionParams = $(this).data('action-params');
    var actionName = $(this).data('action');
    var actionReceiver = $(this).data('action-receiver');
    Swal.fire({
      text: 'Are you sure you want to remove?',
      icon: 'warning',
      buttonsStyling: false,
      showCancelButton: true,
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
      customClass: {
        confirmButton: 'btn btn-danger',
        cancelButton: 'btn btn-secondary'
      }
    }).then(function (result) {
      if (result.isConfirmed) {
        livewireInstance.dispatchTo(actionReceiver, actionName, _objectSpread({}, actionParams));
      }
    });
  });
});
$('[data-action-search]').on('change', function () {
  var tableId = $(this).data('table-id');
  window.LaravelDataTables["".concat(tableId)].search($(this).val()).draw();
});
/******/ })()
;