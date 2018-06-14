@section('list')
  <section class="panel">
        <header class="panel-heading panel-heading-custom-padding">
              User
        </header>
         <header class="panel-heading panel-heading-custom-padding">
          	<div class="row">
      			  <div class="col-md-12">
          			
          		</div>
          	</div>
            {!! Form::open(['onsubmit'=>'return false;', 'role' => 'form', 'id' => 'list-filter', 'method' => 'get']) !!}
            <div class="input-group">
               {!! Form::text('search', null, ['class' => 'form-control', 'placeholder'=> 'Search', 'onchange' => 'setList("list", "")' ]) !!}
               <span class="input-group-btn">
                    {!! Form::select('searchby', $searchby, null, ['class' => 'form-control', 'style'=>'width:auto;margin-left:10px;',  'onchange' => 'setList("list", "")' ]) !!}

                    {!! Form::select('perpage', [5=>5, 10=>10, 30=>30, 100=>100], null, ['class' => 'form-control', 'style'=>'width:auto;margin-left:10px;',  'onchange' => 'setList("list", "")' ]) !!}
                    <button class="btn btn-success" style="margin-left:10px" type="button"  onclick="addNew('new')">Add New</button>
               </span>
            </div>
            {!! Form::close() !!}
        </header>
        <div class="panel-body table-responsive" id="list-table-container"></div>
  </section>
@endsection
<script type="text/javascript">
  $(function(){
    setList('list');
  })
</script>