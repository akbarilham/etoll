@section('list')
<div class="content-box">
    <div class="head info-bg clearfix">
        <h5 class="content-title pull-left">Menu</h5>
        <div class="functions-btns pull-right">
            <a class="fullscreen-btn" href="#" data-toggle="tooltip" title="{!! trans('general.go-fullscreen') !!}"><i class="zmdi zmdi-fullscreen"></i></a>
        </div>
    </div>

    <div class="head info-bg clearfix">
        
    </div>

    <div class="content">
        <div class="custom-content-list">
            <section class="panel">
                 <header class="panel-heading panel-heading-custom-padding">
                    <div class="row">
                      <div class="col-md-12">

                        {!! Form::open(['onsubmit'=>'return false;', 'role' => 'form', 'id' => 'list-filter', 'method' => 'get', 'class'=>'form-inline']) !!}
                        <div class="form-group">
                            {!! Form::text('search', null, ['class' => 'form-control', 'placeholder'=> 'Search', 'onchange' => 'setList("list", "")' ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::select('searchby', $searchby, null, ['class' => 'form-control',  'onchange' => 'setList("list", "")' ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::select('perpage', [5=>5, 10=>10, 30=>30, 100=>100], null, ['class' => 'form-control',  'onchange' => 'setList("list", "")' ]) !!}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-c-1" type="button"  onclick="addNew('new')">{!! trans('general.add-new') !!}</button>
                        </div>
                        {!! Form::close() !!}
                        
                      </div>
                    </div>

                </header>
                <div class="panel-body table-responsive" id="list-table-container"></div>
            </section> 
        </div>
        <div class="custom-content-form"></div>
    </div>

</div>
@endsection
<script type="text/javascript">
  $(function(){
    setList('list');
  })
</script>