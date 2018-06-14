@extends('guest.dashboard.template.content')

@section('content')
{!! HTML::script('plugins/highchart/5.0.10/highcharts.js?v=1.1') !!}
{!! HTML::script('plugins/highchart/5.0.10/modules/exporting.js') !!}
<div class="row">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Customer ID</span>
            <input type="text" class="form-control"  onkeyup="beforeConstructCustomer(event);"   placeholder="Search for..." 
                   id="customer"
                   value="">
            </input>
            <span class="input-group-btn">

                <button class="btn btn-success btn-fill" type="button" onclick="constructCustomer()">
                    <i class="fa fa-search"></i> Search!
                </button>
            </span>
        </div><!-- /input-group -->
    </div><!-- /.col-lg-6 -->
</div>
<br/>

<div class="row">
    <div class="col-md-12">
        <h4>{!!trans('dashboard.obu_information')!!}</h4>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="content"  id="pageCustomer">

            </div>
        </div>
    </div>

</div>




<div id="loader">

</div>
<script>

    $(function () {
        constructCustomer();
//        constructTrans();
    });

    function beforeConstructCustomer(e) {
        if (e.keyCode == 13) {
            constructCustomer();
        }
    }
    function constructCustomer() {
        searchTransaction('<?= URL('page/dashboard/customer'); ?>');


    }


    function searchTransaction(url) {
        var customer = $('#customer').val();
        if (customer != "") {
            getTransaction(url, customer);
        }
    }

    function getTransaction(url, customer) {
        var _token = $('input[name="_token"]').val();
        $('#loader').html('<div class="background-loading"></div>');
        $.post(url,
                {
                    action: 'customer',
                    customer: customer,
                    _token: _token
                }, function (data, status) {
                console.log(data);
            // setTimeout(function () {
            //     constructCustomer();
            // }, 180000);
            $('#pageCustomer').html(data);
            $('.background-loading').remove();
        }).fail(function (xhr, textStatus, errorThrown) {
            //console.log(xhr);
            $('#pageCustomer').html(xhr.responseText);
            $('.background-loading').remove();
        });
    }
</script>
@endsection
