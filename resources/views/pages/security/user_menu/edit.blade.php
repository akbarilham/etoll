<div>
    <h5>{!! trans('security.edit-data-menu-form') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'user_menu/update', 'role' => 'form', 'data-validate' => 'parsley']) !!}
        <div class="form-group">
            <label for="exampleInputName1">Menu ID</label>
             {!! Form::text('',$result->dataQuery->p_menu_id, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Application ID', 'readonly'=>true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Application ID</label>
             {!! Form::text('application_id',$result->dataQuery->p_application_id, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Application ID', 'required' => true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Code</label>
             {!! Form::text('code',$result->dataQuery->code, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Code', 'required' => true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Parent ID</label>
             {!! Form::text('parent_id',$result->dataQuery->parent_id, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Parent ID']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Route</label>
             {!! Form::text('file_name',$result->dataQuery->file_name, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Route', 'required' => true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Sorting</label>
             {!! Form::number('listing_no',$result->dataQuery->listing_no, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Sorting']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Status</label>
            {!! Form::select('is_active',['Y'=>"Aktif",'N'=>"Tidak Aktif"], $result->dataQuery->is_active
            , ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'status']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Description</label>
             {!! Form::textarea('description',$result->dataQuery->description, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Description', 'required' => true]) !!}
        </div>

        <input type="hidden" name="id" value="{!!$result->dataQuery->p_menu_id!!}">
        <button type="button" class="btn btn-success pull-right" onclick="doSave($(this))">Submit</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal" onclick="setList('list');">{!! trans('general.cancel') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
</div>
