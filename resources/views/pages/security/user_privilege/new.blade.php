<div>
    <h5>{!! trans('security.new-data-user-form') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'user/save', 'role' => 'form', 'class'=>'form', 'data-validate' => 'parsley']) !!}
        <div class="form-group">
            <label for="exampleInputName1">Username</label>
             {!! Form::text('user_name',null , ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Username', 'required'=>true]) !!}
        </div>

        <div class="form-group">
            <label for="exampleInputName1">Password</label>
             {!! Form::password('password', ['class'=>'form-control', 'id'=>'inputPassword', 'placeholder'=>'Password', 'required'=>true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Confirm Password</label>
             {!! Form::password('cpassword', ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Confirm Password', 'required'=>true, 'data-parsley-equalto'=>'#inputPassword']) !!}
        </div>

        <hr>

        <div class="form-group">
            <label for="exampleInputName1">Full Name</label>
            {!! Form::text('full_name',null , ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Full Name', 'required'=>true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Email</label>
            {!! Form::text('email_address',null , ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Email Address', 'required'=>true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Status</label>
            {!! Form::select('user_status',[0=>"Tidak Aktif",1=>"Aktif"], 1 
            , ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'status']) !!}
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="doSave($(this))">Submit</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal"onclick="setList('list');">{!! trans('general.cancel') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
</div>
