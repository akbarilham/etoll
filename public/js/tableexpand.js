
function setListExpand(request, pagination)
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
			
		}
	});
	return false;
}

// js khusus, akan segera di pindahkan jika selesai masa SIT
function doExpand(request, id, appr, customer_id){

	$('.custom-content-list').hide();

	$('.custom-content-form').show();
	$('.custom-content-form').LoadingOverlay("show");
	
	var id = id || '';
	var appr = appr || '';
	var customer_id = customer_id || '';
	var url = '';
	// js khusus, akan segera di pindahkan jika selesai masa SIT
	var toPage = '{"request":"' + request + '", "id":"' + id + '", "appr":"' + appr + '", "customer_id":"' + customer_id + '"}';
	$.ajax({
		url : url,
		data : JSON.parse(toPage),
		type : 'get',
		success: function(response) {
			$('.custom-content-form').LoadingOverlay('hide');
			$('.custom-content-form').html(response);
		},
		error: function (xhr, status, error){

		}
	});
}

function doApprove(submitButtonElement){
	var form =  submitButtonElement.closest('form');
	var formData = new FormData(form[0]);
	var url = form.attr('action');
	// alert(JSON.stringify(formData,null,4));
	// for (var pair of formData.entries()) {
	//     console.log(pair[0]+ ', ' + pair[1]); 
	// }
	$.ajax({
		url : url,
		data : formData,
		type : 'post',
		cache: false,
        contentType: false,
        processData: false,
		success: function(response) {
			var response = JSON.parse(response);
			if(response.status == 'success'){
				$("#myModal").modal('hide');
				swal("Success", response.msg , "success");
				setListExpand('list');
			}else{
				$("#myModal").modal('hide');
				swal("Failed", response.msg , "error");
			}
		},
		error: function (xhr, status, error){
			console.log(error);
		}
	});
}

function doApproveSec(stringa){
	var stringa = stringa || '';
	var string = stringa.split("|");
	var id = string[1];
	var customer_id = string[2];
	var subscriber_id = string[3];
	var subscription_name = string[4];
	var service_no = string[5]; 
	var account_no = string[6];
	var last_name = string[7];
	var serial_no = string[8];
	var pan = string[9];
	var approval_status = 'A';
	var approval_date = '2017-06-01';
	var reject_reason = 'tydack sukaque';
	var _token = document.getElementById('token').value;

	var formData = new FormData();
	formData.append('id', id);
	formData.append('customer_id', customer_id);
	formData.append('subscriber_id', subscriber_id);
	formData.append('subscription_name', subscription_name);
	formData.append('service_no', service_no);
	formData.append('account_no', account_no);
	formData.append('last_name', last_name);
	formData.append('serial_no', serial_no);
	formData.append('pan', pan);
	formData.append('approval_date', approval_date);
	formData.append('approval_status', approval_status);
	formData.append('reject_reason', reject_reason);
	formData.append('_token', _token);
	// var form =  submitButtonElement.closest('form');
	var url = 'obuactivation/approve';
	// for (var pair of formData.entries()) {
	//     console.log(pair[0]+ ', ' + pair[1]); 
	// }
	$.ajax({
		url : url,
		data : formData,
		type : 'post',
		cache: false,
        contentType: false,
        processData: false,
		success: function(response) {
			console.log('do approve sec : ' + response);
			var response = JSON.parse(response);
			if(response.status == 'success'){
				$("#myModal").modal('hide');
				swal("Success", response.msg , "success");
				setListExpand('list');
			}else{
				$("#myModal").modal('hide');
				swal("Failed", response.msg , "error");
			}
		},
		error: function (xhr, status, error){

		}
	});
}