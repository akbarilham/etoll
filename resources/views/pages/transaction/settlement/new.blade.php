<div>
    <h5>{!! trans('master.new-data-provider-form') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'provider/save', 'role' => 'form', 'data-validate' => 'parsley']) !!}
        <div class="form-group">
            <label for="exampleInputName1">Code</label>
             {!! Form::text('code',null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Code', 'required'=>true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Name</label>
            {!! Form::text('name',null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Provider Name', 'required'=>true]) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Status</label>
            {!! Form::select('status',[0=>"Tidak Aktif",1=>"Aktif"], null, ['class'=>'form-control', 'id'=>'inputName']) !!}
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="doSave($(this))">Submit</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal" onclick="setList('list');">{!! trans('general.cancel') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
    
</div>
