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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/dashboard/dashboard.js":
/*!*********************************************!*\
  !*** ./resources/js/dashboard/dashboard.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  'use strict';

  $(function () {
    if ($("#orders-chart").length) {
      var currentChartCanvas = $("#orders-chart").get(0).getContext("2d");
      var currentChart = new Chart(currentChartCanvas, {
        type: 'bar',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: 'Delivered',
            data: [260, 380, 230, 400, 780, 530, 340, 200, 400, 650, 780, 500],
            backgroundColor: '#392c70'
          }, {
            label: 'Estimated',
            data: [480, 600, 510, 600, 1000, 570, 500, 350, 450, 710, 820, 650],
            backgroundColor: '#d1cede'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 20,
              bottom: 0
            }
          },
          scales: {
            yAxes: [{
              gridLines: {
                drawBorder: false
              },
              ticks: {
                stepSize: 250,
                fontColor: "#686868"
              }
            }],
            xAxes: [{
              stacked: true,
              ticks: {
                beginAtZero: true,
                fontColor: "#686868"
              },
              gridLines: {
                display: false
              },
              barPercentage: 0.4
            }]
          },
          legend: {
            display: false
          },
          elements: {
            point: {
              radius: 0
            }
          },
          legendCallback: function legendCallback(chart) {
            var text = [];
            text.push('<ul class="legend' + chart.id + '">');

            for (var i = 0; i < chart.data.datasets.length; i++) {
              text.push('<li><span class="legend-label" style="background-color:' + chart.data.datasets[i].backgroundColor + '"></span>');

              if (chart.data.datasets[i].label) {
                text.push(chart.data.datasets[i].label);
              }

              text.push('</li>');
            }

            text.push('</ul>');
            return text.join("");
          }
        }
      });
      document.getElementById('orders-chart-legend').innerHTML = currentChart.generateLegend();
    }

    if ($('#sales-chart').length) {
      var lineChartCanvas = $("#sales-chart").get(0).getContext("2d");
      var data = {
        labels: ["2013", "2014", "2014", "2015", "2016", "2017", "2018"],
        datasets: [{
          label: 'Support',
          data: [1500, 7030, 1050, 2300, 3510, 6800, 4500],
          borderColor: ['#392c70'],
          borderWidth: 3,
          fill: false
        }, {
          label: 'Product',
          data: [5500, 4080, 3050, 5600, 4510, 5300, 2400],
          borderColor: ['#d1cede'],
          borderWidth: 3,
          fill: false
        }]
      };
      var options = {
        scales: {
          yAxes: [{
            gridLines: {
              drawBorder: false
            },
            ticks: {
              stepSize: 2000,
              fontColor: "#686868"
            }
          }],
          xAxes: [{
            display: false,
            gridLines: {
              drawBorder: false
            }
          }]
        },
        legend: {
          display: false
        },
        elements: {
          point: {
            radius: 3
          }
        },
        stepsize: 1
      };
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: data,
        options: options
      });
    }

    if ($("#sales-status-chart").length) {
      var pieChartCanvas = $("#sales-status-chart").get(0).getContext("2d");
      var pieChart = new Chart(pieChartCanvas, {
        type: 'pie',
        data: {
          datasets: [{
            data: [75, 25, 15, 10],
            backgroundColor: ['#392c70', '#04b76b', '#ff5e6d', '#eeeeee'],
            borderColor: ['#392c70', '#04b76b', '#ff5e6d', '#eeeeee']
          }],
          // These labels appear in the legend and in the tooltips when hovering different arcs
          labels: ['Active users', 'Subscribers', 'New visitors', 'Others']
        },
        options: {
          responsive: true,
          animation: {
            animateScale: true,
            animateRotate: true
          },
          legend: {
            display: false
          },
          legendCallback: function legendCallback(chart) {
            var text = [];
            text.push('<ul class="legend' + chart.id + '">');

            for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
              text.push('<li><span class="legend-label" style="background-color:' + chart.data.datasets[0].backgroundColor[i] + '"></span>');

              if (chart.data.labels[i]) {
                text.push(chart.data.labels[i]);
              }

              text.push('<label class="badge badge-light badge-pill legend-percentage ml-auto">' + chart.data.datasets[0].data[i] + '%</label>');
              text.push('</li>');
            }

            text.push('</ul>');
            return text.join("");
          }
        }
      });
      document.getElementById('sales-status-chart-legend').innerHTML = pieChart.generateLegend();
    }

    if ($("#daily-sales-chart").length) {
      var dailySalesChartData = {
        datasets: [{
          data: [50, 10, 10, 30],
          backgroundColor: ['#392c70', '#04b76b', '#e9e8ef', '#ff5e6d'],
          borderWidth: 0
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: ['Mail order sales', 'Instore sales', 'Download sales', 'Sales return']
      };
      var dailySalesChartOptions = {
        responsive: true,
        maintainAspectRatio: true,
        animation: {
          animateScale: true,
          animateRotate: true
        },
        legend: {
          display: false
        },
        legendCallback: function legendCallback(chart) {
          var text = [];
          text.push('<ul class="legend' + chart.id + '">');

          for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
            text.push('<li><span class="legend-label" style="background-color:' + chart.data.datasets[0].backgroundColor[i] + '"></span>');

            if (chart.data.labels[i]) {
              text.push(chart.data.labels[i]);
            }

            text.push('</li>');
          }

          text.push('</ul>');
          return text.join("");
        },
        cutoutPercentage: 70
      };
      var dailySalesChartCanvas = $("#daily-sales-chart").get(0).getContext("2d");
      var dailySalesChart = new Chart(dailySalesChartCanvas, {
        type: 'doughnut',
        data: dailySalesChartData,
        options: dailySalesChartOptions
      });
      document.getElementById('daily-sales-chart-legend').innerHTML = dailySalesChart.generateLegend();
    }

    if ($("#inline-datepicker-example").length) {
      $('#inline-datepicker-example').datepicker({
        enableOnReadonly: true,
        todayHighlight: true
      });
    }
  });
})(jQuery);

/***/ }),

/***/ 4:
/*!***************************************************!*\
  !*** multi ./resources/js/dashboard/dashboard.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\gestionale\resources\js\dashboard\dashboard.js */"./resources/js/dashboard/dashboard.js");


/***/ })

/******/ });