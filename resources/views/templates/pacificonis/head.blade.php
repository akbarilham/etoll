@include('templates.pacificonis.components.script')
<head>
    <meta charset="UTF-8">
    <title>ETC</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no" />
  
  
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#49CEFF">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#49CEFF" />
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- Theme style -->

    {!! HTML::style('templates/pacificonis/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! HTML::style('templates/pacificonis/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('templates/pacificonis/bower_components/animate.css/animate.min.css') !!}
    {!! HTML::style('templates/pacificonis/bower_components/metisMenu/dist/metisMenu.min.css') !!}
    {!! HTML::style('templates/pacificonis/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') !!}
    {!! HTML::style('templates/pacificonis/bower_components/Waves/dist/waves.min.css') !!}
    {!! HTML::style('templates/pacificonis/bower_components/toastr/toastr.css') !!}

    {!! HTML::style('templates/pacificonis/css/style.css') !!}

    {!! HTML::style('templates/pacificonis/css/demo.css') !!}

    <!-- Theme style -->


    {!! HTML::style('css/sweetalert.css') !!}

    {!! HTML::style('css/bootstrap-datepicker.css') !!}

    {!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
    
    {!! HTML::style('css/bootstrap-datetimepicker.min.css') !!}


    @yield('script')
</head>