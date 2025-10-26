@extends('layouts.customer')

@section('title', 'Home')

@section('content')

    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                        </li>
                                        <li class="nav-item">
                                            <!-- Dashboard tab removed per request -->
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false"><i class="fi-rs-marker mr-10"></i>My Address</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="page-login.html"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    <div class="tab-pane fade active show" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Account Details &nbsp;|&nbsp; <a href="#" id="edit-profile-link">Edit</a></h5>
                                            </div>
                                            <div class="card-body">
                                                {{-- Show user details and provide inline edit form --}}
                                                @php
                                                    $user = auth()->user();
                                                    $profile = $user->profile;
                                                    $profileImageUrl = $profile && $profile->profile_image ? asset('storage/' . $profile->profile_image) : asset('assets/imgs/default-user.png');
                                                @endphp

                                                @if(session('status'))
                                                    <div class="alert alert-success">{{ session('status') }}</div>
                                                @endif

                                                <div id="profile-display" style="font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Liberation Sans', sans-serif;">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-3 text-center mb-3 mb-md-0">
                                                            <img src="{{ $profileImageUrl }}" alt="Profile Image" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="row">
                                                                <div class="col-sm-6 mb-3">
                                                                    <div class="bg-light p-3 rounded h-100">
                                                                        <h6 class="mb-1"><i class="fi-rs-user mr-2"></i>Full Name</h6>
                                                                        <p class="mb-0">{{ $user->name }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 mb-3">
                                                                    <div class="bg-light p-3 rounded h-100">
                                                                        <h6 class="mb-1"><i class="fi-rs-smartphone mr-2"></i>Phone</h6>
                                                                        <p class="mb-0">{{ $user->phone ?? '—' }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 mb-3">
                                                                    <div class="bg-light p-3 rounded h-100">
                                                                        <h6 class="mb-1"><i class="fi-rs-envelope mr-2"></i>Email</h6>
                                                                        <p class="mb-0">{{ $user->email }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 mb-3">
                                                                    <div class="bg-light p-3 rounded h-100">
                                                                        <h6 class="mb-1"><i class="fi-rs-calendar mr-2"></i>Date of birth</h6>
                                                                        <p class="mb-0">{{ $profile && $profile->birthdate ? $profile->birthdate->format('Y-m-d') : '—' }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="profile-edit" style="display:none; margin-top:20px;">
                                                    <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-3 text-center">
                                                                    <img id="profile-preview" src="{{ $profileImageUrl }}" alt="Profile Preview" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;margin-bottom:10px;cursor:pointer;">
                                                                    {{-- hidden file input: clicking the avatar opens file chooser --}}
                                                                    <input id="profile-image-input" name="profile_image" type="file" accept="image/*" style="display:none;" />
                                                                    <small class="text-muted d-block">Click avatar to change</small>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <div class="row">
                                                                        <div class="form-group col-12 mb-3">
                                                                            <label>Full Name <span class="required">*</span></label>
                                                                            <input required class="form-control" name="name" type="text" value="{{ old('name', $user->name) }}" />
                                                                        </div>
                                                                        <div class="form-group col-12 mb-3">
                                                                            <label>Phone</label>
                                                                            <input class="form-control" name="phone" type="text" value="{{ old('phone', $user->phone) }}" />
                                                                        </div>
                                                                        <div class="form-group col-12 mb-3">
                                                                            <label>Email Address <span class="required">*</span></label>
                                                                            <input required class="form-control" name="email" type="email" value="{{ old('email', $user->email) }}" />
                                                                        </div>
                                                                        <div class="form-group col-12 mb-3">
                                                                            <label>Date of birth</label>
                                                                            <input class="form-control" name="birthdate" type="date" value="{{ old('birthdate', $profile && $profile->birthdate ? $profile->birthdate->format('Y-m-d') : '') }}" />
                                                                        </div>
                                                                        <div class="col-12 mt-3 d-flex gap-2">
                                                                            <button type="submit" class="btn btn-fill-out font-weight-bold">Save Changes</button>
                                                                            {{-- Make cancel button red using Bootstrap 'btn-danger' --}}
                                                                            <button type="button" id="cancel-edit-btn" class="btn btn-danger">Cancel</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <script>
                                                    (function(){
                                                        var editLink = document.getElementById('edit-profile-link');
                                                        var cancelBtn = document.getElementById('cancel-edit-btn');
                                                        var display = document.getElementById('profile-display');
                                                        var edit = document.getElementById('profile-edit');
                                                        if(editLink){
                                                            editLink.addEventListener('click', function(e){ e.preventDefault(); display.style.display = 'none'; edit.style.display = 'block'; });
                                                        }
                                                        if(cancelBtn){
                                                            cancelBtn.addEventListener('click', function(){ edit.style.display = 'none'; display.style.display = 'block'; });
                                                        }

                                                        // image preview when selecting file
                                                        var fileInput = document.getElementById('profile-image-input');
                                                        var previewImg = document.getElementById('profile-preview');
                                                        if(fileInput && previewImg){
                                                            // make avatar clickable to open file chooser
                                                            previewImg.style.cursor = 'pointer';
                                                            previewImg.addEventListener('click', function(){ fileInput.click(); });

                                                            fileInput.addEventListener('change', function(evt){
                                                                var file = this.files && this.files[0];
                                                                if(!file) return;
                                                                var reader = new FileReader();
                                                                reader.onload = function(e){ previewImg.src = e.target.result; };
                                                                reader.readAsDataURL(file);
                                                            });
                                                        }
                                                    })();
                                                </script>
                                                {{-- Ensure .btn-danger shows red even if main theme sets .btn color globally --}}
                                                @push('styles')
                                                <style>
                                                    /* page-specific override so the Cancel button appears red */
                                                    #profile-edit .btn.btn-danger {
                                                        background-color: #ef4444 !important;
                                                        border-color: #ef4444 !important;
                                                        color: #fff !important;
                                                    }
                                                    #profile-edit .btn.btn-danger:hover {
                                                        background-color: #dc2626 !important;
                                                        border-color: #dc2626 !important;
                                                    }
                                                </style>
                                                @endpush
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Dashboard tab-pane removed per request -->
                                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Your Orders</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Order</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>#1357</td>
                                                                <td>March 45, 2020</td>
                                                                <td>Processing</td>
                                                                <td>$125.00 for 2 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>#2468</td>
                                                                <td>June 29, 2020</td>
                                                                <td>Completed</td>
                                                                <td>$364.00 for 5 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>#2366</td>
                                                                <td>August 02, 2020</td>
                                                                <td>Completed</td>
                                                                <td>$280.00 for 3 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Orders tracking</h3>
                                            </div>
                                            <div class="card-body contact-from-area">
                                                <p>To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <form class="contact-form-style mt-30 mb-50" action="#" method="post">
                                                            <div class="input-style mb-20">
                                                                <label>Order ID</label>
                                                                <input name="order-id" placeholder="Found in your order confirmation email" type="text" />
                                                            </div>
                                                            <div class="input-style mb-20">
                                                                <label>Billing email</label>
                                                                <input name="billing-email" placeholder="Email you used during checkout" type="email" />
                                                            </div>
                                                            <button class="submit submit-auto-width" type="submit">Track</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                        @php
                                            $user = auth()->user();
                                            $profile = $user ? $user->profile : null;
                                        @endphp
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between align-items-center">
                                                        <h5 class="mb-0">Shipping Address</h5>
                                                        <a href="#" id="edit-shipping-link">Edit</a>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="shipping-display">
                                                            {{-- Consider address present only when at least one of street/city/state/postal exists. Country alone does not count. --}}
                                                            @if($profile && ($profile->address_street || $profile->address_city || $profile->address_state || $profile->address_postal))
                                                                <address>
                                                                    @if($profile->address_street){{ $profile->address_street }}<br />@endif
                                                                    @if($profile->address_city)
                                                                        {{ $profile->address_city }}@if($profile->address_state) , {{ $profile->address_state }}@endif
                                                                        <br />
                                                                    @endif
                                                                    @if($profile->address_postal){{ $profile->address_postal }}<br />@endif
                                                                    @if($profile->country){{ $profile->country }}@endif
                                                                </address>
                                                            @else
                                                                <p class="text-muted">No shipping address set.</p>
                                                            @endif
                                                        </div>

                                                        <div id="shipping-edit" style="display:none;">
                                                            <form method="POST" action="{{ route('customer.profile.update') }}">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="form-group col-md-6 mb-3">
                                                                        <label>Country</label>
                                                                        <input type="text" name="country" class="form-control" value="{{ old('country', $profile->country ?? '') }}" />
                                                                    </div>
                                                                    <div class="form-group col-md-6 mb-3">
                                                                        <label>Postal / ZIP</label>
                                                                        <input type="text" name="address_postal" class="form-control" value="{{ old('address_postal', $profile->address_postal ?? '') }}" />
                                                                    </div>
                                                                    <div class="form-group col-12 mb-3">
                                                                        <label>Street address</label>
                                                                        <input type="text" name="address_street" class="form-control" value="{{ old('address_street', $profile->address_street ?? '') }}" />
                                                                    </div>
                                                                    <div class="form-group col-md-6 mb-3">
                                                                        <label>City</label>
                                                                        <input type="text" name="address_city" class="form-control" value="{{ old('address_city', $profile->address_city ?? '') }}" />
                                                                    </div>
                                                                    <div class="form-group col-md-6 mb-3">
                                                                        <label>State / Province</label>
                                                                        <input type="text" name="address_state" class="form-control" value="{{ old('address_state', $profile->address_state ?? '') }}" />
                                                                    </div>
                                                                    <div class="col-12 mt-3 d-flex gap-2">
                                                                        <button type="submit" class="btn btn-fill-out font-weight-bold">Save Address</button>
                                                                        <button type="button" id="cancel-shipping-btn" class="btn btn-outline-secondary">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            (function(){
                                                var editLink = document.getElementById('edit-shipping-link');
                                                var cancelBtn = document.getElementById('cancel-shipping-btn');
                                                var display = document.getElementById('shipping-display');
                                                var edit = document.getElementById('shipping-edit');
                                                if(editLink){
                                                    editLink.addEventListener('click', function(e){ e.preventDefault(); display.style.display = 'none'; edit.style.display = 'block'; });
                                                }
                                                if(cancelBtn){
                                                    cancelBtn.addEventListener('click', function(){ edit.style.display = 'none'; display.style.display = 'block'; });
                                                }
                                            })();
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
