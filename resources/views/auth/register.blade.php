<x-guest-layout>
    <h2 class="text-xl font-bold mb-6">Register</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700">Full Name</label>
            <input type="text" name="name" required
                class="w-full mt-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" required
                class="w-full mt-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Password</label>
            <input type="password" name="password" required
                class="w-full mt-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                class="w-full mt-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Role</label>
            <select name="role" required
                class="w-full mt-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="customer">Customer</option>
                <option value="seller">Seller</option>
            </select>
        </div>

        <button type="submit"
            class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
            Register
        </button>
    </form>
</x-guest-layout>
