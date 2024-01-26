 <div class="nav_menu">
    <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
    </div>
    <nav class="nav navbar-nav">
    <ul class=" navbar-right">
        <li class="nav-item dropdown open" style="padding-left: 15px;">
        <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
        @if(empty(session()->get('admin_image')))
            <img src="{{asset('site-img/default.png')}}">Hello,{{session()->get('admin_name')}}
        @else
            <img src="{{asset('site-img/'.$adminImg->image)}}">Hello,{{session()->get('admin_name')}}
        @endif
        </a>
        <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item"  href="{{url('admin/profile-settings')}}"> Profile</a>
            <a class="dropdown-item"  href="{{url('admin/change-password')}}"> Change Password</a>
            <a class="dropdown-item admin-logout"  href="javascript:void(0)"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
        </div>
        </li>
    </ul>
    </nav>
</div>