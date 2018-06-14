{!! HTML::script('templates/director/js/jquery.min.js') !!}
@extends('index')

@section('content')
    {!! HTML::script('plugins/highchart/5.0.10/highcharts.js?v=1') !!}
    {!! HTML::script('plugins/highchart/5.0.10/modules/exporting.js') !!}

    {!! Form::token() !!}
    <style type="text/css">
        .color-container { height:auto; }
        .content-box .content {
            padding: 25px;
        }
    </style>
    <div class="content-box">
        <div class="head info-bg clearfix">
            <h5 class="content-title pull-left">Customer Issue Dashboard Analytic</h5>
            <div class="functions-btns pull-right">
                <a class="refresh-btn" href="#"><i class="zmdi zmdi-refresh"></i></a>
                <a class="fullscreen-btn" href="#"><i class="zmdi zmdi-fullscreen"></i></a>
                <a class="close-btn" href="#"><i class="zmdi zmdi-close"></i></a>
            </div>
        </div>

        <div class="content custom-content-form">
            <br>
            <div class="row">
                <div class="col-md-12">
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <label>Date</label><span style="margin-right: 10px;"></span>
                            <div class="input-group">
                                <input type="text" class="form-control" data-date-format='yyyy-mm-dd'
                                placeholder="Search for..."
                                   id="date"
                                   value="<?= date('Y-m-d'); ?>">
                                <div class="input-group-addon p-0 input-group-addon-sm"><button type="button" class="btn btn-info waves-effect" onclick="findChart()"><span class="fa fa-search"></span></button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br/><br/>
            <div class="row">
                <div class="col-md-6">
                    <div class="color-container warning-bg" data-toggle="modal" data-target="#warning-modal" data-toggle-tooltip="" data-placement="top" title="" data-original-title="Click to view demos for this color">
                    <span><strong>Status by Total Count</strong></span>
                    <div class="row">
                        <div class="col-sm-6 color">
                            <span>Open</span>
                            <span id="status-open-amount"></span>
                        </div>
                        <div class="col-sm-6 color">
                            <span>Closed</span>
                            <span id="status-closed-amount"></span>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="color-container info-bg" data-toggle="modal" data-target="#info-modal" data-toggle-tooltip="" data-placement="top" title="" data-original-title="Click to view demos for this color">
                    <span><strong>Priority by Total Count</strong></span>
                    <div class="row">
                        <div class="col-sm-4 color">
                            <span>LOW</span>
                            <span id="priority-low-amount"></span>
                        </div>
                        <div class="col-sm-4 color">
                            <span>MEDIUM</span>
                            <span id="priority-medium-amount"></span>
                        </div>
                        <div class="col-sm-4 color">
                            <span>HIGH</span>
                            <span id="priority-high-amount"></span>
                        </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="row">

                <br/><br/>
                <div class="row">
                    <div class="col-md-6 chart-width">
                        <div id="chart4" style="width: 100%;"></div>
                    </div>

                    <div class="col-md-6 chart-width">
                        <div id="chart1" style="width: 100%; margin:0 auto;"></div>
                    </div>

                    <div class="col-md-6 chart-width">
                        <div id="chart2" style="width: 100%;"></div>
                    </div>

                    <div class="col-md-6 chart-width">
                        <div id="chart3" style="width: 100%;"></div>
                    </div>

                    <div class="col-md-6 chart-width">
                        <div id="chart3" style="width: 100%;"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script type="text/javascript">

        $(function () {
            var option = {
                autoclose: true,
                disableTouchKeyboard: true
            };
            $('#date').datepicker(option);
            getchart();
        });



        var chart1 =  Highcharts.chart('chart1', {
            chart: {
                defaultSeriesType: 'line'
            },
            title: {
                text: 'CUSTOMER ISSUE BY STATUS'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ["aa","aaa","aaa"]
            },
            yAxis: {
                labels:
                    {
                        enabled: true
                    },
                title: {
                    text:"By Status Issue Count",
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: 'Open',
                    data: []
                }, {
                    name: 'Pending',
                    data: []
                }, {
                    name: 'Closed',
                    data: []
                }


            ]
        })

        Highcharts.chart('chart2', {
            chart: {
                defaultSeriesType: 'line'
            },
            title: {
                text: 'CUSTOMER ISSUE BY PRIORITY'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                labels:
                    {
                        enabled: true
                    },
                title: {
                    text:"By Priority Issue Count",
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: 'Low',
                    data: []
                }, {
                    name: 'Medium',
                    data: []
                }, {
                    name: 'High',
                    data: []
                }


            ]
        });

        Highcharts.chart('chart3', {
            chart: {
                defaultSeriesType: 'line'
            },
            title: {
                text: 'CUSTOMER ISSUE BY TYPE'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                labels:
                    {
                        enabled: true
                    },
                title: {
                    text:"By Issue Type Count",
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,  
                    borderWidth: 0
                }
            }
        });

        Highcharts.chart('chart4', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Issue Type By Total Count'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series : [{
                name: 'Issue',
                colorByPoint: true,
                data : []
            }]
        });

        function findChart() {

            getchart();
        }

        function getchart(){
            $('.custom-content-form').LoadingOverlay("show");

            var cWidth = $(".chart-width").width();

            var option = {
                chart: {
                    width : cWidth,
                    defaultSeriesType: 'line'
                },
            }; 

            var date = $('#date').val();
            var _token = $('input[name="_token"]').val();

            $.post("<?= URL('page/dashboard/customercare/getdata'); ?>",  {
                date: date,
                _token: _token
            },function(data, status){
                console.log(data);
                /* Count amount */
                $('#status-open-amount').html( data['count']['Status'][0]['count'] );
                $('#status-closed-amount').html( data['count']['Status'][1]['count'] );

                $('#priority-low-amount').html( data['count']['Priority'][0]['count'] );
                $('#priority-medium-amount').html( data['count']['Priority'][1]['count']);
                $('#priority-high-amount').html( data['count']['Priority'][2]['count']);


                $('.custom-content-form').LoadingOverlay('hide');

                var chart = $("#chart1").highcharts();
                chart.reflow();
                chart.series[0].setData(data["open"]);
                chart.series[1].setData(data["pending"]);
                chart.series[2].setData(data["closed"]);

                chart.xAxis[0].setCategories(data["date"]);

                chart.reflow();

                var chart = $("#chart2").highcharts();
                chart.reflow();
                chart.series[0].setData(data["low"]);
                chart.series[1].setData(data["medium"]);
                chart.series[2].setData(data["hight"]);
                chart.xAxis[0].setCategories(data["date"]);

                var chart = $("#chart3").highcharts();

                chart.reflow();

                /*Empty series*/
                while( chart.series.length > 0 ) {
                    chart.series[0].remove( false );
                }
                /* Adding series */
                for(var key in data['issueType'])
                {
                    chart.addSeries({                        
                        name: key,
                        data: data['issueType'][key]
                    });
                }
                chart.xAxis[0].setCategories(data["date"]);

                chart.reflow();

                /* Pie chart Issue by Status */
                var chart = $("#chart4").highcharts();
                var seriesData = [];
                for(var key in data['count']['IssueType'])
                {
                    seriesData.push([                        
                        data['count']['IssueType'][key]['name'],
                        parseInt( data['count']['IssueType'][key]['count'] )
                    ]);
                };
                chart.series[0].setData(seriesData, false);

                chart.reflow();

            });
        }
    </script>
@endsection