<x-guest-layout>
    <h2 class="text-xl font-bold mb-6">Register as {{ ucfirst($role) }}</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="hidden" name="role" value="{{ $role }}">

        <div class="mb-4">
            <label class="block text-gray-700">Full Name</label>
            <input type="text" name="name" required value="{{ old('name') }}"
                class="w-full mt-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <div class="flex items-center gap-2">
                <input type="email" name="email" required value="{{ old('email') }}"
                    class="w-full mt-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
               
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Phone Number</label>
            <div class="flex items-center gap-2">
                <input type="tel" name="phone" required value="{{ old('phone') }}" placeholder="+1 555 555 5555"
                    class="w-full mt-1 px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Birthday</label>
            <input type="date" name="birthdate" value="{{ old('birthdate') }}"
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

        <button type="submit"
            class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
            Register
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('login.form') }}" class="text-blue-600 hover:underline">Already have an account? Login</a>
    </div>
</x-guest-layout>
