{!! HTML::script('templates/director/js/jquery.min.js') !!}
@extends('index')

@section('content')
<div class="content-box">
    <div class="head info-bg clearfix">
        <h5 class="content-title pull-left">{!! trans('general.new-rerate-form') !!}</h5>
        <div class="functions-btns pull-right">
            <a class="fullscreen-btn" href="#" data-toggle="tooltip" title="{!! trans('general.go-fullscreen') !!}"><i class="zmdi zmdi-fullscreen"></i></a>
        </div>
    </div>

    <div class="content" style="padding-right: 5rem;" id="form-container">
        <div class="row">
              <div class="col-md-12">
                    {!! Form::open(['url' => 'rerate/save', 'role' => 'form', 'class'=>'form', 'data-validate' => 'parsley']) !!}
                        <div class="form-group">
                            <label for="exampleInputName1">Reference</label>
                             {!! Form::text('reference',null , ['class'=>'form-control', 'id'=>'inputReference', 'placeholder'=>'Reference', 'required'=>true]) !!}
                        </div>

                        <button type="button" class="btn btn-success pull-right" onclick="submitRerate($(this))">Submit</button>
                        <button type="reset" class="btn btn-default pull-right" style="margin-right:10px" value="reset" >{!! trans('general.reset') !!}</button>
                        <div style="clear:both"></div>
                    {!! Form::close() !!}
              </div>
        </div>
    </div>

</div>
<input type="hidden" id="URL" value="{!!URL('')!!}">
{!! HTML::script('js/partial/rerate.js') !!}
@endsection
