@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')

                <style>
                    /* Responsive table: auto-size columns, keep header/body aligned, and allow horizontal scroll on small viewports. */
                    .table-responsive {
                        -webkit-overflow-scrolling: touch; /* momentum scrolling on iOS */
                        scroll-behavior: smooth;
                        overflow-x: auto;
                    }

                    /* Let the table size itself to content but never exceed the container width. On larger screens it will
                       expand to available space; on small screens it may be wider than the viewport and will scroll. */
                    .table-responsive .table {
                        width: auto;
                        max-width: 100%;
                        table-layout: auto; /* columns size according to content */
                        border-collapse: collapse;
                        margin: 0;
                    }

                    /* Keep cells from wrapping by default so columns size to their longest cell; use ellipsis to keep UI tidy.
                       On desktop we allow normal wrapping where it improves layout. */
                    .table-responsive .table th,
                    .table-responsive .table td {
                        /* Allow cells to size to their content without forcing extra width.
                           Let text wrap when necessary so long cells don't inflate column width. */
                        white-space: normal;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        vertical-align: middle;
                        padding: .6rem .75rem;
                    }

                    /* Table border and cell separators */
                    .table-responsive .table {
                        /* subtle outer border and rounded corners */
                        border: 1px solid #dee2e6;
                        border-radius: .375rem;
                    }

                    /* row / cell separators (keep header thicker) */
                    .table-responsive .table thead th {
                        border-bottom: 2px solid #dee2e6;
                    }

                    .table-responsive .table tbody td,
                    .table-responsive .table thead th {
                        border-bottom: 1px solid #e9ecef;
                    }

                    /* vertical separators between columns */
                    .table-responsive .table th,
                    .table-responsive .table td {
                        border-right: 1px solid #e9ecef;
                    }

                    /* Remove the extra right border on the last column for a clean edge */
                    .table-responsive .table th:last-child,
                    .table-responsive .table td:last-child {
                        border-right: 0;
                    }

                    /* Remove duplicate bottom border on the last row for a cleaner look */
                    .table-responsive .table tbody tr:last-child td {
                        border-bottom: 0;
                    }

                    /* Avatar sizing: small, fixed to avoid layout shifts */
                    .table-responsive .img-avatar {
                        /* Don't force a fixed column width. Allow avatar to scale down
                           and never exceed 48px in either dimension. */
                        width: auto;
                        height: auto;
                        max-width: 48px;
                        max-height: 48px;
                        object-fit: cover;
                        flex-shrink: 1;
                    }
                    /* Inline item layout for store column: image + text.
                       Ensure the text can shrink and ellipsis correctly. */
                    .itemside { display: flex; align-items: center; gap: .75rem; }
                    .itemside .left { flex: 0 1 auto; display: flex; align-items: center; }
                    .itemside .info { flex: 1 1 auto; min-width: 0; }

                    /* Header layout: keep controls and title aligned and responsive */
                    .content-header {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        gap: 1rem;
                        flex-wrap: wrap;
                    }
                    .content-header .content-title { margin: 0; font-size: 1.25rem; }
                    .content-header > div { display: flex; gap: .5rem; align-items: center; }

                    /* Ensure action dropdowns can overflow the table cell when opened */
                    .table-responsive td.text-end,
                    .table-responsive td.text-end * { overflow: visible !important; }
                    .table-responsive .dropdown { position: relative; }
                    .table-responsive .dropdown-menu { position: absolute; top: 100%; right: 0; left: auto; z-index: 3000; min-width: 8rem; }

                    /* On medium and smaller screens, allow horizontal scroll instead of collapsing columns. Keep table
                       semantics (thead/tbody) so header and body columns stay aligned. */
                    @media (max-width: 991.98px) {
                        .table-responsive .table {
                            /* allow table to be as wide as its content, but at least container width so layout is stable */
                            width: max-content;
                            min-width: 100%;
                        }
                        .table-responsive .table th,
                        .table-responsive .table td {
                            white-space: nowrap;
                        }
                        .content-header { align-items: flex-start; }
                        .content-header .content-title { width: 100%; }
                        .content-header > div { width: 100%; display: flex; justify-content: flex-end; }
                    }

                    /* On large screens use full width and allow cells to wrap where appropriate so columns don't leave large unused space. */
                    @media (min-width: 992px) {
                        .table-responsive .table { width: 100%; }
                        .table-responsive .table th,
                        .table-responsive .table td { white-space: normal; }
                    }

                    /* Ensure mobile keeps native table semantics (prevents some themes from converting tables to stacked cards)
                       while still allowing horizontal scrolling if content overflows. This preserves header/body alignment. */
                    @media (max-width: 480px) {
                        .table-responsive .table {
                            display: table !important;
                            table-layout: auto !important;
                            width: max-content; /* let table be as wide as content, container will scroll */
                            min-width: 100%;
                        }
                        .table-responsive thead { display: table-header-group !important; }
                        .table-responsive tbody { display: table-row-group !important; }
                        .table-responsive tr { display: table-row !important; }
                        .table-responsive th,
                        .table-responsive td { display: table-cell !important; white-space: nowrap; }
                    }
                </style>

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
                <div class="d-flex gap-2 flex-wrap customer-actions">
                    <button class="btn btn-primary" onclick="return confirm('Send email to customer?');"><i class="material-icons md-mail"></i> Send Email</button>
                    <button class="btn btn-warning" onclick="return confirm('Are you sure?');"><i class="material-icons md-block"></i> Block Customer</button>
                    <button class="btn btn-danger" onclick="return confirm('This action cannot be undone. Are you sure?');"><i class="material-icons md-delete"></i> Delete Account</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
