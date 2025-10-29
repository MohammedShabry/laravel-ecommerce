@extends('layouts.admin')

@section('title', 'Dashboard')

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
                    <h2 class="content-title">Sellers list</h2>
                </div>
                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row gx-3">
                            <div class="col-lg-4 col-md-6 me-auto">
                                <!-- optional header controls could go here -->
                            </div>
                        </div>
                    </header>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Store</th>
                                        <th>Owner</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Ensure we have a collection to filter. If a paginator is passed, use its collection.
                                        $sellersCollection = $sellers ?? collect();
                                        if (method_exists($sellersCollection, 'getCollection')) {
                                            // It's a LengthAwarePaginator or Paginator
                                            $sellersCollection = $sellersCollection->getCollection();
                                        }
                                        // Filter only active sellers (case-insensitive). Use `verification_status` column.
                                        $activeSellers = $sellersCollection->filter(function($seller) {
                                            return isset($seller->verification_status) && strcasecmp($seller->verification_status, 'active') === 0;
                                        });
                                    @endphp

                                    @forelse($activeSellers as $seller)
                                        @php $user = $seller->user ?? null; @endphp
                                        <tr>
                                            <td>
                                                <div class="itemside">
                                                    <div class="left">
                                                        <img src="{{ asset($user->avatar ?? 'assetsbackend/imgs/people/avatar-1.png') }}" class="img-sm img-avatar" alt="Userpic" />
                                                    </div>
                                                    <div class="info pl-3">
                                                        <span class="mb-0 title">{{ $seller->store_name ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->name ?? 'Seller' }}</td>
                                            <td>{{ $user->email ?? '-' }}</td>
                                            <td>{{ $user->phone ?? '-' }}</td>
                                            <td>
                                                @php $status = strtolower($seller->verification_status ?? ''); @endphp
                                                @if($status === 'active')
                                                    <span class="badge rounded-pill alert-success text-dark">Active</span>
                                                @elseif($status === 'pending')
                                                    <span class="badge rounded-pill alert-warning text-dark">Pending</span>
                                                @elseif($status === 'rejected')
                                                    <span class="badge rounded-pill alert-danger text-white">Rejected</span>
                                                @else
                                                    <span class="badge rounded-pill alert-secondary text-dark">{{ ucfirst($seller->verification_status ?? 'Unknown') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.sellerdetail', ['seller' => $seller->id]) }}" class="btn btn-sm btn-brand rounded font-sm mt-8">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No active sellers found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination -->
                        @if(method_exists($sellers, 'links'))
                            <div class="mt-3">
                                {{ $sellers->links() }}
                            </div>
                        @endif
                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->

@endsection