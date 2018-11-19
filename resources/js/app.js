
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

global.Highcharts = require('highcharts');
require('highcharts/highcharts-3d')(Highcharts);
require('./modules/front-custom.js');


import EnableHighCharts from './modules/enableHighCharts';
global.EnableHighCharts = EnableHighCharts;