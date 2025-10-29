@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

                <div class="row">
                    <div class="col-9">
                        <div class="content-header">
                            <h2 class="content-title">Add New Product</h2>
                            <!-- action buttons removed per request -->
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row gx-5">
                                    <aside class="col-lg-3 border-end">
                                        <nav class="nav nav-pills flex-column mb-4">
                                            <a class="nav-link active" aria-current="page" href="#" data-target="#section-general">General</a>
                                            <a class="nav-link" href="#" data-target="#section-files-media">Files & Media</a>
                                            <a class="nav-link" href="#" data-target="#section-price-stock">Price & Stock</a>
                                            <a class="nav-link" href="#" data-target="#section-seo">SEO</a>
                                            <a class="nav-link" href="#" data-target="#section-shipping">Shipping</a>
                                            <a class="nav-link" href="#" data-target="#section-warranty">Warranty</a>
                                        </nav>
                                    </aside>
                                    <div class="col-lg-9">
                                        <section class="content-body p-xl-4">
                                            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                @if(session('success'))
                                                    <div class="alert alert-success">{{ session('success') }}</div>
                                                @endif
                                                @if($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul class="mb-0">
                                                            @foreach($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <!-- Consolidated styles and external CSS moved here for clarity -->
                                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
                                                <style>
                                                    /* Category expand/collapse button */
                                                    #product-category-box .toggle-btn{
                                                        background: transparent;
                                                        border: none;
                                                        padding: 0;
                                                        margin: 0 6px 0 0;
                                                        width: 18px;
                                                        height: 18px;
                                                        line-height: 16px;
                                                        text-align: center;
                                                        cursor: pointer;
                                                        color: #6c757d;
                                                        font-weight: 600;
                                                    }
                                                    #product-category-box .toggle-btn:focus{ outline: none; }
                                                    #product-category-box .toggle-btn:hover{ color: #495057; }

                                                    /* --- FIX ALIGNMENT FOR REFUND TOGGLE and related styles --- */
                                                    .refund-row { align-items: flex-start; }
                                                    .refund-row .col-lg-3 { display: flex; align-items: center; min-height: 48px; padding-top: 0; }
                                                    .refund-row .col-lg-9 { display: block; padding-top: 0; }
                                                    .refund-row .col-lg-9 > .form-check { min-height: 48px; display: flex; align-items: center; }
                                                    .form-check.form-switch { padding-left: 0; margin: 0; display: inline-flex; align-items: center; }
                                                    .form-check-input.large-toggle { transform: scale(1.2); transform-origin: left center; margin-top: 0; margin-left: 0; }

                                                    /* Shipping / status alignment */
                                                    .status-row { align-items: flex-start; }
                                                    .status-row .col-lg-3 { display: flex; align-items: center; min-height: 30px; padding-top: 0; }
                                                    .status-row .col-lg-9 { display: flex; flex-direction: column; align-items: flex-start; padding-top: 0; gap: 1px; }
                                                    .status-row .col-lg-9 > .form-check { min-height: 30px; display: flex; align-items: center; }
                                                    .status-row .col-lg-9 small { display: block; margin-top: 0; font-size: 0.6rem; line-height: 1.2; color: #6c757d; }

                                                    /* Shipping-specific rows: align label and toggle horizontally */
                                                    .shipping-row { align-items: center; }
                                                    .shipping-row .col-lg-3 { display: flex; align-items: center; min-height: 30px; padding-top: 0; }
                                                    .shipping-row .col-lg-9 { display: flex; align-items: center; padding-top: 0; gap: 8px; }
                                                    .shipping-row .col-lg-9 > .form-check { min-height: 30px; display: flex; align-items: center; margin: 0; }
                                                    .shipping-row .col-lg-9 small { display: block; margin-top: 0; font-size: 0.72rem; color: #6c757d; }

                                                    /* refund note section */
                                                    #refundNoteSection { width: 100%; margin-top: 12px; display: block; }

                                                    /* modal styles */
                                                    .refund-modal { position: fixed; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 9999; pointer-events: auto; }
                                                    .refund-modal.d-none { display: none; pointer-events: none; }
                                                    .refund-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 9998; pointer-events: auto; }
                                                    .refund-modal-dialog { position: relative; background: #fff; width: 90%; max-width: 760px; border-radius: 6px; padding: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); z-index: 9999; pointer-events: auto; }
                                                    .refund-note-cards { display: flex; flex-wrap: wrap; }
                                                    .refund-note-card { cursor: pointer; border: 1px solid #e9ecef; border-radius: 6px; width: calc(50% - 8px); }
                                                    .refund-note-card:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.06); transform: translateY(-2px); }

                                                    /* small helper text adjustments */
                                                    small { font-size: 0.72rem; line-height: 1.2; color: #6c757d; }
                                                    .col-lg-9 small { display: block; margin-top: 4px !important; margin-bottom: 0 !important; }
                                                    .col-lg-9 small.mb-10 { margin-bottom: 4px !important; }

                                                    /* Choices swatch */
                                                    .colour-swatch { display: inline-block; width: 12px; height: 12px; border-radius: 50%; margin-right: 8px; vertical-align: middle; border: 1px solid rgba(0,0,0,0.08); box-shadow: 0 0 0 1px rgba(255,255,255,0.02) inset; }
                                                    .choices__list--multiple .colour-swatch { width: 10px; height: 10px; margin-right: 6px; }
                                                    .choices__list--dropdown .choices__item .colour-swatch { margin-right: 10px; }

                                                    /* Variants table layout */
                                                    table#variantsTable { width: 100%; border-collapse: collapse; table-layout: auto; }
                                                    table#variantsTable th, table#variantsTable td { border: 1px solid #e9ecef !important; padding: 0.5rem !important; vertical-align: middle !important; white-space: nowrap; }
                                                    table#variantsTable thead th { background: #f8f9fa !important; font-weight: 600; }
                                                    table#variantsTable td .form-control { width: 100%; box-sizing: border-box; margin: 0; }
                                                    #variants-section .table-responsive { overflow-x: auto; }

                                                    /* Warranty row */
                                                    .warranty-row .col-lg-3 { display: flex; align-items: center; min-height: 30px; padding-top: 0; }
                                                    .warranty-row .col-lg-9 { display: flex; flex-direction: column; align-items: flex-start; padding-top: 0; gap: 6px; }
                                                    .warranty-row .form-check.form-switch { padding-left: 0; margin: 0; display: inline-flex; align-items: center; }
                                                    .warranty-row .form-check-label { font-weight: 500; }
                                                    .warranty-row .form-check-input.large-toggle { transform: scale(1.15); transform-origin: left center; margin-top: 0; margin-left: 0; }

                                                    /* SSR-friendly helper */
                                                    .d-none { display: none !important; }
                                                </style>
                                                <!-- General section (hidden by default; JS will show active tab) -->
                                                <div id="section-general" class="d-none">
                                                    <div class="mb-4">
                                                        <h3 class="mb-1">Product information</h3>
                                                    </div>
                                                    <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Product name*</label>
                                                    <div class="col-lg-9">
                                                        <input name="name" type="text" class="form-control" placeholder="Type here" value="{{ old('name') }}" />
                                                    </div>
                                                    <!-- col.// -->
                                                    </div>

                                                    <!-- Product Category panel (right-side box similar to screenshot) -->
                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Category</label>
                                                        <div class="col-lg-9">
                                                            <div id="product-category-box" class="card p-3" style="width:100%; max-width:480px;">
                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                    <strong>Product category</strong>
                                                                </div>
                                                                <div class="category-list" style="max-height:320px; overflow:auto;">
                                                                    <?php
                                                                        // Build parent => children map for rendering a tree
                                                                        $tree = [];
                                                                        if (isset($categories) && is_iterable($categories)) {
                                                                            foreach ($categories as $c) {
                                                                                $pid = $c->parent_id === null ? 0 : $c->parent_id;
                                                                                if (!isset($tree[$pid])) $tree[$pid] = [];
                                                                                $tree[$pid][] = $c;
                                                                            }

                                                                            $render = function($parentId) use (&$render, $tree) {
                                                                                if (!isset($tree[$parentId])) return;
                                                                                foreach ($tree[$parentId] as $cat) {
                                                                                    // does this node have children?
                                                                                    $hasChildren = isset($tree[$cat->id]) && count($tree[$cat->id]) > 0;
                                                                                    ?>
                                                                                    <ul class="list-unstyled mb-0 node-list" style="margin:0; padding:0;">
                                                                                        <li class="d-flex align-items-start py-1 border-bottom" style="gap:8px;">
                                                                                            <div style="flex:0 0 22px; display:flex; align-items:center;">
                                                                                                <?php if($hasChildren): ?>
                                                                                                    <button type="button" class="toggle-btn" aria-expanded="false" data-id="<?php echo e($cat->id); ?>">+</button>
                                                                                                <?php else: ?>
                                                                                                    <span style="width:18px; display:inline-block;"></span>
                                                                                                <?php endif; ?>
                                                                                            </div>

                                                                                            <div class="form-check" style="flex:0 0 28px; margin-right:6px;">
                                                                                                <?php
                                                                                                    // output parent id for client-side traversal (use 0 for root/null)
                                                                                                    $cbParentId = $cat->parent_id === null ? 0 : $cat->parent_id;
                                                                                                ?>
                                                                             <!-- visible checkbox is controlled by radios and made non-interactive;
                                                                                 a hidden input will be created/removed by JS so values still submit -->
                                                                             <input class="form-check-input category-checkbox controlled-cat-checkbox" type="checkbox" value="<?php echo e($cat->id); ?>" id="catCheck-<?php echo e($cat->id); ?>" data-parent="<?php echo e($cbParentId); ?>" disabled tabindex="-1" aria-hidden="true">
                                                                                            </div>

                                                                                            <div class="flex-grow-1 text-truncate" title="<?php echo e($cat->name); ?>"><?php echo e($cat->name); ?></div>

                                                                                            <div class="form-check ms-2" style="flex:0 0 36px;">
                                                                                                <input class="form-check-input main-radio" type="radio" name="main_category" value="<?php echo e($cat->id); ?>" aria-label="Set as main category">
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                    <?php
                                                                                    // render children container (hidden by default)
                                                                                    if ($hasChildren) {
                                                                                        echo '<div class="children ms-3 d-none" data-parent="' . e($cat->id) . '">';
                                                                                        $render($cat->id);
                                                                                        echo '</div>';
                                                                                    }
                                                                                }
                                                                            };

                                                                            // start rendering from root nodes (parent_id null mapped to 0)
                                                                            echo '<div class="tree-root">';
                                                                            $render(0);
                                                                            echo '</div>';
                                                                        } else {
                                                                            echo '<div class="text-muted">No categories available</div>';
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    

                                                <!-- Category select removed per request; the category panel on the right uses $categories -->

                                                                                                <!-- row.// -->
                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Brand</label>
                                                    <div class="col-lg-9">
                                                        <select name="brand_id" id="brandSelect" class="form-control" aria-label="Select brand">
                                                            <option value="">Select Brand</option>
                                                            <?php if(isset($brands) && $brands->count()): ?>
                                                                <?php foreach($brands as $b): ?>
                                                                    <option value="<?php echo e($b->id); ?>" <?php echo e(old('brand_id') == $b->id ? 'selected' : ''); ?>><?php echo e($b->name); ?></option>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <!-- fallback hard-coded list if no brands available -->
                                                                <option value="">No brands available</option>
                                                            <?php endif; ?>
                                                        </select>
                                                        <small class="text-muted d-block mt-2">Choose a single brand for this product.</small>
                                                    </div>
                                                    <!-- col.// -->
                                                </div>

                                                                                                <div class="row mb-4">
                                                                                                    <label class="col-lg-3 col-form-label">Unit*</label>
                                                                                                    <div class="col-lg-9">
                                                                                                        <input name="unit" type="text" class="form-control" placeholder="Type here" value="{{ old('unit') }}" />
                                                                                                    </div>
                                                    <!-- col.// -->
                                                </div>

                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Weight (In Kg)</label>
                                                    <div class="col-lg-9">
                                                        <input name="weight" type="text" class="form-control" placeholder="Type here" value="{{ old('weight') }}" />
                                                    </div>
                                                    <!-- col.// -->
                                                </div>
                                                
                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Short Description</label>
                                                    <div class="col-lg-9">
                                                        <textarea name="short_description" class="form-control" rows="2" placeholder="Short description (shown in product lists or preview)"></textarea>
                                                        <small class="text-muted d-block mt-2">A brief summary of the product (suggested max 160 characters).</small>
                                                    </div>
                                                    <!-- col.// -->
                                                </div>

                                                <!-- row.// -->
                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Description*</label>
                                                    <div class="col-lg-9">
                                                        <textarea name="description" class="form-control" placeholder="Type here" rows="4">{{ old('description') }}</textarea>
                                                    </div>
                                                    <!-- col.// -->
                                                </div>


                                                <!-- row.// -->
                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Related tags</label>
                                                    <div class="col-lg-9">
                                                        <input name="tags" type="text" class="form-control" placeholder="tag1, tag2, tag3" value="{{ old('tags') }}" />
                                                    </div>
                                                    <!-- col.// -->
                                                </div>

                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Bar Code</label>
                                                    <div class="col-lg-9">
                                                        <input name="barcode" type="text" class="form-control" placeholder="Type here" value="{{ old('barcode') }}" />
                                                    </div>
                                                    <!-- col.// -->
                                                </div>
                                                
                                                <div class="mb-4">
                                                    <h3 class="mb-1">Refund</h3>
                                                </div>
                                                <!-- Refundable toggle and note area -->
                                                <div class="row mb-4 refund-row">
                                                    <label class="col-lg-3 col-form-label">Refundable?</label>
                                                    <div class="col-lg-9">
                                                        <div class="form-check form-switch">
                                                            <input type="hidden" name="refundable" value="0">
                                                            <input name="refundable" class="form-check-input large-toggle" type="checkbox" id="refundableToggle" value="1" aria-label="Refundable toggle">
                                                        </div>

                                                        <div id="refundNoteSection" class="mt-3 d-none">
                                                            <label class="form-label">Note</label>
                                                            <textarea id="refundNoteTextarea" name="refund_note" class="form-control mb-2" rows="4" placeholder="Type refund note or select from presets"></textarea>
                                                            <div class="d-flex align-items-center">
                                                                <button type="button" id="selectRefundNoteBtn" class="btn btn-sm btn-outline-secondary">+ Select Refund Note</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Status subtopic -->
                                                <div class="mb-4">
                                                    <h3 class="mb-1">Status</h3>
                                                </div>

                                                <!-- Featured & Today's Deal toggles -->
                                                <div class="row mb-4 status-row">
                                                    <label class="col-lg-3 col-form-label">Featured</label>
                                                    <div class="col-lg-9">
                                                        <div class="form-check form-switch">
                                                            <input type="hidden" name="featured" value="0">
                                                            <input name="featured" class="form-check-input large-toggle" type="checkbox" id="featuredToggle" value="1" aria-label="Featured toggle">
                                                        </div>
                                                        <small class="text-muted font-sm">Mark this product as featured on the homepage.</small>
                                                    </div>
                                                </div>

                                                <div class="row mb-4 status-row">
                                                    <label class="col-lg-3 col-form-label">Todays Deal</label>
                                                    <div class="col-lg-9">
                                                        <input type="hidden" name="todays_deal" value="0">
                                                        <div class="form-check form-switch">
                                                            <input name="todays_deal" class="form-check-input large-toggle" type="checkbox" id="todaysDealToggle" value="1" aria-label="Today's Deal toggle">
                                                        </div>
                                                        <small class="text-muted font-sm">Enable if this product is part of today's special deals.</small>
                                                    </div>
                                                </div>

                                                <!-- Flash Deal subtopic with toggle -->
                                                <div class="mb-4">
                                                    <h3 class="mb-1">Flash Deal</h3>
                                                </div>

                                                <!-- Flash Deal Toggle -->
                                                <div class="row mb-4 status-row">
                                                    <label class="col-lg-3 col-form-label">Flash Deal</label>
                                                    <div class="col-lg-9">
                                                        <input type="hidden" name="flash_deal_enabled" value="0">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input large-toggle" type="checkbox" id="flashDealToggle" name="flash_deal_enabled" value="1">
                                                            <label class="form-check-label" for="flashDealToggle"></label>
                                                        </div>
                                                        <small class="text-muted d-block">Enable this to add a flash deal with time duration and discount.</small>
                                                    </div>
                                                </div>

                                                <div id="flashFields" class="mb-4 d-none">
                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Time Duration</label>
                                                        <div class="col-lg-9">
                                                            <div class="d-flex gap-2" style="max-width:560px">
                                                                <input id="flashStart" name="flash_start" type="datetime-local" class="form-control" placeholder="Start date & time" />
                                                                <input id="flashEnd" name="flash_end" type="datetime-local" class="form-control" placeholder="End date & time" />
                                                            </div>
                                                            <small class="text-muted d-block mt-2">Specify the start and end date/time for the flash deal. Both fields are required when adding flash deal details.</small>
                                                        </div>
                                                        <!-- col.// -->
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Discount</label>
                                                        <div class="col-lg-9">
                                                            <div class="d-flex gap-2" style="max-width:420px">
                                                                <input id="flashDiscount" name="flash_discount" type="number" step="0.01" class="form-control" placeholder="Discount amount (e.g., 10)" />
                                                                <select id="flashDiscountType" name="flash_discount_type" class="form-control" style="max-width:160px">
                                                                    <option value="flat">Flat</option>
                                                                    <option value="percent">Percentage</option>
                                                                </select>
                                                            </div>
                                                            <small class="text-muted">Enter discount amount and choose whether it's a flat value or percentage for the flash deal.</small>
                                                        </div>
                                                        <!-- col.// -->
                                                    </div>
                                                </div>

                                                <!-- Modal for selecting refund notes (simple custom modal) -->
                                                <div id="refundModal" class="refund-modal d-none" aria-hidden="true">
                                                    <div class="refund-modal-overlay"></div>
                                                    <div class="refund-modal-dialog">
                                                        <div class="refund-modal-header d-flex justify-content-between align-items-center">
                                                            <h5 class="mb-0">Choose Note</h5>
                                                            <button type="button" id="refundModalClose" class="btn btn-sm btn-light">&times;</button>
                                                        </div>
                                                        <div class="refund-modal-body mt-3">
                                                            <div class="refund-note-cards d-flex gap-3">
                                                                <div class="card refund-note-card p-3" data-note="Thank you for reaching out to us regarding your recent purchase. We're sorry to hear that the product didn't meet your expectations, and we completely understand your request for a refund.">
                                                                    <div class="card-body p-0">
                                                                        <p class="mb-0 text-muted small">Thank you for reaching out to us regarding your recent purchase. We're sorry to hear that the product didn't meet your expectations, and we completely understand your request for a refund.</p>
                                                                    </div>
                                                                </div>
                                                                <div class="card refund-note-card p-3" data-note="We're here to help make this process smooth and hassle-free. Based on our refund policy, we'll review your request and aim to process your refund within [X] business days.">
                                                                    <div class="card-body p-0">
                                                                        <p class="mb-0 text-muted small">We're here to help make this process smooth and hassle-free. Based on our refund policy, we'll review your request and aim to process your refund within [X] business days.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                


                                                

                                                

                                                

                                                

                                                

                                                </div>
                                                <!-- end of general section -->

                                                <!-- Files & Media section (hidden until user clicks nav) -->
                                                <div id="section-files-media" class="d-none">
                                                    <div class="mb-4">
                                                        <h3 class="mb-1">Product Files & Media</h3>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Gallery Images</label>
                                                        <div class="col-lg-9">
                                                            <div class="input-group">
                                                                <input id="galleryImages" name="gallery_images[]" type="file" accept="image/*" multiple class="form-control">
                                                            </div>
                                                            <small class="text-muted d-block mt-2 ">These images are visible in product details page gallery. Minimum dimensions required: 900px width X 900px height.</small>
                                                            <div id="galleryPreview" class="mt-2 d-flex flex-wrap gap-2"></div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Thumbnail Image</label>
                                                        <div class="col-lg-9">
                                                            <div class="input-group">
                                                                <input id="thumbnailImage" name="thumbnail_image" type="file" accept="image/*" class="form-control">
                                                            </div>
                                                            <small class="text-muted d-block mt-2">This image is visible in all product box. Minimum dimensions required: 195px width X 195px height. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive. If no thumbnail is uploaded, the product's first gallery image will be used as the thumbnail image.</small>
                                                            <div id="thumbnailPreview" class="mt-2"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- placeholder sections for other nav items (kept hidden) -->
                                                <div id="section-price-stock" class="d-none">
                                                    <div class="mb-4"><h3 class="mb-1">Price & Stock</h3></div>

                                                    <!-- Colours searchable multi-select (Choices.js) -->
                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Colours</label>
                                                        <div class="col-lg-9">
                                                            <?php
                                                                $defaultColours = ['Red','Blue','Green','Black','White','Yellow','Orange','Purple','Pink','Brown','Gray','Cyan','Magenta'];
                                                                $coloursToShow = isset($colors) && is_iterable($colors) ? $colors : $defaultColours;
                                                            ?>
                                                            <select id="coloursSelect" name="colours[]" multiple class="form-control" aria-label="Select colours">
                                                                <?php foreach($coloursToShow as $c): ?>
                                                                    <?php
                                                                        // Determine value/label and a color hint to be used as swatch.
                                                                        $val = is_object($c) ? ($c->value ?? $c->name ?? (string)$c) : (string)$c;
                                                                        $label = is_object($c) ? ($c->name ?? $c->value ?? (string)$c) : (string)$c;
                                                                        // Try to pick a hex/color property if provided, fallback to label/value (CSS color names or hex expected)
                                                                        $colorHint = is_object($c) ? ($c->hex ?? $c->color ?? $c->hex_code ?? $c->value ?? $c->name ?? (string)$c) : (string)$c;
                                                                    ?>
                                                                    <option value="<?php echo e($val); ?>" data-color="<?php echo e($colorHint); ?>"><?php echo e($label); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Attributes: multi-select & value selectors -->
                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Attributes</label>
                                                        <div class="col-lg-9">
                                                            <select id="attributesSelect" name="attributes[]" multiple class="form-control" aria-label="Select attributes"></select>
                                                            <small class="text-muted d-block mt-0">Choose attributes for this product. After selection, pick one or more values for each attribute to generate variants.</small>
                                                        </div>
                                                    </div>

                                                    <!-- Per-attribute value selectors (rendered dynamically) -->
                                                    <div id="attributes-values-area" class="mb-3 d-none"></div>

                                                    <!-- Pricing mode: same price for all variants or per-variant -->
                                                    <div class="row mb-4 warranty-row">
                                                        <label class="col-lg-3 col-form-label">Pricing Mode</label>
                                                        <div class="col-lg-9">
                                                            <div class="form-check gap-2">
                                                                <input class="form-check-input " type="checkbox" id="useSamePriceToggle" />
                                                                <label class="form-check-label " for="useSamePriceToggle">Use same price for all variants</label>
                                                            </div>

                                                            <div id="globalPriceStock" class="mt-2 d-none">
                                                                <div class="d-flex gap-2" style="max-width:420px">
                                                                    <input id="globalPrice" name="global_price" type="number" step="0.01" class="form-control" placeholder="Price for all variants" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Variants table (generated from selected attribute values) -->
                                                    <div id="variants-section" class="mb-3 d-none">
                                                        <div class="table-responsive">
                                                            <table id="variantsTable" class="table table-sm table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:40px">#</th>
                                                                        <th>Variant</th>
                                                                        <th style="width:160px">SKU</th>
                                                                        <th style="width:140px">Price</th>
                                                                        <th style="width:140px">Stock</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>



                                                    <!-- Discount Date Range removed as requested -->

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Discount *</label>
                                                        <div class="col-lg-9">
                                                            <div class="d-flex gap-2">
                                                                <input name="discount" id="productDiscount" type="number" step="0.01" required class="form-control" placeholder="Discount amount (e.g., 10)" />
                                                                <select name="discount_type" id="productDiscountType" class="form-control" style="max-width:160px">
                                                                    <option value="flat">Flat</option>
                                                                    <option value="percent">Percentage</option>
                                                                </select>
                                                            </div>
                                                            <small class="text-muted">Enter discount amount and choose whether it's a flat value or percentage.</small>
                                                        </div>
                                                    </div>

                                                    <!-- Low Stock Quantity Warning -->
                                                    <div class="mb-4">
                                                        <h4 class="mb-2">Low Stock Quantity Warning</h4>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Quantity</label>
                                                        <div class="col-lg-9">
                                                            <input name="low_stock_quantity" id="lowStockQuantity" type="number" min="0" class="form-control" placeholder="Quantity threshold to trigger low stock warning" />
                                                            <small class="text-muted d-block mt-2">When product stock falls below this number, a low-stock warning will be shown to admins/customers as configured.</small>
                                                        </div>
                                                    </div>

                                                    <!-- Stock Visibility State -->
                                                    <div class="mb-4">
                                                        <h4 class="mb-2">Stock Visibility State</h4>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Stock Visibility</label>
                                                        <div class="col-lg-9">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio" name="stock_visibility" id="stockVisQuantity" value="quantity" checked>
                                                                <label class="form-check-label" for="stockVisQuantity">Show Stock Quantity</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio" name="stock_visibility" id="stockVisTextOnly" value="text_only">
                                                                <label class="form-check-label" for="stockVisTextOnly">Show Stock With Text Only</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio" name="stock_visibility" id="stockVisHidden" value="hidden">
                                                                <label class="form-check-label" for="stockVisHidden">Hide Stock</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                
                                                <!-- SEO section (hidden until user clicks nav) -->
                                                <div id="section-seo" class="d-none">
                                                    <div class="mb-4"><h3 class="mb-1">SEO</h3></div>
                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Meta Title</label>
                                                        <div class="col-lg-9">
                                                            <input name="meta_title" type="text" class="form-control" placeholder="Enter meta title for SEO" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Meta Description</label>
                                                        <div class="col-lg-9">
                                                            <textarea name="meta_description" class="form-control" rows="3" placeholder="Enter meta description for SEO"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Meta Keywords</label>
                                                        <div class="col-lg-9">
                                                            <input name="meta_keywords" type="text" class="form-control" placeholder="Comma separated keywords" />
                                                            <small class="text-muted d-block mt-2">Examples: electronics, phone, smartphone</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="section-shipping" class="d-none">

                                                    <!-- Shipping Configuration -->
                                                    <div class="mb-3"><h4 class="mb-2">Shipping Configuration</h4></div>

                                                    <div class="row mb-4 shipping-row">
                                                        <label class="col-lg-3 col-form-label">Cash On Delivery</label>
                                                        <div class="col-lg-9">
                                                            <div class="form-check form-switch">
                                                                <input type="hidden" name="cash_on_delivery" value="0">
                                                                <input name="cash_on_delivery" class="form-check-input large-toggle" type="checkbox" id="cashOnDeliveryToggle" value="1" aria-label="Cash on delivery toggle">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4 shipping-row">
                                                        <label class="col-lg-3 col-form-label">Free Shipping</label>
                                                        <div class="col-lg-9">
                                                            <div class="form-check form-switch">
                                                                <input type="hidden" name="free_shipping" value="0">
                                                                <input name="free_shipping" class="form-check-input large-toggle" type="checkbox" id="freeShippingToggle" value="1" aria-label="Free shipping toggle">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4 shipping-row">
                                                        <label class="col-lg-3 col-form-label">Flat Rate</label>
                                                        <div class="col-lg-9">
                                                            <div class="form-check form-switch">
                                                                <input type="hidden" name="flat_rate" value="0">
                                                                <input name="flat_rate" class="form-check-input large-toggle" type="checkbox" id="flatRateToggle" value="1" aria-label="Flat rate toggle">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="shippingCostRow" class="row mb-4 d-none">
                                                        <label class="col-lg-3 col-form-label">Shipping cost</label>
                                                        <div class="col-lg-9">
                                                            <input id="shippingCostInput" name="shipping_cost" type="number" min="0" step="0.01" class="form-control" placeholder="0" value="0" />
                                                        </div>
                                                    </div>

                                                    <!-- Estimate Shipping Time -->
                                                    <div class="mb-3 mt-4"><h4 class="mb-2">Estimate Shipping Time</h4></div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Shipping Days</label>
                                                        <div class="col-lg-9">
                                                            <div class="input-group" style="max-width:360px">
                                                                <input id="shippingDaysInput" name="shipping_days" type="number" min="0" class="form-control" placeholder="Shipping Days" />
                                                                <span class="input-group-text">Days</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    
                                                </div>
                                                <div id="section-warranty" class="d-none">
                                                    <div class="mb-4"><h3 class="mb-1">Warranty</h3></div>

                                                    <div class="row mb-4 status-row">
                                                        <label class="col-lg-3 col-form-label">Warranty</label>
                                                        <div class="col-lg-9">
                                                            <!-- hidden field to ensure a value is sent when unchecked -->
                                                            <input type="hidden" name="warranty_enabled" value="0">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input large-toggle" type="checkbox" id="warrantyToggle" name="warranty_enabled" value="1" aria-label="Enable warranty">
                                                            </div>

                                                            <div id="warrantyOptions" class="mt-2 d-none" style="width:100%;">
                                                                <div style="max-width:420px; width:100%;">
                                                                    <select name="warranty_duration" id="warrantyDuration" class="form-select">
                                                                        <option value="">Select warranty duration</option>
                                                                        <option value="3_months">3 Months</option>
                                                                        <option value="6_months">6 Months</option>
                                                                        <option value="1_year">1 Year</option>
                                                                        <option value="2_years">2 Years</option>
                                                                        <option value="3_years">3 Years</option>
                                                                        <option value="5_years">5 Years</option>
                                                                    </select>
                                                                    <small class="text-muted d-block mt-2">Select how long the product warranty lasts. This will be displayed on the product page.</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    

                                                    
                                                </div>

                                                <!-- row.// -->
                                                <br />
                                                <button id="formSubmitBtn" class="btn btn-primary" type="submit">Continue to next</button>
                                                <!-- Consolidated scripts: external libraries and inline behaviors -->
                                                <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
                                                <script>
                                                    /* Refund modal and toggle */
                                                    (function(){
                                                        var toggle = document.getElementById('refundableToggle');
                                                        var section = document.getElementById('refundNoteSection');
                                                        var selectBtn = document.getElementById('selectRefundNoteBtn');
                                                        var modal = document.getElementById('refundModal');
                                                        var modalClose = document.getElementById('refundModalClose');
                                                        var textarea = document.getElementById('refundNoteTextarea');
                                                        var _refundModalOriginalParent = modal ? modal.parentNode : null;
                                                        var _refundModalNextSibling = modal ? modal.nextSibling : null;
                                                        function showModal(){
                                                            document.documentElement.classList.add('modal-open');
                                                            if (modal && modal.parentNode !== document.body) { document.body.appendChild(modal); }
                                                            if (modal) { modal.classList.remove('d-none'); modal.setAttribute('aria-hidden','false'); }
                                                        }
                                                        function closeModal(){
                                                            document.documentElement.classList.remove('modal-open');
                                                            if (modal) {
                                                                modal.classList.add('d-none');
                                                                modal.setAttribute('aria-hidden','true');
                                                                try {
                                                                    if (_refundModalOriginalParent && _refundModalOriginalParent !== document.body) {
                                                                        if (_refundModalNextSibling && _refundModalNextSibling.parentNode === _refundModalOriginalParent) {
                                                                            _refundModalOriginalParent.insertBefore(modal, _refundModalNextSibling);
                                                                        } else { _refundModalOriginalParent.appendChild(modal); }
                                                                    }
                                                                } catch (err) { /* ignore */ }
                                                            }
                                                        }
                                                        if(toggle && section){ toggle.addEventListener('change', function(){ if(toggle.checked) section.classList.remove('d-none'); else section.classList.add('d-none'); }); }
                                                        if(selectBtn){ selectBtn.addEventListener('click', function(){ showModal(); }); }
                                                        if(modalClose){ modalClose.addEventListener('click', function(){ closeModal(); }); }
                                                        if(modal){
                                                            var overlayEl = modal.querySelector('.refund-modal-overlay');
                                                            if (overlayEl) overlayEl.addEventListener('click', function(){ closeModal(); });
                                                            var dialogEl = modal.querySelector('.refund-modal-dialog');
                                                            if (dialogEl) dialogEl.addEventListener('click', function(e){ e.stopPropagation(); });
                                                        }
                                                        var cards = document.querySelectorAll('.refund-note-card');
                                                        cards.forEach(function(card){ card.addEventListener('click', function(){ var note = card.getAttribute('data-note') || card.innerText || ''; if(textarea) textarea.value = note.trim(); closeModal(); }); });
                                                    })();

                                                    /* Category tree toggle (expand/collapse children) */
                                                    (function(){
                                                        var box = document.getElementById('product-category-box');
                                                        if(!box) return;

                                                        function toggleChildren(id){
                                                            try{
                                                                var children = box.querySelector('.children[data-parent="' + id + '"]');
                                                                var btn = box.querySelector('.toggle-btn[data-id="' + id + '"]');
                                                                if(!children) return;
                                                                children.classList.toggle('d-none');
                                                                var expanded = !children.classList.contains('d-none');
                                                                if(btn){ btn.setAttribute('aria-expanded', expanded ? 'true' : 'false'); btn.textContent = expanded ? '-' : '+'; }
                                                            }catch(e){ /* ignore errors */ }
                                                        }

                                                        // Delegate clicks so dynamically-rendered nodes still work
                                                        box.addEventListener('click', function(e){
                                                            var t = e.target;
                                                            if(t && t.classList && t.classList.contains('toggle-btn')){
                                                                var id = t.getAttribute('data-id');
                                                                if(id) toggleChildren(id);
                                                            }
                                                        });

                                                        // If any buttons are pre-expanded via aria-expanded true, ensure state matches
                                                        Array.from(box.querySelectorAll('.toggle-btn')).forEach(function(b){
                                                            var id = b.getAttribute('data-id');
                                                            if(!id) return;
                                                            var children = box.querySelector('.children[data-parent="' + id + '"]');
                                                            if(!children) return;
                                                            var expanded = b.getAttribute('aria-expanded') === 'true';
                                                            if(expanded){ children.classList.remove('d-none'); b.textContent = '-'; } else { children.classList.add('d-none'); b.textContent = '+'; }
                                                        });
                                                    })();

                                                    /* Category selection: when a child is chosen as main (radio), auto-select its ancestors
                                                       Creates hidden inputs named categories[] so values submit while visible checkboxes remain disabled */
                                                    (function(){
                                                        var box = document.getElementById('product-category-box');
                                                        var theForm = document.querySelector('form');
                                                        if(!box || !theForm) return;

                                                        function clearGeneratedHidden(){
                                                            var olds = theForm.querySelectorAll('input[data-generated-by="cat-js"]');
                                                            olds.forEach(function(i){ i.parentNode && i.parentNode.removeChild(i); });
                                                        }

                                                        function setCheckboxVisual(id, checked){
                                                            var cb = box.querySelector('input.controlled-cat-checkbox[value="' + id + '"]');
                                                            if(cb) cb.checked = !!checked;
                                                        }

                                                        function addHiddenFor(id){
                                                            // prevent duplicates
                                                            var exists = theForm.querySelector('input[type="hidden"][name="categories[]"][value="' + id + '"][data-generated-by="cat-js"]');
                                                            if(exists) return;
                                                            var inp = document.createElement('input');
                                                            inp.type = 'hidden';
                                                            inp.name = 'categories[]';
                                                            inp.value = id;
                                                            inp.setAttribute('data-generated-by', 'cat-js');
                                                            theForm.appendChild(inp);
                                                        }

                                                        function pickAncestorsAndSelf(startId){
                                                            // uncheck all visuals and remove previously generated hidden inputs
                                                            Array.from(box.querySelectorAll('input.controlled-cat-checkbox')).forEach(function(cb){ cb.checked = false; });
                                                            clearGeneratedHidden();

                                                            var id = String(startId);
                                                            while(id && id !== '0'){
                                                                // mark visual
                                                                setCheckboxVisual(id, true);
                                                                // add hidden input to submit
                                                                addHiddenFor(id);
                                                                // find parent id from the checkbox element
                                                                var cb = box.querySelector('input.controlled-cat-checkbox[value="' + id + '"]');
                                                                if(!cb) break;
                                                                var pid = cb.getAttribute('data-parent');
                                                                if(!pid) break;
                                                                id = String(pid);
                                                            }
                                                        }

                                                        // delegate change events from radios (main-radio)
                                                        box.addEventListener('change', function(e){
                                                            var t = e.target;
                                                            if(!t) return;
                                                            if(t.classList && t.classList.contains('main-radio')){
                                                                if(t.checked){
                                                                    pickAncestorsAndSelf(t.value);
                                                                }
                                                            }
                                                        });

                                                        // Initialize: if a radio is pre-checked, apply selection
                                                        var pre = box.querySelector('input.main-radio:checked');
                                                        if(pre) pickAncestorsAndSelf(pre.value);
                                                    })();

                                                    /* Flash deal toggle visibility */
                                                    (function(){
                                                        var flashDealToggle = document.getElementById('flashDealToggle');
                                                        var flashFields = document.getElementById('flashFields');
                                                        if (flashDealToggle && flashFields) {
                                                            flashDealToggle.addEventListener('change', function(){ if(flashDealToggle.checked) flashFields.classList.remove('d-none'); else flashFields.classList.add('d-none'); });
                                                        }
                                                    })();

                                                    /* Flash deal validation on submit */
                                                    (function(){
                                                        var flashFields = document.getElementById('flashFields');
                                                        var discountInput = document.getElementById('flashDiscount');
                                                        var discountType = document.getElementById('flashDiscountType');
                                                        var form = document.querySelector('form');
                                                        if (form) {
                                                            form.addEventListener('submit', function(e){
                                                                var startEl = document.getElementById('flashStart');
                                                                var endEl = document.getElementById('flashEnd');
                                                                var startVal = startEl ? startEl.value : '';
                                                                var endVal = endEl ? endEl.value : '';
                                                                var discountVal = discountInput ? parseFloat(discountInput.value || '0') : 0;
                                                                var dtype = discountType ? discountType.value : 'flat';
                                                                var anyFilled = (startVal && startVal.length) || (endVal && endVal.length) || (discountInput && discountInput.value && discountInput.value !== '');
                                                                if (!anyFilled) return true;
                                                                if (!startVal || !endVal) { e.preventDefault(); alert('Please set both start and end date/time for the flash deal.'); return false; }
                                                                var sDt = new Date(startVal); var eDt = new Date(endVal);
                                                                if (isNaN(sDt.getTime()) || isNaN(eDt.getTime()) || sDt >= eDt) { e.preventDefault(); alert('Please ensure the start date/time is before the end date/time.'); return false; }
                                                                if (isNaN(discountVal) || discountVal <= 0) { e.preventDefault(); alert('Please enter a discount greater than 0 for Flash Deal.'); return false; }
                                                                if (dtype === 'percent' && discountVal > 100) { e.preventDefault(); alert('Percent discount cannot exceed 100%.'); return false; }
                                                            });
                                                        }
                                                    })();

                                                    /* Nav switching + file previews */
                                                    (function(){
                                                        var navLinks = document.querySelectorAll('nav.nav a[data-target]');
                                                        function clearActive(){ navLinks.forEach(function(a){ a.classList.remove('active'); }); }
                                                        navLinks.forEach(function(a){ a.addEventListener('click', function(ev){ ev.preventDefault(); var target = a.getAttribute('data-target'); if(!target) return; clearActive(); a.classList.add('active'); var sections = document.querySelectorAll('form > div[id^="section-"]'); sections.forEach(function(s){ s.classList.add('d-none'); }); var el = document.querySelector(target); if(el) el.classList.remove('d-none'); }); });

                                                        function readAndPreview(file, container, isThumbnail){ var reader = new FileReader(); reader.onload = function(e){ var img = document.createElement('img'); img.src = e.target.result; img.style.maxWidth = isThumbnail ? '120px' : '80px'; img.style.maxHeight = isThumbnail ? '120px' : '80px'; img.style.objectFit = 'cover'; img.style.borderRadius = '6px'; img.style.border = '1px solid #e9ecef'; img.style.marginRight = '8px'; container.appendChild(img); }; reader.readAsDataURL(file); }

                                                        function bindFilePreviews(){ var galleryInput = document.getElementById('galleryImages'); var galleryPreview = document.getElementById('galleryPreview'); if(galleryInput){ galleryInput.addEventListener('change', function(){ if(!galleryPreview) return; galleryPreview.innerHTML = ''; Array.from(galleryInput.files).slice(0,12).forEach(function(file){ if(!file.type.match('image.*')) return; readAndPreview(file, galleryPreview, false); }); }); }
                                                            var thumbInput = document.getElementById('thumbnailImage'); var thumbPreview = document.getElementById('thumbnailPreview'); if(thumbInput){ thumbInput.addEventListener('change', function(){ if(!thumbPreview) return; thumbPreview.innerHTML = ''; var file = thumbInput.files[0]; if(!file) return; if(!file.type.match('image.*')) return; readAndPreview(file, thumbPreview, true); }); } }

                                                        if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', function(){ bindFilePreviews(); var activeLink = document.querySelector('nav.nav a.active[data-target]'); if(activeLink){ var t = activeLink.getAttribute('data-target'); var targetEl = document.querySelector(t); if(targetEl) targetEl.classList.remove('d-none'); } }); } else { bindFilePreviews(); var activeLink = document.querySelector('nav.nav a.active[data-target]'); if(activeLink){ var t = activeLink.getAttribute('data-target'); var targetEl = document.querySelector(t); if(targetEl) targetEl.classList.remove('d-none'); } }
                                                    })();

                                                    /* Choices dropdown decoration for coloursSelect */
                                                    (function(){
                                                        var select = document.getElementById('coloursSelect');
                                                        if(!select) return;
                                                        try{
                                                            var choices = new Choices(select, { removeItemButton: true, searchEnabled: true, placeholderValue: 'Select colours', searchPlaceholderValue: 'Type to search colours', shouldSort: false, itemSelectText: '' });
                                                            function createSwatch(color){ var el = document.createElement('span'); el.className = 'colour-swatch'; el.style.backgroundColor = color || 'transparent'; el.setAttribute('aria-hidden','true'); return el; }
                                                            function decorateChoices(){ var dropdownItems = document.querySelectorAll('.choices__list--dropdown .choices__item'); dropdownItems.forEach(function(item){ if(item.querySelector('.colour-swatch')) return; var val = item.getAttribute('data-value'); if(!val) return; var opt = select.querySelector('option[value="'+CSS.escape(val)+'"]'); var color = opt ? opt.getAttribute('data-color') : null; if(color){ var sw = createSwatch(color); item.insertBefore(sw, item.firstChild); } });
                                                                var selectedItems = document.querySelectorAll('.choices__list--multiple .choices__item'); selectedItems.forEach(function(item){ if(item.querySelector('.colour-swatch')) return; var val = item.getAttribute('data-value'); if(!val) return; var opt = select.querySelector('option[value="'+CSS.escape(val)+'"]'); var color = opt ? opt.getAttribute('data-color') : null; if(color){ var sw = createSwatch(color); item.insertBefore(sw, item.firstChild); } }); }
                                                            setTimeout(decorateChoices, 50);
                                                            select.addEventListener('change', function(){ setTimeout(decorateChoices,30); });
                                                            if(choices && typeof choices.passedElement === 'object'){ try{ choices.passedElement.element.addEventListener('choice', function(){ setTimeout(decorateChoices,30); }); } catch(e){ } }
                                                            document.addEventListener('click', function(e){ setTimeout(decorateChoices,120); });
                                                        } catch (e) { console.warn('Choices initialization failed for coloursSelect', e); }
                                                    })();

                                                    /* Attributes -> values -> variants generator */
                                                    (function(){
                                                        var attributesSelect = document.getElementById('attributesSelect');
                                                        var attributesValuesArea = document.getElementById('attributes-values-area');
                                                        var variantsSection = document.getElementById('variants-section');
                                                        var variantsTableBody = document.querySelector('#variantsTable tbody');
                                                        var coloursSelect = document.getElementById('coloursSelect');
                                                        var useSamePriceToggle = document.getElementById('useSamePriceToggle');
                                                        var globalPriceInput = document.getElementById('globalPrice');
                                                        var attributesData = [];
                                                        var attributesChoices = null;
                                                        if(!attributesSelect) return;
                                                        async function loadAttributes(){ try{ var res = await fetch('/admin/attributes/data', { headers: { 'Accept': 'application/json' }}); if(!res.ok) return; attributesData = await res.json(); populateAttributesSelect(); } catch(err){ console.error('Failed to load attributes', err); } }
                                                        function populateAttributesSelect(){ attributesSelect.innerHTML = ''; attributesData.forEach(function(a){ var opt = document.createElement('option'); opt.value = a.id; opt.text = a.name || ('Attribute '+a.id); attributesSelect.appendChild(opt); }); try{ if(attributesChoices){ attributesChoices.destroy(); } attributesChoices = new Choices(attributesSelect, { removeItemButton: true, searchEnabled: true, placeholderValue: 'Select attributes', itemSelectText: '' }); } catch(e){ console.warn('Choices init failed for attributesSelect', e); } attributesSelect.addEventListener('change', onAttributesChange); if(coloursSelect){ coloursSelect.addEventListener('change', buildVariants); } }
                                                        function onAttributesChange(){ var selected = Array.from(attributesSelect.selectedOptions).map(function(o){ return parseInt(o.value); }); renderAttributeValueSelectors(selected); }
                                                        function renderAttributeValueSelectors(selectedIds){ attributesValuesArea.innerHTML = ''; if(!selectedIds || selectedIds.length === 0){ attributesValuesArea.classList.add('d-none'); clearVariants(); return; } attributesValuesArea.classList.remove('d-none'); selectedIds.forEach(function(id){ var attr = attributesData.find(function(x){ return x.id == id; }); if(!attr) return; var row = document.createElement('div'); row.className = 'row mb-3'; var label = document.createElement('label'); label.className = 'col-lg-3 col-form-label'; label.textContent = attr.name || ''; var col = document.createElement('div'); col.className = 'col-lg-9'; var sel = document.createElement('select'); sel.setAttribute('data-attribute-id', attr.id); sel.className = 'form-control attr-values-select'; sel.multiple = true; (attr.values || []).forEach(function(v){ var o = document.createElement('option'); o.value = v.id; o.text = v.value; sel.appendChild(o); }); col.appendChild(sel); row.appendChild(label); row.appendChild(col); attributesValuesArea.appendChild(row); try{ new Choices(sel, { removeItemButton: true, searchEnabled: true, placeholderValue: 'Select values', itemSelectText: '' }); } catch(e){ } sel.addEventListener('change', buildVariants); }); buildVariants(); }
                                                        function buildVariants(){ var selects = Array.from(document.querySelectorAll('.attr-values-select')); var lists = []; var meta = []; if(coloursSelect){ var chosenColours = Array.from(coloursSelect.selectedOptions).map(function(o){ return { id: o.value, label: o.text || o.value }; }); if(chosenColours.length > 0){ lists.push(chosenColours); meta.push({ id: 'colour', name: 'Colour' }); } } for(var i=0;i<selects.length;i++){ var s = selects[i]; var chosen = Array.from(s.selectedOptions).map(function(o){ return { id: o.value, label: o.text }; }); if(chosen.length === 0){ clearVariants(); return; } lists.push(chosen); var label = s.closest('.row').querySelector('label').textContent || ''; meta.push({ id: s.getAttribute('data-attribute-id'), name: label }); } var combos = cartesian(lists); renderVariantsTable(combos, meta); }
                                                        function cartesian(arr){ if(!arr || arr.length === 0) return []; return arr.reduce(function(a,b){ return a.flatMap(function(x){ return b.map(function(y){ return x.concat([y]); }); }); }, [[]]); }
                                                        function renderVariantsTable(combos, meta){
                                                            variantsTableBody.innerHTML = '';
                                                            if(!combos || combos.length === 0){ clearVariants(); return; }
                                                            variantsSection.classList.remove('d-none');
                                                            combos.forEach(function(combo, idx){
                                                                var variantText = combo.map(function(c){ return c.label; }).join('/');
                                                                // build hidden inputs for attribute -> value mapping
                                                                var hiddenInputs = '';
                                                                try{
                                                                    for(var i=0;i<combo.length;i++){
                                                                        var m = meta[i] || {};
                                                                        var item = combo[i] || {};
                                                                        if(!m.id) continue;
                                                                        if(m.id === 'colour'){
                                                                            // colours: allow multiple colour values per variant (store as array)
                                                                            hiddenInputs += '<input type="hidden" name="variants['+idx+'][values][colour][]" value="'+ (item.id || '') +'">';
                                                                        } else if(!isNaN(Number(m.id))){
                                                                            // attribute id -> attribute value id
                                                                            hiddenInputs += '<input type="hidden" name="variants['+idx+'][values]['+ m.id +']" value="'+ (item.id || '') +'">';
                                                                        }
                                                                    }
                                                                }catch(e){ /* ignore */ }

                                                                var rowHtml = '';
                                                                rowHtml += '<td>' + (idx+1) + '</td>';
                                                                rowHtml += '<td>' + escapeHtml(variantText) + '</td>';
                                                                rowHtml += '<td><input type="text" name="variants['+idx+'][sku]" class="form-control" placeholder="SKU" /></td>';
                                                                rowHtml += '<td><input type="number" step="0.01" name="variants['+idx+'][price]" class="form-control variant-price-input" /></td>';
                                                                rowHtml += '<td><input type="number" name="variants['+idx+'][stock]" class="form-control" /></td>';
                                                                rowHtml += hiddenInputs;

                                                                var tr = document.createElement('tr');
                                                                tr.innerHTML = rowHtml;
                                                                variantsTableBody.appendChild(tr);
                                                            });
                                                            applyPricingModeToRows();
                                                        }
                                                        function applyPricingModeToRows(){ var useSame = useSamePriceToggle ? useSamePriceToggle.checked : false; var priceVal = globalPriceInput ? globalPriceInput.value : ''; var priceInputs = Array.from(document.querySelectorAll('.variant-price-input')); priceInputs.forEach(function(inp){ if(useSame){ if(priceVal !== '') inp.value = priceVal; inp.readOnly = true; } else { inp.readOnly = false; } }); var globalArea = document.getElementById('globalPriceStock'); if(globalArea){ if(useSame) globalArea.classList.remove('d-none'); else globalArea.classList.add('d-none'); } }
                                                        if(useSamePriceToggle){ useSamePriceToggle.addEventListener('change', function(){ applyPricingModeToRows(); }); }
                                                        if(globalPriceInput){ globalPriceInput.addEventListener('input', function(){ if(useSamePriceToggle && useSamePriceToggle.checked) applyPricingModeToRows(); }); }
                                                        function clearVariants(){ variantsTableBody.innerHTML = ''; variantsSection.classList.add('d-none'); }
                                                        function escapeHtml(str){ return String(str).replace(/[&<>'"`]/g, function(m){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#x60;'}[m]); }); }
                                                        loadAttributes();
                                                    })();

                                                    /* Shipping visibility */
                                                    (function(){
                                                        var flatToggle = document.getElementById('flatRateToggle');
                                                        var freeToggle = document.getElementById('freeShippingToggle');
                                                        var costRow = document.getElementById('shippingCostRow');
                                                        function updateShippingVisibility(){ if(freeToggle && flatToggle && freeToggle.checked && flatToggle.checked){ freeToggle.checked = false; } if(freeToggle && freeToggle.checked){ if(costRow) costRow.classList.add('d-none'); return; } if(flatToggle && flatToggle.checked){ if(costRow) costRow.classList.remove('d-none'); } else { if(costRow) costRow.classList.add('d-none'); } }
                                                        if(flatToggle) flatToggle.addEventListener('change', function(){ if(flatToggle.checked && freeToggle) freeToggle.checked = false; updateShippingVisibility(); });
                                                        if(freeToggle) freeToggle.addEventListener('change', function(){ if(freeToggle.checked && flatToggle) flatToggle.checked = false; updateShippingVisibility(); });
                                                        if(document.readyState === 'loading'){ document.addEventListener('DOMContentLoaded', updateShippingVisibility); } else { updateShippingVisibility(); }
                                                    })();

                                                    /* Warranty visibility */
                                                    (function(){ var toggle = document.getElementById('warrantyToggle'); var options = document.getElementById('warrantyOptions'); if(!toggle || !options) return; function updateVisibility(){ if(toggle.checked){ options.classList.remove('d-none'); } else { options.classList.add('d-none'); } } if(document.readyState === 'loading'){ document.addEventListener('DOMContentLoaded', updateVisibility); } else { updateVisibility(); } toggle.addEventListener('change', updateVisibility); })();

                                                    /* Submit button label updater */
                                                    (function(){ var submitBtn = document.getElementById('formSubmitBtn'); if(!submitBtn) return; function updateSubmitLabel(){ var warrantySection = document.getElementById('section-warranty'); if(warrantySection && !warrantySection.classList.contains('d-none')){ submitBtn.textContent = 'Publish'; } else { submitBtn.textContent = 'Continue to next'; } } updateSubmitLabel(); document.addEventListener('click', function(e){ var link = e.target.closest('nav.nav a[data-target]'); if(link){ setTimeout(updateSubmitLabel, 40); } }); var theForm = document.querySelector('form'); if(theForm && window.MutationObserver){ var mo = new MutationObserver(function(){ updateSubmitLabel(); }); mo.observe(theForm, { attributes: true, subtree: true, attributeFilter: ['class'] }); } })();
                                                </script>
                                            </form>
                                        </section>
                                        <!-- content-body .// -->
                                    </div>
                                    <!-- col.// -->
                                </div>
                                <!-- row.// -->
                            </div>
                            <!-- card body end// -->
                        </div>
                    </div>
                </div>

@endsection