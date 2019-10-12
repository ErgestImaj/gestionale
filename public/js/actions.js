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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/actions/actions.js":
/*!*****************************************!*\
  !*** ./resources/js/actions/actions.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).on('click', '.delete-btn', function (e) {
  e.preventDefault();
  var actionurl = $(this).data('action');
  var msg = $(this).data('content');
  swal({
    title: "Sei sicuro?",
    text: msg,
    icon: "warning",
    buttons: true,
    dangerMode: true
  }).then(function (willDelete) {
    if (willDelete) {
      axios["delete"](actionurl).then(function (response) {
        if (response.data.status == 'success') {
          table.ajax.reload();
          swal("Good job!", response.data.msg, "success");
        }
      })["catch"](function (err) {
        if (err.response.status == 200) {
          swal("Good job!", err.response.data.msg, "success");
          table.ajax.reload();
        } else {
          swal("Woops!", "Qualcosa è andato storto!", "error");
          swal.stopLoading();
          swal.close();
        }
      });
    }

    swal.stopLoading();
    swal.close();
  });
});
$(document).on('click', '.update-btn', function (e) {
  e.preventDefault();
  var actionurl = $(this).data('action');
  axios.patch(actionurl).then(function (response) {
    if (response.data.status == 'success') {
      table.ajax.reload();
      swal("Good job!", response.data.msg, "success");
    } else if (response.data.status == 'unauthorized') {
      swal("Woops!", response.data.msg, "error");
    }
  })["catch"](function (err) {
    if (err.response.status == 200) {
      swal("Good job!", err.response.data.msg, "success");
      table.ajax.reload();
    } else {
      swal("Woops!", "Qualcosa è andato storto!", "error");
      swal.stopLoading();
      swal.close();
    }
  });
});
$(document).on('click', '.post-action', function (e) {
  e.preventDefault();
  var actionurl = $(this).data('action');
  var msg = $(this).data('content');
  swal({
    title: "Sei sicuro?",
    text: msg,
    icon: "warning",
    buttons: true,
    dangerMode: true
  }).then(function (val) {
    if (val) {
      axios.post(actionurl).then(function (response) {
        if (response.data.status == 'success') {
          table.ajax.reload();
          swal("Good job!", response.data.msg, "success");
        }
      })["catch"](function (err) {
        if (err.response.status == 200) {
          swal("Good job!", err.response.data.msg, "success");
          table.ajax.reload();
        } else {
          swal("Woops!", "Qualcosa è andato storto!", "error");
          swal.stopLoading();
          swal.close();
        }
      });
    }
  });
});
$(document).on('click', '.sender-email', function (e) {
  e.preventDefault();
  var actionurl = $(this).data('action');
  $('#email-settings').toggleClass('open');
  $('#sendemailform').attr('action', actionurl);
});

/***/ }),

/***/ 1:
/*!***********************************************!*\
  !*** multi ./resources/js/actions/actions.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\gestionale\resources\js\actions\actions.js */"./resources/js/actions/actions.js");


/***/ })

/******/ });