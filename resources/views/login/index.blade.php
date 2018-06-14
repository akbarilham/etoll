<!DOCTYPE html>
<html>
	<head>
	    <meta charset="UTF-8">
	    <title>ETC E-Toll | Login</title>
	    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	    <meta name="keywords" content="Admin, Bootstrap 3, Template, Theme, Responsive">
	    <!-- bootstrap 3.0.2 -->
	    {!! HTML::style('templates/director/css/bootstrap.min.css') !!}
	    <!-- font Awesome -->
	    {!! HTML::style('templates/director/css/font-awesome.min.css') !!}
	    <!-- Ionicons -->
	    {!! HTML::style('templates/director/css/ionicons.min.css') !!}

	    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	    <!-- Theme style -->
	    {!! HTML::style('templates/director/css/style.css') !!}

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>

		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<section class="panel" style="margin-top: 150px;border: 1px solid #e4e2e2;">
		                  <header class="panel-heading panel-heading-custom-padding">
		                      LOGIN
		                  </header>
		                  <div class="panel-body">
		                      {!! Form::open(['url' => 'login', 'class' => 'form-horizontal', 'role' => 'form']) !!}
		                          <div class="form-group">
		                              <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Username</label>
		                              <div class="col-lg-10">
		                              		{!! Form::text('username',null, ['class'=>'form-control', 'id'=>'inputUsername1', 'placeholder'=>'Username']) !!}
		                              </div>
		                          </div>
		                          <div class="form-group">
		                              <label for="inputPassword1" class="col-lg-2 col-sm-2 control-label">Password</label>
		                              <div class="col-lg-10">
		                                  {!! Form::password('password', ['class'=>'form-control', 'id'=>'inputPassword1', 'placeholder'=>'Password']) !!}
		                              </div>
		                          </div>
		                          <div class="form-group">
		                              <div class=" col-md-offset-2 col-md-6">
		                                  <div class="checkbox">
		                                      <label>
		                                          <input type="checkbox"> Remember me
		                                      </label>
		                                  </div>
		                              </div>
		                              <div class="col-md-4">
		                              		<button type="submit" class="btn btn-danger lr">Sign in</button>
		                              </div>
		                          </div>
		                          @if(isset($msg))
		                          <div class="form-group">
		                              <div class="col-lg-offset-2 col-lg-10">
		                                  	<label>
	                                          	{{ $msg }}
	                                      	</label>
		                              </div>
		                          </div>
		                          @endif
	                      	{!! Form::close() !!}
	                  	</div>
	              	</section>
			</div>
			<div class="col-md-4"></div>
		</div>

	 <!-- jQuery 2.0.2 -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	{!! HTML::script('templates/director/js/jquery.min.js') !!}
	<!-- Bootstrap -->
	{!! HTML::script('templates/director/js/bootstrap.min.js') !!}
	<!-- Director App -->
	{!! HTML::script('templates/director/js/Director/app.js') !!}
	</body>
</html>