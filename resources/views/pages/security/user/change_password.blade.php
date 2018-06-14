{!! HTML::script('templates/director/js/jquery.min.js') !!}
@extends('index')

@section('content')
	
<div class="content-box">
    <div class="head info-bg clearfix">
        <h5 class="content-title pull-left">Change Password</h5>
        <div class="functions-btns pull-right">
            <a class="fullscreen-btn" href="#" data-toggle="tooltip" title="{!! trans('general.go-fullscreen') !!}"><i class="zmdi zmdi-fullscreen"></i></a>
        </div>
    </div>

    <div class="content">
            <section class="panel">
                    <div class="row">
                      <div class="col-md-6">

                        {!! Form::open(['onsubmit'=>'return false;','url' => 'changepassword/submitchangepassword', 'role' => 'form', 'id' => 'list-filter', 'method' => 'post']) !!}
                        <div class="form-group">
				            <label for="exampleInputName1">Old Password</label>
				             {!! Form::password('old_password', ['class'=>'form-control', 'id'=>'inputOldPassword', 'placeholder'=>'Current Password', 'required' => true]) !!}
				        </div>
				        <div class="form-group">
				            <label for="exampleInputName1">New Password</label>
				             {!! Form::password('new_password', ['class'=>'form-control', 'id'=>'inputPassword', 'placeholder'=>'Enter New Password', 'required' => true, 'data-parsley-minlength'=>4]) !!}
				        </div>
				        <div class="form-group">
				            <label for="exampleInputName1">Confirm New Password</label>
				             {!! Form::password('c_new_password', ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Confirm New Password', 'data-parsley-equalto'=>'#inputPassword', 'required' => true]) !!}
				        </div>
				        <button type="button" class="btn btn-success pull-right" onclick="doChangePassowrd($(this))">Submit</button>
                        {!! Form::close() !!}
                        
                      </div>
                    </div>
<!--                 <div class="panel-body table-responsive" id="list-table-container"></div> -->
            </section> 
    </div>

</div>
<input type="hidden" id="URL" value="{!!URL('')!!}">

<script type="text/javascript">
	function doChangePassowrd(submitButtonElement){
		swal.close();
		// $("#list-table-container").LoadingOverlay("show");
		var form =  submitButtonElement.closest('form');
		var formData = new FormData(form[0]);
		var url = form.attr('action');
		// for (var pair of formData.entries()) {
		//     console.log(pair[0]+ ', ' + pair[1]); 
		// }

		form.parsley().validate();

		if(form.parsley().isValid()){

			$('.custom-content-form').LoadingOverlay("show");

			$.ajax({
				url : url,
				data : formData,
				type : 'post',
				cache: false,
		        contentType: false,
		        processData: false,
				success: function(response) {
					console.log(response);
					var response = JSON.parse(response);
					if(response.status == 'success'){
						swal("Success", response.msg , "success");
						$('.custom-content-form').LoadingOverlay("hide");
						window.location.replace($('#URL').val() + '/welcome');
					}else{
						swal("Failed", response.msg , "error");
						$('.custom-content-form').LoadingOverlay("hide");
					}
				},
				error: function (xhr, status, error){

				}
			});

		}
		
	}
</script>
	
@endsection
