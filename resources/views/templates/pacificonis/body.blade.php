@include('templates.pacificonis.components.header')
@include('templates.pacificonis.components.content')
@include('templates.pacificonis.components.sidebar')
<body class="fixed-sidebar three-column-layout small-content">
    <!-- wrapper -->
    <div class="wrapper">
    <!-- header logo: style can be found in header.less -->
    @yield('header')
        <!-- Left side column. contains the logo and sidebar -->
       @yield('sidebar')

        <!-- Right side column. Contains the navbar and content of the page -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('contents')
                </div>
            </div>
        </div>


        @yield('footer')

    </div>
    <!-- wrapper -->
</body>