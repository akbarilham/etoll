<!DOCTYPE html>
<html>
	<head>
	    <meta charset="UTF-8">
	    <title>ETC E-Toll | Login</title>
	    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	    <meta name="keywords" content="Admin, Bootstrap 3, Template, Theme, Responsive">
	    <!-- bootstrap 3.0.2 -->
	    {!! HTML::style('templates/pacificonis/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
	    {!! HTML::style('templates/pacificonis/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') !!}
	    {!! HTML::style('templates/pacificonis/bower_components/animate.css/animate.min.css') !!}
	    {!! HTML::style('templates/pacificonis/bower_components/metisMenu/dist/metisMenu.min.css') !!}
	    {!! HTML::style('templates/pacificonis/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') !!}
	    {!! HTML::style('templates/pacificonis/bower_components/Waves/dist/waves.min.css') !!}
	    {!! HTML::style('templates/pacificonis/bower_components/toastr/toastr.css') !!}
	    {!! HTML::style('templates/pacificonis/css/ori/style.css') !!}
	</head>
	<body class="user-page">
		  <!--Preloader-->
		<!--<div id="preloader">
		      <div class="refresh-preloader"><div class="preloader"><i>.</i><i>.</i><i>.</i></div></div>
		</div>-->

		<style type="text/css">
			.login-wrap {
  					max-width: 377px !important;
			}
			.custom-bg {
				background: rgba(255, 255, 255, 0.3);
			}
			@media (max-width: 480px) {
			  	.login-wrap {
				 	max-width: 100% !important;
				 	margin-left: 0 !important;
				 	-webkit-transform: none !important;
  					transform: none !important;
				}
				.custom-bg {
					background:none;
				}
			}
		</style>
		  <div class="wrapper warning-bg" style="background: #004689 !important;">
		      <div class="table-wrapper text-center">
		        <div class="table-row">
		          <div class="table-cell">
		            <div class="login login-wrap custom-bg" style="padding: 50px;">

		                  <h4 class="text-center">Login to continue</h4>
		                  {!! Form::open(['url' => 'login', 'class' => '', 'role' => 'form']) !!}
		                    <div class="form-group">
		                      {!! Form::text('username',null, ['class'=>'form-control', 'id'=>'inputUsername1', 'placeholder'=>'Username']) !!}
		                    </div>
		                    <div class="form-group">
		                      {!! Form::password('password', ['class'=>'form-control', 'id'=>'inputPassword1', 'placeholder'=>'Password']) !!}
		                    </div>

		                    <div class="form-group text-left">
		                      <div class="checkbox checkbox-primary">
		                        <label><input type="checkbox">
		                          <i></i></label>
		                          <span class="white f-s-16 m-l-5">Remember me</span>
		                      </div>
		                    </div>

		                    <button type="submit" class="btn btn-block btn-lg btn-warning">Login</button>
		                    	@if(isset($msg))
			                    	<br>
		                          	<div class="form-group">
		                              	<label style="color: #fb2424; font-size: 18px; font-weight: 400;">
		                                  	{{ $msg }}
		                              	</label>
		                          	</div>
	                          	@endif

	                        {!! csrf_field() !!}
		                  {!! Form::close() !!}

		            </div>
		            <div class="login-wrap" style="background-color: white; margin: 0 auto; padding: 1em 0;">
		            	<img src="{!! URL('images/jasamarga-logo.png') !!}" width="100" style="margin: 8px 6px 0 6px" />
		            	<img src="{!! URL('images/telkom-indonesia-logo.png') !!}" height="30" style="margin: 0 6px 0 6px" />
		            </div>
		          </div>
		        </div>
		      </div>

		  </div>

		  {!! HTML::script('templates/pacificonis/bower_components/jquery/dist/jquery.min.js') !!}
		<script>
		</script>
		<script>

		</script>
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">

		</script>
		<script type="text/javascript"></script>
		</body>
</html>