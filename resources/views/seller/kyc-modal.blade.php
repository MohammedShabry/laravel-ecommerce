<div id="kyc-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white w-11/12 md:w-3/4 lg:w-1/2 p-6 rounded shadow overflow-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Seller KYC</h2>

        <form method="POST" action="{{ route('seller.kyc.submit') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-gray-700">Business Registration Number</label>
                    <input type="text" name="business_registration_number" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('business_registration_number') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Bank Name</label>
                    <input type="text" name="bank_name" required class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('bank_name') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Account Holder Name</label>
                    <input type="text" name="account_holder_name" required class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('account_holder_name') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Account Number</label>
                    <input type="text" name="account_number" required class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('account_number') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Branch Name</label>
                    <input type="text" name="branch_name" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('branch_name') }}">
                </div>

                <div>
                    <label class="block text-gray-700">Bank Code</label>
                    <input type="text" name="bank_code" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('bank_code') }}">
                </div>

                <div>
                    <label class="block text-gray-700">National ID / Passport Number</label>
                    <input type="text" name="national_id_number" required class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('national_id_number') }}">
                </div>

                <div>
                    <label class="block text-gray-700">ID Proof (Front)</label>
                    <input type="file" name="id_proof_front" required class="w-full mt-1">
                </div>

                <div>
                    <label class="block text-gray-700">ID Proof (Back) — optional</label>
                    <input type="file" name="id_proof_back" class="w-full mt-1">
                </div>

                <div class="md:col-span-2 mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="terms_agreed" class="form-checkbox" required>
                        <span class="ml-2 text-gray-700">I agree to terms &amp; conditions</span>
                    </label>
                </div>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button type="button" id="close-kyc" class="px-4 py-2 border rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Submit KYC</button>
            </div>
        </form>
    </div>
</div>
