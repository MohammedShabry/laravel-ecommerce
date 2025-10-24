<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(): View
    {
        // Fetch all customers (users with role 'customer') with their profiles
        $customers = User::where('role', 'customer')
            ->with('profile')
            ->get()
            ->map(function ($customer) {
                // Calculate mock data for now until orders table exists
                $customer->orders_count = rand(1, 25);
                $customer->total_spent = rand(100, 5500);
                $customer->last_order_date = now()->subDays(rand(1, 100))->format('d.m.Y');
                return $customer;
            });

        return view('admin.customerslist', compact('customers'));
    }

    /**
     * Display a specific customer's detail.
     */
    public function show(User $customer): View
    {
        $customer->load('profile');
        return view('admin.customerdetail', compact('customer'));
    }

    /**
     * Display a specific customer's orders.
     */
    public function orders(User $customer): View
    {
        $customer->load('profile');
        return view('admin.customerorders', compact('customer'));
    }
}
