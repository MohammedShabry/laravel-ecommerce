<x-app-layout>
    <div class="p-8">
        <h1 class="text-2xl font-bold mb-6">Customer Dashboard</h1>

        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="font-semibold">Total Orders</h2>
                <p class="text-2xl">0</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="font-semibold">Wishlist Items</h2>
                <p class="text-2xl">0</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="font-semibold">Pending Payments</h2>
                <p class="text-2xl">0</p>
            </div>
        </div>

        <div class="mt-6 bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-4">Recent Orders</h2>
            <p class="text-gray-500">No orders yet.</p>
        </div>
    </div>
</x-app-layout>
