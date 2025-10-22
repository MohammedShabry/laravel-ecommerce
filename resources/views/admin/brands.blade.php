@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')


<div class="content-header">
    <div>
        <h2 class="content-title card-title">Brand</h2>
        <p>Brand and vendor management</p>
    </div>
    <div>
        <a href="#" class="btn btn-primary" id="showBrandForm"><i class="text-muted material-icons md-post_add"></i>Add New Brand</a>
    </div>
</div>

<div class="row">
    <!-- Sidebar form (hidden by default) -->
    <div class="col-md-3" id="brandFormSidebar" style="display:none;">
        <div class="card">
            <div class="card-header">Add New Brand</div>
            <div class="card-body">
                <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="brandName" class="form-label">Brand Name</label>
                        <input type="text" class="form-control" id="brandName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="brandImage" class="form-label">Brand Image</label>
                        <input type="file" class="form-control" id="brandImage" name="image">
                        <div id="currentBrandImageWrapper" style="display:none; margin-top:10px;">
                            <img id="currentBrandImage" src="" alt="Current Brand Image" style="max-height:60px; max-width:100px; object-fit:contain; border:1px solid #eee; padding:2px; background:#fafafa;">
                        </div>
                    </div>
                    <!-- Status field removed: status will be set to active by default -->
                    <button type="submit" class="btn btn-success">Add Brand</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Brands list -->
    <div id="brandsColumn" class="col-md-12">
        <div class="card mb-4">
            <header class="card-header">
                <div class="row gx-3">
                    <div class="col-lg-4 mb-lg-0 mb-15 me-auto">
                        <input type="text" placeholder="Search..." class="form-control" />
                    </div>
                </div>
            </header>
            <div class="card-body">
                <div class="row gx-3">
                    @forelse($brands as $brand)
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 mb-4">
                            <figure class="card border-1 brand-card position-relative">
                                <div class="card-header bg-white text-center brand-img-header">
                                    <img src="{{ $brand->image ? asset($brand->image) : asset('assetsbackend/imgs/brands/default.png') }}" class="img-fluid brand-img" alt="Logo" />
                                </div>
                                <figcaption class="card-body text-center d-flex flex-column justify-content-between w-100 brand-card-body">
                                    <h6 class="card-title mb-0">{{ $brand->name }}</h6>
                                    <span class="badge bg-{{ $brand->status ? 'success' : 'secondary' }} mt-1 mb-2">{{ $brand->status ? 'Active' : 'Inactive' }}</span>
                                    
                                    <!-- Action icons moved to bottom right corner -->
                                    <div class="brand-actions">
                                        <a href="#" class="text-success edit-brand-btn" title="Edit" data-id="{{ $brand->id }}" data-name="{{ $brand->name }}" data-image="{{ $brand->image }}"><i class="material-icons md-edit"></i></a>
                                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline delete-brand-form" data-brand-name="{{ $brand->name }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn  p-0 m-0 text-danger" title="Delete"><i class="material-icons md-delete"></i></button>
                                        </form>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
<style>
    .brand-card {
        min-height: 220px;
        height: 100%;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        position: relative;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .brand-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    
    .brand-img-header {
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background: #fafbfc;
        border-bottom: 1px solid #f0f0f0;
        width: 100%;
        padding: 1rem;
    }
    
    .brand-img {
        max-height: 100px;
        max-width: 140px;
        object-fit: contain;
        margin: 0 auto;
        display: block;
    }
    
    .brand-card-body {
        padding: 1rem 1rem 2.5rem 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        width: 100%;
        flex-grow: 1;
    }
    
    .brand-card-body h6 {
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 0;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        margin-top: 0.25rem;
    }
    
    /* Fix spacing in grid */
    .row.gx-3 {
        margin-right: -12px;
        margin-left: -12px;
    }
    
    .row.gx-3 > [class*="col-"] {
        padding-right: 12px;
        padding-left: 12px;
    }
    
    /* Position action buttons at bottom right */
    .brand-actions {
        position: absolute;
        bottom: 8px;
        right: 8px;
        display: flex;
        gap: 8px;
    }
</style>
                    @empty
                        <p>No brands found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 from CDN (only added once here) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('showBrandForm').addEventListener('click', function(e) {
        e.preventDefault();
        var sidebar = document.getElementById('brandFormSidebar');
        var brandsCol = document.getElementById('brandsColumn');
        var isVisible = sidebar.style.display !== 'none' && sidebar.style.display !== '';
        // Toggle display
        sidebar.style.display = isVisible ? 'none' : 'block';
        // Adjust brands column width
        if (isVisible) {
            // hiding sidebar -> full width
            brandsCol.classList.remove('col-md-9');
            brandsCol.classList.add('col-md-12');
        } else {
            // showing sidebar -> shrink brands
            brandsCol.classList.remove('col-md-12');
            brandsCol.classList.add('col-md-9');
        }
        // Reset form to add mode
        var form = sidebar.querySelector('form');
        form.action = "{{ route('admin.brands.store') }}";
        form.querySelector('input[name="name"]').value = '';
        form.querySelector('input[name="image"]').value = '';
        form.querySelector('button[type="submit"]').textContent = 'Add Brand';
        var m = form.querySelector('input[name="_method"]'); if (m) m.remove();
        sidebar.querySelector('.card-header').textContent = 'Add New Brand';
        // Hide current image preview
        var imgWrapper = document.getElementById('currentBrandImageWrapper'); if (imgWrapper) imgWrapper.style.display = 'none';
        var imgEl = document.getElementById('currentBrandImage'); if (imgEl) imgEl.src = '';
    });

    // Edit brand logic
    document.querySelectorAll('.edit-brand-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var sidebar = document.getElementById('brandFormSidebar');
            sidebar.style.display = 'block';
            var brandsCol = document.getElementById('brandsColumn');
            // ensure brands column shrinks when editing
            brandsCol.classList.remove('col-md-12');
            brandsCol.classList.add('col-md-9');
            var form = sidebar.querySelector('form');
            form.action = '/admin/brands/' + btn.dataset.id;
            // Add hidden _method input for PUT
            if (!form.querySelector('input[name="_method"]')) {
                var methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            } else {
                form.querySelector('input[name="_method"]').value = 'PUT';
            }
            form.querySelector('input[name="name"]').value = btn.dataset.name;
            form.querySelector('input[name="image"]').value = '';
            form.querySelector('button[type="submit"]').textContent = 'Save Changes';
            sidebar.querySelector('.card-header').textContent = 'Edit Brand';
            // Show current image preview if available
            var currentImage = btn.dataset.image;
            var imgWrapper = document.getElementById('currentBrandImageWrapper');
            var imgTag = document.getElementById('currentBrandImage');
            if (currentImage) {
                imgTag.src = currentImage.startsWith('http') ? currentImage : (window.location.origin + '/' + currentImage.replace(/^\/+/, ''));
                imgWrapper.style.display = 'block';
            } else {
                imgTag.src = '';
                imgWrapper.style.display = 'none';
            }
        });
    });

    // SweetAlert2 delete logic (AJAX)
    document.querySelectorAll('.delete-brand-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const brandName = form.getAttribute('data-brand-name') || 'this brand';
            Swal.fire({
                title: 'Delete Brand?',
                text: `Are you sure you want to delete "${brandName}"? This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit via AJAX to avoid full page reload
                    const fd = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        body: fd,
                        credentials: 'same-origin'
                    })
                    .then(async res => {
                        if (!res.ok) {
                            let msg = 'Failed to delete';
                            try { const data = await res.json(); msg = data.message || msg; } catch {};
                            throw new Error(msg);
                        }
                        // Remove card from grid
                        const card = form.closest('.col-xl-3, .col-lg-3, .col-md-3, .col-sm-6, .col-12');
                        if (card) card.remove();
                        Swal.fire({ icon: 'success', title: 'Deleted!', text: 'Brand deleted successfully.', timer: 1500, showConfirmButton: false });
                    })
                    .catch(err => {
                        Swal.fire({ icon: 'error', title: 'Error', text: err.message || 'Failed to delete' });
                    });
                }
            });
        });
    });
</script>


@endsection