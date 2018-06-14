<div class="content">
    <h5>Select Role</h5>
    <hr/>
    {!! Form::open(['url' => 'userprivilege/save', 'role' => 'form', 'class'=>'form-horizontal']) !!}
        @foreach($result->roles as $key=>$role)
        <div class="form-group">
            <div class="radio radio-warning" style="padding-top: 0px;">
                <label>
                    <input type="radio" name="role" <?php if( $role->p_role_id == $result->registered->role ) { echo 'checked="checked"'; } ?> value="{!! $role->p_role_id !!}">

                <i></i>
                </label>
                <span style="margin:0px 25px 0px 25px;">{!! $role->code !!}</span>
            </div>
        </div>
        @endforeach
        <br/><br/>
        <input type="hidden" name="user" value="{!! $result->registered->user !!}">
        <button type="button" class="btn btn-success pull-right" onclick="saveUserPrivilege($(this))">Submit</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal"onclick="setList('list');">{!! trans('general.back') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
</div>



<script type="text/javascript">
    function saveUserPrivilege(submitButtonElement){
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
                if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
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

    }
    $('.custom-content-form').LoadingOverlay("hide");
    

}
</script>
