$(function () {
    // all created charts are pushed in this array
    var charts = [];

    // sync tooltip and crosshair thrue graphs and series
    function syncTooltip(container, p) {
        var i = 0, j = 0, xData;
        var data;
        for (; i < charts.length; i++) {
            if (container.id !== charts[i].container.id) {
                // get only x data
                xData = charts[i].series[0].xData;
                // get all data
                data = charts[i].series[0].data;

                var index = xData.indexOf(p);
                if (index > 0) {
                    var points = [];
                    $.each(charts[i].series, function (k, one) {
                        points.push(one.data[index])
                    });
                    charts[i].tooltip.refresh(points);

                    for (; j < data.length; j++) {
                        if (data[j].x === p) {
                            var p2 = charts[i].series[0].data[j];
                            charts[i].xAxis[0].drawCrosshair({chartX: p2.plotX, chartY: p2.plotY}, p2);
                        }
                    }
                    j = 0;
                }
            }
        }

    }

    // share zoom value thrue graphs
    function shareZoomValue(min, max) {
        var i = 0;
        for (; i < charts.length; i++) {
            charts[i].xAxis[0].setExtremes(min, max);
        }
    }

    // remove tooltips and crosshairs when mouse out of graphs container
    function removeTooltipsAndCrosshairs() {
        var i = 0, j = 0;
        for (; i < charts.length; i++) {
            charts[i].tooltip.hide();
            charts[i].xAxis[0].hideCrosshair();
        }
    }
    
    // on point click show details modal
    function showDetails(point){
        console.log(point);
    }

    $(document).ready(function () {

        var server_uid = $("#server-uid").html();

        // common charts options
        var options = {
            global: {
                useUTC: false
            },
            series: {
                allowPointSelect: true
            },
            tooltip: {
                crosshairs: true,
                shared: true,
                useHTML: true,
                hideDelay: 10,
                shadow: false,
                followPointer: false
            },
            plotOptions: {
                series: {
                    point: {
                        events: {
                            mouseOver: function () {
                                //console.log('sync man');
                                syncTooltip(this.series.chart.container, this.x);
                            },
                            click: function () {
                                console.log('clicked');
                                showDetails(this);
                            }
                        }
                    }
                }
            },
            chart: {
                type: 'spline',
                zoomType: 'x',
                animation: false, //Highcharts.svg, // don't animate in old IE
                marginRight: 10,
                events: {
                    selection: function (event) {
                        // selection
                        var min;
                        var max;
                        if (event.xAxis) {
                            min = event.xAxis[0].min;
                            max = event.xAxis[0].max;
                        }
                        // zoom reset value
                        else {
                            min = this.series[0].xAxis.dataMin;
                            max = this.series[0].xAxis.dataMax;
                        }

                        shareZoomValue(min, max);
                    }
                }
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150
            },
            legend: {
                enabled: true
            },
            exporting: {
                enabled: false
            }
        };

        // handle graphs container mouseout event in order to hide all tooltips and crosshairs
        $('.graphs-container').on('mouseleave', function () {
            removeTooltipsAndCrosshairs();
        });

        // get data
        $.getJSON(Routing.generate('api_snapshot', {uid: server_uid}), function (snapshots) {

            var loadMax = {
                name: 'Maximum Load',
                color: '#dd4b39',
                marker: {
                    enabled: false
                }
            };
            var load1min = {
                name: 'Load (1min)',
                color: '#00c0ef',
                type: 'areaspline',
                marker: {
                    enabled: false
                }
            };
            var load5min = {
                name: 'Load (5min)',
                color: '#00a65a',
                marker: {
                    enabled: false
                }
            };
            var load15min = {
                name: 'Load (15min)',
                color: '#f39c12',
                marker: {
                    enabled: false
                }
            };
            var memoryTotal = {
                name: 'Total',
                color: '#dd4b39',
                marker: {
                    enabled: false
                }
            };
            var memoryUsed = {
                name: 'Used',
                color: '#00c0ef',
                type: 'areaspline',
                marker: {
                    enabled: false
                }
            };
            var swapTotal = {
                name: 'Total',
                color: '#dd4b39',
                marker: {
                    enabled: false
                }
            };
            var swapUsed = {
                name: 'Used',
                color: '#00c0ef',
                type: 'areaspline',
                marker: {
                    enabled: false
                }
            };
            var diskTotal = {
                name: 'Total',
                color: '#dd4b39',
                marker: {
                    enabled: false
                }
            };
            var diskUsed = {
                name: 'Used',
                color: '#00c0ef',
                type: 'areaspline',
                marker: {
                    enabled: false
                }
            };
            var timestamp;
            loadMax.data = [];
            load1min.data = [];
            load5min.data = [];
            load15min.data = [];
            memoryTotal.data = [];
            memoryUsed.data = [];
            swapTotal.data = [];
            swapUsed.data = [];
            diskTotal.data = [];
            diskUsed.data = [];

            snapshots.forEach(function (snapshot) {
                //console.log(snapshot);
                timestamp = snapshot.timestamp * 1000;
                // point to array to avoid turboThreshold limitation
                // cf Highcharts error #12: www.highcharts.com/errors/12
                loadMax.data.push([timestamp, parseFloat(snapshot.cpu_count)]);
                load1min.data.push([timestamp, parseFloat(snapshot.cpu_load_min1)]);
                load5min.data.push([timestamp, parseFloat(snapshot.cpu_load_min5)]);
                load15min.data.push([timestamp, parseFloat(snapshot.cpu_load_min15)]);
                memoryTotal.data.push([timestamp, parseFloat(snapshot.memory_total)]);
                memoryUsed.data.push([timestamp, parseFloat(snapshot.memory_used)]);
                swapTotal.data.push([timestamp, parseFloat(snapshot.memory_swap_total)]);
                swapUsed.data.push([timestamp, parseFloat(snapshot.memory_swap_used)]);
                diskTotal.data.push([timestamp, parseFloat(snapshot.disk_total)]);
                diskUsed.data.push([timestamp, parseFloat(snapshot.disk_used)]);
            });
            var lastIndex = snapshots.length - 1;
            //CPU Box
            var cpuPercentUsed = Math.round((snapshots[lastIndex].cpu_load_min15 / snapshots[lastIndex].cpu_count) * 100);
            $('.info-box-cpu .cpu-count').html(snapshots[lastIndex].cpu_count);
            $('.info-box-cpu .cpu-cores-percent-used').html(cpuPercentUsed);
            $('.info-box-cpu .cpu-load-min1').html(snapshots[lastIndex].cpu_load_min1);
            $('.info-box-cpu-icon')
                    .removeClass('glyphicon-refresh glyphicon-refresh-animate')
                    .addClass('bg-green');
            $('.info-box-cpu-icon i').addClass('fa-thumbs-o-up');
            //Swap Box
            var swapPercentUsed = Math.round((snapshots[lastIndex].memory_swap_used / snapshots[lastIndex].memory_swap_total) * 100);
            $('.info-box-memory-swap .memory-swap-percent-used').html(swapPercentUsed);
            $('.info-box-memory-swap .memory-swap-total').html(bytesToSize(snapshots[lastIndex].memory_swap_total));
            $('.info-box-memory-swap-icon')
                    .removeClass('glyphicon-refresh glyphicon-refresh-animate')
                    .addClass('bg-green');
            $('.info-box-memory-swap-icon i').addClass('fa-thumbs-o-up');
            //Disk Box
            var diskPercentUsed = Math.round((snapshots[lastIndex].disk_used / snapshots[lastIndex].disk_total) * 100);
            $('.info-box-disk .disk-percent-used').html(diskPercentUsed);
            $('.info-box-disk .disk-total').html(bytesToSize(snapshots[lastIndex].disk_total));
            $('.info-box-disk-icon')
                    .removeClass('glyphicon-refresh glyphicon-refresh-animate')
                    .addClass('bg-green');
            $('.info-box-disk-icon i').addClass('fa-thumbs-o-up');


            charts[0] = new Highcharts.Chart($.extend(true, {}, options, {
                chart: {
                    renderTo: 'cpu-container',
                    events: {
                        load: function () {

                            var loadMax = this.series[0];
                            var load1min = this.series[1];
                            var load5min = this.series[2];
                            var load15min = this.series[3];


                            /*socket.on('serverUpdate', function (data) {
                             
                             var data = JSON.parse(data), x, y;
                             
                             x = data.timestamp * 1000,
                             y = parseFloat(data.cpu.count);
                             loadMax.addPoint([x, y], true, true);
                             
                             y = parseFloat(data.cpu.load.min1);
                             load1min.addPoint([x, y], true, true);
                             
                             y = parseFloat(data.cpu.load.min5);
                             load5min.addPoint([x, y], true, true);
                             
                             y = parseFloat(data.cpu.load.min15);
                             load15min.addPoint([x, y], true, true);
                             
                             });*/


                        }
                    }
                },
                title: {
                    text: 'Load'
                },
                yAxis: {
                    title: {
                        text: 'Load'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                series: [loadMax, load1min, load5min, load15min]
            }));


            charts[1] = new Highcharts.Chart($.extend(true, {}, options, {
                chart: {
                    renderTo: 'memory-container',
                    events: {
                        load: function () {

                            var memoryTotal = this.series[0];
                            var memoryUsed = this.series[1];

                            /*socket.on('serverUpdate', function (data) {
                             
                             var data = JSON.parse(data), x, y;
                             
                             x = data.timestamp * 1000,
                             y = parseFloat(data.memory.total);
                             memoryTotal.addPoint([x, y], true, true);
                             
                             y = parseFloat(data.memory.used);
                             memoryUsed.addPoint([x, y], true, true);
                             })*/

                        }
                    }
                },
                title: {
                    text: 'RAM'
                },
                yAxis: {
                    title: {
                        text: 'Memory'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                series: [memoryTotal, memoryUsed]
            }));

            charts[2] = new Highcharts.Chart($.extend(true, {}, options, {
                chart: {
                    renderTo: 'swap-container',
                    events: {
                        load: function () {

                            var swapTotal = this.series[0];
                            var swapUsed = this.series[1];
                            /*
                             
                             socket.on('serverUpdate', function (data) {
                             
                             var data = JSON.parse(data),x,y;
                             
                             x = data.timestamp * 1000,
                             
                             y = parseFloat(data.memory.swap.total);
                             swapTotal.addPoint([x, y], true, true);
                             
                             y = parseFloat(data.memory.swap.used);
                             swapUsed.addPoint([x, y], true, true);
                             })
                             
                             */
                        }
                    }
                },
                title: {
                    text: 'Swap'
                },
                yAxis: {
                    title: {
                        text: 'Swap'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                series: [swapTotal, swapUsed]
            }));

            charts[3] = new Highcharts.Chart($.extend(true, {}, options, {
                chart: {
                    renderTo: 'disk-container',
                    events: {
                        load: function () {

                            var diskTotal = this.series[0];
                            var diskUsed = this.series[1];
                            /*
                             
                             socket.on('serverUpdate', function (data) {
                             
                             var data = JSON.parse(data),x,y;
                             
                             x = data.timestamp * 1000,
                             
                             y = parseFloat(data.disk.total);
                             diskTotal.addPoint([x, y], true, true);
                             
                             y = parseFloat(data.disk.used);
                             diskUsed.addPoint([x, y], true, true);
                             })
                             
                             */
                        }
                    }
                },
                title: {
                    text: 'Disk'
                },
                yAxis: {
                    title: {
                        text: 'Disk'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                series: [diskTotal, diskUsed]
            }));

        });
    });
});