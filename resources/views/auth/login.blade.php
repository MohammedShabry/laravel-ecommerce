<x-guest-layout>
    <h2 class="text-xl font-bold mb-6">Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf
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

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
            Login
        </button>

    </form>

    <div class="mt-4 text-center text-sm">
        <a href="{{ route('register.choice') }}" class="text-blue-600 hover:underline">Don't have an account? Register</a>
    </div>
</x-guest-layout>
