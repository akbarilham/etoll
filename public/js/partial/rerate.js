function submitRerate(element) {
		
		var data = element.closest('form').serialize();
		var url = element.closest('form').attr('Action');

		element.closest('form').parsley().validate();

		if(element.closest('form').parsley().isValid()) {
			swal({
			  title: "Are you sure?",
			  text: "",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Continue",
			  closeOnConfirm: true
			},
			function(){
				$("#form-container").LoadingOverlay("show");
			  	$.ajax({
					url : url,
					data : data,
					type : 'post',
					success: function(response) {
						if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
						console.log(response);
						var response = JSON.parse(response);
						if(response.message == 'ok'){
							swal({
							      title: "Sucess",   
							      text: "Success create rerate !",   
							      type: "success" 
							});
							$("#form-container").LoadingOverlay("hide");
							// window.location.replace($('#URL').val() + '/rerate');
						}else if(response.message == 'Error re-rate : ext id not in list event input'){
							swal({
							      title: "Failed",   
							      text: response.message,   
							      type: "error" 
							});
							$("#form-container").LoadingOverlay("hide");
						}else{
							swal({
							      title: "Failed",   
							      text: "Failed create rerate !",   
							      type: "error" 
							});
							$("#form-container").LoadingOverlay("hide");
						}
					},
					error: function (xhr, status, error){
						
					}
				});
			});

		}else {

		}
	}