/**
 * Created by matrix on 17/10/18.
 */
'use strict';

class EnableHighCharts {
    test(){
        console.log("test Class");
    }
    showTweetHistoryChart(data, pointStart) {
         $('#tweet_history_chart').highcharts({
            credits: {
                  enabled: false
            },
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Tweets per day'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' :
                    'Pinch the chart to zoom in'
                },
            xAxis: {
                type: 'datetime',
                minRange: 14 * 24 * 3600000 // fourteen days
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Tweet count'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [{
                name: 'Tweets',
                type: 'area',
                pointInterval: 24 * 3600 * 1000,
                pointStart: pointStart,
                data: data
            }]
        });
    }

    showMostStatsChart(selector, title, data) {
        $('#'+selector).highcharts({
            credits: {
                      enabled: false
            },
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: title
            },
            tooltip: {
                useHTML: true,
                headerFormat: '<small>{point.key}</small><table>'
            },
            subtitle: {
                text: ''
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45,
                    dataLabels: {
                        useHTML: true
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Retweet',
                data: data
            }]
        });
    }

    showDaysofWeekColumnChart(data){
        $('#days_of_week_chart').highcharts({
            credits: {
                  enabled: false
            },
            chart: {
                type: 'column',
                margin: 75,
                options3d: {
                    enabled: true,
                    alpha: 10,
                    beta: 25,
                    depth: 70
                }
            },
            title: {
                text: ''
            },
            plotOptions: {
                column: {
                    depth: 25
                }
            },
            xAxis: {
                categories: ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"]
            },
            yAxis: {
                title: {
                    text: null
                }
            },
            series: [{
                name: 'Tweets',
                color: '#D0C000',
                data: data
            }]
        });
    }

    showHoursOfDayColumnChart(data){
        $('#hours_of_day_chart').highcharts({
            credits: {
                  enabled: false
            },
            chart: {
                type: 'column',
                margin: 75,
                options3d: {
                    enabled: true,
                    alpha: 10,
                    beta: 25,
                    depth: 70
                }
            },
            title: {
                text: ''
            },
            plotOptions: {
                column: {
                    depth: 25
                }
            },
            xAxis: {
                categories: ["0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"]
            },
            yAxis: {
                title: {
                    text: null
                }
            },
            series: [{
                name: 'Tweets',
                data: data
            }]
        });
    }
}

export default EnableHighCharts;
