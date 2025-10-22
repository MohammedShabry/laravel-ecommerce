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
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row gx-5">
                                    <aside class="col-lg-3 border-end">
                                        <nav class="nav nav-pills flex-column mb-4">
                                            <a class="nav-link active" aria-current="page" href="#" data-target="#section-general">General</a>
                                            <a class="nav-link" href="#" data-target="#section-files-media">Files & Media</a>
                                            <a class="nav-link" href="#" data-target="#section-price-stock">Price & Stock</a>
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
                                                </div>

                                                <!-- Category dropdown (added) -->
                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Category</label>
                                                    <div class="col-lg-9">
                                                        <select name="category_id" class="form-control">
                                                            <option value="">Select a category</option>
                                                            <?php if(isset($categories) && is_iterable($categories)): ?>
                                                                <?php foreach($categories as $category): ?>
                                                                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name ?? $category->title ?? 'Category'); ?></option>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <option value="1">Default Category</option>
                                                                <option value="2">Another Category</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <!-- col.// -->
                                                </div>

                                                                                                <!-- row.// -->
                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Brand</label>
                                                    <div class="col-lg-4">
                                                        <small class="text-muted font-sm mb-10">Multiselect: Cmd+click</small>
                                                        <select multiple size="4" class="form-control select-multiple">
                                                            <option>Adidas</option>
                                                            <option>Puma</option>
                                                            <option>Apple</option>
                                                            <option>Toyota</option>
                                                            <option>Toshiba</option>
                                                            <option>Artel</option>
                                                        </select>
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
                                                    <label class="col-lg-3 col-form-label">Minimum Purchase Qty *</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" placeholder="Type here" />
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
                                                    <label class="col-lg-3 col-form-label">Product Code</label>
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
                                                        <label class="col-lg-3 col-form-label">Add to Flash</label>
                                                        <div class="col-lg-9">
                                                            <select id="addToFlashSelect" name="flash_topic" class="form-control">
                                                                <option value="">Choose Flash Title</option>
                                                                <option value="end_of_season">End of Season</option>
                                                                <option value="winter_sale">Winter Sale</option>
                                                                <option value="flash_deal">Flash Deal</option>
                                                                <option value="flash_sale">Flash Sale</option>
                                                            </select>
                                                        </div>
                                                        <!-- col.// -->
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Discount</label>
                                                        <div class="col-lg-9">
                                                            <input id="flashDiscount" name="flash_discount" type="number" min="0" step="0.01" class="form-control" placeholder="0" />
                                                        </div>
                                                        <!-- col.// -->
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Discount Type</label>
                                                        <div class="col-lg-9">
                                                            <select id="flashDiscountType" name="flash_discount_type" class="form-control">
                                                                <option value="">Choose Discount Type</option>
                                                                <option value="flat">Flat</option>
                                                                <option value="percent">Percent</option>
                                                            </select>
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
                                                                var topicEl = document.getElementById('addToFlashSelect');
                                                                var topic = topicEl ? topicEl.value : '';
                                                                var discountVal = discountInput ? parseFloat(discountInput.value || '0') : 0;
                                                                var dtype = discountType ? discountType.value : 'flat';

                                                                // If none provided, skip validation
                                                                var anyFilled = (topic && topic.length) || (discountInput && discountInput.value && discountInput.value !== '');
                                                                if (!anyFilled) return true;

                                                                // topic required if any flash data provided
                                                                if (!topic) {
                                                                    e.preventDefault();
                                                                    alert('Please select a flash topic when adding flash deal details.');
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
                                                            <small class="text-muted d-block mt-2">These images are visible in product details page gallery. Minimum dimensions required: 900px width X 900px height.</small>
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
                                                    <p class="text-muted">Price & Stock fields go here.</p>
                                                </div>
                                                <div id="section-shipping" class="d-none">
                                                    <div class="mb-4"><h3 class="mb-1">Shipping</h3></div>
                                                    <p class="text-muted">Shipping fields go here.</p>
                                                </div>
                                                <div id="section-warranty" class="d-none">
                                                    <div class="mb-4"><h3 class="mb-1">Warranty</h3></div>
                                                    <p class="text-muted">Warranty fields go here.</p>
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