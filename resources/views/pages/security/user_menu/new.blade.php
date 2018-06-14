<div>
    <h5>{!! trans('security.new-data-menu-form') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'user_menu/save', 'role' => 'form', 'data-validate' => 'parsley']) !!}
        <div class="form-group">
            <label for="exampleInputName1">Application ID</label>
             {!! Form::text('application_id', null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Application ID', 'required' => true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Code</label>
             {!! Form::text('code', null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Code', 'required' => true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Parent ID</label>
             {!! Form::text('parent_id', null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Parent ID']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Route</label>
             {!! Form::text('file_name', null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Route', 'required' => true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Sorting</label>
             {!! Form::number('listing_no',null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Sorting']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Status</label>
            {!! Form::select('is_active',['Y'=>"Aktif",'N'=>"Tidak Aktif"], null
            , ['class'=>'form-control', 'id'=>'inputName']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Description</label>
             {!! Form::textarea('description', null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Description', 'required' => true]) !!}
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="doSave($(this))">Submit</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal" onclick="setList('list');">{!! trans('general.cancel') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
</div>
