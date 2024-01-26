<!DOCTYPE html>
<html lang="en">
<head>
  @include('admin.layout.head')
</head>
<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col menu_fixed">
        @include('admin.layout.sidebar')
      </div>
      <!-- top navigation -->
      <div class="top_nav">
        @include('admin.layout.header')
      </div>
      <!-- /top navigation -->
      <!-- page content -->
      <div class="right_col" role="main" style="min-height:100%;">
        @yield('content')
      </div>
      <!-- /page content -->
      <!-- footer content -->
      @include('admin.layout.footer')
      

      
    