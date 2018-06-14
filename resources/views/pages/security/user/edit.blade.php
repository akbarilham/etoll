<div>
    <h5>{!! trans('security.edit-data-user-form') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'user/update', 'role' => 'form', 'data-validate' => 'parsley']) !!}
        <div class="form-group">
            <label for="exampleInputName1">Username</label>
             {!! Form::text('user_name',$result->dataQuery->user_name, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Username', 'required'=>true, 'data-parsley-pattern' => '^[a-zA-Z0-9]+$']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Full Name</label>
            {!! Form::text('full_name',$result->dataQuery->full_name, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Full Name', 'required'=>true, 'data-parsley-pattern' => '^[a-zA-Z ]+$']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Email</label>
            {!! Form::text('email_address',$result->dataQuery->email_address, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Email Address']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Status</label>
            {!! Form::select('user_status',[0=>"Tidak Aktif",1=>"Aktif"], $result->dataQuery->user_status
            , ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'status']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Role</label>
             <select name="role" class="form-control" required>
                 @foreach($result->roles as $key=>$role)
                    <option <?php if( $role->p_role_id == $result->dataQuery->p_role_id ){ echo 'selected'; } ?> value="{!! $role->p_role_id !!}"> {!! $role->code !!} </option>
                 @endforeach
             </select>
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Last Login</label>
            {!! Form::text('a',$result->dataQuery->last_login_time, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Last login', 'disabled'=>true]) !!}
        </div>
        <!-- <hr>
        <div class="form-group">
            <label for="exampleInputName1">Old Password</label>
             {!! Form::password('old_password', ['class'=>'form-control', 'id'=>'inputPassword', 'placeholder'=>'Password']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">New Password</label>
             {!! Form::password('new_password', ['class'=>'form-control', 'id'=>'inputPassword', 'placeholder'=>'Password']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Confirm New Password</label>
             {!! Form::password('c_new_password', ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Confirm Password', 'data-parsley-equalto'=>'#inputPassword']) !!}
        </div> -->
        <input type="hidden" name="id" value="{!!$result->dataQuery->p_user_id!!}">
        <button type="button" class="btn btn-success pull-right" onclick="doSave($(this))">Submit</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal"onclick="setList('list');">{!! trans('general.cancel') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
</div>
