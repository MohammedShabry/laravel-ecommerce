<x-guest-layout>
	<h2 class="text-2xl font-extrabold text-gray-900 text-center">Create your account</h2>
	<p class="mt-2 text-sm text-gray-600 text-center">Register as a {{ ucfirst($role ?? 'customer') }} to start shopping.</p>

	<form class="mt-6" method="POST" action="{{ route('register') }}" novalidate>
		@csrf

		<input type="hidden" name="role" value="{{ $role ?? 'customer' }}">

		<div>
			<label for="name" class="block text-sm font-medium text-gray-700">Full name</label>
			<input id="name" name="name" type="text" required value="{{ old('name') }}"
				class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
			@error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
		</div>

		<div class="mt-4">
			<label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
			<input id="email" name="email" type="email" required value="{{ old('email') }}"
				class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
			@error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
		</div>

		<div class="mt-4">
			<label for="phone" class="block text-sm font-medium text-gray-700">Phone (optional)</label>
			<input id="phone" name="phone" type="text" value="{{ old('phone') }}"
				class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
			@error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
		</div>

		<div class="mt-4">
			<label for="address" class="block text-sm font-medium text-gray-700">Address (optional)</label>
			<input id="address" name="address" type="text" value="{{ old('address') }}"
				class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
			@error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
		</div>

		<div class="mt-4">
			<label for="country" class="block text-sm font-medium text-gray-700">Country</label>
			<select id="country" name="country" class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
				<option value="">Select your country</option>
				<option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
				<option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
				<option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
				<option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia</option>
				<option value="IN" {{ old('country') == 'IN' ? 'selected' : '' }}>India</option>
				<option value="BD" {{ old('country') == 'BD' ? 'selected' : '' }}>Bangladesh</option>
				<option value="PK" {{ old('country') == 'PK' ? 'selected' : '' }}>Pakistan</option>
				<option value="NG" {{ old('country') == 'NG' ? 'selected' : '' }}>Nigeria</option>
				<option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>Other</option>
			</select>
			@error('country') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
		</div>

		<div class="mt-4">
			<label for="password" class="block text-sm font-medium text-gray-700">Password</label>
			<input id="password" name="password" type="password" required
				class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
			@error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
		</div>

		<div class="mt-4">
			<label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
			<input id="password_confirmation" name="password_confirmation" type="password" required
				class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
		</div>

		<div class="mt-6">
			<button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
				Register
			</button>
		</div>
	</form>

	<div class="mt-6 text-center text-sm text-gray-600">
		<p>Already have an account? <a href="{{ route('login.form') }}" class="font-medium text-indigo-600 hover:underline">Log in</a></p>
		<p class="mt-2"><a href="{{ route('register.choice') }}" class="text-sm text-gray-500 hover:underline">Back to registration choices</a></p>
	</div>
</x-guest-layout>

