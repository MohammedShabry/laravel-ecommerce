<aside class="navbar-aside" id="offcanvas_aside">
            <div class="aside-top">
                <a href="index.html" class="brand-wrap">
                    <img src="{{ asset('assetsbackend/imgs/theme/logo.svg') }}" class="logo" alt="Nest Dashboard" />
                </a>
                <div>
                    <button class="btn btn-icon btn-aside-minimize"><i class="text-muted material-icons md-menu_open"></i></button>
                </div>
            </div>
            <nav>
                <ul class="menu-aside">
                    <li class="menu-item {{ request()->is('seller/dashboard*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('seller/dashboard*') ? 'active' : '' }}" href="{{ url('/seller/dashboard') }}">
                            <i class="icon material-icons md-home"></i>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>

                    <li class="menu-item has-submenu {{ request()->is('seller/products*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('seller/products*') ? 'active' : '' }}" href="#">
                            <i class="icon material-icons md-shopping_bag"></i>
                            <span class="text">Products</span>
                        </a>
                        <div class="submenu {{ request()->is('seller/products*') ? 'show' : '' }}">
                            <a class="{{ request()->is('seller/productslist*') ? 'active' : '' }}" href="{{ url('/seller/productslist') }}">Product List</a>
                        </div>
                    </li>

                    <li class="menu-item {{ request()->is('seller/orderlist*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('seller/orderlist*') ? 'active' : '' }}" href="{{ url('/seller/orderlist') }}">
                            <i class="icon material-icons md-shopping_cart"></i>
                            <span class="text">Orders</span>
                        </a>
                    </li>


                    <li class="menu-item {{ request()->is('seller/addproduct*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('seller/addproduct*') ? 'active' : '' }}" href="{{ url('/seller/addproduct') }}">
                            <i class="icon material-icons md-add_box"></i>
                            <span class="text">Add Product</span>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('seller/transactions*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('seller/transactions*') ? 'active' : '' }}" href="{{ url('/seller/transactions') }}">
                            <i class="icon material-icons md-monetization_on"></i>
                            <span class="text">Transactions</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('seller/reviews*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('seller/reviews*') ? 'active' : '' }}" href="{{ url('/seller/reviews') }}">
                            <i class="icon material-icons md-comment"></i>
                            <span class="text">Reviews</span>
                        </a>
                    </li>
                </ul>
                <hr />
                <ul class="menu-aside">
                    <li class="menu-item {{ request()->is('admin/adminsetting*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/adminsetting*') ? 'active' : '' }}" href="{{ url('/admin/adminsetting') }}">
                            <i class="icon material-icons md-settings"></i>
                            <span class="text">Settings</span>
                        </a>
                    </li>
                </ul>
                <br />
                <br />
            </nav>
        </aside>