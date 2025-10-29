@extends('layouts.admin')

@section('title', 'Brands')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center flex-wrap">
    <div>
        <h2 class="content-title card-title mb-1">Brands</h2>
    </div>
    <button class="btn btn-primary d-flex align-items-center gap-1 add-brand-btn" 
            data-bs-toggle="modal" 
            data-bs-target="#brandModal">
        <i data-lucide="plus"></i> Add Brand
    </button>
</div>

<div class="card mt-4 border-0 shadow-sm">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center flex-wrap">
        <div class="col-12 col-md-4 mb-2 mb-md-0">
            <input type="text" class="form-control" placeholder="Search brand..." id="brandSearch">
        </div>
    </div>

    <div class="card-body">
        <div class="row g-3" id="brandGrid">
            @forelse($brands as $brand)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                    <div class="card brand-item border-0 shadow-sm h-100 position-relative">
                        <!-- Image section with gradient overlay -->
                        <div class="brand-image-section">
                            <img src="{{ $brand->image ? asset($brand->image) : asset('assetsbackend/imgs/brands/default.png') }}"
                                 alt="{{ $brand->name }}" class="brand-img">
                            <div class="brand-overlay"></div>
                        </div>
                        
                        <!-- Content section -->
                        <div class="brand-content">
                            <h6 class="brand-name text-truncate mb-0">{{ $brand->name }}</h6>
                            
                            <!-- Action buttons with hover effect -->
                            <div class="brand-actions">
                                <button class="btn-action btn-edit edit-brand-btn"
                                        data-id="{{ $brand->id }}"
                                        data-name="{{ $brand->name }}"
                                        data-image="{{ $brand->image }}"
                                        title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}"
                                      method="POST"
                                      class="delete-brand-form d-inline"
                                      data-brand-name="{{ $brand->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center mt-3">No brands found.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Brand Modal -->
<div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="brandModalLabel">Add New Brand</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Brand Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Brand Image</label>
                <input type="file" name="image" class="form-control">
                <div id="currentBrandImageWrapper" class="mt-2 d-none">
                    <img id="currentBrandImage" src="" class="img-thumbnail" style="max-width: 100px;">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Save Brand</button>
        </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
/* ==== HEADER ==== */
.content-header {
    margin-bottom: 1rem;
}
.content-header .btn {
    white-space: nowrap;
}

/* ==== BRAND CARD DESIGN ==== */
.brand-item {
    border-radius: 16px;
    background-color: #fff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    height: 180px;
    display: flex;
    flex-direction: column;
}

.brand-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
}

.brand-item:hover .brand-overlay {
    opacity: 0.15;
}

.brand-item:hover .brand-actions {
    opacity: 1;
    transform: translateY(0);
}

/* Image Section */
.brand-image-section {
    position: relative;
    height: 120px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.brand-img {
    max-height: 70%;
    max-width: 70%;
    object-fit: contain;
    z-index: 1;
    position: relative;
    transition: transform 0.3s ease;
}

.brand-item:hover .brand-img {
    transform: scale(1.08);
}

.brand-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(13, 110, 253, 0.05) 0%, rgba(111, 66, 193, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* Content Section */
.brand-content {
    flex: 1;
    padding: 12px 16px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: #fff;
}

.brand-name {
    font-size: 0.95rem;
    font-weight: 600;
    color: #212529;
    line-height: 1.3;
}

/* ==== ACTION BUTTONS ==== */
.brand-actions {
    display: flex;
    gap: 8px;
    justify-content: center;
    margin-top: 8px;
    opacity: 0;
    transform: translateY(5px);
    transition: all 0.3s ease;
}

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.btn-edit {
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    color: #fff;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #ffb300 0%, #fb8c00 100%);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
}

.btn-delete {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: #fff;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

.btn-action i {
    font-size: 0.9rem;
}

/* ==== RESPONSIVE ==== */
@media (max-width: 576px) {
    .content-header {
        flex-wrap: nowrap !important;
        justify-content: space-between !important;
        align-items: center !important;
        display: flex !important; /* ensure flex row on small screens */
        flex-direction: row !important;
    }
    /* Ensure the title can shrink and truncate instead of pushing the button to a new line */
    /* Ensure the title container can shrink instead of pushing the button to next line */
    .content-header > div {
        flex: 1 1 auto;
        min-width: 0; /* allows text-overflow to work */
        display: flex;
        align-items: center;
    }
    .content-header .content-title {
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    /* Keep the add button its natural size, prevent growth, and push it to the right */
    .content-header .add-brand-btn {
        flex: 0 0 auto;
        white-space: nowrap;
        margin-left: 0.5rem;
        margin-right: 0;
    }
    /* As a safeguard, make the button take right-most space using auto margin if needed */
    .content-header .add-brand-btn.ml-auto,
    .content-header .add-brand-btn[style*="margin-left:auto"] {
        margin-left: auto !important;
    }
    .add-brand-btn {
        padding: 0.2rem 0.75rem !important;
        font-size: 0.85rem !important;
    }
    .add-brand-btn i {
        width: 10px;
        height: 10px;
    }
    
    /* Mobile-specific adjustments */
    .brand-item {
        height: 150px;
    }
    
    .brand-image-section {
        height: 90px;
    }
    
    .brand-img {
        max-height: 60%;
        max-width: 60%;
    }
    
    .brand-content {
        padding: 10px 12px;
    }
    
    .brand-name {
        font-size: 0.85rem;
    }
    
    .btn-action {
        width: 28px;
        height: 28px;
        font-size: 0.85rem;
    }
    
    .brand-actions {
        margin-top: 6px;
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();

    // Edit brand
    document.querySelectorAll('.edit-brand-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const modal = new bootstrap.Modal(document.getElementById('brandModal'));
            const form = document.querySelector('#brandModal form');
            const label = document.getElementById('brandModalLabel');
            const imgWrapper = document.getElementById('currentBrandImageWrapper');
            const imgTag = document.getElementById('currentBrandImage');

            label.textContent = 'Edit Brand';
            form.action = `/admin/brands/${btn.dataset.id}`;
            if (!form.querySelector('input[name="_method"]')) {
                const m = document.createElement('input');
                m.name = '_method';
                m.type = 'hidden';
                m.value = 'PUT';
                form.appendChild(m);
            }
            form.querySelector('input[name="name"]').value = btn.dataset.name;
            form.querySelector('input[name="image"]').value = '';

            if (btn.dataset.image) {
                imgTag.src = btn.dataset.image.startsWith('http') ? btn.dataset.image : (window.location.origin + '/' + btn.dataset.image);
                imgWrapper.classList.remove('d-none');
            } else {
                imgWrapper.classList.add('d-none');
            }

            form.querySelector('button[type="submit"]').textContent = 'Save Changes';
            modal.show();
        });
    });

    // Reset modal on close
    document.getElementById('brandModal').addEventListener('hidden.bs.modal', () => {
        const form = document.querySelector('#brandModal form');
        const label = document.getElementById('brandModalLabel');
        form.action = "{{ route('admin.brands.store') }}";
        form.querySelector('input[name="name"]').value = '';
        form.querySelector('input[name="image"]').value = '';
        form.querySelector('button[type="submit"]').textContent = 'Save Brand';
        const method = form.querySelector('input[name="_method"]');
        if (method) method.remove();
        document.getElementById('currentBrandImageWrapper').classList.add('d-none');
    });

    // Delete confirmation
    document.querySelectorAll('.delete-brand-form').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            const brandName = form.dataset.brandName;
            Swal.fire({
                title: `Delete "${brandName}"?`,
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: "btn btn-danger me-2",
                    cancelButton: "btn btn-secondary"
                },
                buttonsStyling: false
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endsection
