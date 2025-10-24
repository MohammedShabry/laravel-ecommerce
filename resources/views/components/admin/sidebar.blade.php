<aside class="navbar-aside" id="offcanvas_aside">
            <div class="aside-top">
                <a href="index.html" class="brand-wrap">
                    <img src="{{ asset('sample_logo.png') }}" class="logo" alt="Nest Dashboard" />
                </a>
                <div>
                    <button class="btn btn-icon btn-aside-minimize"><i class="text-muted material-icons md-menu_open"></i></button>
                </div>
            </div>
            <nav>
                <ul class="menu-aside">
                    <li class="menu-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
                            <i class="icon material-icons md-home"></i>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>

                    <li class="menu-item has-submenu {{ request()->is('admin/products*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/products*') ? 'active' : '' }}" href="#">
                            <i class="icon material-icons md-shopping_bag"></i>
                            <span class="text">Products</span>
                        </a>
                        <div class="submenu {{ request()->is('admin/products*') ? 'show' : '' }}">
                            <a class="{{ request()->is('admin/productslist*') ? 'active' : '' }}" href="{{ url('/admin/productslist') }}">Product List</a>
                            <a class="{{ request()->is('admin/attributes*') ? 'active' : '' }}" href="{{ url('/admin/attributes') }}">Attributes</a>
                        </div>
                    </li>

                    <li class="menu-item {{ request()->is('admin/orderlist*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/orderlist*') ? 'active' : '' }}" href="{{ url('/admin/orderlist') }}">
                            <i class="icon material-icons md-shopping_cart"></i>
                            <span class="text">Orders</span>
                        </a>
                    </li>

                    <li class="menu-item has-submenu {{ request()->is('admin/seller*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/seller*') ? 'active' : '' }}" href="#">
                            <i class="icon material-icons md-store"></i>
                            <span class="text">Sellers</span>
                        </a>
                        <div class="submenu {{ request()->is('admin/seller*') ? 'show' : '' }}">
                            <a class="{{ request()->is('admin/sellerlist*') ? 'active' : '' }}" href="{{ url('/admin/sellerlist') }}">Sellers list</a>
                            <a class="{{ request()->is('admin/sellerrequests*') ? 'active' : '' }}" href="{{ url('/admin/sellerrequests') }}">Seller Requests</a>
                            <a class="{{ request()->is('admin/seller-commission*') ? 'active' : '' }}" href="page-seller-detail.html">Seller commition</a>
                        </div>
                    </li>


                    <li class="menu-item {{ request()->is('admin/addproduct*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/addproduct*') ? 'active' : '' }}" href="{{ url('/admin/addproduct') }}">
                            <i class="icon material-icons md-add_box"></i>
                            <span class="text">Add Product</span>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('admin/transactions*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/transactions*') ? 'active' : '' }}" href="{{ url('/admin/transactions') }}">
                            <i class="icon material-icons md-monetization_on"></i>
                            <span class="text">Transactions</span>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->is('admin/customerslist*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/customerslist*') ? 'active' : '' }}" href="{{ url('/admin/customerslist') }}">
                            <i class="icon material-icons md-person"></i>
                            <span class="text">Users</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/reviews*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/reviews*') ? 'active' : '' }}" href="{{ url('/admin/reviews') }}">
                            <i class="icon material-icons md-comment"></i>
                            <span class="text">Reviews</span>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/brands*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/brands*') ? 'active' : '' }}" href="{{ url('/admin/brands') }}"> <i class="icon material-icons md-stars"></i> <span class="text">Brands</span> </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
                        <a class="menu-link {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ url('/admin/categories') }}"> <i class="icon material-icons md-stars"></i> <span class="text">Categories</span> </a>
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