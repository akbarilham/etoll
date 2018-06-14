@section('list')
<div class="content-box">
    <div class="head info-bg clearfix">
        <h5 class="content-title pull-left">Toll Plaza</h5>
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
                            {!! Form::select('searchby', $searchby, null, ['class' => 'form-control',  'onchange' => 'setList("list", "")' ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::select('perpage', [5=>5, 10=>10, 30=>30, 100=>100], null, ['class' => 'form-control',  'onchange' => 'setList("list", "")' ]) !!}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="button"  onclick="addsNew('newplaza', 'p_plaza_id', '0')">Add Plaza</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="button"  onclick="addsNew('newplaza', 'p_plaza_gate_id', false)">Add Line</button>
                        </div>

                        {!! Form::close() !!}
                        
                      </div>
                    </div>

                </header>
                <div class="panel-body table-responsive" id="list-table-container"></div>
          </section>
        </div>
        <div class="custom-content-form"></div>
    </div>

</div>
<input type="hidden" id="URL" value="{!!URL('')!!}">

@endsection
<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery.validation/1.13.1/jquery.validate.min.js"></script>
<script src="js/parsley.js"></script>
<script type="text/javascript">
function addsNew(request, param, id){

    $('.custom-content-list').hide();

    $('.custom-content-form').show();
    $('.custom-content-form').LoadingOverlay("show");

    var param = param || '';
    var id = id || '';
    var url = 'tollplaza/newplaza';
    var toPage = '{"request":"' + request + '", "param":"' + param + '", "id":"' + id + '"}';
    $.ajax({
        url : url,
        data : JSON.parse(toPage),
        type : 'get',
        success: function(response) {
            if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
            $('.custom-content-form').LoadingOverlay('hide');
            $('.custom-content-form').html(response);
        },
        error: function (xhr, status, error){

        }
    });
}

function doViews(request, id, search, searchby, perpage, page){

    $('.custom-content-list').hide();
    $('.head').hide();

    $('.custom-content-form').show();
    $('.custom-content-form').LoadingOverlay("show");

    var id = id || '';
    var url = 'tollplaza/gateindex';
    var toPage = '{"request":"' + request + '", "p_plaza_id":"' + id + '", "search":"' + search + '", "searchby":"' + searchby + '", "perpage":"' + perpage + '",  "page":"' + page + '"}';
    $.ajax({
        url : url,
        data : JSON.parse(toPage),
        type : 'get',
        success: function(response) {
            if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
            $('.custom-content-form').LoadingOverlay('hide');
            $('.custom-content-form').html(response);
        },
        error: function (xhr, status, error){

        }
    });
}

function doViewTotal(request, id, datas){

    $('.custom-content-list').hide();

    $('.custom-content-form').show();
    $('.custom-content-form').LoadingOverlay("show");

    var id = id || '';
    var datas = datas || '';
    var url = 'tollplaza/viewtotal';
    var toPage = '{"request":"' + request + '", "id":"' + id + '", "datas":"' + datas + '"}';

    $.ajax({
        url : url,
        data : JSON.parse(toPage),
        type : 'get',
        success: function(response) {
            if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
            $('.custom-content-form').LoadingOverlay('hide');
            $('.custom-content-form').html(response);
        },
        error: function (xhr, status, error){

        }
    });
}

function doViewDetail(request, id, datas){

    $('.custom-content-list').hide();

    $('.custom-content-form').show();
    $('.custom-content-form').LoadingOverlay("show");

    var id = id || '';
    var url = 'tollplaza/viewdetail';
    var toPage = '{"request":"' + request + '", "id":"' + id + '", "datas":"' + datas + '"}';
    $.ajax({
        url : url,
        data : JSON.parse(toPage),
        type : 'get',
        success: function(response) {
            if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
            $('.custom-content-form').LoadingOverlay('hide');
            $('.custom-content-form').html(response);
        },
        error: function (xhr, status, error){

        }
    });
}

function doEdits(request, id){

    $('.custom-content-list').hide();

    $('.custom-content-form').show();
    $('.custom-content-form').LoadingOverlay("show");

    var id = id || '';
    var url = '';
    var toPage = '{"request":"' + request + '", "id":"' + id + '", "p_plaza_gate_id":"' + id + '"}';
    $.ajax({
        url : url,
        data : JSON.parse(toPage),
        type : 'get',
        success: function(response) {
            if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
            $('.custom-content-form').LoadingOverlay('hide');
            $('.custom-content-form').html(response);
        },
        error: function (xhr, status, error){

        }
    });
}

function doSaves(submitButtonElement){
    swal.close();
    $('.custom-content-form').LoadingOverlay("show");
    var form =  submitButtonElement.closest('form');
    var formData = new FormData(form[0]);
    var url = form.attr('action');

    form.parsley().validate();

    if(form.parsley().isValid()){

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            
            url : url,
            data : formData,
            type : 'POST',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
                console.log(response);
                var response = JSON.parse(response);
                if(response.status == 'success'){
                    $("#list-table-container").LoadingOverlay("hide");
                    $("#myModal").modal('hide');
                    swal("Success", response.msg , "success");
                    setList('list');
                }else{
                    $("#list-table-container").LoadingOverlay("hide");
                    $("#myModal").modal('hide');
                    swal("Failed", response.msg , "error");
                }
            },
            error: function (xhr, status, error){

            }
        });

    }
    $('.custom-content-form').LoadingOverlay("hide");
    

}

function doDeletes(deleteButtonElement, url, id, tollplaza){
    var url = url || '';
    var id = id || '';
    var tollplaza = tollplaza || '';
    var _token = deleteButtonElement.attr('_token');

    var data = new FormData();
    data.append(tollplaza, id);
    data.append('tollplaza', tollplaza);
    data.append('_token', _token);

    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this data!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes",
      cancelButtonText: "Cancel",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
        swal.close();
        $("#list-table-container").LoadingOverlay("show");
        $.ajax({
            url : url,
            data : data,
            type : 'post',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
                var response = JSON.parse(response);
                if(response.status == 'success'){
                    $("#list-table-container").LoadingOverlay("hide");
                    swal("Success", response.msg , "success");
                    setList('list');
                }else{
                    $("#list-table-container").LoadingOverlay("hide");
                    swal("Failed", response.msg , "success");
                }
                
            },
            error: function (xhr, status, error){
                swal("Failed", "Sorry, failed to delete data", "error");
            }
        });
      } else {
        swal("Cancelled", "Your data is safe :)", "error");
      }
    });
}

  $(function(){
    setList('list');
  })
</script>