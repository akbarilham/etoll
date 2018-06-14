<?php $id = $_GET['p_plaza_id']; ?>
<div class="content-box">
    <div class="head info-bg clearfix">
        <h5 class="content-title pull-left">Toll Plaza Line</h5>
        <div class="functions-btns pull-right">
            <a class="fullscreen-btn" href="#" data-toggle="tooltip" title="{!! trans('general.go-fullscreen') !!}"><i class="zmdi zmdi-fullscreen"></i></a>
        </div>
    </div>

    <hr/>

        <section class="panel">
             <header class="panel-heading panel-heading-custom-padding">
                <div class="row">
                  <div class="col-md-12">

                    {!! Form::open(['onsubmit'=>'return false;', 'role' => 'form', 'id' => 'list-filter', 'method' => 'get', 'class'=>'form-inline', 'data-parsley-validate' => 'parsley']) !!}
                    <div class="form-group">
                        {!! Form::text('search', null, ['class' => 'form-control', 'placeholder'=> 'Search', 'onchange' => 'setList("list", "")', 'required' => true]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::select('perpage', [5=>5, 10=>10, 30=>30, 100=>100], null, ['class' => 'form-control',  'onchange' => 'setList("list", "")', 'required' => true ]) !!}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="button"  onclick="addsNew('new', 'p_plaza_gate_id', '{!! $id !!}')">Add New</button>
                    </div>
                    {!! Form::close() !!}
                    
                  </div>
                </div>

            </header>
        </section>

    <div class="content-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                {!! Form::open(['onsubmit'=>'return false;', 'url' => 'obuactivation/approve', 'role' => 'form']) !!}
                <div class="m-b-20">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Line Code</th>
                                <th>Sequence No</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php $no=1; ?>

                            @foreach ($result->dataQuery->body as $objectData)
                            <?php 
                                $arraydata = (array) $objectData;
                                $datas = implode('|', array_values($arraydata));
                                $datadel = key($arraydata);
                            ?>
                            
                            <tr>
                                <td>{!! $no !!}</td>
                                <td>{!! $objectData->gate_code !!}</td>
                                <td>{!! $objectData->seq_no !!}</td>
                                <td>{!! $objectData->description !!}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit link btn-sm-c-1" data-toggle="tooltip" title="edit" onclick="doViewDetail('viewdetail', '{!! $objectData->p_plaza_gate_id !!}', '{!! $datas !!}')"><i class="zmdi zmdi-edit"></i></button>&nbsp;
                                    <button class="btn btn-sm btn-danger delete link btn-sm-c-1" data-toggle="tooltip" title="delete" _token="{{csrf_token()}}" onclick="doDeletes($(this), 'tollplaza/mydelete', '{!! $objectData->p_plaza_gate_id !!}', '{!! $datadel !!}')"><i class="zmdi zmdi-delete"></i></button>
                                </td>
                            </tr>

                            <?php $no++; ?>
                            @endforeach

                        </tbody>
                    </table>
                    <span class="pagination text-muted">{!! $result->dataQuery->lastPage !!} Pages in total&nbsp;</span>
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li onclick="setList(\'list\', 4)"><a href="#" data-toggle="tooltip" title="'.trans('general.prev-page').'">«</a></li>
                </div>            
                <div class="form-group" style="margin: 1em">
                    <input type="hidden" name="id" value="1">
                    <input name="_token" id="token" type="hidden" value="{{ csrf_token() }}"/>
                    <button type="button" name="approval_status" class="btn btn-success pull-right" onclick="doSave($(this))">Save</button>
                    <button type="button" class="btn btn-default pull-right" style="margin-right:10px" data-dismiss="modal"onclick="setList('list');">{!! trans('general.cancel') !!}</button>
                </div>
            {!! Form::close() !!}            
            </div>
        </div>
    </div>
</div>
