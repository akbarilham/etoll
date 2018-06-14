<div>
    <h5>{!! trans('master.edit-data-provider-form') !!}</h5>
    <hr/>
    {!! Form::open(['url' => 'blacklist/update', 'role' => 'form']) !!}
        <div class="form-group">
            <label for="exampleInputName1">EMONEY</label>
             {!! Form::text('emoney_id',$result->dataQuery->emoney_id, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'EMONEY']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">STATUS</label>
            {!! Form::text('obu_id',$result->dataQuery->obu_id, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'OBU']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Name</label>
            {!! Form::text('p_subscription_status_id',$result->dataQuery->p_subscription_status_id, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'STATUS']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">PRODUCT</label>
             {!! Form::text('product_id',$result->dataQuery->product_id, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'PRODUCT']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">Data</label>
            {!! Form::text('data_id',$result->dataQuery->data_id, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Data']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">BALANCE</label>
            {!! Form::text('last_balance',$result->dataQuery->last_balance, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'BALANCE']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">TOP UP</label>
             {!! Form::text('topup_amount',$result->dataQuery->topup_amount, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'TOP UP']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">TRANSASCTION</label>
            {!! Form::text('transaction_id',$result->dataQuery->transaction_id, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'TRANSASCTION']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">SEND</label>
            {!! Form::text('send_status',$result->dataQuery->send_status, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'SEND']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">TRANSACTION DATE</label>
             {!! Form::text('trans_date',$result->dataQuery->trans_date, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'TRANSACTION DATE']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">BLACKLIST TYPE</label>
            {!! Form::text('black_list_type_id',$result->dataQuery->black_list_type_id, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'BLACKLIST TYPE']) !!}
        </div>
        <div class="form-group">
            <label for="exampleInputName1">BLACK LIST SOURCE</label>
            {!! Form::text('black_list_source',$result->dataQuery->black_list_source, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'BLACK LIST SOURCE']) !!}
        </div>
         <div class="form-group">
            <label for="exampleInputName1">FILE</label>
            {!! Form::text('file_seq',$result->dataQuery->file_seq, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'FILE']) !!}
        </div>
         <div class="form-group">
            <label for="exampleInputName1">TIME</label>
            {!! Form::text('time_stamp_ic',$result->dataQuery->time_stamp_ic, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'TIME']) !!}
        </div>
        <input type="hidden" name="id" value="{!!$result->dataQuery->emoney_id!!}">
        <button type="button" class="btn btn-success pull-right" onclick="doSave($(this))">Submit</button>
        <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal"onclick="setList('list');">{!! trans('general.cancel') !!}</button>
        <div style="clear:both"></div>
    {!! Form::close() !!}
</div>
