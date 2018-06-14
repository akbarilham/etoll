@section('list')
<div class="content-box">
    <div class="head info-bg clearfix">
        <h5 class="content-title pull-left">Operaton Report List</h5>
        <div class="functions-btns pull-right">
            <a class="fullscreen-btn" href="#" data-toggle="tooltip" title="{!! trans('general.go-fullscreen') !!}"><i class="zmdi zmdi-fullscreen"></i></a>
        </div>
    </div>

    <div class="content">
        <div class="custom-content-list">
            <section class="panel">
                 <header class="panel-heading panel-heading-custom-padding">
                    <div class="row">
                      <div class="col-md-12">

                        {!! Form::open(['onsubmit'=>'return false;', 'role' => 'form', 'id' => 'list-filter', 'method' => 'get', 'class'=>'form-inline']) !!}
                        <div class="form-group">
                            {!! Form::text('dtfrom', date('d/m/Y'),['class' => 'form-control datepicker', 'placeholder'=>'Input date']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::text('dtto', date('d/m/Y'),['class' => 'form-control datepicker', 'placeholder'=>'Input date']) !!}
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
