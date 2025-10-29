@extends('layouts.admin')

@section('title', 'Dashboard')


@section('content')

    <style>
        /* Responsive table: auto-size columns, keep header/body aligned, and allow horizontal scroll on small viewports. */
        .table-responsive {
            -webkit-overflow-scrolling: touch; /* momentum scrolling on iOS */
            scroll-behavior: smooth;
            overflow-x: auto;
        }

        /* Let the table size itself to content but never exceed the container width. On larger screens it will
           expand to available space; on small screens it may be wider than the viewport and will scroll. */
        .table-responsive .table {
            width: auto;
            max-width: 100%;
            table-layout: auto; /* columns size according to content */
            border-collapse: collapse;
            margin: 0;
        }

        /* Keep cells from wrapping by default so columns size to their longest cell; use ellipsis to keep UI tidy.
           On desktop we allow normal wrapping where it improves layout (see media query). */
        .table-responsive .table th,
        .table-responsive .table td {
            /* Allow cells to size to their content without forcing extra width.
               Let text wrap when necessary so long cells don't inflate column width. */
            white-space: normal;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: middle;
            padding: .6rem .75rem;
        }

        /* Table border and cell separators */
        .table-responsive .table {
            /* subtle outer border and rounded corners */
            border: 1px solid #dee2e6;
            border-radius: .375rem;
        }

        /* row / cell separators (keep header thicker) */
        .table-responsive .table thead th {
            border-bottom: 2px solid #dee2e6;
        }

        .table-responsive .table tbody td,
        .table-responsive .table thead th {
            border-bottom: 1px solid #e9ecef;
        }

        /* vertical separators between columns */
        .table-responsive .table th,
        .table-responsive .table td {
            border-right: 1px solid #e9ecef;
        }

        /* Remove the extra right border on the last column for a clean edge */
        .table-responsive .table th:last-child,
        .table-responsive .table td:last-child {
            border-right: 0;
        }

        /* Remove duplicate bottom border on the last row for a cleaner look */
        .table-responsive .table tbody tr:last-child td {
            border-bottom: 0;
        }

        /* Image sizing: small, fixed to avoid layout shifts */
        .table-responsive .img-category {
            width: auto;
            height: auto;
            max-width: 48px;
            max-height: 48px;
            object-fit: cover;
            flex-shrink: 1;
        }

        /* Inline item layout for category column: image + text.
           Ensure the text can shrink and ellipsis correctly. */
        .itemside { display: flex; align-items: center; gap: .75rem; }
        .itemside .left { flex: 0 1 auto; display: flex; align-items: center; }
        .itemside .info { flex: 1 1 auto; min-width: 0; }

        /* Header layout: keep controls and title aligned and responsive */
        .content-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .content-header .content-title { margin: 0; font-size: 1.25rem; }
        .content-header > div { display: flex; gap: .5rem; align-items: center; }

        /* Ensure action dropdowns can overflow the table cell when opened */
        .table-responsive td.text-end,
        .table-responsive td.text-end * { overflow: visible !important; }
        .table-responsive .dropdown { position: relative; }
        .table-responsive .dropdown-menu { position: absolute; top: 100%; right: 0; left: auto; z-index: 3000; min-width: 8rem; }

        /* On medium and smaller screens, allow horizontal scroll instead of collapsing columns. Keep table
           semantics (thead/tbody) so header and body columns stay aligned. */
        @media (max-width: 991.98px) {
            .table-responsive .table {
                /* allow table to be as wide as its content, but at least container width so layout is stable */
                width: max-content;
                min-width: 100%;
            }
            .table-responsive .table th,
            .table-responsive .table td {
                white-space: nowrap;
            }
            .content-header { align-items: flex-start; }
            .content-header .content-title { width: 100%; }
            .content-header > div { width: 100%; display: flex; justify-content: flex-end; }
        }

        /* On large screens use full width and allow cells to wrap where appropriate so columns don't leave large unused space. */
        @media (min-width: 992px) {
            .table-responsive .table { width: 100%; }
            .table-responsive .table th,
            .table-responsive .table td { white-space: normal; }
        }

        /* Ensure mobile keeps native table semantics (prevents some themes from converting tables to stacked cards)
           while still allowing horizontal scrolling if content overflows. This preserves header/body alignment. */
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

        /* Form responsiveness */
        @media (max-width: 767.98px) {
            .category-form-wrapper {
                margin-bottom: 2rem;
            }
            .category-form-wrapper .card {
                margin-bottom: 1.5rem;
            }
        }

        /* Stack form on top of table on small screens */
        @media (max-width: 991.98px) {
            .content-header input[type="text"] {
                max-width: 100%;
            }
        }

        /* Improve form spacing on mobile */
        @media (max-width: 575.98px) {
            .content-header {
                flex-direction: column;
                align-items: stretch;
            }
            .content-header > div {
                width: 100%;
            }
            .content-header input[type="text"] {
                width: 100%;
            }
        }

        /* Category Dropdown Styles */
        .category-dropdown-btn {
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        .category-dropdown-btn:hover {
            background-color: #f8f9fa !important;
            border-color: #adb5bd !important;
        }
        .category-dropdown-btn:focus {
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .category-tree-menu {
            max-height: 320px;
            overflow-y: auto;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
        }
        
        /* Adjust dropdown height on smaller screens */
        @media (max-width: 767.98px) {
            .category-tree-menu {
                max-height: 280px;
            }
        }
        
        @media (max-width: 575.98px) {
            .category-tree-menu {
                max-height: 240px;
            }
        }
        .category-tree-menu::-webkit-scrollbar {
            width: 8px;
        }
        .category-tree-menu::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .category-tree-menu::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        .category-tree-menu::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        .category-tree-item {
            position: relative;
        }
        .category-tree-item .category-select {
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .category-tree-item .category-select:hover {
            background-color: #f8f9fa;
            padding-left: calc(var(--bs-dropdown-item-padding-x) + 5px) !important;
        }
        .category-tree-item .category-select:active {
            background-color: #e9ecef;
        }
        .toggle-children {
            transition: transform 0.2s ease;
        }
        .toggle-children.expanded i {
            transform: rotate(90deg);
        }
        .category-children {
            background-color: #f8f9fa;
        }
        .dropdown-header {
            padding: 0.75rem 1rem;
            font-weight: 600;
        }
    </style>

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
                        <h2 class="content-title">Categories</h2>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal" id="addCategoryBtn">
                            <i class="material-icons md-plus"></i> Create new
                        </button>
                    </div>
                </div>
                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row gx-3">
                            <div class="col-lg-4 col-md-6 me-auto">
                                <input type="text" placeholder="Search Categories" class="form-control" />
                            </div>
                        </div>
                    </header>
                    <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Slug</th>
                                                <th>Parent</th>
                                                <th>Order Level</th>
                                                <th>Status</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($categories as $category)
                                            <tr>
                                                <td>
                                                    <div class="itemside">
                                                        <div class="left">
                                                            @if($category->image)
                                                                <img src="{{ asset('storage/' . $category->image) }}" class="img-sm img-category" alt="{{ $category->name }}" />
                                                            @else
                                                                <img src="{{ asset('assetsbackend/imgs/items/1.jpg') }}" class="img-sm img-category" alt="Default" />
                                                            @endif
                                                        </div>
                                                        <div class="info pl-3">
                                                            <span class="mb-0 title"><b>{{ $category->name }}</b></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $category->slug }}</td>
                                                <td>
                                                    @if($category->parent_id)
                                                        @php
                                                            $parent = $categories->firstWhere('id', $category->parent_id);
                                                        @endphp
                                                        {{ $parent ? $parent->name : '-' }}
                                                    @else
                                                        <span class="text-muted">None</span>
                                                    @endif
                                                </td>
                                                <td>{{ $category->order_level }}</td>
                                                <td>
                                                    @php $status = strtolower($category->status ?? 'inactive'); @endphp
                                                    @if($status === 'active')
                                                        <span class="badge rounded-pill alert-success text-dark">Active</span>
                                                    @else
                                                        <span class="badge rounded-pill alert-secondary text-dark">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-sm btn-light rounded font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item edit-category-btn" href="#" data-id="{{ $category->id }}">Edit</a>
                                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="delete-category-form" data-category-name="{{ $category->name }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6">No categories found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                        </div>
                    </div>
                    <!-- card-body end// -->
                </div>
                <!-- card end// -->

                <!-- Category Modal -->
                <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="categoryModalLabel">Create Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="category-form" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" id="form-method" value="POST">
                                <input type="hidden" name="edit_id" id="edit_id" value="">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="category_name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" placeholder="Type here" class="form-control" id="category_name" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Parent Category</label>
                                        <div id="category-tree-dropdown" class="dropdown">
                                            <button class="btn btn-light border w-100 text-start d-flex justify-content-between align-items-center category-dropdown-btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span id="selected-category-label" class="text-dark">
                                                    <i class="material-icons md-folder_open me-2" style="font-size: 18px; vertical-align: middle;"></i>
                                                    None
                                                </span>
                                                <i class="material-icons md-expand_more" style="font-size: 20px;"></i>
                                            </button>
                                            <ul class="dropdown-menu w-100 p-0 shadow-sm category-tree-menu" aria-labelledby="dropdownMenuButton">
                                                <li class="dropdown-header bg-light border-bottom">
                                                    <small class="text-muted">Select Parent Category</small>
                                                </li>
                                                <li class="category-tree-item">
                                                    <a href="#" class="dropdown-item category-select py-2" data-id="" data-label="None">
                                                        <i class="material-icons md-folder_open me-2" style="font-size: 18px; vertical-align: middle; color: #6c757d;"></i>
                                                        <span class="fw-semibold">None</span>
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider m-0"></li>
                                                @php
                                                    function renderCategoryTree($categories, $parentId = null, $level = 0) {
                                                        foreach ($categories->where('parent_id', $parentId) as $cat) {
                                                            $hasChildren = $categories->where('parent_id', $cat->id)->count() > 0;
                                                            $indent = $level * 20;
                                                            echo '<li class="category-tree-item">';
                                                            echo '<div class="d-flex align-items-center position-relative">';
                                                            if ($hasChildren) {
                                                                echo '<span class="toggle-children position-absolute" style="left: ' . ($indent + 10) . 'px; cursor: pointer; color: #6c757d; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 18px; user-select: none;">
                                                                    <i class="material-icons md-chevron_right" style="font-size: 18px; transition: transform 0.2s;"></i>
                                                                </span>';
                                                            }
                                                            echo '<a href="#" class="dropdown-item category-select py-2 flex-grow-1" data-id="' . $cat->id . '" data-label="' . e($cat->name) . '" style="padding-left: ' . ($indent + ($hasChildren ? 40 : 30)) . 'px !important;">';
                                                            echo '<i class="material-icons ' . ($hasChildren ? 'md-folder' : 'md-label') . ' me-2" style="font-size: 18px; vertical-align: middle; color: ' . ($hasChildren ? '#ffc107' : '#6c757d') . ';"></i>';
                                                            echo '<span>' . e($cat->name) . '</span>';
                                                            echo '</a>';
                                                            echo '</div>';
                                                            if ($hasChildren) {
                                                                echo '<ul class="list-unstyled m-0 category-children" style="display: none;">';
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
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" placeholder="Type here" class="form-control" id="category_description" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" id="category_image" />
                                        <div id="current-image-preview" class="mt-2"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="form-submit-btn">Create category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryModal = document.getElementById('categoryModal');
        const categoryForm = document.getElementById('category-form');
        const modalTitle = document.getElementById('categoryModalLabel');
        const submitBtn = document.getElementById('form-submit-btn');
        
        // Store categories data
        window.categories = @json($categories);

        // Expand/collapse tree
        document.querySelectorAll('#category-tree-dropdown .toggle-children').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var ul = this.closest('.category-tree-item').querySelector('.category-children');
                if (ul) {
                    if (ul.style.display === 'none' || !ul.style.display) {
                        ul.style.display = 'block';
                        this.classList.add('expanded');
                    } else {
                        ul.style.display = 'none';
                        this.classList.remove('expanded');
                    }
                }
            });
        });

        // Select category from tree dropdown
        document.querySelectorAll('#category-tree-dropdown .category-select').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                var id = this.getAttribute('data-id');
                var label = this.getAttribute('data-label');
                document.getElementById('selected-category-id').value = id;
                
                // Update button text with icon
                var iconHtml = '<i class="material-icons md-folder_open me-2" style="font-size: 18px; vertical-align: middle;"></i>';
                document.getElementById('selected-category-label').innerHTML = iconHtml + label;
                
                // Close dropdown
                var dropdown = bootstrap.Dropdown.getInstance(document.getElementById('dropdownMenuButton'));
                if (dropdown) dropdown.hide();
            });
        });

        // Reset form when modal is closed
        categoryModal.addEventListener('hidden.bs.modal', function () {
            resetForm();
        });

        // Add category button - reset form
        document.getElementById('addCategoryBtn').addEventListener('click', function() {
            resetForm();
        });

        // Edit category buttons
        document.querySelectorAll('.edit-category-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const catId = this.getAttribute('data-id');
                const cat = window.categories.find(c => c.id == catId);
                if (!cat) return;

                // Set form to edit mode
                modalTitle.textContent = 'Edit Category';
                categoryForm.action = '/admin/categories/' + cat.id;
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
                var iconHtml = '<i class="material-icons md-folder_open me-2" style="font-size: 18px; vertical-align: middle;"></i>';
                document.getElementById('selected-category-label').innerHTML = iconHtml + parentLabel;

                // Image preview
                const preview = document.getElementById('current-image-preview');
                if (cat.image) {
                    preview.innerHTML = '<img src="/storage/' + cat.image + '" class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: cover;">';
                } else {
                    preview.innerHTML = '';
                }

                submitBtn.textContent = 'Save changes';

                // Show modal
                const modal = new bootstrap.Modal(categoryModal);
                modal.show();
            });
        });

        function resetForm() {
            modalTitle.textContent = 'Create Category';
            categoryForm.action = "{{ route('categories.store') }}";
            categoryForm.reset();
            document.getElementById('form-method').value = 'POST';
            document.getElementById('edit_id').value = '';
            document.getElementById('selected-category-id').value = '';
            var iconHtml = '<i class="material-icons md-folder_open me-2" style="font-size: 18px; vertical-align: middle;"></i>';
            document.getElementById('selected-category-label').innerHTML = iconHtml + 'None';
            document.getElementById('current-image-preview').innerHTML = '';
            submitBtn.textContent = 'Create category';
        }
    });
</script>
<!-- SweetAlert2 from CDN -->
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

@endsection