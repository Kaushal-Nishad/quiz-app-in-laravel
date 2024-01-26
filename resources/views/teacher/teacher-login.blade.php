<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{$siteInfo[0]->site_name}}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="site_URL" content="{{ url('/')}}">
<!-- Bootstrap -->  
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
<!-- Custom Theme Style -->
<link  rel="stylesheet" href="{{asset('assets/css/custom.min.css')}}">
</head>
<body class="login">
    <div>
     
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form id="teacherLogin" method="POST">
              @csrf
              <input type="hidden" class="url" value="{{url('teacher/teacher-login')}}">
              <h1>Hello Teacher</h1>
              <div>
                <input type="text" name= "email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" name= "password" class="form-control" placeholder="Password" required="" />
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
  </body>
  <!-- jQuery -->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <!-- Bootstrap -->
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <!-- jquery-validation -->
  <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
  <!--Teacher-Login.js  -->
  <script src="{{asset('assets/js/teacher-login.js')}}"></script>
 	
</html>