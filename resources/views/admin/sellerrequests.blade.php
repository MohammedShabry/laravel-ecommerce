@extends('layouts.admin')

@section('title', 'Seller Requests')

@section('content')
<div class="content-header">
    <h2 class="content-title">Seller Requests</h2>
</div>

<!-- Scoped styles: make selected KYC item use same orange selection as admin sidebar (avoid Bootstrap blue) -->
<style>
    /* match sidebar active orange and subtle background */
    #kyc-list .kyc-item.active {
    background-color: rgba(255, 140, 0, 0.2) !important;
    color: #292f46 !important;
    border-color: transparent !important; /* removes blue border */
    outline: none !important;
    box-shadow: none !important;
}

    #kyc-list .kyc-item:focus {
        background-color: rgba(255, 140, 0, 0.2) !important;
        color: #292f46 !important;
    }

    /* emphasize the name with the same orange used by the sidebar icon */
    #kyc-list .kyc-item.active .fw-semibold {
        color: #FF8C00 !important;
    }

    /* keep small muted text readable */
    #kyc-list .kyc-item.active small.text-muted {
        color: #6c757d !important;
    }

    /* smooth transition when selecting items */
    #kyc-list .kyc-item {
        transition: background-color 0.15s ease, color 0.15s ease;
        cursor: pointer;
        /* increased minimum height and slightly more vertical padding for easier touch/click */
        min-height: 64px;
        padding-top: .65rem;
        padding-bottom: .65rem;
        display: flex;
        align-items: center;
    }

    /* reduce vertical padding so items fit better */
    #kyc-list .list-group-item {
        /* bump from .45rem to match the new .kyc-item padding */
        padding-top: .65rem;
        padding-bottom: .65rem;
    }

    /* header padding tighter */
    #kyc-list + .list-group, .d-flex.px-3.py-2.border-bottom {
        /* increase slightly to visually match the taller items */
        padding-top: .5rem;
        padding-bottom: .5rem;
    }

    /* keep columns on one line and truncate long text */
    #kyc-list .col-name,
    #kyc-list .col-business {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        padding-right: 6px;
    }

    #kyc-list .col-date {
        white-space: nowrap;
        width:90px;
        flex: 0 0 90px;
        padding-left: 6px;
    }

    /* limit width on small screens while keeping reasonable desktop width */
    @media (min-width: 576px) {
        .swal2-popup {
            max-width: 520px !important;
        }
    }
</style>

<div class="row g-3 mb-4">
    <!-- LEFT CARD: request list -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body" style="max-height:650px; overflow:auto;">
                <!-- Header row for list (visible on all sizes) -->
                <div class="d-flex px-3 py-2 border-bottom bg-light align-items-center" style="font-weight:600;">
                    <div class="col-name" style="flex:1;">Name</div>
                    <div class="col-business" style="flex:1;">Business Name</div>
                    <div class="col-date" style="width:110px;text-align:right;">
                        Date
                    </div>
                </div>

                <ul class="list-group" id="kyc-list">
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
                                // expose filename and extension so JS can decide how to render
                                'additional_doc_name' => $kyc->additional_doc ? basename($kyc->additional_doc) : null,
                                'additional_doc_ext' => $kyc->additional_doc ? pathinfo($kyc->additional_doc, PATHINFO_EXTENSION) : null,
                            ];
                        @endphp
                        <li class="list-group-item kyc-item" data-kyc='@json($payload)' style="cursor:pointer;">
                            <div class="d-flex align-items-center" style="width:100%">
                                <div class="col-name" style="flex:1;">
                                    <div class="fw-semibold">{{ $payload['name'] }}</div>
                                </div>
                                <div class="col-business" style="flex:1;">
                                    <div class="small text-muted">{{ $payload['shop_name'] }}</div>
                                </div>
                                <div class="col-date" style="width:110px;text-align:right;">
                                    <div class="small text-muted">{{ $payload['submitted_at'] }}</div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No seller KYC requests found.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- RIGHT CARD: details pane -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body" id="kyc-detail-pane">
                <div class="text-muted p-5 text-center">Select a request to view details</div>
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

    // get CSRF token from page meta (Laravel includes this in layouts usually)
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

    const renderDetails = (data) => {
        // ensure seller_id fallback to kyc_id when seller not created yet
        const sellerId = data.seller_id ?? data.kyc_id;
        detailPane.innerHTML = `
        <div class="d-flex align-items-center mb-3">
            <div>
                <h4 class="mb-0">${data.name}</h4>
                <small class="text-muted">${data.email ?? '-'}</small><br>
                <small class="text-muted">${data.phone ?? '-'}</small>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3">Business Information</h6>
                <div class="row gy-1">
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Shop Name</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.shop_name ?? '-'}</div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Business Type</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.business_type ?? '-'}</div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Description</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.business_description ?? '-'}</div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Registration No</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.business_registration_number ?? '-'}</div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Submitted On</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.submitted_at ?? '-'}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3">Business Address</h6>
                <div class="row gy-1">
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Street</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.address_street ?? '-'}</div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">City</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.address_city ?? '-'}</div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">State</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.address_state ?? '-'}</div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Postal Code</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.address_postal ?? '-'}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3">Bank Information</h6>
                <div class="row gy-1">
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Bank</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.bank_name ?? '-'}</div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Branch</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.branch_name ?? '-'}</div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Account Holder</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.account_holder_name ?? '-'}</div>
                    </div>
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Account Number</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.account_number ?? '-'}</div>
                    </div>
                    <!-- Bank Code removed -->
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3">Identity Verification</h6>
                <div class="row gy-1">
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">ID Number</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">${data.national_id_number ?? '-'}</div>
                    </div>

                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">ID Front</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">
                            ${data.id_proof_front ? `<img src="${data.id_proof_front}" class="zoom-img" style="height:120px;border:1px solid #ddd;cursor:pointer;">` : '-'}

                        </div>
                    </div>

                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">ID Back</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">
                            ${data.id_proof_back ? `<img src="${data.id_proof_back}" class="zoom-img" style="height:120px;border:1px solid #ddd;cursor:pointer;">` : '-'}

                        </div>
                    </div>
                </div>
            </div>
        </div>

                            ${data.additional_doc ? `
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3">Additional Document</h6>
                <div class="row gy-1">
                    <div class="col-12 d-flex">
                        <div class="fw-semibold text-secondary" style="flex:0 0 150px;max-width:150px;">Document</div>
                        <div class="text-dark" style="flex:1;min-width:0;overflow-wrap:anywhere;">
                            ${(() => {
                                const ext = (data.additional_doc_ext || '').toLowerCase();
                                const url = data.additional_doc;
                                const name = data.additional_doc_name || url.split('/').pop();

                                // common image extensions - show as zoomable image
                                const imageExt = ['jpg','jpeg','png','gif','webp','bmp','svg'];
                                if (imageExt.includes(ext)) {
                                    return `<img src="${url}" class="zoom-img" style="height:120px;border:1px solid #ddd;cursor:pointer;">`;
                                }

                                // always show a PDF-style icon for documents (keeps UI simple)
                                const icon = '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d9534f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><path d="M4 15h8"></path></svg>';

                                return `
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        <a href="${url}" download="${name}" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;text-decoration:none;color:inherit;">
                                            <div style="width:56px;height:56px;display:flex;align-items:center;justify-content:center;border:1px solid #e9ecef;border-radius:.35rem;background:#fff;">${icon}</div>
                                        </a>
                                    </div>`;
                            })()}
                        </div>
                    </div>
                </div>
            </div>
        </div>` : `
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3">Additional Document</h6>
                <div class="text-muted">-</div>
            </div>
        </div>`}

        <div class="d-flex gap-2 justify-content-end">
            <form id="accept-form" action="/admin/sellers/${sellerId}/accept" method="POST">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="submit" class="btn btn-success">Accept</button>
            </form>
            <form id="reject-form" action="/admin/sellers/${sellerId}/reject" method="POST">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="submit" class="btn btn-danger">Reject</button>
            </form>
        </div>

        <div id="image-modal" style="display:none;position:fixed;z-index:9999;inset:0;background:rgba(0,0,0,0.8);align-items:center;justify-content:center;">
            <img id="image-modal-img" src="" style="max-width:90%;max-height:90%;">
        </div>`;
        // add zoom behavior (limit upscaling to natural size, fit to viewport, allow Esc close)
        detailPane.querySelectorAll('.zoom-img').forEach(img => {
            img.addEventListener('click', () => {
                const modal = detailPane.querySelector('#image-modal');
                const modalImg = modal.querySelector('#image-modal-img');
                // reset styles
                modalImg.style.width = '';
                modalImg.style.height = '';
                modalImg.style.maxWidth = '90%';
                modalImg.style.maxHeight = '90%';

                // create a temporary image to read natural dimensions
                const tmp = new Image();
                tmp.onload = () => {
                    const naturalW = tmp.naturalWidth;
                    const naturalH = tmp.naturalHeight;
                    const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
                    const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);
                    // compute the max allowed size inside viewport (90% of viewport)
                    const maxW = vw * 0.9;
                    const maxH = vh * 0.9;

                    // prefer showing at natural size (no upscale) but scale down to fit viewport if needed
                    let displayW = Math.min(naturalW, maxW);
                    let displayH = Math.min(naturalH, maxH);

                    // maintain aspect ratio
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
                    // animate opacity
                    modal.style.opacity = 0;
                    setTimeout(() => (modal.style.opacity = 1), 10);
                };
                tmp.src = img.src;

                // close handlers
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

    kycItems.forEach(item => {
        item.addEventListener('click', () => {
            kycItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            const data = JSON.parse(item.dataset.kyc);
            renderDetails(data);
        });
    });

    // auto-select first item if present
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
<!-- SweetAlert2 from CDN (only added once here) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- small overrides so Swal uses the project's font, smaller sizing and Bootstrap buttons -->
<style>
    /* make sweetalert use the same font as the page and a slightly smaller base size */
    .swal2-popup {
        font-family: inherit !important;
        font-size: .95rem !important;
        line-height: 1.25 !important;
    }
    .swal2-title {
        font-weight: 600 !important;
        font-size: 1rem !important;
        color: inherit !important;
    }
    .swal2-html-container {
        color: #6c757d !important; /* match muted text */
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
    /* make confirm/cancel buttons use Bootstrap styles (adds consistency) */
    .swal2-styled.swal2-confirm.btn {
        margin-left: .5rem;
    }
    /* limit width on small screens while keeping reasonable desktop width */
    @media (min-width: 576px) {
        .swal2-popup {
            max-width: 520px !important;
        }
    }
</style>

<script>
/*
    Enhanced accept/reject flow:
    - Intercept accept-form and reject-form submissions inside the detail pane.
    - Prompt confirmation (accept) or reason (reject) via SweetAlert2.
    - Send POST via fetch (AJAX) with form data and CSRF token, handle JSON responses.
    - Update UI in-place (replace buttons with status and add badge to selected list item) so the admin stays on the same page.
*/
document.addEventListener('DOMContentLoaded', () => {
    const detailPane = document.getElementById('kyc-detail-pane');
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

    detailPane.addEventListener('submit', async (e) => {
        const form = e.target;
        if (!form) return;

        // helper to find active list item
        const activeItem = document.querySelector('.kyc-item.active');

        // helper to replace action buttons with status block
        const showStatus = (statusHtml) => {
            const btnRow = detailPane.querySelector('.d-flex.gap-2.justify-content-end');
            if (btnRow) {
                btnRow.outerHTML = statusHtml;
            }
        };

        // common fetch handler
        const postForm = async (formEl, extraFields = {}) => {
            const url = formEl.action;
            const fd = new FormData(formEl);
            // append any extras (e.g., rejection_reason)
            for (const k in extraFields) {
                fd.set(k, extraFields[k]);
            }
            // ensure CSRF token present
            if (!fd.has('_token') && csrfToken) fd.set('_token', csrfToken);

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: fd
                });

                // Read response body once as text then attempt to parse JSON.
                // This avoids the "body stream already read" error when
                // res.json() fails and we then call res.text().
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

        // REJECT flow: show textarea prompt and send via AJAX
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
                // send rejection to server
                await postForm(form, { rejection_reason: reason });
                // on success just reload the page (no further SweetAlert dialogs)
                window.location.reload();
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Error', text: err.message || 'Failed to reject' });
            }
            return;
        }

        // ACCEPT flow: show confirmation then send via AJAX
        if (form.id === 'accept-form') {
            e.preventDefault();
            const confirmed = await Swal.fire({
                title: 'Accept Seller KYC?',
                text: 'This will approve the seller and create/activate their seller account.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, accept',
                cancelButtonText: 'Cancel',
                customClass: { confirmButton: 'btn btn-success', cancelButton: 'btn btn-secondary' }
            });

            if (!confirmed.isConfirmed) return;

            Swal.showLoading();
            try {
                await postForm(form);
                // on success just reload page so admin sees updated list (no extra alerts)
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
