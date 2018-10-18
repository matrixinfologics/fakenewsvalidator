'use strict';

global.$ = require("jquery");
global.jQuery = require("jquery");

require('jquery-slim');
require('bootstrap');

require('./libs/highcharts.js');
require('./libs/highcharts-3d.js');

require('./modules/front-custom.js');


import EnableHighCharts from './modules/enableHighCharts';
global.EnableHighCharts = EnableHighCharts;

