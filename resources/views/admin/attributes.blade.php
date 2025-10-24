@extends('layouts.admin')

@section('title', 'Attributes')

@section('content')

<div class="content-header">
    <h1>Attributes</h1>
</div>

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
                <div class="table-responsive mb-3">
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
                                <th style="width:150px" class="text-center">Actions</th>
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
    let allAttributes = [];

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

    saveAttributeBtn.addEventListener('click', e=>{
        e.preventDefault();
        if(!currentAttribute) return;
        const editIdx = saveAttributeBtn.dataset.editIdx ? parseInt(saveAttributeBtn.dataset.editIdx) : NaN;
        if(!isNaN(editIdx)){ allAttributes[editIdx] = JSON.parse(JSON.stringify(currentAttribute)); delete saveAttributeBtn.dataset.editIdx; }
        else{ allAttributes.push(JSON.parse(JSON.stringify(currentAttribute))); }
        renderAllAttributes();
        resetForm();
    });

    function renderAllAttributes(){
        allAttributesTable.innerHTML = '';
        if(allAttributes.length === 0){
            allAttributesTable.innerHTML = '<tr class="text-muted"><td colspan="4">No attributes added yet.</td></tr>';
            return;
        }

        allAttributes.forEach((attr, idx)=>{
            const valuesBadges = `<div class="d-flex flex-wrap gap-2">
                ${attr.values.map(v=>`
                    <div class="badge bg-light text-dark border border-secondary d-flex align-items-center gap-2" style="padding: 0.5rem 0.75rem;">
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
            b.addEventListener('click', ev=>{
                const i = parseInt(ev.currentTarget.dataset.idx);
                if(isNaN(i)) return;
                if(!confirm('Delete this attribute?')) return;
                allAttributes.splice(i,1); renderAllAttributes();
            });
        });

        allAttributesTable.querySelectorAll('.btn-edit').forEach(b=>{
            b.addEventListener('click', ev=>{
                const i = parseInt(ev.currentTarget.dataset.idx);
                if(isNaN(i)) return;
                const a = allAttributes[i];
                if(!a) return;
                currentAttribute = { name: a.name, values: JSON.parse(JSON.stringify(a.values)) };
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
