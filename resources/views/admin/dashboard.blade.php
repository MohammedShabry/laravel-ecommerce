@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
            <div class="text-sm text-gray-500">Welcome back, Admin</div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm font-medium text-gray-600">Total Customers</h2>
                <p class="mt-2 text-3xl font-semibold text-gray-800">0</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm font-medium text-gray-600">Total Sellers</h2>
                <p class="mt-2 text-3xl font-semibold text-gray-800">0</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-sm font-medium text-gray-600">Total Orders</h2>
                <p class="mt-2 text-3xl font-semibold text-gray-800">0</p>
            </div>
        </div>

        <div class="mt-6 bg-white p-4 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Orders</h2>
            <div class="text-gray-500">No data available yet.</div>
        </div>
    </div>
@endsection
