@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

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
                                            <td width="30%">
                                                <a href="#" class="itemside">
                                                    <div class="left">
                                                        <img src="{{ asset($user->avatar ?? 'assetsbackend/imgs/people/avatar-1.png') }}" class="img-sm img-avatar" alt="Userpic" />
                                                    </div>
                                                    <div class="info pl-3">
                                                        <h6 class="mb-0 title">{{ $seller->store_name ?? '-'}}</h6>
                                                    </div>
                                                </a>
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