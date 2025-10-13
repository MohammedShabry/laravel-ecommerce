<x-guest-layout>
    <h1 class="text-2xl font-bold mb-6 text-center">Register</h1>
    <div class="space-y-4">
        <a href="{{ route('register.seller') }}" 
           class="block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
           Register as Seller
        </a>
        <a href="{{ route('register.customer') }}" 
           class="block bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
           Register as Customer
        </a>
    </div>

    <div class="mt-6 text-sm text-center">
        <p>Already have an account? <a href="{{ route('login.form') }}" class="text-blue-600 hover:underline">Login</a></p>
    </div>
</x-guest-layout>
