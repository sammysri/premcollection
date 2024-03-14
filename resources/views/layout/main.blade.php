<!DOCTYPE html><!--
* CoreUI - Free Bootstrap Admin Template
* @version v4.2.2
* @link https://coreui.io/product/free-bootstrap-admin-template/
* Copyright (c) 2023 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
--><!-- Breadcrumb-->
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Prems Collection Admin Panel</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('assets/favicon/android-icon-192x19')}}2.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('assets/favicon/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{asset('vendors/simplebar/css/simplebar.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendors/simplebar.css')}}">
    <!-- Main styles for this application-->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="{{asset('css/examples.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/@coreui/chartjs/css/coreui-chartjs.css')}}" rel="stylesheet">
  </head>
  <body>
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
      <div class="sidebar-brand d-none d-md-flex">
        PANEL
        <!-- <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
          <use xlink:href="assets/brand/coreui.svg#full"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
          <use xlink:href="assets/brand/coreui.svg#signet"></use>
        </svg> -->
      </div>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
          <a class="nav-link" href="{{route('dashboard')}}">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer')}}"></use>
            </svg> Dashboard
            <!-- <span class="badge badge-sm bg-info ms-auto">NEW</span> -->
          </a>
        </li>
        <li class="nav-title">General</li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="colors.html">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-drop')}}"></use>
            </svg> Colors
          </a>
        </li> -->
       
        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-cursor')}}"></use>
            </svg> Hotels
          </a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{route('hotels.create')}}"><span class="nav-icon"></span> Add Hotel</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('hotels.index')}}"><span class="nav-icon"></span> All Hotels</a></li>
          </ul>
        </li>
        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-cursor')}}"></use>
            </svg> Doctors
          </a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{route('doctors.create')}}"><span class="nav-icon"></span> Add Doctor</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('doctors.index')}}"><span class="nav-icon"></span> All Doctors</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('category')}}"><span class="nav-icon"></span> All Categories</a></li>
          </ul>
        </li>
        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-cursor')}}"></use>
            </svg> Astrologers
          </a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{route('astrologers.create')}}"><span class="nav-icon"></span> Add Astrologer</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('astrologers.index')}}"><span class="nav-icon"></span> All Astrologers</a></li>
          </ul>
        </li>
        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-cursor')}}"></use>
            </svg> Cars
          </a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{route('cars.create')}}"><span class="nav-icon"></span> Add Car</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('cars.index')}}"><span class="nav-icon"></span> All Cars</a></li>
          </ul>
        </li>
        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-cursor')}}"></use>
            </svg> Dinner Menu
          </a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{route('dinner-menus.create')}}"><span class="nav-icon"></span> Add Dinner Menu</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('dinner-menus.index')}}"><span class="nav-icon"></span> All Dinner Menu</a></li>
          </ul>
        </li>
        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-cursor')}}"></use>
            </svg> Banners
          </a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{route('banners.create')}}"><span class="nav-icon"></span> Add Banner</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('banners.index')}}"><span class="nav-icon"></span> All Banners</a></li>
          </ul>
        </li>
        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-cursor')}}"></use>
            </svg> Stores
          </a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{route('stores.create')}}"><span class="nav-icon"></span> Add Store</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('stores.index')}}"><span class="nav-icon"></span> All Stores</a></li>
          </ul>
        </li>
        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-cursor')}}"></use>
            </svg> Albums
          </a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{route('albums.create')}}"><span class="nav-icon"></span> Add Album</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('albums.index')}}"><span class="nav-icon"></span> All Albums</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('bookedServices')}}">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer')}}"></use>
            </svg> Booking Request
            <!-- <span class="badge badge-sm bg-info ms-auto">NEW</span> -->
          </a>
        </li>
        @admin
          <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
              <svg class="nav-icon">
                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-cursor')}}"></use>
              </svg> Admin Management
            </a>
            <ul class="nav-group-items">
              <li class="nav-item"><a class="nav-link" href="{{url('admin/management/create')}}"><span class="nav-icon"></span> Add New Admin</a></li>
              <li class="nav-item"><a class="nav-link" href="{{url('admin/management')}}"><span class="nav-icon"></span> All Admins</a></li>
            </ul>
          </li>
        @endadmin
        <li class="nav-group">
          <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-cursor')}}"></use>
            </svg> User Management
          </a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{url('user/management/create')}}"><span class="nav-icon"></span> Add New User</a></li>
            <li class="nav-item"><a class="nav-link" href="{{url('user/management')}}"><span class="nav-icon"></span> All Users</a></li>
          </ul>
        </li>

      </ul>
    </div>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
      <header class="header header-sticky mb-4">
        <div class="container-fluid">
          <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
              <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-menu')}}"></use>
            </svg>
          </button><a class="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
              <use xlink:href="{{asset('assets/brand/coreui.svg#full')}}"></use>
            </svg></a>
          
          
          <ul class="header-nav ms-3">
            <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md"><img class="avatar-img" src="https://placehold.co/125x125?text=P" alt="user"></div>
              </a>
              <div class="dropdown-menu dropdown-menu-end pt-0">
                <div class="dropdown-header bg-light py-2">
                  <div class="fw-semibold">Account</div>
                </div>
                <!-- <div class="dropdown-divider"></div><a class="dropdown-item" href="#"> -->
                <!-- <svg class="icon me-2">
                  <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                </svg> Lock Account</a> -->
                @auth
                  <a class="dropdown-item" href="{{route('changePassword')}}">
                    <svg class="icon me-2">
                      <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout')}}"></use>
                    </svg> Change password
                  </a>
                  <a class="dropdown-item" href="javascript:void(0);" style="cursor: pointer;" onclick="document.getElementById('logout-form').submit()">
                    <svg class="icon me-2">
                      <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout')}}"></use>
                    </svg> Logout
                  </a>
                  <form method="post" action="{{route('logout')}}" id="logout-form">@csrf</form>
                @endauth
              </div>
            </li>
          </ul>
        </div>
        <!-- <div class="header-divider"></div>
        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <span>Home</span>
              </li>
              <li class="breadcrumb-item active"><span>Dashboard</span></li>
            </ol>
          </nav>
        </div> -->
      </header>

      @yield('content')

      <footer class="footer">
        <div><a href="#">NAME </a><a href="#">Admin Panel</a> © 2024 creativeLabs.</div>
        <div class="ms-auto">Developed by&nbsp;<a href="#">Paul</a></div>
      </footer>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{asset('vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
    <script src="{{asset('vendors/simplebar/js/simplebar.min.js')}}"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="{{asset('vendors/chart.js/js/chart.min.js')}}"></script>
    <script src="{{asset('vendors/@coreui/chartjs/js/coreui-chartjs.js')}}"></script>
    <script src="{{asset('vendors/@coreui/utils/js/coreui-utils.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    
    @yield('footer-content')

  </body>
</html>