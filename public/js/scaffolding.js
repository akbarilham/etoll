function setList(request, pagination)
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
			console.log(response);
			//redirect of token expired
			if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }

			$('#list-table-container').html(response);
			$("#list-table-container").LoadingOverlay("hide");
		},
		error: function (xhr, status, error){
			
		}
	});
	return false;
}

function addNew(request){

	$('.custom-content-list').hide();

	$('.custom-content-form').show();
	$('.custom-content-form').LoadingOverlay("show");

	var url = '';
	var toPage = '{"request":"' + request + '"}';
	$.ajax({
		url : url,
		data : JSON.parse(toPage),
		type : 'get',
		success: function(response) {
			console.log(response);
			//redirect of token expired
			if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
			$('.custom-content-form').LoadingOverlay('hide');
			$('.custom-content-form').html(response);
		},
		error: function (xhr, status, error){

		}
	});
}

function doEdit(request, id){

	$('.custom-content-list').hide();

	$('.custom-content-form').show();
	$('.custom-content-form').LoadingOverlay("show");

	var id = id || '';
	var url = '';
	var toPage = '{"request":"' + request + '", "id":"' + id + '"}';
	$.ajax({
		url : url,
		data : JSON.parse(toPage),
		type : 'get',
		success: function(response) {
			//redirect of token expired
			console.log(response);
			if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
			$('.custom-content-form').LoadingOverlay('hide');
			$('.custom-content-form').html(response);
		},
		error: function (xhr, status, error){

		}
	});
}

function doSave(submitButtonElement){
	swal.close();
	// $("#list-table-container").LoadingOverlay("show");
	$('.custom-content-form').LoadingOverlay("show");
	var form =  submitButtonElement.closest('form');
	var formData = new FormData(form[0]);
	var url = form.attr('action');
	// for (var pair of formData.entries()) {
	//     console.log(pair[0]+ ', ' + pair[1]); 
	// }

	form.parsley().validate();

	if(form.parsley().isValid()){

		$.ajax({
			url : url,
			data : formData,
			type : 'post',
			cache: false,
	        contentType: false,
	        processData: false,
			success: function(response) {
				console.log(response);
				//redirect of token expired
				if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
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

function doDelete(deleteButtonElement, url, id){
	var url = url || '';
	var id = id || '';
	var _token = deleteButtonElement.attr('_token');

	var data = new FormData();
	data.append('id', id);
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
			console.log(response);
				var response = JSON.parse(response);
				if(response.status == 'success'){
					$("#list-table-container").LoadingOverlay("hide");
					swal("Success", response.msg , "success");
					setList('list');
				}else{
					$("#list-table-container").LoadingOverlay("hide");
					swal("Failed", response.msg, "error");
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