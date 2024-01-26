<!DOCTYPE html>
<html lang="en">
<head>
  @include('teacher.layout.head')
</head>
<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col menu_fixed">
        @include('teacher.layout.sidebar')
      </div>
      <!-- top navigation -->
      <div class="top_nav">
        @include('teacher.layout.header')
      </div>
      <!-- /top navigation -->
      <!-- page content -->
      <div class="right_col" role="main">
        <div class=""> 
          @yield('content')
        </div>
      </div>
      <!-- /page content -->
      <!-- footer content -->
      <footer>
        @include('teacher.layout.footer')
      

      
    