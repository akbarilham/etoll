<div>
    <h5>{!! trans('general.customer-care-form-send-email') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'customercare/sendemail', 'role' => 'form']) !!}
        
        <div class="form-group">
            <label for="exampleInputName1">Customer Name</label>
             {!! Form::text('',$issue->name, ['class'=>'form-control', 'disabled'=>'true', 'id'=>'inputName', 'placeholder'=>'Code']) !!}
        </div>

        <div class="form-group">
            <label for="exampleInputName1">Email</label>
             {!! Form::text('',$issue->email, ['class'=>'form-control', 'disabled'=>'true', 'id'=>'inputName', 'placeholder'=>'Email']) !!}
        </div>

        <div class="form-group">
            <label for="exampleInputName1">Subject</label>
             {!! Form::text('', $issue->reference_name.' - REQ NO : '.$issue->ticket_number, ['class'=>'form-control', 'disabled'=>'true', 'id'=>'inputName', 'placeholder'=>'Reference Name']) !!}
        </div>

         <div class="form-group">
            <label for="exampleInputName1">Message</label>
            <textarea class="form-control" name="emailbody" rows="4" required="true"> Yth, {!! $issue->name !!}, <isi pesan> Terimakasih.
            </textarea>
        </div>

        <input type="hidden" name="id" value="{!! $issue->id !!}">
        <button type="button" class="btn btn-success pull-right" onclick="doSendEmail($(this))">Submit</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal" onclick="setList('list');">{!! trans('general.cancel') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
</div>
<script type="text/javascript">
    function doSendEmail(submitButtonElement){
        swal.close();
        var form =  submitButtonElement.closest('form');
        var formData = new FormData(form[0]);
        var url = form.attr('action');

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
                        $("#list-table-container").LoadingOverlay("hide");
                        swal("Success", response.msg , "success");
                        setList('list');
                    }else{
                        $("#list-table-container").LoadingOverlay("hide");
                        swal("Failed", response.msg , "error");
                    }
                },
                error: function (xhr, status, error){

                }
            });

        }else {
            $("#list-table-container").LoadingOverlay("hide");
        }
    }
</script>
