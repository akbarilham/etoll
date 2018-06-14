<div>
    <h5>{!! trans('master.new-data-provider-form') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'balance_history/save', 'role' => 'form', 'data-validate' => 'parsley']) !!}
        <div class="form-group">
            <label for="exampleInputName1">Service No</label>
             {!! Form::text('service_no',null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Code', 'required'=>true]) !!}
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="doSave($(this))">Submit</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal" onclick="setList('list');">{!! trans('general.cancel') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
    
</div>
