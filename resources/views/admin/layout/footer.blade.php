      <footer>
        <div class="pull-right">
          Copyright @ <?php echo date('Y'); ?> <a href="#" target="_blank">Kaushal Nishad</a>
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
      <input type="text" id="url" hidden value="{{url('/')}}">
      </div>
    </div>
    <!-- jQuery -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('assets/nprogress/nprogress.js')}}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{asset('assets/js/custom.min.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/daterangepicker.js')}}"></script>
    <!-- jquery-validation -->
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <!-- sweet alert -->
    <script src="{{asset('assets/js/sweetalert2.min.js')}}"></script>
    <!-- Main_ajax.js -->
    <script src="{{asset('assets/js/main_ajax.js')}}"></script>
    @yield('pageJsScripts')
    </body>
</html>