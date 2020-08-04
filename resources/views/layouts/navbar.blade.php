<div class="page-header navbar navbar-fixed-top bg-light">
    <div class="page-header-inner ">
        <!-- logo start -->
        <div class="page-logo">
            <a href="/">
                <span class="logo-icon fa fa-stethoscope fa-rotate-45"></span>
                <span class="logo-default">E-PHARMACY</span> </a>
        </div>
        <ul class="nav navbar-nav navbar-left in">
            <li class="pt-3 pl-3 h3"><strong>KHEZAN PHARMACY</strong></li>
        </ul>

        <!-- start mobile menu -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- end mobile menu -->

        <!-- start header menu -->
        <div class="top-menu hidden-sm hidden-xs">
            <ul class="nav navbar-nav pull-right">
                <!-- start manage user dropdown -->
                <li class="dropdown dropdown-user">
                <li class="dropdown dropdown-user">
                    <a href="/logout">
                        <i class="icon-logout"></i> Log Out </a>
                </li>
                </li>
            </ul>
        </div>
    </div>
    <!-- start horizontal menu -->
    <div class="navbar-custom">
        <div class="hor-menu hidden-sm hidden-xs">
            <ul class="nav navbar-nav">
                <li class="mega-menu-dropdown active open">
                    <a href="/" class="dropdown-toggle"><strong>Home</strong> <i class="material-icons"></i>
                    </a>
                </li>

                <li class="mega-menu-dropdown">
                    <a href=" {{route('sale-home')}} " class="dropdown-toggle"> <strong>Sales</strong><i class="material-icons"></i>
                        <i class="fa fa-angle-down"></i>
                        <span class="arrow "></span>
                    </a>
                    <ul class="dropdown-menu" style="min-width: 200px;">
                        <li>
                            <div class="mega-menu-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <a href="/sales/addSale" class="nav-link "><i class="fa fa-plus"></i> <span class="title"><strong>Add sale</strong></span></a>
                                            </li>
                                            <li>
                                                <a href="/sale/seeSales" class="nav-link "><i class="fa fa-eye"></i> <span class="title"><strong>View Sales</strong></span></a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="mega-menu-dropdown ">
                    <a href=" {{ route('purchase-home') }}" class="dropdown-toggle"> <strong>Purchases</strong><i class="material-icons"></i>
                        <i class="fa fa-angle-down"></i>
                        <span class="arrow "></span>
                    </a>
                    <ul class="dropdown-menu" style="min-width: 200px;">
                        <li>
                            <div class="mega-menu-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="mega-menu-submenu">
                                            <li>
                                                <a href="/purchases/add" class="nav-link "><i class="fa fa-plus"></i> <span class="title"><strong>Add Purchase</strong></span></a>
                                            </li>
                                            <li>
                                                <a href="/purchase/see" class="nav-link "> <i class="fa fa-eye"></i><span class="title"><strong>View Purchases</strong></span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="mega-menu-dropdown ">
                    <a href="/expenses" class="dropdown-toggle"><strong>Expense </strong><i class="material-icons"></i>
                    </a>
                </li>
                <li class="mega-menu-dropdown ">
                    <a href="/reports" class="dropdown-toggle"><strong> Reports</strong><i class="material-icons"></i>
                    </a>
                </li>

                <li class="mega-menu-dropdown hidden">
                    <a href="/reports/stock" class="dropdown-toggle"><strong>Stock </strong><i class="material-icons"></i>
                    </a>
                </li>
                <li class="mega-menu-dropdown ">
                    <a href="/live-items" class="dropdown-toggle"><strong>Drugs </strong><i class="material-icons"></i>
                    </a>
                </li>
                <li class="mega-menu-dropdown ">
                    <a href="/suppliers" class="dropdown-toggle"><strong> Suppliers</strong><i class="material-icons"></i>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <!-- end horizontal menu -->
</div>
<!-- end header -->

<!-- start page container -->
<div class="page-container">
    <!-- start sidebar menu -->
    <div class="sidebar-container">
        <div class="sidemenu-container navbar-collapse collapse fixed-menu">
            <div id="remove-scroll" class="left-sidemenu">
                <ul class="sidemenu  page-header-fixed slimscroll-style" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                    <li class="mega-menu-dropdown active open">
                        <a href="/" class="dropdown-toggle"><strong>Home</strong> <i class="material-icons"></i>
                        </a>
                    </li>

                    <li class="mega-menu-dropdown">
                        <a href=" {{route('sale-home')}} " class="dropdown-toggle"> <strong>Sales</strong><i class="material-icons"></i>
                        </a>
                    </li>
                    <li class="mega-menu-dropdown ">
                        <a href=" {{ route('purchase-home') }}" class="dropdown-toggle"> <strong>Purchases</strong><i class="material-icons"></i>
                        </a>
                    </li>

                    <li class="mega-menu-dropdown ">
                        <a href="/expenses" class="dropdown-toggle"><strong>Expense </strong><i class="material-icons"></i>
                        </a>
                    </li>
                    <li class="mega-menu-dropdown ">
                        <a href="/reports" class="dropdown-toggle"><strong> Reports</strong><i class="material-icons"></i>
                        </a>
                    </li>

                    <li class="mega-menu-dropdown ">
                        <a href="/reports/stock" class="dropdown-toggle"><strong>Stock </strong><i class="material-icons"></i>
                        </a>
                    </li>
                    <li class="mega-menu-dropdown ">
                        <a href="/live-items" class="dropdown-toggle"><strong>Drugs </strong><i class="material-icons"></i>
                        </a>
                    </li>
                    <li class="mega-menu-dropdown ">
                        <a href="/suppliers" class="dropdown-toggle"><strong> Suppliers</strong><i class="material-icons"></i>
                        </a>
                    </li>
                    <li class="mega-menu-dropdown ">
                        <a href="/logout" class="dropdown-toggle"><strong> Log out</strong><i class="material-icons"></i>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end page container -->