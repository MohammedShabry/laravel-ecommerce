@extends('layouts.admin')

@section('title', 'Seller Requests')

@section('content')
<div class="content-header">
    <h2 class="content-title">Sellers Requests</h2>
</div>

<!-- Responsive styles -->
<style>
    /* Base styles for KYC items */
    #kyc-list .kyc-item {
        transition: background-color 0.15s ease, color 0.15s ease, transform 0.1s ease;
        cursor: pointer;
        min-height: 56px;
        padding: 0.75rem;
        display: flex;
        align-items: center;
        border-left: 3px solid transparent;
    }

    #kyc-list .kyc-item:hover {
        background-color: rgba(0, 0, 0, 0.02);
        transform: translateX(2px);
    }

    #kyc-list .kyc-item.active {
        background-color: rgba(255, 140, 0, 0.15) !important;
        color: #292f46 !important;
        border-left-color: #FF8C00 !important;
        border-color: transparent !important;
        outline: none !important;
        box-shadow: none !important;
    }

    #kyc-list .kyc-item:focus {
        background-color: rgba(255, 140, 0, 0.15) !important;
        color: #292f46 !important;
    }

    #kyc-list .kyc-item.active .fw-semibold {
        color: #FF8C00 !important;
    }

    #kyc-list .kyc-item.active small.text-muted {
        color: #6c757d !important;
    }

    /* List header */
    .list-header {
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 2px solid #dee2e6;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* Mobile-first: Stack layout */
    .requests-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .requests-list-card,
    .requests-detail-card {
        width: 100%;
    }

    /* Mobile: Hide some columns, make layout simpler */
    @media (max-width: 767.98px) {
        .list-header .col-business,
        .kyc-item .col-business {
            display: none;
        }

        .list-header .col-date,
        .kyc-item .col-date {
            width: 80px !important;
            flex: 0 0 80px !important;
            font-size: 0.75rem;
        }

        #kyc-list .kyc-item {
            min-height: 48px;
            padding: 0.6rem;
        }

        .list-header {
            padding: 0.6rem 0.75rem;
            font-size: 0.8rem;
        }

        /* Make detail pane full width on mobile */
        #kyc-detail-pane .card {
            margin-bottom: 0.75rem;
        }

        #kyc-detail-pane h6 {
            font-size: 0.9rem;
        }

        /* Stack action buttons on mobile */
        #kyc-detail-pane .d-flex.gap-2 {
            flex-direction: column !important;
        }

        #kyc-detail-pane .d-flex.gap-2 form {
            width: 100%;
        }

        #kyc-detail-pane .d-flex.gap-2 button {
            width: 100%;
        }

        /* Smaller images on mobile */
        #kyc-detail-pane .zoom-img {
            height: 80px !important;
        }
    }

    /* Tablet: Show all columns, side-by-side if needed */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .requests-container {
            flex-direction: row;
        }

        .requests-list-card {
            width: 40%;
            min-width: 320px;
        }

        .requests-detail-card {
            width: 60%;
            flex: 1;
        }

        .list-header .col-date,
        .kyc-item .col-date {
            width: 90px;
            flex: 0 0 90px;
        }
    }

    /* Desktop: Full side-by-side layout */
    @media (min-width: 992px) {
        .requests-container {
            flex-direction: row;
        }

        .requests-list-card {
            width: 45%;
            max-width: 550px;
        }

        .requests-detail-card {
            flex: 1;
        }

        .list-header .col-date,
        .kyc-item .col-date {
            width: 110px;
            flex: 0 0 110px;
        }
    }

    /* Column layout */
    .col-name,
    .col-business {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        padding-right: 8px;
        flex: 1;
    }

    .col-date {
        white-space: nowrap;
        text-align: right;
        padding-left: 8px;
    }

    /* Scrollable containers */
    .requests-list-scroll {
        max-height: calc(100vh - 250px);
        min-height: 400px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .requests-detail-scroll {
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Only control height on mobile/tablet */
    @media (max-width: 991.98px) {
        .requests-detail-scroll {
            max-height: calc(100vh - 250px);
            min-height: 400px;
        }
    }

    /* Card enhancements */
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }

    /* Detail pane cards */
    #kyc-detail-pane .card {
        border-radius: 0.375rem;
        border: 1px solid #e9ecef;
        background: #ffffff;
    }

    #kyc-detail-pane .card-body {
        padding: 1rem;
    }

    #kyc-detail-pane h6 {
        font-size: 1rem;
        font-weight: 600;
        color: #292f46;
        margin-bottom: 0.75rem;
    }

    /* Info rows in detail pane */
    .info-row {
        display: flex;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #6c757d;
        flex: 0 0 140px;
        max-width: 140px;
        font-size: 0.875rem;
    }

    .info-value {
        flex: 1;
        min-width: 0;
        overflow-wrap: anywhere;
        color: #292f46;
        font-size: 0.875rem;
    }

    @media (max-width: 575.98px) {
        .info-label {
            flex: 0 0 110px;
            max-width: 110px;
            font-size: 0.8rem;
        }
        
        .info-value {
            font-size: 0.8rem;
        }
    }

    /* SweetAlert responsive */
    @media (min-width: 576px) {
        .swal2-popup {
            max-width: 520px !important;
        }
    }

    /* Custom scrollbar for better UX */
    .requests-list-scroll::-webkit-scrollbar,
    .requests-detail-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .requests-list-scroll::-webkit-scrollbar-track,
    .requests-detail-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .requests-list-scroll::-webkit-scrollbar-thumb,
    .requests-detail-scroll::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .requests-list-scroll::-webkit-scrollbar-thumb:hover,
    .requests-detail-scroll::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    /* Mobile back button for detail view */
    #mobile-back-btn {
        display: none;
    }

    @media (max-width: 767.98px) {
        #mobile-back-btn {
            display: inline-flex;
            margin-bottom: 1rem;
        }

        .requests-detail-card {
            display: none;
        }

        .requests-detail-card.show-mobile {
            display: block;
        }

        .requests-list-card.hide-mobile {
            display: none;
        }
    }
</style>

<div class="requests-container mb-4">
    <!-- LEFT CARD: Request List -->
    <div class="requests-list-card">
        <div class="card">
            <div class="card-body p-0">
                <!-- Header row -->
                <div class="list-header d-flex align-items-center">
                    <div class="col-name">Name</div>
                    <div class="col-business">Business Name</div>
                    <div class="col-date">Date</div>
                </div>

                <!-- Scrollable list -->
                <div class="requests-list-scroll">
                    <ul class="list-group list-group-flush" id="kyc-list">
                        @forelse ($kycs ?? [] as $kyc)
                            @php
                                $user = $kyc->user;
                                $seller = $kyc->seller;
                                $payload = [
                                    'kyc_id' => $kyc->id,
                                    'seller_id' => $seller->id ?? null,
                                    'name' => $user->name ?? ($seller->store_name ?? 'Seller'),
                                    'avatar' => asset($user->avatar ?? 'assetsbackend/imgs/people/avatar-1.png'),
                                    'shop_name' => $kyc->shop_name,
                                    'submitted_at' => optional($kyc->created_at)->format('M d, Y'),
                                    'status' => $kyc->verification_status,
                                    'email' => $user->email,
                                    'phone' => $user->phone,
                                    'business_type' => $kyc->business_type,
                                    'business_description' => $kyc->business_description,
                                    'business_registration_number' => $kyc->business_registration_number,
                                    'address_street' => $kyc->address_street,
                                    'address_city' => $kyc->address_city,
                                    'address_state' => $kyc->address_state,
                                    'address_postal' => $kyc->address_postal,
                                    'bank_name' => $kyc->bank_name,
                                    'account_holder_name' => $kyc->account_holder_name,
                                    'account_number' => $kyc->account_number,
                                    'branch_name' => $kyc->branch_name,
                                    'national_id_number' => $kyc->national_id_number,
                                    'id_proof_front' => $kyc->id_proof_front ? asset('storage/'.$kyc->id_proof_front) : null,
                                    'id_proof_back' => $kyc->id_proof_back ? asset('storage/'.$kyc->id_proof_back) : null,
                                    'additional_doc' => $kyc->additional_doc ? asset('storage/'.$kyc->additional_doc) : null,
                                    'additional_doc_name' => $kyc->additional_doc ? basename($kyc->additional_doc) : null,
                                    'additional_doc_ext' => $kyc->additional_doc ? pathinfo($kyc->additional_doc, PATHINFO_EXTENSION) : null,
                                ];
                            @endphp
                            <li class="list-group-item kyc-item" data-kyc='@json($payload)'>
                                <div class="d-flex align-items-center w-100">
                                    <div class="col-name">
                                        <div class="fw-semibold">{{ $payload['name'] }}</div>
                                    </div>
                                    <div class="col-business">
                                        <div class="small text-muted">{{ $payload['shop_name'] }}</div>
                                    </div>
                                    <div class="col-date">
                                        <div class="small text-muted">{{ $payload['submitted_at'] }}</div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p class="mb-0">No seller KYC requests found.</p>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT CARD: Details Pane -->
    <div class="requests-detail-card">
        <div class="card">
            <div class="card-body requests-detail-scroll" id="kyc-detail-pane">
                <div class="empty-state">
                    <i class="bi bi-file-earmark-text"></i>
                    <p class="mb-0">Select a request to view details</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const kycItems = document.querySelectorAll('.kyc-item');
    const detailPane = document.getElementById('kyc-detail-pane');
    const listCard = document.querySelector('.requests-list-card');
    const detailCard = document.querySelector('.requests-detail-card');

    // Get CSRF token
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

    // Check if mobile view
    const isMobile = () => window.innerWidth < 768;

    const renderDetails = (data) => {
        const sellerId = data.seller_id ?? data.kyc_id;
        
        // Mobile back button
        const backButton = isMobile() ? `
            <button id="mobile-back-btn" class="btn btn-sm btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to List
            </button>
        ` : '';

        detailPane.innerHTML = `
        ${backButton}
        
        <!-- User Header -->
        <div class="d-flex align-items-start mb-4 pb-3 border-bottom">
            <div class="flex-grow-1">
                <h4 class="mb-1" style="color: #292f46; font-weight: 600;">${data.name}</h4>
                <div class="d-flex flex-column gap-1">
                    <small class="text-muted"><i class="bi bi-envelope me-1"></i>${data.email ?? '-'}</small>
                    <small class="text-muted"><i class="bi bi-telephone me-1"></i>${data.phone ?? '-'}</small>
                </div>
            </div>
        </div>

        <!-- Business Information -->
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-building me-2 text-primary"></i>Business Information</h6>
                <div class="info-row">
                    <div class="info-label">Shop Name</div>
                    <div class="info-value">${data.shop_name ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Business Type</div>
                    <div class="info-value">${data.business_type ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Description</div>
                    <div class="info-value">${data.business_description ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Registration No</div>
                    <div class="info-value">${data.business_registration_number ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Submitted On</div>
                    <div class="info-value">${data.submitted_at ?? '-'}</div>
                </div>
            </div>
        </div>

        <!-- Business Address -->
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-geo-alt me-2 text-primary"></i>Business Address</h6>
                <div class="info-row">
                    <div class="info-label">Street</div>
                    <div class="info-value">${data.address_street ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">City</div>
                    <div class="info-value">${data.address_city ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">State</div>
                    <div class="info-value">${data.address_state ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Postal Code</div>
                    <div class="info-value">${data.address_postal ?? '-'}</div>
                </div>
            </div>
        </div>

        <!-- Bank Information -->
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-bank me-2 text-primary"></i>Bank Information</h6>
                <div class="info-row">
                    <div class="info-label">Bank</div>
                    <div class="info-value">${data.bank_name ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Branch</div>
                    <div class="info-value">${data.branch_name ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Account Holder</div>
                    <div class="info-value">${data.account_holder_name ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Account Number</div>
                    <div class="info-value">${data.account_number ?? '-'}</div>
                </div>
            </div>
        </div>

        <!-- Identity Verification -->
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-person-badge me-2 text-primary"></i>Identity Verification</h6>
                <div class="info-row">
                    <div class="info-label">ID Number</div>
                    <div class="info-value">${data.national_id_number ?? '-'}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">ID Front</div>
                    <div class="info-value">
                        ${data.id_proof_front ? `<img src="${data.id_proof_front}" class="zoom-img" style="height:120px;border:1px solid #ddd;cursor:pointer;border-radius:0.375rem;object-fit:cover;">` : '-'}
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">ID Back</div>
                    <div class="info-value">
                        ${data.id_proof_back ? `<img src="${data.id_proof_back}" class="zoom-img" style="height:120px;border:1px solid #ddd;cursor:pointer;border-radius:0.375rem;object-fit:cover;">` : '-'}
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Document -->
        ${data.additional_doc ? `
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Additional Document</h6>
                <div class="info-row">
                    <div class="info-label">Document</div>
                    <div class="info-value">
                        ${(() => {
                            const ext = (data.additional_doc_ext || '').toLowerCase();
                            const url = data.additional_doc;
                            const name = data.additional_doc_name || url.split('/').pop();
                            const imageExt = ['jpg','jpeg','png','gif','webp','bmp','svg'];
                            
                            if (imageExt.includes(ext)) {
                                return `<img src="${url}" class="zoom-img" style="height:120px;border:1px solid #ddd;cursor:pointer;border-radius:0.375rem;object-fit:cover;">`;
                            }
                            
                            const icon = '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d9534f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><path d="M4 15h8"></path></svg>';
                            return `
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <a href="${url}" download="${name}" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;text-decoration:none;color:inherit;">
                                        <div style="width:56px;height:56px;display:flex;align-items:center;justify-content:center;border:1px solid #e9ecef;border-radius:.35rem;background:#fff;">${icon}</div>
                                    </a>
                                    <small class="text-muted">${name}</small>
                                </div>`;
                        })()}
                    </div>
                </div>
            </div>
        </div>` : ''}

        <!-- Action Buttons -->
        <div class="d-flex gap-2 justify-content-end mt-4">
            <form id="reject-form" action="/admin/sellers/${sellerId}/reject" method="POST" class="flex-fill flex-sm-grow-0">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-x-circle me-1"></i>Reject
                </button>
            </form>
            <form id="accept-form" action="/admin/sellers/${sellerId}/accept" method="POST" class="flex-fill flex-sm-grow-0">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-check-circle me-1"></i>Accept
                </button>
            </form>
        </div>

        <!-- Image Modal -->
        <div id="image-modal" style="display:none;position:fixed;z-index:9999;inset:0;background:rgba(0,0,0,0.85);align-items:center;justify-content:center;cursor:zoom-out;">
            <img id="image-modal-img" src="" style="max-width:90%;max-height:90%;box-shadow:0 4px 20px rgba(0,0,0,0.3);border-radius:0.5rem;">
        </div>`;

        // Setup image zoom
        setupImageZoom();

        // Setup mobile back button
        const backBtn = detailPane.querySelector('#mobile-back-btn');
        if (backBtn) {
            backBtn.addEventListener('click', () => {
                detailCard.classList.remove('show-mobile');
                listCard.classList.remove('hide-mobile');
            });
        }
    };

    const setupImageZoom = () => {
        detailPane.querySelectorAll('.zoom-img').forEach(img => {
            img.addEventListener('click', () => {
                const modal = detailPane.querySelector('#image-modal');
                const modalImg = modal.querySelector('#image-modal-img');
                
                modalImg.style.width = '';
                modalImg.style.height = '';
                modalImg.style.maxWidth = '90%';
                modalImg.style.maxHeight = '90%';

                const tmp = new Image();
                tmp.onload = () => {
                    const naturalW = tmp.naturalWidth;
                    const naturalH = tmp.naturalHeight;
                    const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
                    const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);
                    const maxW = vw * 0.9;
                    const maxH = vh * 0.9;

                    let displayW = Math.min(naturalW, maxW);
                    let displayH = Math.min(naturalH, maxH);

                    const ratio = naturalW / naturalH;
                    if (displayW / displayH > ratio) {
                        displayW = displayH * ratio;
                    } else {
                        displayH = displayW / ratio;
                    }

                    modalImg.style.width = displayW + 'px';
                    modalImg.style.height = displayH + 'px';
                    modalImg.src = img.src;
                    modal.style.display = 'flex';
                    modal.style.opacity = 0;
                    setTimeout(() => (modal.style.opacity = 1), 10);
                };
                tmp.src = img.src;

                const closeModal = () => {
                    modal.style.opacity = 0;
                    setTimeout(() => (modal.style.display = 'none'), 150);
                    document.removeEventListener('keydown', onKey);
                };
                modal.onclick = (e) => {
                    if (e.target === modal || e.target === modalImg) closeModal();
                };
                const onKey = (e) => { if (e.key === 'Escape') closeModal(); };
                document.addEventListener('keydown', onKey);
            });
        });
    };

    // Handle KYC item clicks
    kycItems.forEach(item => {
        item.addEventListener('click', () => {
            kycItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            
            const data = JSON.parse(item.dataset.kyc);
            renderDetails(data);

            // Mobile: Show detail pane and hide list
            if (isMobile()) {
                detailCard.classList.add('show-mobile');
                listCard.classList.add('hide-mobile');
                detailCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Auto-select first item if present
    if (kycItems.length > 0) {
        const first = kycItems[0];
        first.classList.add('active');
        try {
            const data = JSON.parse(first.dataset.kyc);
            renderDetails(data);
        } catch (e) {
            console.error('Failed to parse first kyc data', e);
        }
    }
});
</script>
@endpush
@push('scripts')
<!-- SweetAlert2 from CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert styling -->
<style>
    .swal2-popup {
        font-family: inherit !important;
        font-size: .95rem !important;
        line-height: 1.25 !important;
    }
    .swal2-title {
        font-weight: 600 !important;
        font-size: 1.1rem !important;
        color: #292f46 !important;
    }
    .swal2-html-container {
        color: #6c757d !important;
    }
    .swal2-textarea {
        font-family: inherit !important;
        font-size: .95rem !important;
        min-height: 100px !important;
        padding: .5rem !important;
        border-radius: .375rem !important;
        border: 1px solid #ced4da !important;
        box-shadow: none !important;
    }
    .swal2-styled.swal2-confirm.btn {
        margin-left: .5rem;
    }
    
    @media (min-width: 576px) {
        .swal2-popup {
            max-width: 520px !important;
        }
    }
    
    /* Mobile responsive adjustments */
    @media (max-width: 575.98px) {
        .swal2-popup {
            width: 90% !important;
            padding: 1.25rem !important;
        }
        .swal2-title {
            font-size: 1rem !important;
        }
        .swal2-html-container {
            font-size: 0.875rem !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const detailPane = document.getElementById('kyc-detail-pane');
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

    detailPane.addEventListener('submit', async (e) => {
        const form = e.target;
        if (!form) return;

        const postForm = async (formEl, extraFields = {}) => {
            const url = formEl.action;
            const fd = new FormData(formEl);
            for (const k in extraFields) {
                fd.set(k, extraFields[k]);
            }
            if (!fd.has('_token') && csrfToken) fd.set('_token', csrfToken);

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: fd
                });

                const text = await res.text();
                let payload;
                try {
                    payload = JSON.parse(text);
                } catch (_) {
                    payload = { success: res.ok, message: text };
                }

                if (!res.ok) {
                    throw new Error(payload && payload.message ? payload.message : 'Request failed');
                }

                return payload;
            } catch (err) {
                throw err;
            }
        };

        // REJECT flow
        if (form.id === 'reject-form') {
            e.preventDefault();
            const { value: reason, isConfirmed } = await Swal.fire({
                title: 'Reject Seller KYC',
                text: 'Please enter a reason for rejection',
                input: 'textarea',
                inputAttributes: { 'aria-label': 'Rejection reason', rows: 4 },
                inputPlaceholder: 'Provide a brief explanation...',
                showCancelButton: true,
                confirmButtonText: 'Submit Rejection',
                cancelButtonText: 'Cancel',
                width: '520px',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                focusConfirm: false,
                preConfirm: (val) => {
                    if (!val || !val.trim()) {
                        Swal.showValidationMessage('Rejection reason is required');
                        return false;
                    }
                    if (val.trim().length > 1000) {
                        Swal.showValidationMessage('Reason is too long (max 1000 characters)');
                        return false;
                    }
                    return val.trim();
                }
            });

            if (!isConfirmed) return;

            Swal.showLoading();
            try {
                await postForm(form, { rejection_reason: reason });
                window.location.reload();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Error', text: err.message || 'Failed to reject' });
            }
            return;
        }

        // ACCEPT flow
        if (form.id === 'accept-form') {
            e.preventDefault();
            const confirmed = await Swal.fire({
                title: 'Accept Seller KYC?',
                text: 'This will approve the seller and create/activate their seller account.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, accept',
                cancelButtonText: 'Cancel',
                customClass: { 
                    confirmButton: 'btn btn-success', 
                    cancelButton: 'btn btn-secondary' 
                }
            });

            if (!confirmed.isConfirmed) return;

            Swal.showLoading();
            try {
                await postForm(form);
                window.location.reload();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Error', text: err.message || 'Failed to accept' });
            }
            return;
        }
    });
});
</script>
@endpush
