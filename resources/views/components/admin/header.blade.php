<header class="main-header navbar">
                <div class="col-search">
                    <form class="searchform">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0 ps-0">
                                <i class="material-icons md-search text-muted"></i>
                            </span>
                            <input list="search_terms" type="text" class="form-control border-0" placeholder="Search for products, orders, customers..." />
                        </div>
                        <datalist id="search_terms">
                            <option value="Products"></option>
                            <option value="New orders"></option>
                            <option value="Apple iphone"></option>
                            <option value="Customers"></option>
                            <option value="Sellers"></option>
                        </datalist>
                    </form>
                </div>
                <div class="col-nav">
                    <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside">
                        <i class="material-icons md-menu"></i>
                    </button>
                    <ul class="nav align-items-center">
                        <li class="nav-item">
                            <a class="nav-link btn-icon position-relative" href="#" title="Notifications">
                                <i class="material-icons md-notifications"></i>
                                <span class="badge rounded-pill">3</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-icon darkmode" href="#" title="Toggle Dark Mode">
                                <i class="material-icons md-brightness_6"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="requestfullscreen nav-link btn-icon" title="Fullscreen">
                                <i class="material-icons md-fullscreen"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-icon" href="#" title="Messages">
                                <i class="material-icons md-email"></i>
                            </a>
                        </li>
                        <li class="dropdown nav-item ms-2">
                            <a class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" href="#" id="dropdownAccount" aria-expanded="false" style="text-decoration: none;">
                                <img class="img-xs rounded-circle" src="{{ asset('assetsbackend/imgs/people/avatar-2.png') }}" alt="User" style="width: 38px; height: 38px; object-fit: cover; border: 2px solid #e5e7eb;" />
                                <div class="ms-2 d-none d-md-block">
                                    <div class="fw-semibold" style="font-size: 13px; color: #1f2937;">Admin User</div>
                                    <div class="text-muted" style="font-size: 11px;">Administrator</div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount" style="min-width: 220px;">
                                <div class="px-3 py-2 border-bottom">
                                    <div class="fw-semibold text-dark">Admin User</div>
                                    <div class="text-muted small">admin@example.com</div>
                                </div>
                                <a class="dropdown-item" href="#">
                                    <i class="material-icons md-perm_identity me-2"></i>My Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="material-icons md-settings me-2"></i>Account Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="material-icons md-account_balance_wallet me-2"></i>Wallet
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="material-icons md-help_outline me-2"></i>Help Center
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#">
                                    <i class="material-icons md-exit_to_app me-2"></i>Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </header>