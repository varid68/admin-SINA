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
/******/ 	return __webpack_require__(__webpack_require__.s = 47);
/******/ })
/************************************************************************/
/******/ ({

/***/ 47:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(48);


/***/ }),

/***/ 48:
/***/ (function(module, exports) {

$(function () {
  var width = 10;
  var interval = null;

  $('.glyphicon').click(function () {
    var san = $('input[name="password"]');
    san.attr('type') == 'password' ? san.attr('type', 'text') : san.attr('type', 'password');
  });

  function intervalLoading() {
    interval = setInterval(function () {
      $('.progress-bar').css('width', width + '%');
      width = width < 100 ? width + 10 : 10;
      console.log(width);
    }, 1000);
  }

  function onSuccess(data) {
    if (data != 'Wrong Password') {
      $('#select select').prop('disabled', false);
      $.each(data.matkul, function (index, value) {
        var val = {
          id: value.id_matkul,
          semester: value.semester
        };
        var json = JSON.stringify(val);
        $('select').append($("<option></option>").attr("value", json).text(value.mata_kuliah));
      });
    } else alert('Kombinasi username & password salah!');

    clearInterval(interval);
    $('#loading').css('visibility', 'hidden');
  }

  $('.btn-submit').click(function (e) {
    $('#loading').css('visibility', 'visible');
    intervalLoading();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    e.preventDefault();
    var formData = {
      username: $('input[name="username"]').val(),
      password: $('input[name="password"]').val()
    };

    if (formData.username != '' && formData.password != '') {
      $.ajax({
        type: 'POST',
        url: '/login',
        data: formData,
        success: function success(data) {
          onSuccess(data);
        },
        error: function error(err) {
          alert(err);
        }
      });
    }
  });

  $("select").change(function () {
    window.location = '/login/' + $(this).val();
    $('#loading').css('visibility', 'visible');
    intervalLoading();
  });
});

/***/ })

/******/ });