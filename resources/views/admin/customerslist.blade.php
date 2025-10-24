@extends('layouts.admin')

@section('title', 'Customers')

@section('content')

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
                                        <th>Avatar</th>
                                        <th>Name</th>
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
                                            @if ($customer->profile && $customer->profile->profile_image)
                                                <img src="{{ asset('storage/' . $customer->profile->profile_image) }}" class="img-sm img-avatar" alt="Userpic" />
                                            @else
                                                <img src="{{ asset('assetsbackend/imgs/people/avatar-' . ($loop->index % 4 + 1) . '.png') }}" class="img-sm img-avatar" alt="Userpic" />
                                            @endif
                                        </td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->orders_count }}</td>
                                        <td>${{ number_format($customer->total_spent, 2) }}</td>
                                        <td>
                                            @if ($customer->status === 'active')
                                                <span class="badge rounded-pill bg-success text-white">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger text-white">Inactive</span>
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
                                        <td colspan="9" class="text-center py-4">
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