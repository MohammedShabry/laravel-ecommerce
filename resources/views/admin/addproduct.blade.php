@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

                <div class="row">
                    <div class="col-9">
                        <div class="content-header">
                            <h2 class="content-title">Add New Product</h2>
                            <div>
                                <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>
                                <button class="btn btn-md rounded font-sm hover-up">Publich</button>
                            </div>
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
                                            <form enctype="multipart/form-data">
                                                <!-- General section (hidden by default; JS will show active tab) -->
                                                <div id="section-general" class="d-none">
                                                    <div class="mb-4">
                                                        <h3 class="mb-1">Product information</h3>
                                                    </div>
                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Product name*</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" placeholder="Type here" />
                                                    </div>
                                                    <!-- col.// -->
                                                    <script>
                                                        (function(){
                                                            function initCategoryPanel(){
                                                                var radios = document.querySelectorAll('#product-category-box .main-radio');
                                                                var checks = document.querySelectorAll('#product-category-box .category-checkbox');

                                                                // remember last selected main category so we can update checkboxes
                                                                var lastMainId = null;

                                                                // helper: get checkbox element by id
                                                                function getCb(id){ return document.getElementById('catCheck-' + id); }

                                                                // hidden-input management: create/remove hidden inputs named categories[]
                                                                function ensureHiddenFor(id){
                                                                    var hidId = 'catHidden-' + id;
                                                                    if(document.getElementById(hidId)) return;
                                                                    var h = document.createElement('input');
                                                                    h.type = 'hidden';
                                                                    h.name = 'categories[]';
                                                                    h.value = id;
                                                                    h.id = hidId;
                                                                    // append near the category box so it's inside the form
                                                                    var box = document.getElementById('product-category-box');
                                                                    if(box && box.parentNode){ box.appendChild(h); }
                                                                    else { document.body.appendChild(h); }
                                                                }

                                                                function removeHiddenFor(id){
                                                                    var hid = document.getElementById('catHidden-' + id);
                                                                    if(hid) hid.remove();
                                                                }

                                                                // helper: return true if candidateAncestor is an ancestor of nodeId
                                                                function isAncestor(candidateAncestor, nodeId){
                                                                    if(!candidateAncestor || !nodeId) return false;
                                                                    var cur = nodeId + '';
                                                                    while(true){
                                                                        var cb = getCb(cur);
                                                                        if(!cb) break;
                                                                        var p = cb.getAttribute('data-parent');
                                                                        if(!p || p === '0') break;
                                                                        if(p + '' === candidateAncestor + '') return true;
                                                                        cur = p + '';
                                                                    }
                                                                    return false;
                                                                }

                                                                // helper: return true if any checked checkbox exists in the subtree of nodeId
                                                                function hasCheckedDescendant(nodeId){
                                                                    var boxes = document.querySelectorAll('#product-category-box .category-checkbox');
                                                                    for(var i=0;i<boxes.length;i++){
                                                                        var b = boxes[i];
                                                                        if(!b.checked) continue;
                                                                        var cur = b.value + '';
                                                                        while(true){
                                                                            var cb = getCb(cur);
                                                                            if(!cb) break;
                                                                            var p = cb.getAttribute('data-parent');
                                                                            if(!p || p === '0') break;
                                                                            if(p + '' === nodeId + '') return true;
                                                                            cur = p + '';
                                                                        }
                                                                    }
                                                                    return false;
                                                                }

                                                                // check a node and all its ancestors (and expand parents)
                                                                function checkWithAncestors(id){
                                                                    try{
                                                                        var currentId = id + '';
                                                                        while(true){
                                                                            var curCb = getCb(currentId);
                                                                            if(!curCb) break;
                                                                            // set the visible (disabled) checkbox state for visual consistency
                                                                            curCb.checked = true;
                                                                            // ensure a hidden input exists so the category will be submitted
                                                                            ensureHiddenFor(currentId);
                                                                            var parent = curCb.getAttribute('data-parent');
                                                                            if(!parent || parent === '0' || parent === null) break;
                                                                            // expand parent container and toggle button
                                                                            var container = document.querySelector('#product-category-box .children[data-parent="' + parent + '"]');
                                                                            var toggleBtn = document.querySelector('#product-category-box .toggle-btn[data-id="' + parent + '"]');
                                                                            if(container && container.classList.contains('d-none')) container.classList.remove('d-none');
                                                                            if(toggleBtn){ toggleBtn.textContent = '\u2212'; toggleBtn.setAttribute('aria-expanded','true'); }
                                                                            currentId = parent + '';
                                                                        }
                                                                    } catch(e) { /* ignore */ }
                                                                }

                                                                // uncheck a node and walk up attempting to uncheck ancestors when safe
                                                                function uncheckPreviousPath(prevId, newId){
                                                                    try{
                                                                        var cur = prevId + '';
                                                                        // uncheck the previous node itself
                                                                        var prevCb = getCb(cur);
                                                                        if(prevCb){ prevCb.checked = false; removeHiddenFor(cur); }

                                                                        while(true){
                                                                            var cb = getCb(cur);
                                                                            if(!cb) break;
                                                                            var parent = cb.getAttribute('data-parent');
                                                                            if(!parent || parent === '0' || parent === null) break;
                                                                            var parentCb = getCb(parent);
                                                                            if(!parentCb) break;
                                                                            // if the parent is an ancestor of the new selected node, keep it
                                                                            if(newId && isAncestor(parent, newId)) break;
                                                                            // if any other checked descendant exists under this parent, keep it
                                                                            if(hasCheckedDescendant(parent)) break;
                                                                            // safe to uncheck
                                                                            parentCb.checked = false;
                                                                            removeHiddenFor(parent);
                                                                            cur = parent + '';
                                                                        }
                                                                    } catch(e){ /* ignore */ }
                                                                }

                                                                radios.forEach(function(r){
                                                                    r.addEventListener('change', function(){
                                                                        if(!this.checked) return;
                                                                        var id = this.value + '';

                                                                        // if there was a previous main selection different than current, try to clear it
                                                                        if(lastMainId && lastMainId !== id){
                                                                            uncheckPreviousPath(lastMainId, id);
                                                                        }

                                                                        // ensure current and its ancestors are checked and visible
                                                                        checkWithAncestors(id);

                                                                        lastMainId = id;
                                                                    });
                                                                });

                                                                // On init: make visible checkboxes non-interactive and ensure hidden inputs exist for any server-checked boxes
                                                                checks.forEach(function(cb){
                                                                    // remove name if present and keep disabled — hidden inputs carry submit values
                                                                    if(cb.hasAttribute('name')) cb.removeAttribute('name');
                                                                    cb.disabled = true;
                                                                    // if server rendered a checked state, ensure hidden input exists
                                                                    if(cb.checked){ ensureHiddenFor(cb.value); }
                                                                });

                                                                // initialize lastMainId from any server-rendered checked radio
                                                                var initiallyChecked = document.querySelector('#product-category-box .main-radio:checked');
                                                                if(initiallyChecked) lastMainId = initiallyChecked.value + '';

                                                            // Toggle expand/collapse buttons
                                                            function bindToggleButtons(){
                                                                var toggles = document.querySelectorAll('#product-category-box .toggle-btn');
                                                                toggles.forEach(function(btn){
                                                                    // avoid double-binding
                                                                    if (btn._bound) return; btn._bound = true;
                                                                    btn.addEventListener('click', function(){
                                                                        var id = btn.getAttribute('data-id');
                                                                        var container = document.querySelector('#product-category-box .children[data-parent="' + id + '"]');
                                                                        if(!container) return;
                                                                        var expanded = btn.getAttribute('aria-expanded') === 'true';
                                                                        if(expanded){
                                                                            container.classList.add('d-none');
                                                                            btn.textContent = '+';
                                                                            btn.setAttribute('aria-expanded','false');
                                                                        } else {
                                                                            container.classList.remove('d-none');
                                                                            btn.textContent = '\u2212'; // minus sign
                                                                            btn.setAttribute('aria-expanded','true');
                                                                        }
                                                                    });
                                                                });
                                                            }

                                                            // bind immediately and on DOM changes
                                                            bindToggleButtons();

                                                                checks.forEach(function(cb){
                                                                    cb.addEventListener('change', function(){
                                                                        // If a category checkbox is unchecked and it was the main, clear the main radio
                                                                        if(!this.checked){
                                                                            var main = document.querySelector('#product-category-box .main-radio[value="' + this.value + '"]');
                                                                            if(main && main.checked){ main.checked = false; }
                                                                        }
                                                                    });
                                                                });
                                                                // re-bind toggles in case nodes were added dynamically
                                                                if(document.readyState !== 'loading') bindToggleButtons();
                                                            }

                                                            if(document.readyState === 'loading'){
                                                                document.addEventListener('DOMContentLoaded', initCategoryPanel);
                                                            } else { initCategoryPanel(); }
                                                        })();
                                                    </script>
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

                                                    <style>
                                                        /* Make category expand/collapse sign unboxed */
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
                                                    </style>

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
                                                        <input type="text" class="form-control" placeholder="Type here" />
                                                    </div>
                                                    <!-- col.// -->
                                                </div>

                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Weight (In Kg)</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" placeholder="Type here" />
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
                                                        <textarea class="form-control" placeholder="Type here" rows="4"></textarea>
                                                    </div>
                                                    <!-- col.// -->
                                                </div>


                                                <!-- row.// -->
                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Related tags</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" placeholder="Type" />
                                                    </div>
                                                    <!-- col.// -->
                                                </div>

                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Bar Code</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" placeholder="Type here" />
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
                                                            <input class="form-check-input large-toggle" type="checkbox" id="refundableToggle" aria-label="Refundable toggle">
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
                                                            <input class="form-check-input large-toggle" type="checkbox" id="featuredToggle" aria-label="Featured toggle">
                                                        </div>
                                                        <small class="text-muted font-sm">Mark this product as featured on the homepage.</small>
                                                    </div>
                                                </div>

                                                <div class="row mb-4 status-row">
                                                    <label class="col-lg-3 col-form-label">Todays Deal</label>
                                                    <div class="col-lg-9">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input large-toggle" type="checkbox" id="todaysDealToggle" aria-label="Today's Deal toggle">
                                                        </div>
                                                        <small class="text-muted font-sm">Enable if this product is part of today's special deals.</small>
                                                    </div>
                                                </div>

                                                <!-- Flash Deal subtopic (fields shown directly) -->
                                                <div class="mb-4">
                                                    <h3 class="mb-1">Flash Deal</h3>
                                                </div>

                                                <div id="flashFields" class="mb-4">
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

                                                <style>
    /* --- FIX ALIGNMENT FOR REFUND TOGGLE --- */
    /* Keep the toggle aligned with other inputs, but avoid moving the label
       when the note appears. Allow the right column to expand while the
       left label column stays a fixed minimum height so the label remains
       visually stationary. */
    .refund-row {
        /* allow right column to grow without re-centering the left label */
        align-items: flex-start;
    }

    /* Keep the label column a fixed minimum height and vertically center the
       label inside that box so it doesn't move when the right side expands. */
    .refund-row .col-lg-3 {
        display: flex;
        align-items: center;
        min-height: 48px; /* matches typical input row height */
        padding-top: 0;
    }

    /* Make the right column a normal block so the switch sits at the same left edge
       as other inputs and the note stacks below the switch instead of beside it. */
    .refund-row .col-lg-9 {
        display: block;
        padding-top: 0;
    }

    /* Ensure the toggle itself sits vertically centered in a fixed-height area
       so it lines up with the label (which has the same min-height). The refund
       note lives below this area and won't push the label/toggle around. */
    .refund-row .col-lg-9 > .form-check {
        min-height: 48px; /* match label column height */
        display: flex;
        align-items: center;
    }

    /* Keep the switch itself inline and vertically centered */
    .form-check.form-switch {
        padding-left: 0;
        margin: 0;
        display: inline-flex;
        align-items: center;
    }

    .form-check-input.large-toggle {
        transform: scale(1.2);
        transform-origin: left center;
        margin-top: 0; /* remove Bootstrap offset */
        margin-left: 0;
    }

    /* Make shipping toggles match the general (large) toggle appearance and alignment.
       Many shipping switches are rendered with the same Bootstrap classes but lack the
       "large-toggle" helper class — normalize them here so they visually match. */
    .shipping-row .form-check.form-switch {
        padding-left: 0;
        margin: 0;
        display: inline-flex;
        align-items: center;
    }

    /* Scale shipping inputs slightly to match other big toggles and remove top offset */
    .shipping-row .form-check-input,
    .shipping-row .form-check-input[type="checkbox"] {
        transform: scale(1.15);
        transform-origin: left center;
        margin-top: 0;
        margin-left: 0;
    }

    /* If markup includes explicit large-toggle on shipping, ensure consistent scale */
    .shipping-row .form-check-input.large-toggle {
        transform: scale(1.2);
        transform-origin: left center;
    }

    /* --- ALIGNMENT FOR STATUS TOGGLES (Featured / Today's Deal) --- */
    .status-row {
        align-items: flex-start;
    }

    .status-row .col-lg-3 {
        display: flex;
        align-items: center;
        min-height: 30px; /* match other input height */
        padding-top: 0;
    }

    /* Make the right column a vertical stack so the switch and the small detail
       are visually grouped and sit close together. Use a small gap to reduce
       vertical space between the toggle and the detail text. */
    .status-row .col-lg-9 {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-top: 0;
        gap: 1px; /* tightened space between toggle and small detail */
    }

    .status-row .col-lg-9 > .form-check {
        min-height: 30px; /* slightly smaller to tighten vertical spacing */
        display: flex;
        align-items: center;
    }

    /* --- ALIGNMENT FOR SHIPPING TOGGLES (Cash On Delivery / Free Shipping / Flat Rate) --- */
    .shipping-row {
        align-items: flex-start;
    }

    .shipping-row .col-lg-3 {
        display: flex;
        align-items: center;
        min-height: 30px; /* match other input height */
        padding-top: 0;
    }

    .shipping-row .col-lg-9 {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-top: 0;
        gap: 1px;
    }

    .shipping-row .col-lg-9 > .form-check {
        min-height: 30px;
        display: flex;
        align-items: center;
    }

    /* Ensure the small detail text sits directly below the toggle and use a
       slightly smaller font-size to make the block more compact. */
    .status-row .col-lg-9 small {
        display: block;
        margin-top: 0;
        font-size: 0.6rem; /* smaller detail text */
        line-height: 1.2;
        color: #6c757d;
    }

    /* ensure refund note section appears below toggle with correct margin and full width */
    #refundNoteSection {
        width: 100%;
        margin-top: 12px;
        display: block;
    }

    /* modal styles (updated) */
    /* Make the modal overlay cover entire viewport and capture pointer events so underlying
       sidebar/header can't receive hover/mouse events while modal is open. Increase
       z-index to be above other layout elements. */
    .refund-modal {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999; /* very high so it sits above sidebar/header */
        pointer-events: auto; /* allow clicks on overlay/dialog */
    }
    .refund-modal.d-none { display: none; pointer-events: none; }
    /* Overlay sits under the dialog but above everything else and blocks pointer events */
    .refund-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 9998;
        pointer-events: auto; /* capture pointer events */
    }
    /* Dialog should be above the overlay and able to receive clicks; stop pointer events from propagating */
    .refund-modal-dialog {
        position: relative;
        background: #fff;
        width: 90%;
        max-width: 760px;
        border-radius: 6px;
        padding: 20px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        z-index: 9999;
        pointer-events: auto;
    }
    .refund-note-cards { display: flex; flex-wrap: wrap; }
    .refund-note-card { cursor: pointer; border: 1px solid #e9ecef; border-radius: 6px; width: calc(50% - 8px); }
    .refund-note-card:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.06); transform: translateY(-2px); }

    /* Reduce default <small> font size in this view to make helper/detail text more compact
       Scoped for this blade file (applies globally within this template). Adjust value as needed. */
    small {
        font-size: 0.72rem; /* smaller than Bootstrap default ~0.875rem */
        line-height: 1.2;
        color: #6c757d; /* keep typical muted color for small details */
    }

    /* Reduce vertical gap between form fields and their helper <small> text.
       Target the right-side column (.col-lg-9) so helper text sits closer to
       the related input/select/switch. Use !important so utility classes like
       `mt-2` are overridden in this template. */
    .col-lg-9 small {
        display: block;
        margin-top: 4px !important; /* tighten space (approx 0.25rem) */
        margin-bottom: 0 !important;
    }

    /* If a small tag used a large bottom margin utility (e.g. mb-10), make it modest here */
    .col-lg-9 small.mb-10 {
        margin-bottom: 4px !important;
    }
</style>


                                                <script>
                                                    (function(){
                                                        var toggle = document.getElementById('refundableToggle');
                                                        var section = document.getElementById('refundNoteSection');
                                                        var selectBtn = document.getElementById('selectRefundNoteBtn');
                                                        var modal = document.getElementById('refundModal');
                                                        var modalClose = document.getElementById('refundModalClose');
                                                        var textarea = document.getElementById('refundNoteTextarea');

                                                        // keep reference to the modal's original parent so we can restore later
                                                        var _refundModalOriginalParent = modal ? modal.parentNode : null;
                                                        var _refundModalNextSibling = modal ? modal.nextSibling : null;

                                                        function showModal(){
                                                            // prevent body from reacting to hover/collapse by disabling pointer-events on underlying content
                                                            document.documentElement.classList.add('modal-open');

                                                            // Move modal under <body> so it is positioned independently of the page layout
                                                            // (prevents shaking when the sidebar/header/footer reflow on hover).
                                                            if (modal && modal.parentNode !== document.body) {
                                                                document.body.appendChild(modal);
                                                            }

                                                            if (modal) {
                                                                modal.classList.remove('d-none');
                                                                modal.setAttribute('aria-hidden','false');
                                                            }
                                                        }
                                                        function closeModal(){
                                                            document.documentElement.classList.remove('modal-open');

                                                            if (modal) {
                                                                modal.classList.add('d-none');
                                                                modal.setAttribute('aria-hidden','true');

                                                                // Try to restore modal to its original location in the DOM
                                                                try {
                                                                    if (_refundModalOriginalParent && _refundModalOriginalParent !== document.body) {
                                                                        if (_refundModalNextSibling && _refundModalNextSibling.parentNode === _refundModalOriginalParent) {
                                                                            _refundModalOriginalParent.insertBefore(modal, _refundModalNextSibling);
                                                                        } else {
                                                                            _refundModalOriginalParent.appendChild(modal);
                                                                        }
                                                                    }
                                                                } catch (err) {
                                                                    // ignore restore errors — not critical
                                                                }
                                                            }
                                                        }

                                                        // Toggle visibility
                                                        toggle.addEventListener('change', function(e){
                                                            if(toggle.checked){ section.classList.remove('d-none'); }
                                                            else { section.classList.add('d-none'); }
                                                        });

                                                        // Open modal
                                                        selectBtn.addEventListener('click', function(){ showModal(); });

                                                        // Close modal
                                                        modalClose.addEventListener('click', function(){ closeModal(); });

                                                        // Click outside dialog to close. Use overlay element specifically.
                                                        var overlayEl = modal.querySelector('.refund-modal-overlay');
                                                        if (overlayEl) {
                                                            overlayEl.addEventListener('click', function(e){
                                                                closeModal();
                                                            });
                                                        }

                                                        // Prevent clicks inside the dialog from bubbling to overlay
                                                        var dialogEl = modal.querySelector('.refund-modal-dialog');
                                                        if (dialogEl) {
                                                            dialogEl.addEventListener('click', function(e){
                                                                e.stopPropagation();
                                                            });
                                                        }

                                                        // Select a note
                                                        var cards = document.querySelectorAll('.refund-note-card');
                                                        cards.forEach(function(card){
                                                            card.addEventListener('click', function(){
                                                                var note = card.getAttribute('data-note') || card.innerText || '';
                                                                textarea.value = note.trim();
                                                                closeModal();
                                                            });
                                                        });
                                                    })();
                                                </script>

                                                <style>
    /* show/hide helper for server-side rendering fallback */
    .d-none { display: none !important; }
    </style>

                                                <script>
                                                    (function(){
                                                        var flashFields = document.getElementById('flashFields');
                                                        var discountInput = document.getElementById('flashDiscount');
                                                        var discountType = document.getElementById('flashDiscountType');

                                                        // Validate flash inputs only if user provided any flash data
                                                        var form = document.querySelector('form');
                                                        if (form) {
                                                            form.addEventListener('submit', function(e){
                                                                // New flash duration inputs
                                                                var startEl = document.getElementById('flashStart');
                                                                var endEl = document.getElementById('flashEnd');
                                                                var startVal = startEl ? startEl.value : '';
                                                                var endVal = endEl ? endEl.value : '';
                                                                var discountVal = discountInput ? parseFloat(discountInput.value || '0') : 0;
                                                                var dtype = discountType ? discountType.value : 'flat';

                                                                // If none provided, skip validation
                                                                var anyFilled = (startVal && startVal.length) || (endVal && endVal.length) || (discountInput && discountInput.value && discountInput.value !== '');
                                                                if (!anyFilled) return true;

                                                                // Both start and end are required when adding flash details
                                                                if (!startVal || !endVal) {
                                                                    e.preventDefault();
                                                                    alert('Please set both start and end date/time for the flash deal.');
                                                                    return false;
                                                                }

                                                                var sDt = new Date(startVal);
                                                                var eDt = new Date(endVal);
                                                                if (isNaN(sDt.getTime()) || isNaN(eDt.getTime()) || sDt >= eDt) {
                                                                    e.preventDefault();
                                                                    alert('Please ensure the start date/time is before the end date/time.');
                                                                    return false;
                                                                }

                                                                if (isNaN(discountVal) || discountVal <= 0) {
                                                                    e.preventDefault();
                                                                    alert('Please enter a discount greater than 0 for Flash Deal.');
                                                                    return false;
                                                                }
                                                                if (dtype === 'percent' && discountVal > 100) {
                                                                    e.preventDefault();
                                                                    alert('Percent discount cannot exceed 100%.');
                                                                    return false;
                                                                }
                                                            });
                                                        }
                                                    })();
                                                </script>

                                                <script>
                                                    (function(){
                                                        // Nav switching: show/hide section blocks
                                                        var navLinks = document.querySelectorAll('nav.nav a[data-target]');
                                                        function clearActive(){ navLinks.forEach(function(a){ a.classList.remove('active'); }); }
                                                        navLinks.forEach(function(a){
                                                            a.addEventListener('click', function(ev){
                                                                ev.preventDefault();
                                                                var target = a.getAttribute('data-target');
                                                                if(!target) return;
                                                                clearActive();
                                                                a.classList.add('active');
                                                                // hide all section divs inside the form
                                                                var sections = document.querySelectorAll('form > div[id^="section-"]');
                                                                sections.forEach(function(s){ s.classList.add('d-none'); });
                                                                var el = document.querySelector(target);
                                                                if(el) el.classList.remove('d-none');
                                                            });
                                                        });

                                                        // File preview helpers
                                                        function readAndPreview(file, container, isThumbnail){
                                                            var reader = new FileReader();
                                                            reader.onload = function(e){
                                                                var img = document.createElement('img');
                                                                img.src = e.target.result;
                                                                img.style.maxWidth = isThumbnail ? '120px' : '80px';
                                                                img.style.maxHeight = isThumbnail ? '120px' : '80px';
                                                                img.style.objectFit = 'cover';
                                                                img.style.borderRadius = '6px';
                                                                img.style.border = '1px solid #e9ecef';
                                                                img.style.marginRight = '8px';
                                                                container.appendChild(img);
                                                            };
                                                            reader.readAsDataURL(file);
                                                        }

                                                        // Bind file preview listeners after DOM ready so inputs exist
                                                        function bindFilePreviews(){
                                                            var galleryInput = document.getElementById('galleryImages');
                                                            var galleryPreview = document.getElementById('galleryPreview');
                                                            if(galleryInput){
                                                                galleryInput.addEventListener('change', function(){
                                                                    if(!galleryPreview) return;
                                                                    galleryPreview.innerHTML = '';
                                                                    Array.from(galleryInput.files).slice(0,12).forEach(function(file){
                                                                        if(!file.type.match('image.*')) return;
                                                                        readAndPreview(file, galleryPreview, false);
                                                                    });
                                                                });
                                                            }

                                                            var thumbInput = document.getElementById('thumbnailImage');
                                                            var thumbPreview = document.getElementById('thumbnailPreview');
                                                            if(thumbInput){
                                                                thumbInput.addEventListener('change', function(){
                                                                    if(!thumbPreview) return;
                                                                    thumbPreview.innerHTML = '';
                                                                    var file = thumbInput.files[0];
                                                                    if(!file) return;
                                                                    if(!file.type.match('image.*')) return;
                                                                    readAndPreview(file, thumbPreview, true);
                                                                });
                                                            }
                                                        }

                                                        if (document.readyState === 'loading') {
                                                            document.addEventListener('DOMContentLoaded', function(){
                                                                bindFilePreviews();
                                                                // show active tab on load
                                                                var activeLink = document.querySelector('nav.nav a.active[data-target]');
                                                                if(activeLink){
                                                                    var t = activeLink.getAttribute('data-target');
                                                                    var targetEl = document.querySelector(t);
                                                                    if(targetEl) targetEl.classList.remove('d-none');
                                                                }
                                                            });
                                                        } else {
                                                            bindFilePreviews();
                                                            var activeLink = document.querySelector('nav.nav a.active[data-target]');
                                                            if(activeLink){
                                                                var t = activeLink.getAttribute('data-target');
                                                                var targetEl = document.querySelector(t);
                                                                if(targetEl) targetEl.classList.remove('d-none');
                                                            }
                                                        }
                                                    })();
                                                </script>

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
                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Pricing Mode</label>
                                                        <div class="col-lg-9">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="useSamePriceToggle" />
                                                                <label class="form-check-label" for="useSamePriceToggle">Use same price for all variants</label>
                                                            </div>

                                                            <div id="globalPriceStock" class="mt-2 d-none">
                                                                <div class="d-flex gap-2" style="max-width:420px">
                                                                    <input id="globalPrice" name="global_price" type="number" step="0.01" class="form-control" placeholder="Price for all variants" />
                                                                </div>
                                                                <small class="text-muted d-block mt-1">When enabled, per-variant price fields will be set to this value and made readonly before submit.</small>
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

                                                <!-- Choices.js (searchable multi-select) -->
                                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
                                                <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
                                                <style>
                                                    /* small circular swatch used inside choices and selected items */
                                                    .colour-swatch {
                                                        display: inline-block;
                                                        width: 12px;
                                                        height: 12px;
                                                        border-radius: 50%;
                                                        margin-right: 8px;
                                                        vertical-align: middle;
                                                        border: 1px solid rgba(0,0,0,0.08);
                                                        box-shadow: 0 0 0 1px rgba(255,255,255,0.02) inset;
                                                    }

                                                    /* slightly larger swatch inside selected items */
                                                    .choices__list--multiple .colour-swatch {
                                                        width: 10px;
                                                        height: 10px;
                                                        margin-right: 6px;
                                                    }

                                                    /* ensure dropdown items align nicely */
                                                    .choices__list--dropdown .choices__item .colour-swatch {
                                                        margin-right: 10px;
                                                    }
                                                </style>

                                                <style>
                                                    /* Force clear table borders and layout for variants table in case other CSS resets removed them */
                                                    table#variantsTable {
                                                        width: 100%;
                                                        border-collapse: collapse;
                                                        table-layout: auto;
                                                    }

                                                    table#variantsTable th,
                                                    table#variantsTable td {
                                                        border: 1px solid #e9ecef !important;
                                                        padding: 0.5rem !important;
                                                        vertical-align: middle !important;
                                                        white-space: nowrap;
                                                    }

                                                    /* slightly muted header background to match bootstrap table headers */
                                                    table#variantsTable thead th {
                                                        background: #f8f9fa !important;
                                                        font-weight: 600;
                                                    }

                                                    /* Ensure inputs fill the table cell and keep their default borders */
                                                    table#variantsTable td .form-control {
                                                        width: 100%;
                                                        box-sizing: border-box;
                                                        margin: 0;
                                                    }

                                                    /* Make responsive container visible overflow if needed */
                                                    #variants-section .table-responsive {
                                                        overflow-x: auto;
                                                    }
                                                </style>

                                                <script>
                                                    (function(){
                                                        var select = document.getElementById('coloursSelect');
                                                        if(!select) return;

                                                        try{
                                                            var choices = new Choices(select, {
                                                                removeItemButton: true,
                                                                searchEnabled: true,
                                                                placeholderValue: 'Select colours',
                                                                searchPlaceholderValue: 'Type to search colours',
                                                                shouldSort: false,
                                                                itemSelectText: ''
                                                            });

                                                            // Add swatches to choices dropdown and selected items.
                                                            function createSwatch(color){
                                                                var el = document.createElement('span');
                                                                el.className = 'colour-swatch';
                                                                // try to set as background color; if invalid CSS color the swatch will be empty
                                                                el.style.backgroundColor = color || 'transparent';
                                                                el.setAttribute('aria-hidden','true');
                                                                return el;
                                                            }

                                                            function decorateChoices(){
                                                                // dropdown list items
                                                                var dropdownItems = document.querySelectorAll('.choices__list--dropdown .choices__item');
                                                                dropdownItems.forEach(function(item){
                                                                    // avoid double-inserting
                                                                    if(item.querySelector('.colour-swatch')) return;
                                                                    var val = item.getAttribute('data-value');
                                                                    if(!val) return;
                                                                    // find original option to read data-color
                                                                    var opt = select.querySelector('option[value="'+CSS.escape(val)+'"]');
                                                                    var color = opt ? opt.getAttribute('data-color') : null;
                                                                    if(color){
                                                                        var sw = createSwatch(color);
                                                                        // insert at start of the item
                                                                        item.insertBefore(sw, item.firstChild);
                                                                    }
                                                                });

                                                                // selected items in multiple list
                                                                var selectedItems = document.querySelectorAll('.choices__list--multiple .choices__item');
                                                                selectedItems.forEach(function(item){
                                                                    if(item.querySelector('.colour-swatch')) return;
                                                                    var val = item.getAttribute('data-value');
                                                                    if(!val) return;
                                                                    var opt = select.querySelector('option[value="'+CSS.escape(val)+'"]');
                                                                    var color = opt ? opt.getAttribute('data-color') : null;
                                                                    if(color){
                                                                        var sw = createSwatch(color);
                                                                        item.insertBefore(sw, item.firstChild);
                                                                    }
                                                                });
                                                            }

                                                            // initial decorate after small timeout to allow Choices to render
                                                            setTimeout(decorateChoices, 50);

                                                            // When choices list changes (selection or filtering), re-decorate.
                                                            // Choices emits various events; listen to choice and list events.
                                                            select.addEventListener('change', function(){ setTimeout(decorateChoices,30); });

                                                            // also hook into Choices' internal event system if available
                                                            if(choices && typeof choices.passedElement === 'object'){
                                                                try{
                                                                    choices.passedElement.element.addEventListener('choice', function(){ setTimeout(decorateChoices,30); });
                                                                } catch(e){ /* not critical */ }
                                                            }

                                                            // Re-decorate any time dropdown shows (user opens dropdown)
                                                            document.addEventListener('click', function(e){ setTimeout(decorateChoices,120); });

                                                        } catch (e) {
                                                            // If Choices fails (older browsers), leave native select as fallback
                                                            console.warn('Choices initialization failed for coloursSelect', e);
                                                        }
                                                    })();
                                                </script>
                                                        <script>
                                                            (function(){
                                                                // Attributes -> values -> variants generator
                                                                var attributesSelect = document.getElementById('attributesSelect');
                                                                var attributesValuesArea = document.getElementById('attributes-values-area');
                                                                var variantsSection = document.getElementById('variants-section');
                                                                var variantsTableBody = document.querySelector('#variantsTable tbody');
                                                                var coloursSelect = document.getElementById('coloursSelect');
                                                                // pricing mode elements (price only)
                                                                var useSamePriceToggle = document.getElementById('useSamePriceToggle');
                                                                var globalPriceInput = document.getElementById('globalPrice');
                                                                var attributesData = [];
                                                                var attributesChoices = null;

                                                                if(!attributesSelect) return;

                                                                async function loadAttributes(){
                                                                    try{
                                                                        var res = await fetch('/admin/attributes/data', { headers: { 'Accept': 'application/json' }});
                                                                        if(!res.ok) return;
                                                                        attributesData = await res.json();
                                                                        populateAttributesSelect();
                                                                    } catch(err){ console.error('Failed to load attributes', err); }
                                                                }

                                                                function populateAttributesSelect(){
                                                                    attributesSelect.innerHTML = '';
                                                                    attributesData.forEach(function(a){
                                                                        var opt = document.createElement('option');
                                                                        opt.value = a.id;
                                                                        opt.text = a.name || ('Attribute '+a.id);
                                                                        attributesSelect.appendChild(opt);
                                                                    });
                                                                    try{
                                                                        if(attributesChoices){ attributesChoices.destroy(); }
                                                                        attributesChoices = new Choices(attributesSelect, { removeItemButton: true, searchEnabled: true, placeholderValue: 'Select attributes', itemSelectText: '' });
                                                                    } catch(e){ console.warn('Choices init failed for attributesSelect', e); }
                                                                    attributesSelect.addEventListener('change', onAttributesChange);
                                                                    // rebuild variants when colours change as well
                                                                    if(coloursSelect){
                                                                        coloursSelect.addEventListener('change', buildVariants);
                                                                    }
                                                                }

                                                                function onAttributesChange(){
                                                                    var selected = Array.from(attributesSelect.selectedOptions).map(function(o){ return parseInt(o.value); });
                                                                    renderAttributeValueSelectors(selected);
                                                                }

                                                                function renderAttributeValueSelectors(selectedIds){
                                                                    attributesValuesArea.innerHTML = '';
                                                                    if(!selectedIds || selectedIds.length === 0){ attributesValuesArea.classList.add('d-none'); clearVariants(); return; }
                                                                    attributesValuesArea.classList.remove('d-none');

                                                                    selectedIds.forEach(function(id){
                                                                        var attr = attributesData.find(function(x){ return x.id == id; });
                                                                        if(!attr) return;
                                                                        // row
                                                                        var row = document.createElement('div');
                                                                        row.className = 'row mb-3';
                                                                        var label = document.createElement('label');
                                                                        label.className = 'col-lg-3 col-form-label';
                                                                        label.textContent = attr.name || '';
                                                                        var col = document.createElement('div');
                                                                        col.className = 'col-lg-9';
                                                                        var sel = document.createElement('select');
                                                                        sel.setAttribute('data-attribute-id', attr.id);
                                                                        sel.className = 'form-control attr-values-select';
                                                                        sel.multiple = true;
                                                                        // populate values
                                                                        (attr.values || []).forEach(function(v){
                                                                            var o = document.createElement('option');
                                                                            o.value = v.id;
                                                                            o.text = v.value;
                                                                            sel.appendChild(o);
                                                                        });
                                                                        col.appendChild(sel);
                                                                        row.appendChild(label);
                                                                        row.appendChild(col);
                                                                        attributesValuesArea.appendChild(row);

                                                                        try{ new Choices(sel, { removeItemButton: true, searchEnabled: true, placeholderValue: 'Select values', itemSelectText: '' }); } catch(e){ /* ignore */ }
                                                                        sel.addEventListener('change', buildVariants);
                                                                    });

                                                                    // initial build
                                                                    buildVariants();
                                                                }

                                                                function buildVariants(){
                                                                    var selects = Array.from(document.querySelectorAll('.attr-values-select'));
                                                                    var lists = [];
                                                                    var meta = [];
                                                                    // include colours as the first dimension if any selected
                                                                    if(coloursSelect){
                                                                        var chosenColours = Array.from(coloursSelect.selectedOptions).map(function(o){ return { id: o.value, label: o.text || o.value }; });
                                                                        if(chosenColours.length > 0){
                                                                            lists.push(chosenColours);
                                                                            meta.push({ id: 'colour', name: 'Colour' });
                                                                        }
                                                                    }
                                                                    for(var i=0;i<selects.length;i++){
                                                                        var s = selects[i];
                                                                        var chosen = Array.from(s.selectedOptions).map(function(o){ return { id: o.value, label: o.text }; });
                                                                        if(chosen.length === 0){ // if any attribute has no chosen values, we don't build variants
                                                                            clearVariants();
                                                                            return;
                                                                        }
                                                                        lists.push(chosen);
                                                                        var label = s.closest('.row').querySelector('label').textContent || '';
                                                                        meta.push({ id: s.getAttribute('data-attribute-id'), name: label });
                                                                    }

                                                                    // cartesian product
                                                                    var combos = cartesian(lists);
                                                                    renderVariantsTable(combos, meta);
                                                                }

                                                                function cartesian(arr){
                                                                    if(!arr || arr.length === 0) return [];
                                                                    return arr.reduce(function(a,b){
                                                                        return a.flatMap(function(x){ return b.map(function(y){ return x.concat([y]); }); });
                                                                    }, [[]]);
                                                                }

                                                                function renderVariantsTable(combos, meta){
                                                                    variantsTableBody.innerHTML = '';
                                                                    if(!combos || combos.length === 0){ clearVariants(); return; }
                                                                    variantsSection.classList.remove('d-none');
                                                                    combos.forEach(function(combo, idx){
                                                                        var tr = document.createElement('tr');
                                                                        // show compact variant label like "Red/M/cotton"
                                                                        var variantText = combo.map(function(c){ return c.label; }).join('/');
                                                                        tr.innerHTML = '<td>' + (idx+1) + '</td>' +
                                                                            '<td>' + escapeHtml(variantText) + '</td>' +
                                                                            '<td><input type="text" name="variants['+idx+'][sku]" class="form-control" placeholder="SKU" /></td>' +
                                                                            // price input has identifiable class so we can toggle readonly/value; stock remains per-variant and editable
                                                                            '<td><input type="number" step="0.01" name="variants['+idx+'][price]" class="form-control variant-price-input" /></td>' +
                                                                            '<td><input type="number" name="variants['+idx+'][stock]" class="form-control" /></td>';
                                                                        variantsTableBody.appendChild(tr);
                                                                    });

                                                                    // after rows are rendered, apply pricing mode (same price or per-variant)
                                                                    applyPricingModeToRows();
                                                                }

                                                                    // Apply pricing mode: when 'use same price' is enabled, set all variant price inputs to the global value
                                                                function applyPricingModeToRows(){
                                                                    var useSame = useSamePriceToggle ? useSamePriceToggle.checked : false;
                                                                    var priceVal = globalPriceInput ? globalPriceInput.value : '';
                                                                    var priceInputs = Array.from(document.querySelectorAll('.variant-price-input'));

                                                                    priceInputs.forEach(function(inp){
                                                                        if(useSame){
                                                                            if(priceVal !== '') inp.value = priceVal;
                                                                            inp.readOnly = true; // readonly still submits value
                                                                        } else {
                                                                            inp.readOnly = false;
                                                                        }
                                                                    });

                                                                    // show/hide the global inputs area
                                                                    var globalArea = document.getElementById('globalPriceStock');
                                                                    if(globalArea){ if(useSame) globalArea.classList.remove('d-none'); else globalArea.classList.add('d-none'); }
                                                                }

                                                                // wire events: toggle and global price input
                                                                if(useSamePriceToggle){
                                                                    useSamePriceToggle.addEventListener('change', function(){ applyPricingModeToRows(); });
                                                                }
                                                                if(globalPriceInput){ globalPriceInput.addEventListener('input', function(){ if(useSamePriceToggle && useSamePriceToggle.checked) applyPricingModeToRows(); }); }

                                                                function clearVariants(){
                                                                    variantsTableBody.innerHTML = '';
                                                                    variantsSection.classList.add('d-none');
                                                                }

                                                                function escapeHtml(str){ return String(str).replace(/[&<>'"`]/g, function(m){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#x60;'}[m]); }); }

                                                                // start
                                                                loadAttributes();
                                                            })();
                                                        </script>
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
                                                                <input class="form-check-input" type="checkbox" id="cashOnDeliveryToggle" aria-label="Cash on delivery toggle">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4 shipping-row">
                                                        <label class="col-lg-3 col-form-label">Free Shipping</label>
                                                        <div class="col-lg-9">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="freeShippingToggle" aria-label="Free shipping toggle">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4 shipping-row">
                                                        <label class="col-lg-3 col-form-label">Flat Rate</label>
                                                        <div class="col-lg-9">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="flatRateToggle" aria-label="Flat rate toggle">
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

                                                    <script>
                                                        (function(){
                                                            var flatToggle = document.getElementById('flatRateToggle');
                                                            var freeToggle = document.getElementById('freeShippingToggle');
                                                            var costRow = document.getElementById('shippingCostRow');
                                                            var costInput = document.getElementById('shippingCostInput');

                                                            function updateShippingVisibility(){
                                                                // If both are checked (server-rendered state), pick flat-rate as default and turn off free shipping
                                                                if(freeToggle && flatToggle && freeToggle.checked && flatToggle.checked){
                                                                    // ensure only one remains checked
                                                                    freeToggle.checked = false;
                                                                }

                                                                // If free shipping is enabled, always hide flat-rate cost
                                                                if(freeToggle && freeToggle.checked){
                                                                    if(costRow) costRow.classList.add('d-none');
                                                                    return;
                                                                }

                                                                if(flatToggle && flatToggle.checked){
                                                                    if(costRow) costRow.classList.remove('d-none');
                                                                } else {
                                                                    if(costRow) costRow.classList.add('d-none');
                                                                }
                                                            }

                                                            if(flatToggle) flatToggle.addEventListener('change', function(){
                                                                // when enabling flat-rate, force free shipping off
                                                                if(flatToggle.checked && freeToggle) freeToggle.checked = false;
                                                                updateShippingVisibility();
                                                            });

                                                            if(freeToggle) freeToggle.addEventListener('change', function(){
                                                                // when enabling free shipping, force flat-rate off
                                                                if(freeToggle.checked && flatToggle) flatToggle.checked = false;
                                                                updateShippingVisibility();
                                                            });

                                                            // initialize state on load (in case server rendered checked states are present)
                                                            if(document.readyState === 'loading'){
                                                                document.addEventListener('DOMContentLoaded', updateShippingVisibility);
                                                            } else {
                                                                updateShippingVisibility();
                                                            }
                                                        })();
                                                    </script>
                                                </div>
                                                <div id="section-warranty" class="d-none">
                                                    <div class="mb-4"><h3 class="mb-1">Warranty</h3></div>

                                                    <div class="row mb-4 warranty-row">
                                                        <label class="col-lg-3 col-form-label">Warranty</label>
                                                        <div class="col-lg-9">
                                                            <!-- hidden field to ensure a value is sent when unchecked -->
                                                            <input type="hidden" name="warranty_enabled" value="0">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input large-toggle" type="checkbox" id="warrantyToggle" name="warranty_enabled" value="1" aria-label="Enable warranty">
                                                                <label class="form-check-label ms-2" for="warrantyToggle">Enable warranty</label>
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

                                                    <style>
                                                        /* Warranty row: match spacing and alignment used by status/shipping rows */
                                                        .warranty-row { align-items: flex-start; }
                                                        .warranty-row .col-lg-3 { display: flex; align-items: center; min-height: 30px; padding-top: 0; }
                                                        .warranty-row .col-lg-9 { display: flex; flex-direction: column; align-items: flex-start; padding-top: 0; gap: 6px; }
                                                        .warranty-row .form-check.form-switch { padding-left: 0; margin: 0; display: inline-flex; align-items: center; }
                                                        .warranty-row .form-check-label { font-weight: 500; }
                                                        .warranty-row .form-check-input.large-toggle { transform: scale(1.15); transform-origin: left center; margin-top: 0; margin-left: 0; }
                                                    </style>

                                                    <script>
                                                        (function(){
                                                            var toggle = document.getElementById('warrantyToggle');
                                                            var options = document.getElementById('warrantyOptions');
                                                            if(!toggle || !options) return;

                                                            function updateVisibility(){
                                                                if(toggle.checked){ options.classList.remove('d-none'); }
                                                                else { options.classList.add('d-none'); }
                                                            }

                                                            // initialize on load (respect server-rendered checked state)
                                                            if(document.readyState === 'loading'){
                                                                document.addEventListener('DOMContentLoaded', updateVisibility);
                                                            } else { updateVisibility(); }

                                                            toggle.addEventListener('change', updateVisibility);
                                                        })();
                                                    </script>
                                                </div>

                                                <!-- row.// -->
                                                <br />
                                                <button class="btn btn-primary" type="submit">Continue to next</button>
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