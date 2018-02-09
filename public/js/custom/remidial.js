/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 51);
/******/ })
/************************************************************************/
/******/ ({

/***/ 51:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(52);


/***/ }),

/***/ 52:
/***/ (function(module, exports) {

$(function () {
  var toggle = false;
  var absensi = 0;
  var tugas = 0;
  var uts = 0;
  var uas = 0;
  var finalScoreHtml = null;

  function getGrade(nilai) {
    var grade = null;

    if (nilai <= 100 && nilai >= 92) grade = 'A';else if (nilai <= 91 && nilai >= 84) grade = 'A-';else if (nilai <= 83 && nilai >= 75) grade = 'B+';else if (nilai <= 74 && nilai >= 67) grade = 'B';else if (nilai <= 66 && nilai >= 59) grade = 'B-';else if (nilai <= 58 && nilai >= 50) grade = 'C+';else if (nilai <= 49 && nilai >= 42) grade = 'C';else if (nilai <= 41 && nilai >= 34) grade = 'C';else if (nilai <= 33 && nilai >= 25) grade = 'D+';else if (nilai <= 24) grade = 'D';else grade = '!!';

    return grade;
  }

  function calculateScore(thisObject) {
    var finalScore = Math.round(absensi + tugas + uts + uas);
    var grade = getGrade(finalScore);
    var hasil = finalScore + ' (' + grade + ')';
    thisObject.parents('tr').find('.final-score').val(finalScore);
    thisObject.parent().siblings('.nilai_akhir').text(hasil);
  }

  $('#btn-modal-download').click(function () {
    window.location = '/remidial-pdf';
  });

  $('.btn-info').click(function () {
    $('.absensi, .tugas, .uts, .uas').siblings().show();
    $('.absensi, .tugas, .uts, .uas').hide();
    $('.on-edit').hide();
    $('.btn-info').show();

    if (toggle) {
      $(this).parents('tr').find('.absensi, .tugas, .uts, .uas').hide();
      $(this).parents('tr').find('.absensi, .tugas, .uts, .uas').siblings().show();
      $(this).show();
      $(this).siblings('.on-edit').hide();
      finalScoreHtml = null;
      toggle = false;
    } else {
      $(this).parents('tr').find('.absensi, .tugas, .uts, .uas').show();
      $(this).parents('tr').find('.absensi, .tugas, .uts, .uas').siblings().hide();
      $(this).hide();
      $(this).siblings('.on-edit').show();
      $(this).parents('tr').find('.absensi').focus();
      finalScoreHtml = $(this).parent().siblings('.nilai_akhir').html();
      toggle = true;
    }
  });

  $('.dismiss').click(function () {
    $('.absensi, .tugas, .uts, .uas').siblings().show();
    $('.absensi, .tugas, .uts, .uas').hide();
    $('.on-edit').hide();
    $('.btn-info').show();

    var absensi = $(this).parents('tr').find('.absensi').data('absensi');
    var tugas = $(this).parents('tr').find('.tugas').data('tugas');
    var uts = $(this).parents('tr').find('.uts').data('uts');
    var uas = $(this).parents('tr').find('.uas').data('uas');
    var finalScore = $(this).parents('tr').find('.final-score').data('final');
    $(this).parents('tr').find('.absensi').val(absensi);
    $(this).parents('tr').find('.tugas').val(tugas);
    $(this).parents('tr').find('.uts').val(uts);
    $(this).parents('tr').find('.uas').val(uas);
    $(this).parents('tr').find('.final-score').val(finalScore);
    $(this).parents('tr').find('.nilai_akhir').html(finalScoreHtml);
    toggle = false;
  });

  $('.absensi').keyup(function (e) {
    absensi = e.target.value / 14 * 10 / 100 * 100;
    calculateScore($(this));
  });

  $('.tugas').keyup(function (e) {
    tugas = parseInt(20 / 100 * e.target.value);
    calculateScore($(this));
  });

  $('.uts').keyup(function (e) {
    uts = parseInt(30 / 100 * e.target.value);
    calculateScore($(this));
  });

  $('.uas').keyup(function (e) {
    uas = parseInt(40 / 100 * e.target.value);
    calculateScore($(this));
  });

  $('input').keypress(function (e) {
    if (e.keyCode == 13) {
      e.preventDefault();
      input = $("input[type=number]");
      i = input.index(this);
      if (input[i + 1] != null) {
        next = input[i + 1];
        next.focus();
        next.select();
        return false;
      } else {
        input[0].focus();
        next.select();
        return false;
      }
    }
  });
});

/***/ })

/******/ });