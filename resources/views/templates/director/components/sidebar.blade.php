@section('sidebar')
<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                
            </div>
            <div class="pull-left info">
                <p>Halo,&nbsp;&nbsp;{{ Session::get('logged_user')['name'] }}</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>
                <a href="{!! URL('dashboard') !!}">
                    <span>Dashboard</span>
                </a>
            </li>
            @foreach(  Session::get('logged_user')['authorization'] as $menu )
                <li>
                    <a href="{!! URL(strtolower($menu->route)) !!}">
                        <span>{!!$menu->name!!}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
@endsection