@extends('layouts.seller')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Seller Dashboard</h1>

        @if (! $hasKyc)
            <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                Your KYC is not completed. Please complete KYC to start selling.
                <button id="open-kyc" class="ml-4 bg-yellow-700 text-white px-3 py-1 rounded">Open KYC Form</button>
            </div>
        @endif

        @if(session('status'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">{{ session('status') }}</div>
        @endif

        <div class="bg-white p-4 rounded shadow">
            <p>Welcome, {{ $user->name }}. This is your seller dashboard.</p>
        </div>

        <div class="p-8">
            <h2 class="text-xl font-semibold mt-6 mb-4">Overview</h2>

            <div class="grid grid-cols-3 gap-6">
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold">Total Sales</h3>
                    <p class="text-2xl">$0</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold">Total Products</h3>
                    <p class="text-2xl">0</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold">Total Orders</h3>
                    <p class="text-2xl">0</p>
                </div>
            </div>

            <div class="mt-6 bg-white p-4 rounded shadow">
                <h3 class="font-semibold mb-4">Recent Orders</h3>
                <p class="text-gray-500">No recent orders.</p>
            </div>
        </div>

        {{-- Include modal partial --}}
        @include('seller.kyc-modal')

    </div>
@endsection

@section('scripts')
<script>
    (function(){
        const hasKyc = {{ $hasKyc ? 'true' : 'false' }};
        const modal = document.getElementById('kyc-modal');
        const openBtn = document.getElementById('open-kyc');
        const closeBtn = document.getElementById('close-kyc');

        function open(){ if(modal) modal.classList.remove('hidden'); }
        function close(){ if(modal) modal.classList.add('hidden'); }

        if (!hasKyc) setTimeout(open, 300);

        if (openBtn) openBtn.addEventListener('click', open);
        if (closeBtn) closeBtn.addEventListener('click', close);

        // close when clicking outside the modal content
        if (modal) modal.addEventListener('click', function(e){
            if (e.target === modal) close();
        });
    })();
</script>
@endsection
