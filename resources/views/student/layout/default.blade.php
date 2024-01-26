<!doctype html>
<html lang="en-US">
<head>
   @include('student.layout.head')
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <div id="site-logo" class="p-3">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <img class="mx-auto d-block" src="{{asset('site-img/'.$siteInfo[0]->site_logo)}}" alt="" width="100px">
        </div>
      </div>
    </div>
  </div>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-dark">
      @include('student.layout.header')
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <!-- <aside class="control-sidebar control-sidebar-dark"> -->
    <!-- Control sidebar content goes here -->
    <!-- <div class="p-3"> -->
      <!-- <h5>Title</h5> -->
      <!-- <p>Sidebar content</p> -->
    <!-- </div> -->
  <!-- </aside> -->
  <!-- /.control-sidebar -->
  @include('student.layout.footer')
<!-- </div> -->
<!-- ./wrapper -->  
