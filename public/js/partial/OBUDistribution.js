function submitOBUDistribution(element) {
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
			  closeOnConfirm: false
			},
			function(){
			  	$.ajax({
					url : url,
					data : data,
					type : 'post',
					success: function(response) {

						if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }

						console.log(response);
						var response = JSON.parse(response);
						if(response.status == 'success'){
							swal("Success", response.msg , "success");
							window.location.replace($('#URL').val() + '/obudistribution');
						}else{
							swal("Failed", response.msg , "error");
						}
					},
					error: function (xhr, status, error){
						
					}
				});
			});

		}else {

		}
	}

	function getOBUList(element) {

		$("#list-obu-table-container").LoadingOverlay("show");
		var url = $('#URL').val() + '/obudistribution/getOBUList';

		$.ajax({
			url : url,
			data : {IDPROVIDER:element.value},
			type : 'get',
			success: function(response) {

				if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }

				$("#list-obu-table-container").LoadingOverlay("hide");
				$("#list-obu-table-container").html(response);
			},
			error: function (xhr, status, error){
				
			}
		});
		return false;
	}

	$('#list-obu-table-container').on('click', '.row-obu', function() {
		var BOXNUM = $(this).find('.box-number').text();
		var MANUNAME = $(this).find('.manu-name').text();
		var COUNT = $('.choosed-box').length;
		if(checkChoosed(BOXNUM) == true) {
			var ELE = '<tr class="choosed-box"> <td>' +BOXNUM+ '<input type="hidden" name="BOXNUM[]" value="' +BOXNUM+ '"></td> <td>' +MANUNAME+ '</td> <td><button class="btn btn-sm btn-danger waves-effect delete-choosed-box" title="Cancel"><i class="zmdi zmdi-close"></i></button></td> </tr>';
				$('#list-selected-obu-table-container table tbody').append(ELE);
		}else {
			swal("Box is already selected!");
		}

	});

	$('#list-selected-obu-table-container').on('click', '.delete-choosed-box', function() {
		$(this).closest('tr').remove();
	});

	function checkChoosed(BOXNUM) {
		var choosed = [];
		$('.choosed-box').each(function(){
			choosed.push($(this).find('input[name="BOXNUM[]"]').val());
		})
		
		if($.inArray(BOXNUM, choosed) != -1) {
			return false;
		}else {
			return true;
		}
	}