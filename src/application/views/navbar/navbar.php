<?php
    
    $cog = "";

    $con_array = array(
                        'resales' => base_url().'containers/resales',
                        'current' => base_url().'containers/rented',
                        'index' => base_url().'containers/index',
                        'rentals' => base_url().'containers/rentals',
                        'create' => base_url().'containers/create'
                        );

    $cust_array = array(
                    'index' => base_url().'customers',
                    'create' => base_url().'customers/create'
                    );

    $quote_array = array(
                    'index' => base_url().'quotes/index',
                    'create_sales' => base_url().'quotes/create/sales',
                    'create_rental' => base_url().'quotes/create/rental'
                    );

    $orders_array = array(
                    'create_sales' => base_url().'orders/create/sales',
                    'create_rental' => base_url().'orders/create/rental',
                    'index' => base_url().'orders/index'
                    );

    $products_array = array(
                    'index' => base_url().'products/',
                    'create' => base_url().'products/create'
                    );

    $admin_array = array(
                    'users' => base_url().'users',
                    'users_create' => base_url().'users/create'
                    );

    $cal_url = base_url().'calendar';

    $index_active = "";
    $containers_active = "";
    $customers_active = "";
    $quotes_active = "";
    $calendar_active = "";
    $prod_active = "";
    $orders_active = "";

    if($this->uri->segment(1) == 'containers') {
        $containers_active = 'active';
    } elseif($this->uri->segment(1) == 'customers') {
        $customers_active = 'active';
    } elseif($this->uri->segment(1) == 'quotes') {
        $quotes_active = 'active';
    } elseif($this->uri->segment(1) == 'calendar') {
        $calendar_active = 'active';
    } elseif($this->uri->segment(1) == 'products') {
        $prod_active = 'active';
    } elseif($this->uri->segment(1) == 'orders') {
        $orders_active = 'active';
    } else {
        $index_active = 'active';
    }

?>

    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light mb-3 fixed-top">
        <a class="navbar-brand" href="<?= base_url(); ?>">
            <img class="gbr_logo_image d-none d-xl-block" height="25" src="<?= base_url().'assets/img/logo.png'; ?>">
            <img class="small_gbr_logo_image d-block d-xl-none" height="25" src="<?= base_url().'assets/img/logosmall.png'; ?>">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto" id="mainNavbar">
                <li class="nav-item <?= $index_active; ?>">
                    <a class="nav-link" href="<?= base_url(); ?>">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $containers_active; ?>" href="#" id="containersDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Containers
                    </a>
                    <div class="dropdown-menu" aria-labelledby="containersDropdownMenu">
                        <a class="dropdown-item" href="<?= $con_array['create']; ?>">Create Container</a>
                        <a class="dropdown-item" href="<?= $con_array['index']; ?>">View All Containers</a>
                        <a class="dropdown-item" href="<?= $con_array['rentals']; ?>">View Rental Fleet</a>
                        <a class="dropdown-item" href="<?= $con_array['current']; ?>">View Currently Rented</a>
                        <a class="dropdown-item" href="<?= $con_array['resales']; ?>">View Resale Fleet</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="customersDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Customers
                    </a>
                    <div class="dropdown-menu" aria-labelledby="customersDropdownMenu">
                        <a class="dropdown-item" href="<?= $cust_array['create']; ?>">Create Customer</a>
                        <a class="dropdown-item" href="<?= $cust_array['index']; ?>">View All Customers</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="quotesDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Quotes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="quotesDropdownMenu">
                        <a class="dropdown-item" href="<?= $quote_array['create_sales']; ?>">Create Sale Quote</a>
                        <a class="dropdown-item" href="<?= $quote_array['create_rental']; ?>">Create Rental Quote</a>
                        <a class="dropdown-item" href="<?= $quote_array['index']; ?>">View All Quotes</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="ordersDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Orders
                    </a>
                    <div class="dropdown-menu" aria-labelledby="ordersDropdownMenu">
                        <a class="dropdown-item" href="<?= $orders_array['create_sales']; ?>">Create Sale Orders</a>
                        <a class="dropdown-item" href="<?= $orders_array['create_rental']; ?>">Create Rental Orders</a>
                        <a class="dropdown-item" href="<?= $orders_array['index']; ?>">View All Orders</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Products
                    </a>
                    <div class="dropdown-menu" aria-labelledby="productsDropdownMenu">
                        <a class="dropdown-item" href="<?= $products_array['create']; ?>">Create Product</a>
                        <a class="dropdown-item" href="<?= $products_array['index']; ?>">View All Products</a>
                    </div>
                </li>
            </ul>

            <span class="navbar-text">Welcome, <?= $_SESSION['user_first_name']; ?> <?= $_SESSION['user_last_name']; ?>!</span>

            <ul class="navbar-nav">
                <li class="nav-item dropdown d-block d-md-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" id="searchDropdownContainer" aria-labelledby="searchDropdownMenu">
                        <form class="form-inline" action="<?= base_url().'search'; ?>" method="post">
                            <div class="dropdown-item">
                                <select class="form-control" name="category" id="category">
                                    <option value="choose one">Choose One</option>
                                    <option value="containers">Containers</option>
                                    <option value="customers">Customers</option>
                                    <option value="quotes">Quotes</option>
                                    <option value="orders">Orders</option>
                                    <option value="products">Products</option>
                                </select>
                            </div>
                            <div class="dropdown-item">
                                <input type="text" class="form-control" name="query" id="query">
                            </div>
                            <div class="dropdown-item">
                                <input class="btn btn-default headerbutton" type="submit" value="Search" />
                            </div>
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown d-none d-md-block">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" id="searchDropdownContainer" aria-labelledby="searchDropdownMenu">
                        <form class="form-inline" action="<?= base_url().'search'; ?>" method="post">
                            <ul class="list-inline pl-2">
                                <li class="list-inline-item">
                                    <select class="form-control" name="category" id="category">
                                        <option value="choose one">Choose One</option>
                                        <option value="containers">Containers</option>
                                        <option value="customers">Customers</option>
                                        <option value="quotes">Quotes</option>
                                        <option value="orders">Orders</option>
                                        <option value="products">Products</option>
                                    </select>
                                </li>
                                <li class="list-inline-item"><input type="text" class="form-control" name="query" id="query"></li>
                                <li class="list-inline-item"><input class="btn btn-default headerbutton" type="submit" value="Search" /></li>
                            </ul>
                        </form>
                    </div>
                </li>
                <?php if($_SESSION['user_type'] == 'Admin'): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdownMenu">
                        <a class="dropdown-item" href="<?= $admin_array['users']; ?>">View Users</a>
                        <a class="dropdown-item" href="<?= $admin_array['users_create']; ?>">Create New User</a>
                    </div>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url().'users/logout'; ?>"><i class="fa fa-lock" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </nav>


    