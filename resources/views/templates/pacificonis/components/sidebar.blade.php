@section('sidebar')
<aside class="sidebar">
  <ul class="nav metismenu">
  <!-- client profile -->
    <li class="profile-sidebar-container">
      <div class="profile-sidebar text-center">
        <!-- <div class="profile-userpic">
          <img src="img/profile_user.jpg" class="img-responsive img-circle center-block" alt="user">
          <span class="online"></span>
        </div> -->
        <div class="profile-usertitle">
          <!-- <div class="name">
            Hallo,&nbsp;&nbsp;{{ Session::get('logged_user')['name'] }}
          </div> -->
        </div>
        <!-- <div class="profile-activity clearfix">
          <div class="pull-left">
            Photos
            <br>
            <span>56</span>
          </div>
          <div class="pull-right">
            Videos
            <br>
            <span>18</span>
          </div>
        </div> -->
      </div>
    </li>
    <!-- client profile -->

    @foreach(  Session::get('logged_user')['authorization'] as $key=>$menu )

        @if(is_array($menu))

            <li>
              <a href="#"><i class="zmdi zmdi-view-dashboard"></i>{!! $key !!}<span class="zmdi arrow"></span></a>
              <ul class="nav nav-inside collapse">
                <li class="inside-title">{!! $key !!}</li>
                @foreach($menu as $child_key => $child_menu)

                 <li><a href="{!! URL(strtolower($child_menu->route)) !!}">{!!$child_menu->name!!}</a></li>
                    
                @endforeach
              </ul>
            </li>

        @else

            <li>
              <a href="{!! URL(strtolower($menu->route)) !!}"><i class="zmdi zmdi-copy"></i>{!!$menu->name!!}</a>
            </li>

        @endif
    @endforeach

  </ul>
</aside>
@endsection