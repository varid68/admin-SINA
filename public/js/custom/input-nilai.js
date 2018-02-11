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
/******/ 	return __webpack_require__(__webpack_require__.s = 49);
/******/ })
/************************************************************************/
/******/ ({

/***/ 49:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(50);


/***/ }),

/***/ 50:
/***/ (function(module, exports) {

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

$(function () {
  var tugas = 0;
  var absensi = 0;
  var uts = 0;
  var hasilAkhir = [];

  (function focusOnInit() {
    $('input').eq(1).focus();
  })();

  // membuat array kosong untuk menghitung nilai akhir
  (function createEmptyArray() {
    var length = $('tr').length - 1;
    for (var i = 0; i < length; i++) {
      hasilAkhir.push([].concat(_toConsumableArray(Array(4))).map(function (u, i) {
        return null;
      }));
    }
  })();

  // menghitung nilai absensi 
  $('.absensi').keyup(function (e) {
    var Hasil = e.target.value / 14 * 10 / 100 * 100;
    absensi = parseInt(Hasil.toFixed(2));
    var indexElem = $('.absensi').index(this);
    hasilAkhir[indexElem][0] = absensi;
  });

  // menghitung nilai tugas 30%
  $('.tugas').keyup(function (e) {
    tugas = parseInt(20 / 100 * e.target.value);
    var indexElem = $('.tugas').index(this);
    hasilAkhir[indexElem][1] = tugas;
  });

  //menghitung nilai uts 30%
  $('.uts').keyup(function (e) {
    uts = parseInt(30 / 100 * e.target.value);
    var indexElem = $('.uts').index(this);
    hasilAkhir[indexElem][2] = uts;
  });

  // menghitung nilai uas 40%
  $('.uas').keyup(function (e) {
    uas = parseInt(40 / 100 * e.target.value);
    var indexElem = $('.uas').index(this);
    var i = hasilAkhir[indexElem][0] + hasilAkhir[indexElem][1] + hasilAkhir[indexElem][2] + uas;
    if (e.target.value != '') gradeNilai(i, indexElem);
  });

  // memberikan warna merah nilai jika di bawah standart < 60
  function gradeNilai(nilai, indexElem) {
    var grade = null;

    if (nilai <= 100 && nilai >= 92) grade = 'A';else if (nilai <= 91 && nilai >= 84) grade = 'A-';else if (nilai <= 83 && nilai >= 75) grade = 'B+';else if (nilai <= 74 && nilai >= 67) grade = 'B';else if (nilai <= 66 && nilai >= 59) grade = 'B-';else if (nilai <= 58 && nilai >= 50) grade = 'C+';else if (nilai <= 49 && nilai >= 42) grade = 'C';else if (nilai <= 41 && nilai >= 34) grade = 'C';else if (nilai <= 33 && nilai >= 25) grade = 'D+';else if (nilai <= 24) grade = 'D';else grade = '!!';

    $('input.nilai-akhir[type="hidden"]').eq(indexElem).val(nilai);
    var selector = $('td.grade').eq(indexElem).html(nilai + '&nbsp&nbsp&nbsp' + grade);
    nilai < 59 ? selector.css('color', 'red') : selector.css('color', 'black');
  }

  // pindah textbox saat enter
  $('input').keypress(function (e) {
    if (e.keyCode == 13) {
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