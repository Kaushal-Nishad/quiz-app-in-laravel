<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="#" class="site_title">
            <img src="{{asset('site-img/'.$siteInfo[0]->site_logo)}}" alt="{{$siteInfo[0]->site_name}}" width="40px">
            <span>{{$siteInfo[0]->site_name}}</span>
        </a>
    </div>
    <div class="clearfix"></div>
    <!-- menu profile quick info -->
    <div class="profile clearfix">
        @if(!empty(session()->get('teacher_image')))
            <div class="profile_pic">
                <img src="{{asset('teacher/'.session()->get('teacher_image'))}}" alt="..." class="img-circle profile_img">
            </div> 
        @else
            <div class="profile_pic">
                <img src="{{asset('teacher/default.png')}}" alt="..." class="img-circle profile_img">
            </div> 
        @endif 
        <div class="profile_info">
        <span>Welcome,</span>
        <h2>{{session()->get('teacher_name')}}</h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /menu profile quick info -->
    <br />
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <li>
                <a href="{{url('teacher/home')}}"><i class="fa fa-home"></i>Home</a>
            </li>
            <li>
                <a href="{{url('teacher/quizzes')}}"><i class="fa fa-gears"></i>Quizzes</a>
            </li>
            <li>
                <a href="{{url('teacher/questions')}}"><i class="fa fa-question"></i>Questions</a>
            </li>
            <li>
                <a href="{{url('teacher/my-students')}}"><i class="fa fa-users"></i>Students</a>
            </li>
            <li>
                <a href="{{url('teacher/mailbox')}}"><i class="fa fa-envelope"></i>Mailbox</a>
            </li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->
</div>