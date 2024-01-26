 
 <div class="container">
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="{{url('student/my-quizzes')}}" class="nav-link">Quizzes</a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/my-quiz-history')}}" class="nav-link">History</a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/mailbox')}}" class="nav-link">Mailbox</a>
          </li>
        </ul>
        <!-- Right navbar links -->
    
    <ul class="navbar-nav ml-auto">
       <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          @if(count($notification) > 0)
          <span class="badge badge-warning navbar-badge">{{count($notification)}}</span>
          @endif
        </a>
        @if(count($notification) > 0)
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @foreach($notification as $noty)
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="{{asset('student/default.png')}}" alt="" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                  {{session()->get('student_name')}}
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm"> {{$noty->mail_title}}</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{date('d M, Y',strtotime($noty->created_at))}}</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            @endforeach
            <a href="{{url('student/mailbox')}}" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        @endif
      </li>
      <li class="nav-item dropdown">
        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Hello, {{session()->get('student_name')}}</a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
          <li><a href="{{url('student/profile')}}" class="dropdown-item">My Profile </a></li>
          <li class="dropdown-divider"></li>
          <li><a href="{{url('student/logout')}}" class="dropdown-item">Logout</a></li>
        </ul>
      </li>
    </ul>
   
  </div>   