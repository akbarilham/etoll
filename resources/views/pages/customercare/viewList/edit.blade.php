<div>
    <h5>{!! trans('general.customer-care-view-issue') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'customercare/saveissue', 'role' => 'form', 'data-validate' => 'parsley']) !!}

        <div class="form-group">
            <label for="exampleInputName1">Ticket Number</label>
             {!! Form::text('',$issue->ticket_number, ['class'=>'form-control', 'readonly'=>'true', 'id'=>'inputName', 'placeholder'=>'Ticket Number']) !!}
        </div>
        
        <div class="form-group">
            <label for="exampleInputName1">Customer Name</label>
             {!! Form::text('',$issue->name, ['class'=>'form-control', 'readonly'=>'true','id'=>'inputName', 'placeholder'=>'Code']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Email</label>
             {!! Form::text('',$issue->email, ['class'=>'form-control','readonly'=>'true', 'id'=>'inputName', 'placeholder'=>'Email']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Address</label>
             {!! Form::textarea('',$issue->address, ['class'=>'form-control', 'readonly'=>'true', 'id'=>'inputName', 'placeholder'=>'Code', 'rows' =>"3"]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Subject</label>
             {!! Form::text('',$issue->reference_name, ['class'=>'form-control','readonly'=>'true', 'id'=>'inputName', 'placeholder'=>'Code']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Issue Description</label>
             {!! Form::textarea('',$issue->issue_description, ['class'=>'form-control', 'rows'=>4, 'readonly'=>'true','id'=>'inputName', 'placeholder'=>'Describe Issue', 'required'=>true]) !!}
        </div>

        @if($issue->priority != 0)


        <div class="form-group">
            <label for="exampleInputName1">Priority</label>
            <select name="priority" class="form-control" disabled="true" readonly>
                @foreach($priority as $key=>$val)
                    <option <?php if($issue->priority == $val->id) { echo "selected"; } ?> value="{!! $val->id !!}"> {!! $val->reference_name !!} </option>
                @endforeach
            </select> 
        </div>

        <!-- No save button when status is closed -->
        <?php
            if($issue->status == 143) //ticket is already closed
            {
                $readonly = true;
            }
            else {
                $readonly = false;
            }
        ?>
        <div class="form-group">
            <label for="exampleInputName1">Solution Description</label>
             {!! Form::textarea('solution_description',$issue->solution_description, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Describe solution', 'rows' =>"3", 'readonly'=>$readonly]) !!}
        </div>

        

        <div class="form-group">
            <label for="exampleInputName1">Status</label>
            <select name="status" class="form-control">
                @foreach($status as $key=>$val)
                    <option <?php if($issue->status == $val->id) { echo "selected"; } ?> value="{!! $val->id !!}"> {!! $val->reference_name !!} </option>
                @endforeach
            </select> 
        </div>

        @else

        <div class="form-group">
            <label for="exampleInputName1">Priority</label>
            <select name="priority" class="form-control">
                @foreach($priority as $key=>$val)
                    <option <?php if($issue->priority == $val->id) { echo "selected"; } ?> value="{!! $val->id !!}"> {!! $val->reference_name !!} </option>
                @endforeach
            </select> 
        </div>

        @endif

        <input type="hidden" name="id" value="{!! $issue->id !!}">

        <!-- No save button when status is closed -->
        @if($issue->status != 143)
            <button type="button" class="btn btn-success pull-right" onclick="doSaveIssue($(this))">Submit</button>
        @endif
        

        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal" onclick="setList('list');">{!! trans('general.cancel') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
</div>
<script type="text/javascript">
    function doSaveIssue(submitButtonElement){
        swal.close();
        $('.custom-content-form').LoadingOverlay("show");
        var form =  submitButtonElement.closest('form');
        var formData = new FormData(form[0]);
        var url = form.attr('action');

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
</script>
