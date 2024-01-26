<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>@yield('title') > {{$siteInfo[0]->site_title}}</title>
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<!-- Bootstrap --> 
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
<!-- Datatables -->
 <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/responsive.bootstrap.min.css')}}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
<!-- NProgress -->
<link rel="stylesheet" href="{{asset('assets/nprogress/nprogress.css')}}">
<!-- bootstrap-daterangepicker -->
<link rel="stylesheet" href="{{asset('assets/css/daterangepicker.css')}}">
<!-- Custom Theme Style -->
<link  rel="stylesheet" href="{{asset('assets/css/custom.min.css')}}">
<!-- Select2 Style -->
<link  rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
<!-- Sweet Alert -->
<link  rel="stylesheet" href="{{asset('assets/css/sweet-alert-bootstrap-4.min.css')}}">
<!-- Style.CSS -->
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">