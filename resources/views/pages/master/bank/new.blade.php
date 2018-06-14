<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Add</h4>
            </div>
            <div class="modal-body">

                {!! Form::open(['url' => 'bank/save', 'role' => 'form']) !!}
                    <div class="form-group">
                        <label for="exampleInputName1">Code</label>
                         {!! Form::text('code',null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Code']) !!}
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        {!! Form::text('name',null, ['class'=>'form-control', 'id'=>'inputName', 'placeholder'=>'Bank Name']) !!}
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Status</label>
                        {!! Form::select('status',[0=>"Tidak Aktif",1=>"Aktif"], 1, ['class'=>'form-control', 'id'=>'inputName']) !!}
                    </div>
                    <button type="button" class="btn btn-success pull-right" onclick="doSave($(this))">Submit</button>
                    <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal">Close</button>
                    <div style="clear:both"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $("#myModal").modal('show');
    });
</script>
