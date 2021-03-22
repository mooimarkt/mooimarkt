<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mooimarkt | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/newthemplate/admin/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/newthemplate/admin/dist/css/adminlte.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/newthemplate/admin/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="/newthemplate/admin/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/newthemplate/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/newthemplate/admin/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/newthemplate/admin/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/newthemplate/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="/newthemplate/admin/dist/css/StyleSheet.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @if($Page == "listing-management")
        <link rel="stylesheet" href="/newthemplate/admin/dist/css/owl.carousel.min.css">
        <link rel="stylesheet" href="/newthemplate/admin/dist/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="/newthemplate/admin/dist/css/ruslan.css">
    @endif
    @if(in_array($Page,['meetings','pages','payments','users', 'words', 'qaCategories', 'howWorksCategories']) == "meetings")
        <link rel="stylesheet" href="/newthemplate/admin/plugins/datatables/jquery.dataTables.min.css">
    @endif
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="/newthemplate/admin/#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>



    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/getDashBoardPage" class="brand-link">
            <img src="/newthemplate/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Mooimarkt</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src=" {{ isset(auth()->user()->avatar) ? auth()->user()->avatar : '/newthemplate/admin/dist/img/user2-160x160.jpg' }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('admin_profile') }}" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="/getDashBoardPage" class="nav-link{{$Page == "dashboard" ? " active" : ""}}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/listings" class="nav-link{{in_array($Page,['listings','listing-management']) ? " active" : ""}}">
                            <i class="nav-icon fa fa-newspaper-o"></i>
                            <p>
                                Listings
                            </p>
                        </a>
                    </li>
{{--                    <li class="nav-item">
                        <a href="/admin/tickets" class="nav-link{{in_array($Page,['tickets','ticket']) ? " active" : ""}}">
                            <i class="nav-icon fa fa-ticket"></i>
                            <p>
                                Tikets
                            </p>
                        </a>
                    </li>--}}
                    <li class="nav-item has-treeview menu-open">
                        <a href="/admin/payments" class="nav-link{{in_array($Page,['settings','payments']) ? " active" : ""}}">
                            <i class="nav-icon fa fa-pie-chart"></i>
                            <p>
                                Payments
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/payments" class="nav-link{{$Page == "payments" ? " active" : ""}}">
                                    <i class="fa fa-list-ul nav-icon"></i>
                                    <p>All payments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/settings" class="nav-link{{$Page == "settings" ? " active" : ""}}">
                                    <i class="fa fa-gear nav-icon"></i>
                                    <p>Settings</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview menu-open">
                        <a href="/admin/users/all" class="nav-link{{in_array($Page,['add-user','users']) ? " active" : ""}}">
                            <i class="nav-icon fa fa-child"></i>
                            <p>
                                Users
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/users/all" class="nav-link{{$Page == "users" ? " active" : ""}}">
                                    <i class="fa fa-group nav-icon"></i>
                                    <p>All Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/users/add" class="nav-link{{$Page == "add-user" ? " active" : ""}}">
                                    <i class="fa fa-user-plus nav-icon"></i>
                                    <p>Add new User</p>
                                </a>
                            </li>
                        </ul>
                    </li>
   {{--                 <li class="nav-item has-treeview">
                        <a href="/admin/meetings" class="nav-link{{$Page == "meetings" ? " active" : ""}}">
                            <i class="nav-icon fa fa-handshake-o"></i>
                            <p>
                                Meetings
                            </p>
                        </a>
                    </li>--}}
                    <li class="nav-item has-treeview menu-open">
                        <a href="/admin/category" class="nav-link{{in_array($Page,['category','subcategory']) ? " active" : ""}}">
                            <i class="nav-icon fa fa-th-list"></i>
                            <p>
                                Structure
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/category" class="nav-link{{$Page == "category" ? " active" : ""}}">
                                    <i class="fa fa-th-large nav-icon"></i>
                                    <p>Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/subcategory" class="nav-link{{$Page == "subcategory" ? " active" : ""}}">
                                    <i class="fa fa-th nav-icon"></i>
                                    <p>Subcategories</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview menu-open">
                        <a href="/admin/pages" class="nav-link{{in_array($Page,['add-page','pages']) ? " active" : ""}}">
                            <i class="nav-icon fa fa-folder"></i>
                            <p>
                                Pages
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/pages" class="nav-link{{$Page == "pages" ? " active" : ""}}">
                                    <i class="fa fa-folder-open nav-icon"></i>
                                    <p>All Pages</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/add-page" class="nav-link{{$Page == "add-page" ? " active" : ""}}">
                                    <i class="fa fa-file-code-o nav-icon"></i>
                                    <p>Add new Page</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview menu-open">
                        <a href="/admin/qa" class="nav-link{{in_array($Page,['add-qaCategory','qaCategories']) ? " active" : ""}}">
                            <i class="nav-icon fa fa-folder"></i>
                            <p>
                                QA
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('qa.categories.list') }}" class="nav-link{{$Page == "qaCategories" ? " active" : ""}}">
                                    <i class="fa fa-folder-open nav-icon"></i>
                                    <p>QA Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('qa.category.create') }}" class="nav-link{{$Page == "add-qaCategory" ? " active" : ""}}">
                                    <i class="fa fa-file-code-o nav-icon"></i>
                                    <p>Add new QA Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('qa.item.create') }}" class="nav-link{{$Page == "add-qaItem" ? " active" : ""}}">
                                    <i class="fa fa-file-code-o nav-icon"></i>
                                    <p>Add new QA Item</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview menu-open">
                        <a href="/admin/qa" class="nav-link{{in_array($Page,['add-howWorksCategory','howWorksCategories']) ? " active" : ""}}">
                            <i class="nav-icon fa fa-folder"></i>
                            <p>
                                How It Works
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('howWorks.categories.list') }}" class="nav-link{{$Page == "howWorksCategories" ? " active" : ""}}">
                                    <i class="fa fa-folder-open nav-icon"></i>
                                    <p>How Works Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('howWorks.category.create') }}" class="nav-link{{$Page == "add-howWorksCategory" ? " active" : ""}}">
                                    <i class="fa fa-file-code-o nav-icon"></i>
                                    <p>Add new Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('howWorks.item.create') }}" class="nav-link{{$Page == "add-howWorksItem" ? " active" : ""}}">
                                    <i class="fa fa-file-code-o nav-icon"></i>
                                    <p>Add new Item</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="nav-item has-treeview">
                        <a href="/admin/profile" class="nav-link{{$Page == "profile" ? " active" : ""}}">
                            <i class="nav-icon fa fa-id-badge"></i>
                            <p>
                                Profile
                            </p>
                        </a>
                    </li> --}}


                    {{--<li class="nav-item has-treeview">
                        <a href="{{ route('voucher.index') }}" class="nav-link{{$Page == "voucher" ? " active" : ""}}">
                            <i class="nav-icon fa  fa-money"></i>
                            <p>
                                Vouchers
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('voucher-trader.index') }}" class="nav-link{{$Page == "voucher-trader" ? " active" : ""}}">
                            <i class="nav-icon fa  fa-money"></i>
                            <p>
                                Trader Vouchers
                            </p>
                        </a>
                    </li>--}}

                    <li class="nav-item has-treeview">
                        <a href="/admin/prices" class="nav-link{{$Page == "prices" ? " active" : ""}}">
                            <i class="nav-icon fa fa-eur"></i>
                            <p>
                                Prices
                            </p>
                        </a>
                    </li>










                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link {{ request()->is('admin/languages*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-language"></i>
                            <p>
                                Languages
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('languages.list') }}" class="nav-link{{$Page == "languages" ? " active" : ""}}">
                                    <i class="fa fa-folder-open nav-icon"></i>
                                    <p>Languages</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('languages.create') }}" class="nav-link{{$Page == "language-create" ? " active" : ""}}">
                                    <i class="fa fa-file-code-o nav-icon"></i>
                                    <p>Create Languages</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('words.list') }}" class="nav-link">
                                    <i class="fa fa-file-code-o nav-icon"></i>
                                    <p>Create Words</p>
                                </a>
                            </li>
                        </ul>
                    </li>



                    {{--<li class="nav-item has-treeview">
                        <a href="/admin/google-sheets" class="nav-link{{$Page == "google-sheets" ? " active" : ""}}">
                            <i class="nav-icon fa fa-table"></i>
                            <p>
                                Google Sheets
                            </p>
                        </a>
                    </li>--}}

                    <li class="nav-item has-treeview">
                        <a href="/admin/sitemap" class="nav-link{{$Page == "sitemap" ? " active" : ""}}">
                            <i class="nav-icon fa fa-sitemap"></i>
                            <p>
                                Sitemap
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="/logout" class="nav-link">
                            <i class="nav-icon fa fa-sign-out"></i>
                            <p>
                                log out
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
