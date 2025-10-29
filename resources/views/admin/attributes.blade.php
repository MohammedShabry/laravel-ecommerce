@extends('layouts.admin')

@section('title', 'Attributes')

@section('content')

<div class="content-header">
    <h1 class="content-title">Attributes</h1>
</div>

<style>
    /* Adopt sellerlist responsive table base styles and keep attribute-specific tweaks. */
    .table-responsive {
        -webkit-overflow-scrolling: touch; /* momentum scrolling on iOS */
        scroll-behavior: smooth;
        overflow-x: auto;
    }

    .table-responsive .table {
        width: auto;
        max-width: 100%;
        table-layout: auto; /* columns size according to content */
        border-collapse: collapse;
        margin: 0;
    }

    .table-responsive .table th,
    .table-responsive .table td {
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: middle;
        padding: .6rem .75rem;
    }

    .table-responsive .table {
        border: 1px solid #dee2e6;
        border-radius: .375rem;
    }

    .table-responsive .table thead th { border-bottom: 2px solid #dee2e6; }
    .table-responsive .table tbody td,
    .table-responsive .table thead th { border-bottom: 1px solid #e9ecef; }
    .table-responsive .table th,
    .table-responsive .table td { border-right: 1px solid #e9ecef; }
    .table-responsive .table th:last-child,
    .table-responsive .table td:last-child { border-right: 0; }
    .table-responsive .table tbody tr:last-child td { border-bottom: 0; }

    .table-responsive .img-avatar {
        width: auto; height: auto; max-width: 48px; max-height: 48px; object-fit: cover; flex-shrink: 1;
    }

    .itemside { display: flex; align-items: center; gap: .75rem; }
    .itemside .left { flex: 0 1 auto; display: flex; align-items: center; }
    .itemside .info { flex: 1 1 auto; min-width: 0; }

    .content-header { display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; }
    .content-header .content-title { margin:0; font-size:1.25rem; }

    .table-responsive td.text-end,
    .table-responsive td.text-end * { overflow: visible !important; }
    .table-responsive .dropdown { position: relative; }
    .table-responsive .dropdown-menu { position: absolute; top:100%; right:0; left:auto; z-index:3000; min-width:8rem; }

    @media (max-width: 991.98px) {
        .table-responsive .table { width: max-content; min-width: 100%; }
        .table-responsive .table th, .table-responsive .table td { white-space: nowrap; }
        .content-header { align-items:flex-start; }
        .content-header .content-title { width:100%; }
        .content-header > div { width:100%; display:flex; justify-content:flex-end; }
    }

    @media (min-width: 992px) {
        .table-responsive .table { width: 100%; }
        .table-responsive .table th, .table-responsive .table td { white-space: normal; }
    }

    /* Values table: allow wrapping on small screens so values use available space
       and do not force horizontal scroll. This keeps the main attributes table
       scrollable while making the small "values" table compact on mobile. */
    .values-table-responsive .table { min-width: 0 !important; table-layout: fixed; }
    .values-table-responsive .table th, .values-table-responsive .table td { white-space: normal; overflow-wrap:anywhere; word-break:break-word; }
    .values-table-responsive .table th:last-child, .values-table-responsive .table td:last-child { white-space: nowrap; }

    /* Make attribute value badges wrap inside the values column of the big table */
    /* Values displayed inline and horizontally scrollable (single row) */
    #all-attributes-table td .values-inline { display:flex; gap:0.5rem; align-items:center; overflow-x:auto; -webkit-overflow-scrolling:touch; white-space:nowrap; padding-bottom:4px; }
    #all-attributes-table td .values-inline .badge { flex: 0 0 auto; white-space: nowrap; }
    /* fallback: keep previous wrapping behavior for non-supporting browsers */
    #all-attributes-table td .badge { overflow-wrap: anywhere; }

    @media (min-width: 768px) {
        .values-table-responsive .table { min-width: 100% !important; table-layout: auto; }
        .values-table-responsive .table th:last-child, .values-table-responsive .table td:last-child { width: 90px; text-align:center; white-space: nowrap; }
        .values-table-responsive .table th:first-child, .values-table-responsive .table td:first-child { white-space: normal; }
        #new-value { max-width: 360px; }
    }

    @media (min-width: 1200px) { #new-value { max-width: 420px; } }

    /* Tweak for the all-attributes table to better manage space on small screens. */
    #all-attributes-table td:nth-child(3), #all-attributes-table th:nth-child(3) { white-space: normal; overflow-wrap:anywhere; word-break:break-word; }
    #all-attributes-table td:nth-child(2), #all-attributes-table th:nth-child(2) { vertical-align: top; }
    #all-attributes-table td:nth-child(1), #all-attributes-table th:nth-child(1) { vertical-align: top; }
    #all-attributes-table th:last-child, #all-attributes-table td:last-child { width: 90px; white-space: nowrap; text-align:center; vertical-align: middle; }
    #all-attributes-table td .d-flex.gap-2 { gap: 0.35rem !important; }
    @media all and (max-width: 480px) { #all-attributes-table td .d-flex.gap-2 { gap: 0.25rem !important; } #all-attributes-table th:last-child, #all-attributes-table td:last-child { width:72px; } #all-attributes-table td .badge { padding:0.25rem 0.5rem; font-size:.85rem; } }

    /* Small-screen native table semantics (matches sellerlist) - preserve header/body alignment while allowing horizontal scroll */
    @media (max-width: 480px) {
        .table-responsive .table {
            display: table !important;
            table-layout: auto !important;
            width: max-content; /* let table be as wide as content, container will scroll */
            min-width: 100%;
        }
        .table-responsive thead { display: table-header-group !important; }
        .table-responsive tbody { display: table-row-group !important; }
        .table-responsive tr { display: table-row !important; }
        .table-responsive th,
        .table-responsive td { display: table-cell !important; white-space: nowrap; }
    }

</style>

<div class="row mt-4">
    <!-- Add Attribute (left) -->
    <div class="col-lg-6 col-md-12 mb-3">
        <div class="card h-100">
            <div class="card-header">Add New Attribute</div>
            <div class="card-body">
                <form id="attribute-name-form">
                    <div class="form-group">
                        <label for="attribute-name">Name</label>
                        <input id="attribute-name" name="name" class="form-control" placeholder="Attribute Name" required />
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary"> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Values section (right) -->
    <div class="col-lg-6 col-md-12 mb-3">
        <div id="values-section" class="card h-100 d-none">
            <div class="card-header">
                Add Values for: <span id="saved-attribute-name" class="fw-bold"></span>
            </div>
            <div class="card-body">
                <div class="table-responsive values-table-responsive mb-3">
                    <table class="table table-sm table-bordered" id="values-table">
                        <thead>
                            <tr>
                                <th>Value</th>
                                <th style="width:8%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <input id="new-value" class="form-control" style="max-width:220px;" placeholder="Value" />
                    <button id="add-value" class="btn btn-success"> Add</button>
                </div>

                <div class="d-flex gap-2">
                    <button id="save-attribute-with-values" class="btn btn-primary"> Save Attribute</button>
                    <button id="cancel-attribute" class="btn btn-danger"> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Full-width attributes table -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Table of Attributes</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0" id="all-attributes-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width:40px">#</th>
                                <th>Name</th>
                                <th>Values</th>
                                <th style="" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-muted"><td colspan="4">No attributes added yet.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- SweetAlert2 (used for confirm dialogs) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function(){
    const nameForm = document.getElementById('attribute-name-form');
    const nameInput = document.getElementById('attribute-name');
    const valuesSection = document.getElementById('values-section');
    const savedNameEl = document.getElementById('saved-attribute-name');
    const addValueBtn = document.getElementById('add-value');
    const newValueInput = document.getElementById('new-value');
    const newPriceInput = document.getElementById('new-price');
    const valuesTableBody = document.querySelector('#values-table tbody');
    const saveAttributeBtn = document.getElementById('save-attribute-with-values');
    const cancelBtn = document.getElementById('cancel-attribute');
    const allAttributesTable = document.getElementById('all-attributes-table').querySelector('tbody');

    let currentAttribute = null;
    // initialize with server-provided attributes (id and values present)
    let allAttributes = @json($attributes->toArray() ?? []);

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const baseUrl = window.location.pathname.startsWith('/seller') ? '/seller/attributes' : '/admin/attributes';

    async function fetchAttributes(){
        try{
            const res = await fetch("/admin/attributes/data", { headers: { 'Accept': 'application/json' }});
            if(res.ok){ allAttributes = await res.json(); renderAllAttributes(); }
        }catch(err){ console.error(err); }
    }

    nameForm.addEventListener('submit', e=>{
        e.preventDefault();
        const name = nameInput.value.trim();
        if(!name){ alert('Enter attribute name'); return; }
        currentAttribute = { name, values: [] };
        savedNameEl.textContent = name;
        valuesSection.classList.remove('d-none');
        newValueInput.focus();
    });

    addValueBtn.addEventListener('click', e=>{
        e.preventDefault();
        if(!currentAttribute){ alert('Save attribute name first'); return; }
        const val = newValueInput.value.trim();
        if(!val){ alert('Enter a value'); return; }
        currentAttribute.values.push({ value: val });
        renderValues();
        newValueInput.value = ''; newValueInput.focus();
    });

    function renderValues(){
        valuesTableBody.innerHTML = '';
        currentAttribute.values.forEach((item, idx)=>{
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${escapeHtml(item.value)}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger btn-remove" data-idx="${idx}" title="Delete"><i class="bi bi-trash"></i></button>
                </td>
            `;
            valuesTableBody.appendChild(tr);
        });
        valuesTableBody.querySelectorAll('.btn-remove').forEach(b=>{
            b.addEventListener('click', ev=>{
                const idx = parseInt(ev.currentTarget.dataset.idx);
                currentAttribute.values.splice(idx,1);
                renderValues();
            });
        });
    }

    saveAttributeBtn.addEventListener('click', async e=>{
        e.preventDefault();
        if(!currentAttribute) return;
        const editIdx = saveAttributeBtn.dataset.editIdx ? parseInt(saveAttributeBtn.dataset.editIdx) : NaN;
        const payload = { name: currentAttribute.name, values: currentAttribute.values.map(v=>v.value) };
        try{
            if(!isNaN(editIdx) && allAttributes[editIdx] && allAttributes[editIdx].id){
                // update existing
                const id = allAttributes[editIdx].id;
                const res = await fetch(`${baseUrl}/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                if(res.ok){ await fetchAttributes(); resetForm(); }
                else{ const txt = await res.text(); alert('Update failed: '+txt); }
            } else {
                // create new
                const res = await fetch(baseUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                if(res.ok){ await fetchAttributes(); resetForm(); }
                else{ const txt = await res.text(); alert('Save failed: '+txt); }
            }
        }catch(err){ console.error(err); alert('Error saving attribute'); }
    });

    function renderAllAttributes(){
        allAttributesTable.innerHTML = '';
        if(allAttributes.length === 0){
            allAttributesTable.innerHTML = '<tr class="text-muted"><td colspan="4">No attributes added yet.</td></tr>';
            return;
        }

        allAttributes.forEach((attr, idx)=>{
            const valuesBadges = `<div class="values-inline">
                ${attr.values.map(v=>`
                    <div class="badge bg-light text-dark border border-secondary d-flex align-items-center gap-2" style="padding: 0.5rem 0.75rem; white-space:nowrap;">
                        <span>${escapeHtml(v.value)}</span>
                    </div>
                `).join('')}
            </div>`;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${idx+1}</td>
                <td>${escapeHtml(attr.name)}</td>
                <td>${valuesBadges}</td>
                <td class="text-center d-flex gap-2 justify-content-center">
                    <button class="btn btn-sm btn-warning btn-edit" data-idx="${idx}" title="Edit"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete" data-idx="${idx}" title="Delete"><i class="bi bi-trash"></i></button>
                </td>
            `;
            allAttributesTable.appendChild(tr);
        });

        allAttributesTable.querySelectorAll('.btn-delete').forEach(b=>{
            b.addEventListener('click', async ev=>{
                const i = parseInt(ev.currentTarget.dataset.idx);
                if(isNaN(i)) return;
                const attr = allAttributes[i];

                // Use SweetAlert2 confirmation instead of native confirm()
                const { isConfirmed } = await Swal.fire({
                    title: 'Delete attribute?',
                    text: 'This will permanently delete the attribute and its values.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel',
                    customClass: { confirmButton: 'btn btn-danger', cancelButton: 'btn btn-secondary' },
                    buttonsStyling: false
                });

                if(!isConfirmed) return;

                if(attr && attr.id){
                    try{
                        Swal.showLoading();
                        const res = await fetch(`${baseUrl}/${attr.id}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                        });
                        if(res.ok){
                            await fetchAttributes();
                            Swal.fire({ icon: 'success', title: 'Deleted', showConfirmButton: false, timer: 1100 });
                        } else {
                            const txt = await res.text();
                            Swal.fire({ icon: 'error', title: 'Delete failed', text: txt });
                        }
                    }catch(err){ console.error(err); Swal.fire({ icon: 'error', title: 'Error', text: err.message || 'Error deleting attribute' }); }
                } else {
                    // not persisted yet — simply remove locally
                    allAttributes.splice(i,1); renderAllAttributes();
                    Swal.fire({ icon: 'success', title: 'Removed', showConfirmButton: false, timer: 900 });
                }
            });
        });

        allAttributesTable.querySelectorAll('.btn-edit').forEach(b=>{
            b.addEventListener('click', ev=>{
                const i = parseInt(ev.currentTarget.dataset.idx);
                if(isNaN(i)) return;
                const a = allAttributes[i];
                if(!a) return;
                // normalize values array to {value: '...'}
                const vals = (a.values || []).map(v=> ({ value: v.value ?? v }));
                currentAttribute = { name: a.name, values: JSON.parse(JSON.stringify(vals)) };
                nameInput.value = a.name; savedNameEl.textContent = a.name;
                valuesSection.classList.remove('d-none'); renderValues();
                saveAttributeBtn.dataset.editIdx = i; newValueInput.focus();
            });
        });
    }

    cancelBtn.addEventListener('click', e=>{
        e.preventDefault(); if(!confirm('Cancel creating this attribute?')) return; resetForm();
    });

    function resetForm(){
        currentAttribute = null; nameInput.value=''; savedNameEl.textContent='';
        valuesTableBody.innerHTML=''; valuesSection.classList.add('d-none');
        if(saveAttributeBtn.dataset.editIdx) delete saveAttributeBtn.dataset.editIdx;
    }

    function escapeHtml(str){ return String(str).replace(/[&<>"'`]/g, m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#x60;'}[m])); }

    renderAllAttributes();
})();
</script>
@endpush

@endsection
