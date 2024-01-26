 <meta charset="UTF-8">
    <title>{{$siteInfo[0]->site_title}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/summernote/summernote-bs4.css')}}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('assets/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive.bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweet-alert-bootstrap-4.min.css')}}">
    <!-- Style.CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
      .jst-hours {
         display: inline-block;
      }
      .jst-minutes {
         display: inline-block;
      }
      .jst-seconds {
         display: inline-block;
      }
      .jst-clearDiv {
         clear: both;
         display: inline-block;
      }
      .jst-timeout {
         color: red;
      }
    </style>