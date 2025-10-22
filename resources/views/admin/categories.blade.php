@extends('layouts.admin')

@section('title', 'Dashboard')


@section('content')

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Simple toast using Bootstrap 5
                let toast = document.createElement('div');
                toast.className = 'toast align-items-center text-bg-danger border-0 show position-fixed top-0 end-0 m-3';
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                `;
                document.body.appendChild(toast);
                var bsToast = new bootstrap.Toast(toast, { delay: 4000 });
                bsToast.show();
            });
        </script>
    @endif

                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Categories</h2>
                        <p>Add, edit or delete a category</p>
                    </div>
                    <div>
                        <input type="text" placeholder="Search Categories" class="form-control bg-white" />
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <form id="category-form" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" id="form-method" value="POST">
                                    <input type="hidden" name="edit_id" id="edit_id" value="">
                                    <div class="mb-4">
                                        <label for="category_name" class="form-label">Name</label>
                                        <input type="text" name="name" placeholder="Type here" class="form-control" id="category_name" required />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Parent</label>
                                        <div id="category-tree-dropdown" class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle w-100 d-flex justify-content-between align-items-center" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span id="selected-category-label" class="ps-3">None</span>
                                            </button>
                                            <ul class="dropdown-menu w-100 p-2" aria-labelledby="dropdownMenuButton" style="max-height: 300px; overflow-y: auto; min-width: 250px;">
                                                <li>
                                                    <a href="#" class="dropdown-item category-select" data-id="" data-label="None">None</a>
                                                </li>
                                                @php
                                                    function renderCategoryTree($categories, $parentId = null, $level = 0) {
                                                        foreach ($categories->where('parent_id', $parentId) as $cat) {
                                                            $hasChildren = $categories->where('parent_id', $cat->id)->count() > 0;
                                                            $liClass = $level === 0 ? 'ps-2' : 'ps-2 ms-1';
                                                            echo '<li class="' . $liClass . '">';
                                                            if ($hasChildren) {
                                                                echo '<span class="toggle-children me-1" style="cursor:pointer;">+</span>';
                                                            } else {
                                                                echo '<span class="me-2"></span>';
                                                            }
                                                            echo '<a href="#" class="dropdown-item d-inline category-select" data-id="' . $cat->id . '" data-label="' . e($cat->name) . '">' . e($cat->name) . '</a>';
                                                            if ($hasChildren) {
                                                                echo '<ul class="list-unstyled ms-2 d-none">';
                                                                renderCategoryTree($categories, $cat->id, $level + 1);
                                                                echo '</ul>';
                                                            }
                                                            echo '</li>';
                                                        }
                                                    }
                                                    renderCategoryTree($categories);
                                                @endphp
                                            </ul>
                                            <input type="hidden" name="parent_id" id="selected-category-id" value="">
                                        </div>
                                    </div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Expand/collapse tree
        document.querySelectorAll('#category-tree-dropdown .toggle-children').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                var ul = this.parentElement.querySelector('ul');
                if (ul) {
                    if (ul.classList.contains('d-none')) {
                        ul.classList.remove('d-none');
                        this.textContent = '-';
                    } else {
                        ul.classList.add('d-none');
                        this.textContent = '+';
                    }
                }
            });
        });
        // Select category
        document.querySelectorAll('#category-tree-dropdown .category-select').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                var id = this.getAttribute('data-id');
                var label = this.getAttribute('data-label');
                document.getElementById('selected-category-id').value = id;
                document.getElementById('selected-category-label').textContent = label;
            });
        });

        // Inline edit logic
        window.categories = @json($categories);
        document.querySelectorAll('.edit-category-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var catId = this.getAttribute('data-id');
                var cat = window.categories.find(c => c.id == catId);
                if (!cat) return;
                // Set form to edit mode
                var form = document.getElementById('category-form');
                form.action = '/admin/categories/' + cat.id;
                document.getElementById('form-method').value = 'PUT';
                document.getElementById('edit_id').value = cat.id;
                document.getElementById('category_name').value = cat.name;
                document.getElementById('category_description').value = cat.description || '';
                document.getElementById('selected-category-id').value = cat.parent_id || '';
                // Set parent label
                var parentLabel = 'None';
                if (cat.parent_id) {
                    var parentCat = window.categories.find(c => c.id == cat.parent_id);
                    if (parentCat) parentLabel = parentCat.name;
                }
                document.getElementById('selected-category-label').textContent = parentLabel;
                // Image preview
                var preview = document.getElementById('current-image-preview');
                if (cat.image) {
                    preview.innerHTML = '<img src="' + '/storage/' + cat.image + '" width="40" height="40" style="object-fit:cover;">';
                } else {
                    preview.innerHTML = '';
                }
                document.getElementById('form-submit-btn').textContent = 'Save changes';
                document.getElementById('cancel-edit-btn').classList.remove('d-none');
            });
        });
        // Cancel edit
        document.getElementById('cancel-edit-btn').addEventListener('click', function() {
            var form = document.getElementById('category-form');
            form.action = "{{ route('categories.store') }}";
            document.getElementById('form-method').value = 'POST';
            document.getElementById('edit_id').value = '';
            document.getElementById('category_name').value = '';
            document.getElementById('category_description').value = '';
            document.getElementById('selected-category-id').value = '';
            document.getElementById('selected-category-label').textContent = 'None';
            document.getElementById('current-image-preview').innerHTML = '';
            document.getElementById('form-submit-btn').textContent = 'Create category';
            this.classList.add('d-none');
        });
    });
</script>
@endpush
                                    <div class="mb-4">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" placeholder="Type here" class="form-control" id="category_description"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" id="category_image" />
                                        <div id="current-image-preview" class="mt-2"></div>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit" id="form-submit-btn">Create category</button>
                                        <button class="btn btn-secondary mt-2 d-none" type="button" id="cancel-edit-btn">Cancel Edit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" />
                                                    </div>
                                                </th>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>Order Level</th>
                                                <th>Status</th>
                                                <th>Image</th>
                                                <th class="text-end">Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categories as $category)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="{{ $category->id }}" />
                                                    </div>
                                                </td>
                                                <td><b>{{ $category->name }}</b></td>
                                                <td>{{ $category->slug }}</td>
                                                <td>{{ $category->order_level }}</td>
                                                <td>
                                                    @if($category->status == 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($category->image)
                                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="40" height="40" style="object-fit:cover;">
                                                    @else
                                                        <span class="text-muted">No image</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item edit-category-btn" href="#" data-id="{{ $category->id }}">Edit</a>
                                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="delete-category-form" data-category-name="{{ $category->name }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                                                            </form>
@push('scripts')
<!-- SweetAlert2 from CDN (only added once here) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
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
        color: #6c757d !important;
    }
    .swal2-actions {
        display: flex !important;
        gap: 0.75rem !important;
        justify-content: center;
    }
    .swal2-styled.swal2-confirm.btn,
    .swal2-styled.swal2-cancel.btn {
        margin: 0 !important;
    }
    @media (min-width: 576px) {
        .swal2-popup {
            max-width: 520px !important;
        }
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-category-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const categoryName = form.getAttribute('data-category-name') || 'this category';
            Swal.fire({
                title: 'Delete Category?',
                text: `Are you sure you want to delete "${categoryName}"? This action cannot be undone!`,
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
                        // Remove row from table
                        const row = form.closest('tr');
                        if (row) row.remove();
                        Swal.fire({ icon: 'success', title: 'Deleted!', text: 'Category deleted successfully.', timer: 1500, showConfirmButton: false });
                    })
                    .catch(err => {
                        Swal.fire({ icon: 'error', title: 'Error', text: err.message || 'Failed to delete' });
                    });
                }
            });
        });
    });
});
</script>
@endpush
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- .col// -->
                        </div>
                        <!-- .row // -->
                    </div>
                    <!-- card body .// -->
                </div>
                <!-- card .// -->


@endsection