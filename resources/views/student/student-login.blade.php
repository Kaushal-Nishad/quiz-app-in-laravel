<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Online-Test</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="site_URL" content="{{ url('/')}}">
<!-- Bootstrap -->  
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/sweet-alert-bootstrap-4.min.css')}}">
<!-- Custom Theme Style -->
<link  rel="stylesheet" href="{{asset('assets/css/custom.min.css')}}">
</head>
<body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form id="studentLogin" method="POST">
              @csrf
              <input type="hidden" class="url" value="{{url('student/student-login')}}">
              <h1>Hello Student</h1>
              <div>
                <input type="text" name="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button class="btn btn-success submit" href="#">Log in</button>
                 @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('loginError'))
                    <div class="alert alert-danger">
                        {{Session::get('loginError')}}
                    </div>
                @endif
              </div>
              
              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1><i class="fa fa-paw"></i>{{$siteInfo[0]->site_name}}</h1>
                  <p>Copyright @ <?php echo date('Y'); ?> <a href="#" target="_blank">Kaushal Nishad</a></p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <!-- jQuery -->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <!-- Bootstrap -->
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <!-- jquery-validation -->
  <script src="{{asset('assets/js/sweetalert2.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
  <!--Teacher-Login.js  -->
  <script src="{{asset('assets/js/student-login.js')}}"></script>
  </body>
</html>