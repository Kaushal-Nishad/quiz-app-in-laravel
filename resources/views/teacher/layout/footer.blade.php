<div class="pull-right">
Copyright @ <?php echo date('Y'); ?> <a href="#" target="_blank">Kaushal Nishad</a>
</div>
<div class="clearfix"></div>
</footer>
<input type="text" id="url" hidden value="{{url('/')}}">
<!-- /footer content -->
</div>
    </div>
    <!-- jQuery -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/select2.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="{{asset('assets/js/bootstrap-wysiwyg.min.js')}}"></script>
	<script src="{{asset('assets/js/jquery.hotkeys.js')}}"></script>
    <script src="{{asset('assets/js/prettify.js')}}"></script>
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