
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>Pousada Quedas D'Agua | @yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ url('bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- Animation CSS -->
    <link href="{{ url('css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ url('css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (blue.css) for this starter
          page. However, you can choose any other skin from folder css / colors .
-->
    <link href="{{ url('css/colors/blue-dark.css') }}" id="theme" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('css/custom.css') }}">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('css')
</head>

<body>
<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top m-b-0">
        <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a>
            <div class="top-left-part">
                <a class="logo" href="{{ route('dashboard') }}">
                    <b>
                        <img class="img-responsive" src="{{ url('img/logo_pousada.png') }}" alt="home" />
                    </b>
                </a>
            </div>
            <ul class="nav navbar-top-links navbar-left m-l-20 hidden-xs">
                <li>
                    <form role="search" class="app-search hidden-xs" method="get" action="@yield('search-url')">
                        <input type="text" name="search" id="search" placeholder="Buscar..." class="form-control" required maxlength="254">
                        <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                    </form>
                </li>
            </ul>
            <ul class="nav navbar-top-links navbar-right pull-right">
                <li>
                    <a class="profile-pic" href="{{ url('logout') }}"><b>Sair</b></a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-header -->
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>
    <!-- Left navbar-header -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse slimscrollsidebar">
            <ul class="nav" id="side-menu">
                <li style="padding: 10px 0 0;">
                    <a href="{{ route('usuarios.index') }}" class="waves-effect"><i class="fa fa-id-badge fa-fw" aria-hidden="true"></i><span class="hide-menu">Usuários</span></a>
                </li>
                <li>
                    <a href="{{ route('clientes.index') }}" class="waves-effect"><i class="fa fa-group fa-fw" aria-hidden="true"></i><span class="hide-menu">Clientes</span></a>
                </li>
                <li>
                    <a href="{{ route('tipos-quartos.index') }}" class="waves-effect"><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i><span class="hide-menu">Tipos de Quartos</span></a>
                </li>
                <li>
                    <a href="{{ route('quartos.index') }}" class="waves-effect"><i class="fa fa-hotel fa-fw" aria-hidden="true"></i><span class="hide-menu">Quartos</span></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Left navbar-header end -->
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">@yield('title') </h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        @yield('breadcrumb')
                        {{--<li><a href="#">Dashboard</a></li>--}}
                        {{--<li class="active">Blank Page</li>--}}
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            @include('alerts')

            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"> 2017 &copy; Mauricio Ruiz Diaz Maciel</footer>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- jQuery -->
<script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ url('js/bootstrap.min.js') }}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{ url('bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
<!--slimscroll JavaScript -->
<script src="{{ url('js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ url('js/waves.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ url('js/custom.min.js') }}"></script>
@yield('js')
</body>

</html>
