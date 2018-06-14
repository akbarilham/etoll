@section('list')
<div class="content-box">
    <div class="head info-bg clearfix">
        <h5 class="content-title pull-left">Transaction</h5>
        <div class="functions-btns pull-right">
            <a class="fullscreen-btn" href="#" data-toggle="tooltip" title="{!! trans('general.go-fullscreen') !!}"><i class="zmdi zmdi-fullscreen"></i></a>
        </div>
    </div>
    

    <div class="content">
        <div class="custom-content-list">
            <section class="panel">
                 <header class="panel-heading panel-heading-custom-padding">
                    <div class="row">
                      <div class="col-md-12">

                        {!! Form::open(['onsubmit'=>'return false;', 'role' => 'form', 'id' => 'list-filter', 'method' => 'get', 'class'=>'form-inline']) !!}
                        <div class="form-group">
                            {!! Form::text('search', null, ['class' => 'form-control', 'placeholder'=> 'Search', 'onchange' => 'setList("list", "")' ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::select('searchby',  $searchby, null, ['class' => 'form-control',  'onchange' => 'setList("list", "")' ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::select('perpage', [5=>5, 10=>10, 30=>30, 100=>100], null, ['class' => 'form-control',  'onchange' => 'setList("list", "")' ]) !!}
                        </div>
                        
                        <div class="form-group">
                              <div class="input-group date">
                                <span class="input-group-addon date">
                                  <span class="zmdi zmdi-calendar"></span>
                                </span>
                               <input type="text" name="searchbydate" class="form-control datepicker datefrom"/>
                              </div>
                        </div>

                      <div class="form-group">
                            {!! Form::select('searchbyshift', [4 => 'All Shift', 1=>'Shift 1', 2=> 'Shift 2', 3=> 'Shift 3'], null, ['class' => 'form-control',  'onchange' => 'setList("list", "")' ]) !!}
                        </div>
                        
                        {!! Form::close() !!}
                        
                      </div>
                    </div>

                </header>
                <div class="panel-body table-responsive" id="list-table-container"></div>
                <div class="panel-body table-responsive" id="list-table-subscription-saldo"></div>
                <div class="panel-body" id="list-table-subscription-info"></div>
            </section> 
        </div>
        <div class="custom-content-form"></div>
    </div>
<input type="hidden" id="URL" value="{!!URL('')!!}">
<input type="hidden" id="customer_in_id">
<input type="hidden" id="subscriber_in_id">
</div>
@endsection
<script type="text/javascript">
  function setListSpecial(request, pagination)
  { 
    $('.custom-content-form').html('').hide();
    $('.custom-content-list').show();

    $("#list-table-container").LoadingOverlay("show");

    var request = request || '';
    var pagination = pagination || '';
    var filter = $('#list-filter').serialize();
    filter += '&request=' + request + '&page=' + pagination;
    var url = '';

    
    $.ajax({
      url : url,
      data : filter,
      type : 'get',
      success: function(response) {
        $('#list-table-container').html(response);
        $("#list-table-container").LoadingOverlay("hide");
      },
      error: function (xhr, status, error){
        $('#list-table-container').html("");
        $("#list-table-container").LoadingOverlay("hide");
        
      }
    });
    return false;
  }
  $(function(){
    var option = {
            format: "dd-mm-yyyy",
            autoclose: true,
            disableTouchKeyboard: true,
            enableOnReadonly: true,
    };
    $(".datefrom").datepicker(option);
   // $(".datefrom").datepicker("setDate",new Date());
    $('.datefrom').datepicker(option).on('change', function(selected){
      //var minDate = new Date(selected.date.valueOf());

      setListSpecial('list');
     $(this).datepicker('hide');
    })
   
    setListSpecial('list');
  })
  
  var currentDate = new Date(); 
  

</script>