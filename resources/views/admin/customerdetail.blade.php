@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')

<div class="content-header">
    <h2 class="content-title">Customer Details</h2>
    <div>
        <a href="{{ route('admin.customerslist') }}" class="btn btn-secondary"><i class="material-icons md-arrow_back"></i> Back to Customers</a>
    </div>
</div>

<div class="row">
    <!-- Left Column: Customer Information -->
    <div class="col-md-4">
        <!-- Customer Profile Card -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    @if ($customer->profile && $customer->profile->profile_image)
                        <img src="{{ asset('storage/' . $customer->profile->profile_image) }}" class="img-lg img-avatar rounded-circle mb-3" alt="Customer Avatar" style="width: 120px; height: 120px; object-fit: cover;" />
                    @else
                        <img src="{{ asset('assetsbackend/imgs/people/avatar-1.png') }}" class="img-lg img-avatar rounded-circle mb-3" alt="Customer Avatar" style="width: 120px; height: 120px; object-fit: cover;" />
                    @endif
                </div>
                
                <h5 class="card-title text-center mb-1">{{ $customer->name }}</h5>
                <p class="text-center text-muted mb-4">Customer since {{ $customer->created_at->format('M d, Y') }}</p>

                <div class="d-flex justify-content-center mb-3">
                    @if ($customer->status === 'active')
                        <span class="badge rounded-pill bg-success text-white">Active</span>
                    @else
                        <span class="badge rounded-pill bg-danger text-white">Inactive</span>
                    @endif
                </div>

                <hr />

                <!-- Contact Information -->
                <div class="mb-3">
                    <label class="form-label text-muted small">Email Address</label>
                    <p class="mb-0 fw-bold" style="font-size: 0.95rem;">{{ $customer->email }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small">Phone Number</label>
                    <p class="mb-0 fw-bold" style="font-size: 0.95rem;">{{ $customer->phone ?? 'Not provided' }}</p>
                </div>

                <!-- Address Information -->
                @if ($customer->profile)
                    <hr />
                    <h6 class="mb-3">Address Information</h6>

                    <div class="mb-3">
                        <label class="form-label text-muted small">Street Address</label>
                        <p class="mb-0 fw-bold" style="font-size: 0.95rem;">{{ $customer->profile->address_street ?? 'Not provided' }}</p>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label text-muted small">City</label>
                            <p class="mb-0 fw-bold" style="font-size: 0.95rem;">{{ $customer->profile->address_city ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label text-muted small">State</label>
                            <p class="mb-0 fw-bold" style="font-size: 0.95rem;">{{ $customer->profile->address_state ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label text-muted small">Postal Code</label>
                            <p class="mb-0 fw-bold" style="font-size: 0.95rem;">{{ $customer->profile->address_postal ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label text-muted small">Country</label>
                            <p class="mb-0 fw-bold" style="font-size: 0.95rem;">{{ $customer->profile->country ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    @if ($customer->profile->birthdate)
                        <div class="mb-3">
                            <label class="form-label text-muted small">Date of Birth</label>
                            <p class="mb-0 fw-bold" style="font-size: 0.95rem;">{{ $customer->profile->birthdate->format('M d, Y') }}</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-3">Customer Statistics</h6>
                
                <div class="mb-3 pb-2 border-bottom">
                    <label class="form-label text-muted small">Total Orders</label>
                    <p class="mb-0 fw-bold h6">{{ rand(1, 25) }} Orders</p>
                </div>

                <div class="mb-3 pb-2 border-bottom">
                    <label class="form-label text-muted small">Total Spent</label>
                    <p class="mb-0 fw-bold h6 text-success">${{ number_format(rand(100, 5500), 2) }}</p>
                </div>

                <div class="mb-3 pb-2 border-bottom">
                    <label class="form-label text-muted small">Avg Order Value</label>
                    <p class="mb-0 fw-bold h6 text-warning">${{ number_format(rand(50, 500), 2) }}</p>
                </div>

                <div class="mb-0">
                    <label class="form-label text-muted small">Last Order</label>
                    <p class="mb-0 fw-bold h6">{{ now()->subDays(rand(1, 100))->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Order History -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Order History</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $orders = [
                                ['id' => '#ORD-001234', 'date' => '2025-10-20', 'items' => 3, 'amount' => 299.99, 'status' => 'delivered'],
                                ['id' => '#ORD-001233', 'date' => '2025-10-18', 'items' => 2, 'amount' => 149.50, 'status' => 'delivered'],
                                ['id' => '#ORD-001232', 'date' => '2025-10-15', 'items' => 1, 'amount' => 89.99, 'status' => 'processing'],
                                ['id' => '#ORD-001231', 'date' => '2025-10-12', 'items' => 4, 'amount' => 450.75, 'status' => 'shipped'],
                                ['id' => '#ORD-001230', 'date' => '2025-10-10', 'items' => 2, 'amount' => 199.99, 'status' => 'delivered'],
                                ['id' => '#ORD-001229', 'date' => '2025-10-05', 'items' => 5, 'amount' => 599.99, 'status' => 'delivered'],
                            ];
                        @endphp
                        @forelse ($orders as $order)
                        <tr>
                            <td>
                                <span class="text-primary fw-bold">{{ $order['id'] }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order['date'])->format('d.m.Y') }}</td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $order['items'] }} item{{ $order['items'] > 1 ? 's' : '' }}</span>
                            </td>
                            <td>
                                <span class="fw-bold">${{ number_format($order['amount'], 2) }}</span>
                            </td>
                            <td>
                                @if ($order['status'] === 'delivered')
                                    <span class="badge rounded-pill bg-success text-white">
                                        <i class="material-icons md-check_circle" style="font-size: 14px; vertical-align: middle;"></i>
                                        Delivered
                                    </span>
                                @elseif ($order['status'] === 'shipped')
                                    <span class="badge rounded-pill bg-info text-white">
                                        <i class="material-icons md-local_shipping" style="font-size: 14px; vertical-align: middle;"></i>
                                        Shipped
                                    </span>
                                @elseif ($order['status'] === 'processing')
                                    <span class="badge rounded-pill bg-warning text-dark">
                                        <i class="material-icons md-hourglass_empty" style="font-size: 14px; vertical-align: middle;"></i>
                                        Processing
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-secondary text-white">{{ ucfirst($order['status']) }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-icon" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons md-more_horiz"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="material-icons md-visibility"></i> View Details</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="material-icons md-print"></i> Print Invoice</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="material-icons md-cancel"></i> Cancel Order</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted">No orders found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Order Summary Stats -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Total Purchases</p>
                                <h4 class="mb-0">$2,789.21</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Average Order</p>
                                <h4 class="mb-0">$465.87</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-3">Customer Actions</h6>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-primary" onclick="return confirm('Send email to customer?');"><i class="material-icons md-mail"></i> Send Email</button>
                    <button class="btn btn-warning" onclick="return confirm('Are you sure?');"><i class="material-icons md-block"></i> Block Customer</button>
                    <button class="btn btn-danger" onclick="return confirm('This action cannot be undone. Are you sure?');"><i class="material-icons md-delete"></i> Delete Account</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
