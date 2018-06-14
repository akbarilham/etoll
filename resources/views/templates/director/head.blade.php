@include('templates.director.components.script')
<head>
    <meta charset="UTF-8">
    <title>Director | General UI</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="Developed By M Abdur Rokib Promy">
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

    {!! HTML::style('css/sweetalert.css') !!}

    {!! HTML::style('css/datepicker.css') !!}

    <!-- HTML TAB -->
    {!! HTML::style('css/htmltab.css') !!}   

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
     <!-- jQuery 2.0.2 -->
    @yield('script')
</head>