@extends('layouts.admin')

@section('title', 'Customers')

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
                       On desktop we allow normal wrapping where it improves layout (see media query). */
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
                    /* Inline item layout for name/avatar column: image + text.
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

                    /* Center the action icon button so the three-dot icon appears middle-aligned in the cell */
                    .table-responsive .btn-icon {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        width: 36px;
                        height: 36px;
                        padding: 0;
                        border-radius: .375rem;
                    }
                    .table-responsive .btn-icon .material-icons {
                        font-size: 20px;
                        line-height: 1;
                        display: block;
                    }

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
                    <h2 class="content-title">Customers list</h2>
                    <div>
                        <a href="#" class="btn btn-primary"><i class="material-icons md-plus"></i> Create customer</a>
                    </div>
                </div>
                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row gx-3">
                            <div class="col-lg-4 col-md-6 me-auto">
                                <input type="text" placeholder="Search customers..." class="form-control" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-6">
                                <select class="form-select">
                                    <option>Status</option>
                                    <option>Active</option>
                                    <option>Disabled</option>
                                    <option>Show all</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-6">
                                <select class="form-select">
                                    <option>Show 20</option>
                                    <option>Show 30</option>
                                    <option>Show 40</option>
                                </select>
                            </div>
                        </div>
                    </header>
                    <!-- card-header end// -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Orders</th>
                                        <th>Total Spend</th>
                                        <th>Status</th>
                                        <th>Last Order</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $customer)
                                    <tr>
                                        <td>
                                            <div class="itemside">
                                                <div class="left">
                                                    @if ($customer->profile && $customer->profile->profile_image)
                                                        <img src="{{ asset('storage/' . $customer->profile->profile_image) }}" class="img-sm img-avatar" alt="Userpic" />
                                                    @else
                                                        <img src="{{ asset('assetsbackend/imgs/people/avatar-' . ($loop->index % 4 + 1) . '.png') }}" class="img-sm img-avatar" alt="Userpic" />
                                                    @endif
                                                </div>
                                                <div class="info pl-3">
                                                    <span class="mb-0 title">{{ $customer->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->orders_count }}</td>
                                        <td>${{ number_format($customer->total_spent, 2) }}</td>
                                        <td>
                                            @php $cstatus = strtolower($customer->status ?? ''); @endphp
                                            @if ($cstatus === 'active')
                                                <span class="badge rounded-pill alert-success text-dark">Active</span>
                                            @else
                                                <span class="badge rounded-pill alert-danger text-white">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $customer->last_order_date }}</td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-icon" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons md-more_horiz"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('admin.customerdetail', $customer->id) }}"><i class="material-icons md-visibility"></i> View</a></li>

                                                    <li><hr class="dropdown-divider"></li>
                                                    @if ($customer->status === 'active')
                                                        <li><a class="dropdown-item text-danger" href="#" onclick="return confirm('Are you sure?');"><i class="material-icons md-block"></i> Block</a></li>
                                                    @else
                                                        <li><a class="dropdown-item text-success" href="#" onclick="return confirm('Are you sure?');"><i class="material-icons md-check_circle"></i> Unblock</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-muted">No customers found</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- table-responsive.// -->
                        </div>
                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->
                <div class="pagination-area mt-15 mb-50">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-start">
                            <li class="page-item active"><a class="page-link" href="#">01</a></li>
                            <li class="page-item"><a class="page-link" href="#">02</a></li>
                            <li class="page-item"><a class="page-link" href="#">03</a></li>
                            <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">16</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="material-icons md-chevron_right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>

@endsection