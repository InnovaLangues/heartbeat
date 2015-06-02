$(function () {
    $(document).ready(function () {

        var server_uid = $("#server-uid").html();

        $.getJSON(Routing.generate('api_snapshot', { uid: server_uid }), function( snapshots ) {
        
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });

            var loadMax = {
                name: 'Maximum Load',
                color: '#dd4b39',
                marker : {
                    enabled : false
                }
            };

            var load1min = {
                name: 'Load (1min)',
                color: '#00c0ef',
                type: 'areaspline',
                marker : {
                    enabled : false
                }
            };

            var load5min = {
                name: 'Load (5min)',
                color: '#00a65a',
                marker : {
                    enabled : false
                }
            };

            var load15min = {
                name: 'Load (15min)',
                color: '#f39c12',
                marker : {
                    enabled : false
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

            snapshots.forEach(function(snapshot) {

                console.log(snapshot);

                timestamp = snapshot.timestamp * 1000;

                loadMax.data.push({
                    x: timestamp,
                    y: parseFloat(snapshot.cpu_count)
                });

                load1min.data.push({
                    x: timestamp,
                    y: parseFloat(snapshot.cpu_load_min1)
                });

                load5min.data.push({
                    x: timestamp,
                    y: parseFloat(snapshot.cpu_load_min5)
                });

                load15min.data.push({
                    x: timestamp,
                    y: parseFloat(snapshot.cpu_load_min15)
                });

                memoryTotal.data.push({
                    x: timestamp,
                    y: parseFloat(snapshot.memory_total)
                });

                memoryUsed.data.push({
                    x: timestamp,
                    y: parseFloat(snapshot.memory_used)
                });

                swapTotal.data.push({
                    x: timestamp,
                    y: parseFloat(snapshot.memory_swap_total)
                });

                swapUsed.data.push({
                    x: timestamp,
                    y: parseFloat(snapshot.memory_swap_used)
                });

                diskTotal.data.push({
                    x: timestamp,
                    y: parseFloat(snapshot.disk_total)
                });

                diskUsed.data.push({
                    x: timestamp,
                    y: parseFloat(snapshot.disk_used)
                });
            });

            $('#cpu-container').highcharts({
                chart: {
                    type: 'spline',
                    zoomType: 'x',
                    animation: Highcharts.svg, // don't animate in old IE
                    marginRight: 10,
                    events: {
                        load: function () {

                            var loadMax = this.series[0];
                            var load1min = this.series[1];
                            var load5min = this.series[2];
                            var load15min = this.series[3];

                            /*

                            socket.on('serverUpdate', function (data) {
                            
                                var data = JSON.parse(data),x,y;

                                x = data.timestamp * 1000,

                                y = parseFloat(data.cpu.count);
                                loadMax.addPoint([x, y], true, true);
                                
                                y = parseFloat(data.cpu.load.min1);
                                load1min.addPoint([x, y], true, true);

                                y = parseFloat(data.cpu.load.min5);
                                load5min.addPoint([x, y], true, true);

                                y = parseFloat(data.cpu.load.min15);
                                load15min.addPoint([x, y], true, true);

                            })

                        */
                        }
                    }
                },
                title: {
                    text: 'Load'
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150
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
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + '</b><br/>' +
                            Highcharts.dateFormat('%d-%m-%Y %H:%M:%S', this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 2);
                    }
                },
                legend: {
                    enabled: true
                },
                exporting: {
                    enabled: false
                },
                series: [loadMax, load1min, load5min, load15min]
            });









            var memoryTotal = {
                name: 'Total',
                color: '#dd4b39',
                marker : {
                    enabled : false
                }
            };

            var memoryUsed = {
                name: 'Used',
                color: '#00c0ef',
                type: 'areaspline',
                marker : {
                    enabled : false
                }
            };

            $('#memory-container').highcharts({
                chart: {
                    type: 'spline',
                    zoomType: 'x',
                    animation: Highcharts.svg, // don't animate in old IE
                    marginRight: 10,
                    events: {
                        load: function () {

                            var memoryTotal = this.series[0];
                            var memoryUsed = this.series[1];

                            /*
                            socket.on('serverUpdate', function (data) {
                            
                                var data = JSON.parse(data),x,y;

                                x = data.timestamp * 1000,

                                y = parseFloat(data.memory.total);
                                memoryTotal.addPoint([x, y], true, true);
                                
                                y = parseFloat(data.memory.used);
                                memoryUsed.addPoint([x, y], true, true);
                            })
                            */
                        }
                    }
                },
                title: {
                    text: 'RAM'
                },
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150
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
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + '</b><br/>' +
                            Highcharts.dateFormat('%d-%m-%Y %H:%M:%S', this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 2);
                    }
                },
                legend: {
                    enabled: true
                },
                exporting: {
                    enabled: false
                },
                series: [memoryTotal, memoryUsed]
            });











            var swapTotal = {
                name: 'Total',
                color: '#dd4b39',
                marker : {
                    enabled : false
                }
            };

            var swapUsed = {
                name: 'Used',
                color: '#00c0ef',
                type: 'areaspline',
                marker : {
                    enabled : false
                }
            };

            $('#swap-container').highcharts({
                chart: {
                    type: 'spline',
                    zoomType: 'x',
                    animation: Highcharts.svg, // don't animate in old IE
                    marginRight: 10,
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
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150
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
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + '</b><br/>' +
                            Highcharts.dateFormat('%d-%m-%Y %H:%M:%S', this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 2);
                    }
                },
                legend: {
                    enabled: true
                },
                exporting: {
                    enabled: false
                },
                series: [swapTotal, swapUsed]
            });





            var diskTotal = {
                name: 'Total',
                color: '#dd4b39',
                marker : {
                    enabled : false
                }
            };

            var diskUsed = {
                name: 'Used',
                color: '#00c0ef',
                type: 'areaspline',
                marker : {
                    enabled : false
                }
            };

            $('#disk-container').highcharts({
                chart: {
                    type: 'spline',
                    zoomType: 'x',
                    animation: Highcharts.svg, // don't animate in old IE
                    marginRight: 10,
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
                xAxis: {
                    type: 'datetime',
                    tickPixelInterval: 150
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
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + '</b><br/>' +
                            Highcharts.dateFormat('%d-%m-%Y %H:%M:%S', this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 2);
                    }
                },
                legend: {
                    enabled: true
                },
                exporting: {
                    enabled: false
                },
                series: [diskTotal, diskUsed]
            });
        });
    });
});