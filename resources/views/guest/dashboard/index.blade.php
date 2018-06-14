@extends('guest.dashboard.template.content')

@section('content')
{!! HTML::script('plugins/highchart/5.0.10/highcharts.js?v=1.1') !!}
{!! HTML::script('plugins/highchart/5.0.10/modules/exporting.js') !!}
<div class="row">
    <!--    <button class="btn btn-success btn-fill" type="button" onclick="updateHighChart('containerCount')">
            <i class="fa fa-search"></i> Searsch!
        </button>-->
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Tanggal</span>
            <input type="text" class="form-control" data-date-format='yyyy-mm-dd'   placeholder="Search for..." 
                   id="date"
                   value="<?= date('Y-m-d'); ?>">
            <span class="input-group-addon" id="basic-addon1">Shift</span>
            <select name="shift" id="shift" class="form-control">
                <option value="0"> All </option>
                <option value="1"> Shift 1 </option>
                <option value="2"> Shift 2 </option>
                <option value="3"> Shift 3 </option>
            </select>
            <span class="input-group-btn">

                <button class="btn btn-success btn-fill" type="button" onclick="constructTrans()">
                    <i class="fa fa-search"></i> Search!
                </button>
            </span>
        </div><!-- /input-group -->
    </div><!-- /.col-lg-6 -->
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <h4>Transaction Data Summary</h4>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <!--<h4 class="title">Transaction Statistics</h4>-->
                <!--<p class="category">Transaction Performance</p>-->
            </div>
            <div class="content">

                <div id="transaction-resume-by-shift" class="row" style="height: 100%"></div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h4>Transaction By User Type</h4>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <!--<h4 class="title">Transaction Statistics</h4>-->
                <!--<p class="category">Transaction Performance</p>-->
            </div>
            <div class="content">

                <div id="transaction-by-user-type" class="row" style="height: 100%"></div>

            </div>
        </div>
    </div>
</div>

<div class="row">
<div class="col-md-12">
        <h4>Data Roadside VS Data CBO</h4>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="header">
                <!--<h4 class="title">Transaction Statistics</h4>-->
                <!--<p class="category">Transaction Performance</p>-->
            </div>
            <div class="content">

                <div id="containerVsDataCount" style="height: 300px"></div>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="header">
                <!--<h4 class="title">Transaction Statistics</h4>-->
                <!--<p class="category">Transaction Performance</p>-->
            </div>
            <div class="content">

                <div id="containerVsDataSUM" style="height: 300px"></div>

            </div>
        </div>
    </div>
    <div class="col-md-2">
        
    </div>
</div>
<div class="row">
    
    <div class="col-md-12">
        <h4>Charged vs Uncharged Transaction</h4>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="header">
                <h4 class="title">Transaction Statistics</h4>
                <p class="category">Transaction Performance</p>
            </div>
            <div class="content">

                <div id="containerCount" style="height: 300px"></div>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="header">
                <h4 class="title">Transaction Statistics</h4>
                <p class="category">Transaction Performance</p>
            </div>
            <div class="content">

                <div id="containerSum" style="height: 300px"></div>

            </div>
        </div>
    </div>
    <div class="col-md-2">
        <!-- <div class="row" id="detailShift">

        </div> -->
    </div>
</div>

<!-- <div class="row">
    <div class="col-md-12">
        <h4>Transaction Roadside</h4>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">Transaction Statistics</h4>
                <p class="category">Transaction Performance</p>
            </div>
            <div class="content">
                <div id="containerCountRoadSite" style="height: 300px"></div>

            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="header">
                <h4 class="title">Transaction Statistics</h4>
                <p class="category">Transaction Performance</p>
            </div>
            <div class="content">

                <div id="containerSum2" style="height: 300px"></div>

            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="row" id="detailShiftRoadSite">

        </div>
    </div>
</div> -->


<div id="loader">

</div>
<script>
    $(function () {
        $('#date').datepicker({
            autoclose: true
        });

        constructTrans();
    });
    function constructTrans() {
        searchTransaction('<?= URL('page/dashboard/proses'); ?>');
    }


    function searchTransaction(url) {
//clearTimeout();
//       var xhr = new window.XMLHttpRequest();
//       xhr.abort();
        var date = $('#date').val();
        var shift = $('#shift').val();
        getTransaction(url, date,shift);
    }

    function getTransaction(url, date,shift) {
        var _token = $('input[name="_token"]').val();
        $('#loader').html('<div class="background-loading"></div>');
        $.post(url,
                {
                    date: date,
                    shift: shift,
                    _token: _token
                }, function (data, status) {
            var parseData = JSON.parse(data);
            console.log(parseData);
//            alert(data);
//            $('#detailShift').html(data);
            setLineHighChartOneData(JSON.stringify(parseData.countVS));
            setLineHighChartOneData(JSON.stringify(parseData.sumVS));
            setLineHighChartOneData(JSON.stringify(parseData.count));
            setLineHighChartOneData(JSON.stringify(parseData.sum));
            // setLineHighChartOneData(JSON.stringify(parseData.sum2));
            // setLineHighChartOneData(JSON.stringify(parseData.countRoadSite));
            var transactionResume = parseData.transactionResume;
            var txtTransactionResume = '';
            for(var no = 0; no < transactionResume.length; no ++)
            {
                txtTransactionResume += setTransactionResumeByShift(no, transactionResume[no].cbo, transactionResume[no].roadside, transactionResume[no].charged, transactionResume[no].uncharged );
            }
            // console.log(txtTransactionResume);
            $('#transaction-resume-by-shift').html(txtTransactionResume);

            /* Transaction by user type */
            var transactionByUserType = parseData.transactionByUserType;
            var txtTransactionByUserType = '';
            for(var no = 0; no < transactionByUserType.length; no ++)
            {
                // console.log( transactionByUserType[no].raw.rows[0].KYW_COUNT);
                txtTransactionByUserType += setTransactionByUserType(no, transactionByUserType[no].raw.rows[0].UMM_COUNT, transactionByUserType[no].raw.rows[0].MKJ_COUNT, transactionByUserType[no].raw.rows[0].KYW_COUNT, transactionByUserType[no].raw.rows[0].OPL_COUNT );
            }
            // console.log(txtTransactionResume);
            $('#transaction-by-user-type').html(txtTransactionByUserType);

            var jsonShift = parseData.shift;
            var txtShift = '';
            for (var no = 0; no < jsonShift.length; no++) {
                txtShift += setShiftContainer('shift', jsonShift[no].shiftNumber, jsonShift[no].shiftCount, jsonShift[no].shiftSum);
            }
            $('#detailShift').html(txtShift);

            var jsonShift2 = parseData.shiftRoadSite;
            var txtShift2 = '';
            // for (var no = 0; no < jsonShift2.length; no++) {
            //     txtShift2 += setShiftContainer('shiftRoadSite', jsonShift2[no].shiftNumber, jsonShift2[no].shiftCount, jsonShift2[no].shiftSum);
            // }
            // $('#detailShiftRoadSite').html(txtShift2);
            $('.background-loading').remove();
            ajaxUpdateHighChart(url, date, _token);
        });
    }


    var chart = new Highcharts.chart();

    function setLineHighChartOneData(jsonData) {
        var parse = JSON.parse(jsonData);
        var axCat = JSON.stringify(parse.horizontal);
        var totalTrx = JSON.stringify(parse.data);
        chart = new Highcharts.chart({
            chart: {
                renderTo: parse.id
            },
            title: {
                text: ''
            },
            yAxis: {
                title: {
                    text: parse.title
                }
            },
            legend: {
                layout: 'vertical',
                align: 'center',
                verticalAlign: 'bottom'
            },
            xAxis: {
                categories: JSON.parse(axCat)
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
//            series: [{
//                    name: parse.title,
//                    data: JSON.parse(totalTrx)
//                }]
            series: parse.seriesData
        });


    }

    /* Chart bar */
    var chartBar = new Highcharts.chart();

    function setLineHighChartBar(jsonData) {
        var parse = JSON.parse(jsonData);
        var axCat = JSON.stringify(parse.horizontal);
        var totalTrx = JSON.stringify(parse.data);
        chartBar = new Highcharts.chart({
            chart: {
                renderTo: parse.id
            },
            title: {
                text: ''
            },
            yAxis: {
                title: {
                    text: parse.title
                }
            },
            legend: {
                layout: 'vertical',
                align: 'center',
                verticalAlign: 'bottom'
            },
            xAxis: {
                categories: JSON.parse(axCat)
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
//            series: [{
//                    name: parse.title,
//                    data: JSON.parse(totalTrx)
//                }]
            series: parse.seriesData
        });


    }

    function ajaxUpdateHighChart(url, date, _token) {

        $.post(url,
                {
                    date: date,
                    _token: _token
                }, function (data, status) {

            var parseData = JSON.parse(data);
            //console.log(parseData);
//            var parse = JSON.parse(parseData.count);
            var axCatCount = JSON.stringify(parseData.count.horizontal);
            var dataTrxCount = JSON.stringify(parseData.count.data);
            updateHighChart(parseData.count.id, axCatCount, dataTrxCount);



            var axCatSum = JSON.stringify(parseData.sum.horizontal);
            var dataTrxSum = JSON.stringify(parseData.sum.data);
            updateHighChart(parseData.sum.id, axCatSum, dataTrxSum);

            var axCatCount2 = JSON.stringify(parseData.countRoadSite.horizontal);
            var dataTrxCount2 = JSON.stringify(parseData.countRoadSite.data);
            updateHighChart(parseData.countRoadSite.id, axCatCount2, dataTrxCount2);

//            var axCatSum2 = JSON.stringify(parseData.sum2.horizontal);
//            var dataTrxSum2 = JSON.stringify(parseData.sum2.data);
//            updateHighChart(parseData.sum2.id, axCatSum2, dataTrxSum2);
//            setLineHighChartOneData(JSON.stringify(parseData.count));
//            setLineHighChartOneData(JSON.stringify(parseData.sum));
            var jsonShift = parseData.shift;
            var txtShift = '';
            for (var no = 0; no < jsonShift.length; no++) {
//                txtShift += setShiftContainer(jsonShift[no].shiftNumber, jsonShift[no].shiftCount, jsonShift[no].shiftSum);
                $('#shiftCount' + jsonShift[no].shiftNumber).html(jsonShift[no].shiftCount);
                $('#shiftSum' + jsonShift[no].shiftNumber).html(jsonShift[no].shiftSum);

            }

            var jsonShift2 = parseData.shiftRoadSite;
            var txtShift2 = '';
            for (var no = 0; no < jsonShift2.length; no++) {
                $('#shiftCountshiftRoadSite' + jsonShift2[no].shiftNumber).html(jsonShift2[no].shiftCount);
                $('#shiftSumshiftRoadSite' + jsonShift2[no].shiftNumber).html(jsonShift2[no].shiftSum);

            }
        }).fail(function (xhr, textStatus, errorThrown) {
//            ajaxUpdateHighChart(url, date, _token);
        });

    }

    function updateHighChart(id, axCat, dataTrx) {
        chart.update({
            chart: {
                renderTo: id
            },
            xAxis: {
                categories: JSON.parse(axCat)
            },
            series: [{
                    data: JSON.parse(dataTrx)
                }]
        });
    }

    function setTransactionResumeByShift(shift, cbo, roadside, charged, uncharged) 
    {
        var text = '';
        var color = '';
        switch(shift + 1) {
            case 1 :
                color = 'card-blue';
                break;
            case 2 : 
                color = 'card-cyan';
                break;
            case 3 :
                color = 'card-red';
                break;
            default :
                color = 'card-blue';
        };

        text += ' <div class="col-sm-4">'
                +'<div class="card ' + color + '">'
                +'<div class="header card-transaction-dashboard-header">'
                +'<strong>Shift '+  (shift + 1) +'</strong>'
                +'</div>'
                +'<table class="table table-hover table-striped">'
                    +'<thead>'
                    +'<tr>'
                    +'<th>Trans</th>'
                    +'<th class="al-right">Count</th>'
                    +'<th class="al-right">(Rp.)</th>'
                    +'</tr>'
                    +'</thead>'
                    +'<tbody>'
                        +'<tr>'
                            +'<td>CBO</td>'
                            +'<td class="al-right">' + cbo[0].total_count + '</td>'
                            +'<td class="al-right">' + parseInt(cbo[0].total_amount) + '</td>'
                        +'</tr>'
                        +'<tr>'
                            +'<td>Roadside</td>'
                            +'<td class="al-right">' + roadside[0].total_count + '</td>'
                            +'<td class="al-right">' + parseInt(roadside[0].total_amount) + '</td>'
                        +'</tr>'
                        +'<tr>'
                            +'<td>Charged</td>'
                            +'<td class="al-right">' + charged[0].total_count + '</td>'
                            +'<td class="al-right">' + parseInt(charged[0].total_amount) + '</td>'
                       + '</tr>'
                        +'<tr>'
                            +'<td>Uncharged</td>'
                            +'<td class="al-right">' + uncharged[0].total_count + '</td>'
                            +'<td class="al-right">' + parseInt(uncharged[0].total_amount) + '</td>'
                        +'</tr>'
                    +'</tbody>'
            +'</table>'
        +'</div>'
    +'</div>';

    return text;

    }

    function setTransactionByUserType(shift, umum, mitrakerja, karyawan, operasional) 
    {
        var text = '';
        var color = '';
        switch(shift + 1) {
            case 1 :
                color = 'card-blue';
                break;
            case 2 : 
                color = 'card-cyan';
                break;
            case 3 :
                color = 'card-red';
                break;
            default :
                color = 'card-blue';
        };

        text += ' <div class="col-sm-4">'
                +'<div class="card ' + color + '">'
                +'<div class="header card-transaction-dashboard-header">'
                +'<strong>Shift '+  (shift + 1) +'</strong>'
                +'</div>'
                +'<table class="table table-hover table-striped">'
                    +'<thead>'
                    +'<tr>'
                    +'<th>Trans</th>'
                    +'<th class="al-right">Count</th>'
                    +'</tr>'
                    +'</thead>'
                    +'<tbody>'
                        +'<tr>'
                            +'<td>Umum</td>'
                            +'<td class="al-right">' + parseInt(umum) + '</td>'
                        +'</tr>'
                        +'<tr>'
                            +'<td>Mitra Kerja</td>'
                            +'<td class="al-right">' + parseInt(mitrakerja) + '</td>'
                        +'</tr>'
                        +'<tr>'
                            +'<td>Karyawan</td>'
                            +'<td class="al-right">' + parseInt(karyawan) + '</td>'
                       + '</tr>'
                        +'<tr>'
                            +'<td>Operasional</td>'
                            +'<td class="al-right">' + parseInt(operasional) + '</td>'
                        +'</tr>'
                    +'</tbody>'
            +'</table>'
        +'</div>'
    +'</div>';

    return text;

    }

    function setShiftContainer(id, shiftNumber, shiftCount, shiftSum) {
        var txt = '';
        txt += '<div class="col-md-12">'
                + '<div class="card card-blue">'
                + '<div class="header" style="padding:5px 15px 0">'
                + '<strong>Shift ' + shiftNumber + '</strong>'
//                + '<h4 class="title"><strong>Shift ' + shiftNumber + '</strong></h4>'
                + '</div>'
                + '<div class="content table-responsive table-full-width" style="padding:0px 15px 0px 15px;">'
                + '<table class="table table-hover table-striped">'
                + '<tbody>'
                + '<tr>'
                + '<td  style="font-size: 12px">Transaction Quantity</td>'
                + '<td style="font-size: 12px;text-align:right;" id="shiftCount' + id + shiftNumber + '">' + shiftCount + '</td>'
                + '</tr>'
                + '<tr>'
                + '<td style="font-size: 12px">Transaction Amount</td>'
                + '<td style="font-size: 12px;text-align:right;" id="shiftSum' + id + shiftNumber + '">' + shiftSum + '</td>'
                + '</tr>'

                + '</tbody>'
                + '</table>'

                + '</div>'
                + '</div>'
                + '</div>';

        return txt;
    }

    function ajaxErrorUpdateHighChart(url, date, _token) {

        $.post(url,
                {
                    date: date,
                    action: 'token'
                }, function (data, status) {
            $('input[name="_token"]').val(data);
            var token = $('input[name="_token"]').val();
            ajaxUpdateHighChart(url, date, token);

        }).fail(function (xhr, textStatus, errorThrown) {
            ajaxErrorUpdateHighChart(url, date, _token);
        });
    }
</script>
@endsection
