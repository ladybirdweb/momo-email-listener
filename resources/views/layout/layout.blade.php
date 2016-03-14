<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" ng-app="myApp">
        <title>Faveo | MOMO EMAIL LISTENER</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- faveo favicon -->
        <link rel="shortcut icon" href="{{asset("lb-faveo/media/images/favicon.ico")}}">
        <!-- Bootstrap 3.3.2 -->
        <link href="{{asset("lb-faveo/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="{{asset("lb-faveo/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="{{asset("lb-faveo/css/ionicons.min.css")}}" rel="stylesheet">
        <!-- Theme style -->
        <link href="{{asset("lb-faveo/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link href="{{asset("lb-faveo/css/skins/_all-skins.css")}}" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="{{asset("lb-faveo/plugins/iCheck/flat/blue.css")}}" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <link rel="stylesheet" href="{{asset("lb-faveo/css/tabby.css")}}" type="text/css">
        <link href="{{asset("lb-faveo/css/jquerysctipttop.css")}}" rel="stylesheet" type="text/css">
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <link rel="stylesheet" href="{{asset("lb-faveo/css/editor.css")}}" type="text/css">
        <link href="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}" rel="stylesheet" type="text/css" />
        {{--jquery ui css --}}
        <link type="text/css" href="{{asset("lb-faveo/css/jquery.ui.css")}}" rel="stylesheet">
        <link type="text/css" href="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.css")}}" rel="stylesheet">
        <link href="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}" rel="stylesheet" type="text/css" />        
        <link rel="stylesheet" type="text/css" href="{{asset("lb-faveo/css/faveo-css.css")}}">

        <link href="{{asset("lb-faveo/css/jquery.rating.css")}}" rel="stylesheet" type="text/css" />

        <!-- Select2 -->
        <link rel="stylesheet" href="{{asset("lb-faveo/plugins/select2/select2.min.css")}}">
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="{{asset("lb-faveo/js/jquery-2.1.4.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/js/jquery2.1.1.min.js")}}" type="text/javascript"></script>

        @yield('HeadInclude')
    </head>
    <body class="sidebar-mini wysihtml5-supported skin-purple-light fixed">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="../../index2.html" class="logo">
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>MOMO</b> LISTENER</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">EMAIL</li>
                        <li @yield('list')><a href="{!! url('emails') !!}"><i class="fa fa-book"></i> <span>List All</span></a></li>
                        <li @yield('create')><a href="{!! url('emails/create') !!}"><i class="fa fa-book"></i> <span>Create</span></a></li>
                        <li class="header">MAILBOX</li>
                        <li @yield('inbox')><a href="{!! url('/') !!}"><i class="fa fa-circle-o text-aqua"></i> <span>Inbox</span></a></li>
                        <li @yield('read')><a href="{!! url('readmails') !!}"><i class="fa fa-circle-o text-aqua"></i> <span>Fetch Mails</span></a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @yield('header')

                    @yield('breadcrumb')


                </section>

                <!-- Main content -->
                <section class="content">
                    @yield('content')          
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0
                </div>
                <strong>Copyright &copy; 2016 <a href="https://www.faveohelpdesk.com"><b>FAVEO</b> HELPDESK</a>.</strong> All rights reserved. Powered by <img src="{{asset("lb-faveo/media/images/ladybird.png")}}">
            </footer>
            {{-- // <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}

            <script src="{{asset("lb-faveo/js/ajax-jquery.min.js")}}"></script>

            {{-- // <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> --}}

            <script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
            <!-- Bootstrap 3.3.2 JS -->
            <script src="{{asset("lb-faveo/js/bootstrap.min.js")}}" type="text/javascript"></script>
            <!-- Slimscroll -->
            <script src="{{asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
            <!-- FastClick -->
            <script src="{{asset("lb-faveo/plugins/fastclick/fastclick.min.js")}}"></script>
            <!-- AdminLTE App -->
            <script src="{{asset("lb-faveo/js/app.min.js")}}" type="text/javascript"></script>
            <!-- AdminLTE for demo purposes -->
            {{-- // <script src="{{asset("dist/js/demo.js")}}" type="text/javascript"></script> --}}
        <!-- iCheck -->
        <script src="{{asset("lb-faveo/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
        {{-- maskinput --}}
        {{-- // <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script> --}}
        {{-- jquery ui --}}
        <script src="{{asset("lb-faveo/js/jquery.ui.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}" type="text/javascript"></script>
        <script src="{{asset("lb-faveo/plugins/datatables/jquery.dataTables.js")}}" type="text/javascript"></script>
        <!-- Page Script -->

        {{-- // <script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script> --}}
        <script type="text/javascript" src="{{asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")}}"></script>

        <script type="text/javascript" src="{{asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")}}"></script>
        <script src="{{asset("lb-faveo/js/jquery.rating.pack.js")}}" type="text/javascript"></script>

        <script src="{{asset("lb-faveo/plugins/select2/select2.full.min.js")}}" ></script>

        <script>
            $(function () {
                // Enable iCheck plugin for checkboxes
                // iCheck for checkbox and radio inputs
                // $('input[type="checkbox"]').iCheck({
                // checkboxClass: 'icheckbox_flat-blue',
                // radioClass: 'iradio_flat-blue'
                // });
                // Enable check and uncheck all functionality
                $(".checkbox-toggle").click(function () {
                    var clicks = $(this).data('clicks');
                    if (clicks) {
                        //Uncheck all checkboxes
                        $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
                    } else {
                        //Check all checkboxes
                        $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
                    }
                    $(this).data("clicks", !clicks);
                });

                //Handle starring for glyphicon and font awesome
                $(".mailbox-star").click(function (e) {
                    e.preventDefault();
                    //detect type
                    var $this = $(this).find("a > i");
                    var glyph = $this.hasClass("glyphicon");
                    var fa = $this.hasClass("fa");
                    //Switch states
                    if (glyph) {
                        $this.toggleClass("glyphicon-star");
                        $this.toggleClass("glyphicon-star-empty");
                    }
                    if (fa) {
                        $this.toggleClass("fa-star");
                        $this.toggleClass("fa-star-o");
                    }
                });
            });
        </script>
        <script type="text/javascript">
            //     $(document).ready(function() {
            //         $("#content").Editor();
            //     });
            // </script>
       <!-- // <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script> -->
        <script src="{{asset("lb-faveo/js/tabby.js")}}"></script>
         <!-- // <script src="{{asset("dist/js/editor.js")}}"></script> -->
        <!-- CK Editor -->
        <!-- // <script src="{{asset("//cdn.ckeditor.com/4.4.3/standard/ckeditor.js")}}"></script> -->
        {{-- // <script src="{{asset("lb-faveo/downloads/CKEditor.js")}}"></script> --}}
    <script src="{{asset("lb-faveo/plugins/filebrowser/plugin.js")}}"></script>
    <script src="{{asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}" type="text/javascript"></script>
    <script>
        // $(function () {
        // //Add text editor
        // $("textarea").wysihtml5();
        // });
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
        });
    </script>
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
    @yield('FooterInclude')
</body>
</html>