<div>
    <h5>{!! trans('general.customer-care-view-issue') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'customercare/saveissue', 'role' => 'form', 'data-validate' => 'parsley']) !!}
        <div class="form-group">
            <label for="exampleInputName1">Customer Name</label>
             {!! Form::text('',$issue->name, ['class'=>'form-control', 'disabled'=>'true', 'id'=>'inputName', 'placeholder'=>'Code']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Email</label>
             {!! Form::text('',$issue->email, ['class'=>'form-control', 'disabled'=>'true', 'id'=>'inputName', 'placeholder'=>'Email']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Address</label>
             {!! Form::textarea('',$issue->address, ['class'=>'form-control', 'disabled'=>'true', 'id'=>'inputName', 'placeholder'=>'Code', 'rows' =>"3"]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Issue Hint</label>
             {!! Form::text('',$issue->reference_name, ['class'=>'form-control', 'disabled'=>'true', 'id'=>'inputName', 'placeholder'=>'Code']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Issue Hint</label>
             {!! Form::textarea('',$issue->issue_description, ['class'=>'form-control', 'disabled'=>'true' ,'id'=>'inputName', 'placeholder'=>'Code']) !!}
        </div>

        @if($issue->priority != 0)


        <div class="form-group">
            <label for="exampleInputName1">Priority</label>
            <select name="priority" class="form-control" disabled="true">
                @foreach($priority as $key=>$val)
                    <option <?php if($issue->priority == $val->p_reference_list_id) { echo "selected"; } ?> value="{!! $val->p_reference_list_id !!}"> {!! $val->reference_name !!} </option>
                @endforeach
            </select> 
        </div>

        <div class="form-group">
            <label for="exampleInputName1">SOLUTION DESCRIPTIONNN</label>
             {!! Form::textarea('solution_description',$issue->solution_description, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Describe solution', 'rows' =>"3", 'required'=>true]) !!}
        </div>

        <div class="form-group">
            <label for="exampleInputName1">Status</label>
            <select name="status" class="form-control">
                @foreach($status as $key=>$val)
                    <option <?php if($issue->status == $val->p_reference_list_id) { echo "selected"; } ?> value="{!! $val->p_reference_list_id !!}"> {!! $val->reference_name !!} </option>
                @endforeach
            </select> 
        </div>

        @else

        <div class="form-group">
            <label for="exampleInputName1">Priority</label>
            <select name="priority" class="form-control">
                @foreach($priority as $key=>$val)
                    <option <?php if($issue->priority == $val->p_reference_list_id) { echo "selected"; } ?> value="{!! $val->p_reference_list_id !!}"> {!! $val->reference_name !!} </option>
                @endforeach
            </select> 
        </div>

        @endif

        <input type="hidden" name="id" value="{!! $issue->id !!}">
        <button type="button" class="btn btn-success pull-right" onclick="doSaveIssue($(this))">Submit</button>
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
