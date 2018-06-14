<div>
    <h5>{!! trans('security.edit-data-role-form') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'userrole/update', 'role' => 'form']) !!}
        <div class="form-group">
            <label for="exampleInputName1">Name</label>
             {!! Form::text('name',$result->dataQuery->code , ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Role name', 'required'=>true]) !!}
        </div>

        <div class="form-group">
            <label for="exampleInputName1">Status</label>
            {!! Form::select('is_active',['Y'=>"Aktif",'N'=>"Tidak Aktif"], $result->dataQuery->is_active
            , ['class'=>'form-control', 'id'=>'inputName']) !!}
        </div> 

        <div class="form-group">
            <label for="exampleInputName1">Description</label>
            {!! Form::textarea('description', $result->dataQuery->description, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Role description', 'rows' =>"3"]) !!}
        </div>

        <div class="form-group">
            <label for="exampleInputName1">Select Menu</label>
        </div>
        <br>
        @foreach($result->menus as $key=>$menu)
        <div class="form-group">
            <div class="checkbox checkbox-warning" style="padding-top: 0px; width: 100%; margin-top: -10px;">
                <label>
                    <input <?php if( in_array($menu->p_menu_id, (array)$result->selected_menus ) ){ echo 'checked'; } ?> type="checkbox" name="menus[]" value="{!! $menu->p_menu_id !!}">

                <i style="margin-top: -16px;margin-right: 5px;"></i>
                </label>
                <span style="margin:0px 25px 0px 5  px;">{!! $menu->code !!}</span>
            </div>
        </div>
       @endforeach

        <input type="hidden" name="id" value="{!!$result->dataQuery->p_role_id!!}">
        <button type="button" class="btn btn-success pull-right" onclick="doSave($(this))">Submit</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal"onclick="setList('list');">{!! trans('general.cancel') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
</div>
