@include('templates.director.components.header')
@include('templates.director.components.content')
@include('templates.director.components.sidebar')
<body class="skin-black">
    <!-- header logo: style can be found in header.less -->
    @yield('header')
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
       @yield('sidebar')

        <!-- Right side column. Contains the navbar and content of the page -->
        <div class="right-side">

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <!--breadcrumbs start -->
                        <!-- <ul class="breadcrumb">
                            <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Current page</li>
                        </ul> -->
                        <!--breadcrumbs end -->
                    </div>
                </div>
                @yield('contents')

            </section>
        </div>
        @yield('footer')
    </div><!-- ./wrapper -->
</body>