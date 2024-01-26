<div class="left_col scroll-view"> 
    <div class="navbar nav_title" style="border: 0;">
        <a href="#" class="site_title">
        @if($siteInfo[0]->site_logo != '')
            <img src="{{asset('site-img/'.$siteInfo[0]->site_logo)}}" alt="{{$siteInfo[0]->site_name}}" width="40px">
        @endif
            <span>{{$siteInfo[0]->site_name}}</span></a>
    </div>
    <div class="clearfix"></div>
    <!-- menu profile quick info -->
    <div class="profile clearfix">
        <div class="profile_pic">
            {{-- @dd(session()->get('admin_image')) --}}
            @if(session()->get('admin_image') == '')
                <img src="{{asset('site-img/default.png')}}" alt="..." class="img-circle profile_img">
            @else
            <img src="{{asset('site-img/'.$adminImg->image)}}" alt="..." class="img-circle profile_img">
            @endif
        </div>
        <div class="profile_info">
        <span>Welcome,</span>
        <h2>{{session()->get('admin_name')}}</h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /menu profile quick info -->
    <br />
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li>
                <a href="{{url('admin/dashboard')}}"><i class="fa fa-home"></i>Dashboard</a>
            </li>
            <li>
                <a href="{{url('admin/subjects')}}"><i class="fa fa-book"></i>Subjects</a>
            </li>
            <li>
                <a href="{{url('admin/quizzes')}}"><i class="fa fa-file"></i>Quizzes</a>
            </li>
            <li>
                <a href="{{url('admin/questions')}}"><i class="fa fa-question"></i>Questions</a>
            </li>
            <li>
                <a href="{{url('admin/teachers')}}"><i class="fa fa-user"></i>Teachers</a>
            </li>
            <li>
                <a href="{{url('admin/students')}}"><i class="fa fa-users"></i>Students</a>
            </li>
            
            <li><a><i class="fa fa-cog"></i>Settings <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{url('admin/general-settings')}}">General Settings</a></li>
                    <li><a href="{{url('admin/profile-settings')}}">Profile Settings</a></li>
                </ul>
            </li>
        </ul>
        </div>
    </div>
    <!-- /sidebar menu -->
</div>