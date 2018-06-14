@section('header')

<nav class="navbar navbar-cyan">
    <div class="navbar-header container brand-blue">
       <a href="#" class="menu-toggle"><i class="zmdi zmdi-menu" data-toggle="tooltip" title="{!! trans('general.menu-navigation') !!}"></i></a>
       <a href="{!!URL('')!!}" class="logo">ETC ADMIN</a>
       <a href="{!!URL('')!!}" class="icon-logo"></a>
    </div>
    <div class="navbar-container clearfix">
        <!-- <div class="pull-left">
          <a href="#" class="page-title text-uppercase">Tables</a>
        </div> -->

        <div class="pull-right">
            <!-- <div class="pull-left search-container">
                <form class="searchbox">
                  <input type="text" placeholder="Search" name="search" class="searchbox-input">
                  <input type="submit" class="searchbox-submit" value="">
                  <span class="searchbox-icon"><span class="zmdi zmdi-search search-icon"></span></span>
                </form>
            </div> -->

            <ul class="nav pull-right right-menu">
                <li class="more-options dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" title="{!! trans('general.menu-navigation') !!}">
                        <i class="zmdi zmdi-account-circle"></i>
                    </a>
                    <div class="more-opt-container dropdown-menu">
                        <a href="{!!URL('changepassword')!!}"><i class="zmdi zmdi-settings"></i>Change Password</a>
                        <a href="{!!URL('logout')!!}"><i class="zmdi zmdi-run"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

@endsection