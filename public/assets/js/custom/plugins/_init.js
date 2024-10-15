/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/js/custom/plugins/_init.js ***!
  \**********************************************/
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
/******/ })()
;