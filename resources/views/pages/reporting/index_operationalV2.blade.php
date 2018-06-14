@extends('index')

 @section('content')

<div class="content-box">
    <div class="head info-bg clearfix">
        <h5 class="content-title pull-left">Operasional Report V2</h5>
        <div class="functions-btns pull-right">
            <a class="fullscreen-btn" href="#"><i class="zmdi zmdi-fullscreen"></i></a>
        </div>
    </div>

    <div class="content">

      {!! Form::open(array('url' => 'reportoperasionalv2/showreport', 'class'=>'form-horizontal','style'=>'max-width:900px')) !!}

        @if( Session::has( 'empty' ))
          <div class="alert alert-danger">
             {{ Session::get( 'empty' ) }}
          </div>
        @endif

        <div class="col-md-12">
            <div class="form-group">
                <label>Plaza</label>
                <select class="form-control" name="i_plaza" onchange="getLane($(this));">
                  @foreach($plaza as $item)
                    <option value="{{$item->plaza_code}}">{{$item->plaza_name}}</option>
                  @endforeach
                    <option value="all">ALL</option>
                </select>
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                <label>Lane</label>
                <select class="form-control" name="i_lane" id="gate-lane">
                    <option value="all">ALL</option>
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Date From</label>
                <div class="input-group date datefrom">
                    <span class="input-group-addon">
                        <span class="zmdi zmdi-calendar"></span>
                    </span>
                    {!! Form::text('dtfrom', date('d/m/Y'),['class' => 'form-control datepicker datefrom', 'placeholder'=>'Input date']) !!}
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Date To</label>
                <div class="input-group date dateto">
                    <span class="input-group-addon">
                        <span class="zmdi zmdi-calendar"></span>
                    </span>
                    {!! Form::text('dtto', date('d/m/Y'),['class' => 'form-control datepicker dateto', 'placeholder'=>'Input date']) !!}
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Format as</label>
                {!! Form::select('exformat',['pdf'=>"Pdf"], 1, ['class'=>'form-control', 'id'=>'inputName']) !!}
            </div>
        </div>



      {{ Form::button('Submit', array('class' => 'btn btn-success', 'style'=>'float:right;', 'type'=>'submit')) }}
      <div style="clear:both"></div>
      {!! Form::close() !!}
      <input id="url" type="hidden" value="{!! URL('') !!}">

      <script type="text/javascript">
       var thisYear = new Date().getYear();
       var thisDate = new Date().getDate();
        $(function(){
          var option = {
            format: "dd/mm/yyyy",
            autoclose: true,
            disableTouchKeyboard: true,
            enableOnReadonly: true
          };

          $('.datefrom').datepicker(option).on('changeDate', function(selected){
            var minDate = new Date(selected.date.valueOf());
            $('.dateto').datepicker('setStartDate', minDate);
          })

          $('.dateto').datepicker(option).on('changeDate', function(selected){
            var maxDate = new Date(selected.date.valueOf());
            $('.datefrom').datepicker('setEndDate', maxDate);
          })

        })
        $('.datepicker').keydown(false);
      </script>

      <script type="text/javascript">
        function getLane(element){
          var plaza = element.val();
          var url = $('#url').val() + '/reportoperasional/getlane';
          //alert(url);
          $.ajax({
            url : url,
            data : {plaza_code : plaza},
            type : 'get',
            success: function(response) {
              if(String(response.replace(/\s+/g, '')) === "SESSION_EXPIRED"){ window.location.reload() }
              $('#gate-lane').append(response);
              console.log(response);
            },
            error: function (xhr, status, error){
              
            }
          });
        }
      </script>


    </div>
</div>

</div>

@endsection