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
                                    <aside class="col-lg-3 border-end desktop-sidebar">
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
                                            <form id="productForm" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" novalidate>
                                                @csrf
                                                
                                                <!-- Mobile horizontal navigation (hidden on desktop) -->
                                                <div class="mobile-top-nav">
                                                    <nav class="nav">
                                                        <a class="nav-link active" href="#" data-target="#section-general">
                                                            <i class="bi bi-info-circle"></i>
                                                            <span>General</span>
                                                        </a>
                                                        <a class="nav-link" href="#" data-target="#section-files-media">
                                                            <i class="bi bi-images"></i>
                                                            <span>Media</span>
                                                        </a>
                                                        <a class="nav-link" href="#" data-target="#section-price-stock">
                                                            <i class="bi bi-cash-stack"></i>
                                                            <span>Price</span>
                                                        </a>
                                                        <a class="nav-link" href="#" data-target="#section-seo">
                                                            <i class="bi bi-search"></i>
                                                            <span>SEO</span>
                                                        </a>
                                                        <a class="nav-link" href="#" data-target="#section-shipping">
                                                            <i class="bi bi-truck"></i>
                                                            <span>Shipping</span>
                                                        </a>
                                                        <a class="nav-link" href="#" data-target="#section-warranty">
                                                            <i class="bi bi-shield-check"></i>
                                                            <span>Warranty</span>
                                                        </a>
                                                    </nav>
                                                </div>
                                                <!-- Consolidated styles and external CSS moved here for clarity -->
                                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
                                                <style>
                                                    /* Orange Theme Variables */
                                                    :root {
                                                        --orange-primary: #ff6b35;
                                                        --orange-dark: #e85a2a;
                                                        --orange-light: #ff8c61;
                                                        --orange-lighter: #ffe5dc;
                                                        --orange-pale: #fff5f2;
                                                        --text-dark: #2d3748;
                                                        --border-color: #ffd4c4;
                                                    }

                                                    /* Responsive Navigation Styles */
                                                    /* Desktop: vertical sidebar (default behavior) */
                                                    .desktop-sidebar {
                                                        display: block;
                                                        background: linear-gradient(135deg, var(--orange-pale) 0%, #fff 100%);
                                                        border-right: 2px solid var(--border-color) !important;
                                                        padding: 1.5rem 1rem;
                                                        border-radius: 12px 0 0 12px;
                                                    }
                                                    
                                                    .desktop-sidebar .nav-link {
                                                        color: var(--text-dark);
                                                        padding: 0.75rem 1rem;
                                                        margin-bottom: 0.5rem;
                                                        border-radius: 8px;
                                                        transition: all 0.3s ease;
                                                        font-weight: 500;
                                                        border-left: 3px solid transparent;
                                                    }
                                                    
                                                    .desktop-sidebar .nav-link:hover {
                                                        background: var(--orange-lighter);
                                                        color: var(--orange-dark);
                                                        border-left-color: var(--orange-primary);
                                                        transform: translateX(5px);
                                                    }
                                                    
                                                    .desktop-sidebar .nav-link.active {
                                                        background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-light) 100%);
                                                        color: white;
                                                        font-weight: 600;
                                                        border-left-color: var(--orange-dark);
                                                        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
                                                    }
                                                    
                                                    .mobile-top-nav {
                                                        display: none;
                                                    }
                                                    
                                                    /* Mobile: horizontal top nav with icons */
                                                    @media (max-width: 991px) {
                                                        .desktop-sidebar {
                                                            display: none !important;
                                                        }
                                                        
                                                        .mobile-top-nav {
                                                            display: block;
                                                            margin-bottom: 2rem;
                                                            padding: 1.5rem 0;
                                                            background: transparent;
                                                            overflow-x: auto;
                                                            overflow-y: hidden;
                                                            -webkit-overflow-scrolling: touch;
                                                        }
                                                        
                                                        .mobile-top-nav .nav {
                                                            display: flex;
                                                            justify-content: space-between;
                                                            align-items: center;
                                                            position: relative;
                                                            min-width: max-content;
                                                            padding: 0 1rem;
                                                            gap: 1rem;
                                                        }
                                                        
                                                        /* Connecting line between icons */
                                                        .mobile-top-nav .nav::before {
                                                            content: '';
                                                            position: absolute;
                                                            top: 20px;
                                                            left: 2.5rem;
                                                            right: 2.5rem;
                                                            height: 2px;
                                                            background: var(--border-color);
                                                            z-index: 0;
                                                        }
                                                        
                                                        /* Progress line that fills as you move through sections */
                                                        .mobile-top-nav .nav::after {
                                                            content: '';
                                                            position: absolute;
                                                            top: 20px;
                                                            left: 2.5rem;
                                                            height: 2px;
                                                            background: var(--orange-primary);
                                                            z-index: 1;
                                                            transition: width 0.3s ease;
                                                            width: 0%;
                                                        }
                                                        
                                                        .mobile-top-nav .nav-link {
                                                            display: flex;
                                                            flex-direction: column;
                                                            align-items: center;
                                                            gap: 0.5rem;
                                                            padding: 0;
                                                            background: transparent;
                                                            border: none;
                                                            color: var(--text-dark);
                                                            text-decoration: none;
                                                            position: relative;
                                                            z-index: 2;
                                                            transition: all 0.3s ease;
                                                            flex-shrink: 0;
                                                        }
                                                        
                                                        .mobile-top-nav .nav-link i {
                                                            width: 40px;
                                                            height: 40px;
                                                            border-radius: 50%;
                                                            display: flex;
                                                            align-items: center;
                                                            justify-content: center;
                                                            background: white;
                                                            border: 2px solid var(--border-color);
                                                            color: #6c757d;
                                                            font-size: 1.1rem;
                                                            transition: all 0.3s ease;
                                                            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                                                        }
                                                        
                                                        .mobile-top-nav .nav-link span {
                                                            font-size: 0.75rem;
                                                            font-weight: 500;
                                                            color: #6c757d;
                                                        }
                                                        
                                                        .mobile-top-nav .nav-link:hover i {
                                                            background: var(--orange-lighter);
                                                            border-color: var(--orange-primary);
                                                            transform: scale(1.1);
                                                        }
                                                        
                                                        .mobile-top-nav .nav-link:hover {
                                                            color: var(--orange-primary);
                                                        }
                                                        
                                                        .mobile-top-nav .nav-link.active i {
                                                            background: var(--orange-primary);
                                                            border-color: var(--orange-primary);
                                                            color: white;
                                                            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.4);
                                                            transform: scale(1.15);
                                                        }
                                                        
                                                        .mobile-top-nav .nav-link.active {
                                                            color: var(--orange-primary);
                                                        }
                                                        
                                                        .mobile-top-nav .nav-link.active span {
                                                            font-weight: 700;
                                                            color: var(--orange-primary);
                                                        }
                                                        
                                                        .mobile-top-nav .nav-link.completed i {
                                                            background: var(--orange-primary);
                                                            border-color: var(--orange-primary);
                                                            color: white;
                                                        }
                                                        
                                                        .mobile-top-nav .nav-link.completed {
                                                            color: var(--orange-primary);
                                                        }
                                                        
                                                        /* Smaller screens - make icons smaller */
                                                        @media (max-width: 576px) {
                                                            .mobile-top-nav .nav::before,
                                                            .mobile-top-nav .nav::after {
                                                                top: 16px;
                                                                left: 2rem;
                                                                right: 2rem;
                                                            }
                                                            
                                                            .mobile-top-nav .nav-link i {
                                                                width: 32px;
                                                                height: 32px;
                                                                font-size: 0.9rem;
                                                            }
                                                            
                                                            .mobile-top-nav .nav-link span {
                                                                font-size: 0.65rem;
                                                            }
                                                            
                                                            .mobile-top-nav .nav {
                                                                gap: 0.5rem;
                                                                padding: 0 0.5rem;
                                                            }
                                                        }
                                                    }

                                                    /* Category expand/collapse button */
                                                    #product-category-box {
                                                        border: 2px solid var(--border-color);
                                                        border-radius: 12px;
                                                        padding: 1rem;
                                                        background: var(--orange-pale);
                                                    }
                                                    
                                                    #product-category-box .toggle-btn{
                                                        background: var(--orange-primary);
                                                        border: none;
                                                        padding: 0;
                                                        margin: 0 6px 0 0;
                                                        width: 20px;
                                                        height: 20px;
                                                        line-height: 18px;
                                                        text-align: center;
                                                        cursor: pointer;
                                                        color: white;
                                                        font-weight: 600;
                                                        border-radius: 4px;
                                                        transition: all 0.2s ease;
                                                    }
                                                    #product-category-box .toggle-btn:focus{ outline: 2px solid var(--orange-light); }
                                                    #product-category-box .toggle-btn:hover{ 
                                                        background: var(--orange-dark);
                                                        transform: scale(1.1);
                                                    }

                                                    /* --- FIX ALIGNMENT FOR REFUND TOGGLE and related styles --- */
                                                    .refund-row { align-items: flex-start; }
                                                    .refund-row .col-lg-3 { display: flex; align-items: center; min-height: 48px; padding-top: 0; }
                                                    .refund-row .col-lg-9 { display: block; padding-top: 0; }
                                                    .refund-row .col-lg-9 > .form-check { min-height: 48px; display: flex; align-items: center; }
                                                    .form-check.form-switch { padding-left: 0; margin: 0; display: inline-flex; align-items: center; }
                                                    .form-check-input.large-toggle { 
                                                        transform: scale(1.2); 
                                                        transform-origin: left center; 
                                                        margin-top: 0; 
                                                        margin-left: 0;
                                                    }
                                                    
                                                    /* Orange toggle switches */
                                                    .form-check-input:checked {
                                                        background-color: var(--orange-primary);
                                                        border-color: var(--orange-primary);
                                                    }
                                                    
                                                    .form-check-input:focus {
                                                        border-color: var(--orange-light);
                                                        box-shadow: 0 0 0 0.25rem rgba(255, 107, 53, 0.25);
                                                    }

                                                    /* Shipping / status alignment */
                                                    .status-row { align-items: flex-start; }
                                                    .status-row .col-lg-3 { display: flex; align-items: center; min-height: 30px; padding-top: 0; }
                                                    .status-row .col-lg-9 { display: flex; flex-direction: column; align-items: flex-start; padding-top: 0; gap: 1px; }
                                                    .status-row .col-lg-9 > .form-check { min-height: 30px; display: flex; align-items: center; }
                                                    .status-row .col-lg-9 small { display: block; margin-top: 0; font-size: 0.7rem; line-height: 1.2; color: #8b5a3c; }

                                                    /* Shipping-specific rows: align label and toggle horizontally */
                                                    .shipping-row { align-items: center; }
                                                    .shipping-row .col-lg-3 { display: flex; align-items: center; min-height: 30px; padding-top: 0; }
                                                    .shipping-row .col-lg-9 { display: flex; align-items: center; padding-top: 0; gap: 8px; }
                                                    .shipping-row .col-lg-9 > .form-check { min-height: 30px; display: flex; align-items: center; margin: 0; }
                                                    .shipping-row .col-lg-9 small { display: block; margin-top: 0; font-size: 0.72rem; color: #8b5a3c; }

                                                    /* refund note section */
                                                    #refundNoteSection { width: 100%; margin-top: 12px; display: block; }

                                                    /* modal styles */
                                                    .refund-modal { position: fixed; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 9999; pointer-events: auto; }
                                                    .refund-modal.d-none { display: none; pointer-events: none; }
                                                    .refund-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9998; pointer-events: auto; }
                                                    .refund-modal-dialog { 
                                                        position: relative; 
                                                        background: #fff; 
                                                        width: 90%; 
                                                        max-width: 760px; 
                                                        border-radius: 16px; 
                                                        padding: 24px; 
                                                        box-shadow: 0 12px 40px rgba(255, 107, 53, 0.15); 
                                                        z-index: 9999; 
                                                        pointer-events: auto;
                                                        border-top: 4px solid var(--orange-primary);
                                                    }
                                                    .refund-note-cards { display: flex; flex-wrap: wrap; gap: 12px; }
                                                    .refund-note-card { 
                                                        cursor: pointer; 
                                                        border: 2px solid var(--border-color); 
                                                        border-radius: 12px; 
                                                        width: calc(50% - 6px);
                                                        padding: 1rem;
                                                        transition: all 0.3s ease;
                                                        background: var(--orange-pale);
                                                    }
                                                    .refund-note-card:hover { 
                                                        box-shadow: 0 6px 20px rgba(255, 107, 53, 0.2); 
                                                        transform: translateY(-4px);
                                                        border-color: var(--orange-primary);
                                                        background: white;
                                                    }

                                                    /* small helper text adjustments */
                                                    small { font-size: 0.72rem; line-height: 1.2; color: #8b5a3c; }
                                                    .col-lg-9 small { display: block; margin-top: 4px !important; margin-bottom: 0 !important; }
                                                    .col-lg-9 small.mb-10 { margin-bottom: 4px !important; }
                                                    
                                                    /* Form controls */
                                                    .form-control:focus,
                                                    .form-select:focus {
                                                        border-color: var(--orange-primary);
                                                        box-shadow: 0 0 0 0.25rem rgba(255, 107, 53, 0.15);
                                                    }
                                                    
                                                    .form-label,
                                                    .col-form-label {
                                                        color: var(--text-dark);
                                                        font-weight: 600;
                                                    }

                                                    /* Choices swatch */
                                                    .colour-swatch { display: inline-block; width: 12px; height: 12px; border-radius: 50%; margin-right: 8px; vertical-align: middle; border: 1px solid rgba(0,0,0,0.08); box-shadow: 0 0 0 1px rgba(255,255,255,0.02) inset; }
                                                    .choices__list--multiple .colour-swatch { width: 10px; height: 10px; margin-right: 6px; }
                                                    .choices__list--dropdown .choices__item .colour-swatch { margin-right: 10px; }

                                                    /* Variants table layout - responsive with horizontal scroll on mobile */
                                                    #variants-section .table-responsive {
                                                        -webkit-overflow-scrolling: touch; /* momentum scrolling on iOS */
                                                        scroll-behavior: smooth;
                                                        overflow-x: auto;
                                                    }
                                                    
                                                    table#variantsTable { 
                                                        width: 100%; 
                                                        border-collapse: collapse; 
                                                        table-layout: auto;
                                                        border-radius: 12px;
                                                        overflow: hidden;
                                                        border: 1px solid #dee2e6;
                                                    }
                                                    table#variantsTable th, table#variantsTable td { 
                                                        border: 1px solid var(--border-color) !important; 
                                                        padding: 0.75rem !important; 
                                                        vertical-align: middle !important; 
                                                        white-space: nowrap; 
                                                    }
                                                    table#variantsTable thead th { 
                                                        background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-light) 100%) !important; 
                                                        font-weight: 600;
                                                        color: white;
                                                        border-bottom: 2px solid #dee2e6;
                                                    }
                                                    table#variantsTable tbody tr:hover {
                                                        background: var(--orange-pale);
                                                    }
                                                    table#variantsTable td .form-control { width: 100%; box-sizing: border-box; margin: 0; min-width: 100px; }
                                                    table#variantsTable td .form-control:invalid { border-color: #dc3545; }
                                                    table#variantsTable td .form-control:valid { border-color: #28a745; }
                                                    
                                                    /* On medium and smaller screens, ensure table scrolls horizontally instead of breaking layout */
                                                    @media (max-width: 991.98px) {
                                                        table#variantsTable {
                                                            /* allow table to be as wide as its content, but at least container width */
                                                            width: max-content;
                                                            min-width: 100%;
                                                        }
                                                        table#variantsTable th,
                                                        table#variantsTable td {
                                                            white-space: nowrap;
                                                        }
                                                    }
                                                    
                                                    /* On large screens use full width */
                                                    @media (min-width: 992px) {
                                                        table#variantsTable { width: 100%; }
                                                    }
                                                    
                                                    /* Ensure mobile keeps native table semantics while allowing horizontal scrolling */
                                                    @media (max-width: 480px) {
                                                        table#variantsTable {
                                                            display: table !important;
                                                            table-layout: auto !important;
                                                            width: max-content;
                                                            min-width: 100%;
                                                        }
                                                        table#variantsTable thead { display: table-header-group !important; }
                                                        table#variantsTable tbody { display: table-row-group !important; }
                                                        table#variantsTable tr { display: table-row !important; }
                                                        table#variantsTable th,
                                                        table#variantsTable td { 
                                                            display: table-cell !important; 
                                                            white-space: nowrap;
                                                        }
                                                    }

                                                    /* Warranty row */
                                                    .warranty-row .col-lg-3 { display: flex; align-items: center; min-height: 30px; padding-top: 0; }
                                                    .warranty-row .col-lg-9 { display: flex; flex-direction: column; align-items: flex-start; padding-top: 0; gap: 6px; }
                                                    .warranty-row .form-check.form-switch { padding-left: 0; margin: 0; display: inline-flex; align-items: center; }
                                                    .warranty-row .form-check-label { font-weight: 500; }
                                                    .warranty-row .form-check-input.large-toggle { transform: scale(1.15); transform-origin: left center; margin-top: 0; margin-left: 0; }

                                                    /* SSR-friendly helper */
                                                    .d-none { display: none !important; }
                                                    
                                                    /* Buttons */
                                                    .btn-primary {
                                                        background: linear-gradient(135deg, var(--orange-primary) 0%, var(--orange-light) 100%);
                                                        border: none;
                                                        padding: 0.75rem 2rem;
                                                        font-weight: 600;
                                                        border-radius: 8px;
                                                        transition: all 0.3s ease;
                                                        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
                                                    }
                                                    
                                                    .btn-primary:hover {
                                                        background: linear-gradient(135deg, var(--orange-dark) 0%, var(--orange-primary) 100%);
                                                        transform: translateY(-2px);
                                                        box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
                                                    }
                                                    
                                                    .btn-primary:active {
                                                        transform: translateY(0);
                                                    }
                                                    
                                                    .btn-secondary {
                                                        background: #6c757d;
                                                        border: none;
                                                        padding: 0.75rem 2rem;
                                                        font-weight: 600;
                                                        border-radius: 8px;
                                                        transition: all 0.3s ease;
                                                        color: white;
                                                    }
                                                    
                                                    .btn-secondary:hover {
                                                        background: #5a6268;
                                                        transform: translateY(-2px);
                                                        color: white;
                                                    }
                                                    
                                                    .btn-success {
                                                        background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
                                                        border: none;
                                                        padding: 0.75rem 2rem;
                                                        font-weight: 600;
                                                        border-radius: 8px;
                                                        transition: all 0.3s ease;
                                                        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
                                                        color: white;
                                                    }
                                                    
                                                    .btn-success:hover {
                                                        background: linear-gradient(135deg, #218838 0%, #28a745 100%);
                                                        transform: translateY(-2px);
                                                        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
                                                        color: white;
                                                    }
                                                    
                                                    /* Responsive buttons for mobile */
                                                    @media (max-width: 767px) {
                                                        .btn-primary,
                                                        .btn-secondary,
                                                        .btn-success {
                                                            padding: 0.5rem 1rem;
                                                            font-size: 0.875rem;
                                                        }
                                                        
                                                        .btn-primary i,
                                                        .btn-secondary i,
                                                        .btn-success i {
                                                            font-size: 0.875rem;
                                                        }
                                                    }
                                                    
                                                    @media (max-width: 576px) {
                                                        .btn-primary,
                                                        .btn-secondary,
                                                        .btn-success {
                                                            padding: 0.4rem 0.75rem;
                                                            font-size: 0.8rem;
                                                        }
                                                    }
                                                    
                                                    /* Section headings */
                                                    h3, h4 {
                                                        color: var(--orange-dark);
                                                        font-weight: 700;
                                                    }
                                                    
                                                    h3::before {
                                                        content: '';
                                                        display: inline-block;
                                                        width: 4px;
                                                        height: 24px;
                                                        background: var(--orange-primary);
                                                        margin-right: 12px;
                                                        border-radius: 2px;
                                                        vertical-align: middle;
                                                    }
                                                    
                                                    /* Card styling */
                                                    .card {
                                                        border: 2px solid var(--border-color);
                                                        border-radius: 16px;
                                                        box-shadow: 0 4px 20px rgba(255, 107, 53, 0.08);
                                                    }
                                                    
                                                    .content-header h2 {
                                                        color: var(--orange-dark);
                                                        font-weight: 700;
                                                        border-bottom: 3px solid var(--orange-primary);
                                                        padding-bottom: 0.5rem;
                                                        display: inline-block;
                                                    }
                                                    
                                                    /* Alert styling */
                                                    .alert-success {
                                                        background: var(--orange-pale);
                                                        border-left: 4px solid var(--orange-primary);
                                                        color: var(--orange-dark);
                                                    }
                                                    
                                                    .alert-danger {
                                                        border-left: 4px solid #dc3545;
                                                    }
                                                </style>
                                                <!-- General section (hidden by default; JS will show active tab) -->
                                                <div id="section-general" class="d-none">
                                                    <div class="mb-4">
                                                        <h3 class="mb-1">Product information</h3>
                                                    </div>
                                                    <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Product name <label class="text-danger">*</label></label>
                                                    <div class="col-lg-9">
                                                        <input name="name" type="text" class="form-control" placeholder="Type here" />
                                                    </div>
                                                    <!-- col.// -->
                                                    </div>

                                                    <!-- Product Category panel (right-side box similar to screenshot) -->
                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Category <label class="text-danger">*</label></label>
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
                                                                    <option value="<?php echo e($b->id); ?>"><?php echo e($b->name); ?></option>
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
                                                                                                        <input name="unit" type="text" class="form-control" placeholder="Type here" />
                                                                                                    </div>
                                                    <!-- col.// -->
                                                </div>

                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Weight (In Kg)</label>
                                                    <div class="col-lg-9">
                                                        <input name="weight" type="text" class="form-control" placeholder="Type here" />
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
                                                    <label class="col-lg-3 col-form-label">Description <label class="text-danger">*</label></label>
                                                    <div class="col-lg-9">
                                                        <textarea name="description" class="form-control" placeholder="Type here" rows="4"></textarea>
                                                    </div>
                                                    <!-- col.// -->
                                                </div>


                                                <!-- row.// -->
                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Related tags</label>
                                                    <div class="col-lg-9">
                                                        <input name="tags" type="text" class="form-control" placeholder="tag1, tag2, tag3" />
                                                    </div>
                                                    <!-- col.// -->
                                                </div>

                                                <div class="row mb-4">
                                                    <label class="col-lg-3 col-form-label">Bar Code</label>
                                                    <div class="col-lg-9">
                                                        <input name="barcode" type="text" class="form-control" placeholder="Type here" />
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
                                                        <label class="col-lg-3 col-form-label">Time Duration <label class="text-danger">*</label></label>
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
                                                        <label class="col-lg-3 col-form-label">Discount <label class="text-danger">*</label></label>
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
                                                        <label class="col-lg-3 col-form-label">Gallery Images <label class="text-danger">*</label></label>
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
                                                        <label class="col-lg-3 col-form-label">Colours <label class="text-danger">*</label></label>
                                                        <div class="col-lg-9">
                                                            <?php
                                                                $defaultColours = ['Red','Blue','Green','Black','White','Yellow','Orange','Purple','Pink','Brown','Gray','Cyan','Magenta'];
                                                                $coloursToShow = isset($colors) && is_iterable($colors) ? $colors : $defaultColours;
                                                                $oldColours = old('colours', []);
                                                            ?>
                                                            <select id="coloursSelect" name="colours[]" multiple class="form-control" aria-label="Select colours">
                                                                <?php foreach($coloursToShow as $c): ?>
                                                                    <?php
                                                                        // Determine value/label and a color hint to be used as swatch.
                                                                        $val = is_object($c) ? ($c->value ?? $c->name ?? (string)$c) : (string)$c;
                                                                        $label = is_object($c) ? ($c->name ?? $c->value ?? (string)$c) : (string)$c;
                                                                        // Try to pick a hex/color property if provided, fallback to label/value (CSS color names or hex expected)
                                                                        $colorHint = is_object($c) ? ($c->hex ?? $c->color ?? $c->hex_code ?? $c->value ?? $c->name ?? (string)$c) : (string)$c;
                                                                        $isSelected = in_array($val, $oldColours);
                                                                    ?>
                                                                    <option value="<?php echo e($val); ?>" data-color="<?php echo e($colorHint); ?>" <?php echo $isSelected ? 'selected' : ''; ?>><?php echo e($label); ?></option>
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
                                                                        <th style="width:160px">SKU <label class="text-danger">*</label></th>
                                                                        <th style="width:140px">Price <label class="text-danger">*</label></th>
                                                                        <th style="width:140px">Stock <label class="text-danger">*</label></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>



                                                    <!-- Discount Date Range removed as requested -->

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Discount</label>
                                                        <div class="col-lg-9">
                                                            <div class="d-flex gap-2">
                                                                <input name="discount" id="productDiscount" type="number" step="0.01" required class="form-control" placeholder="Discount amount (e.g., 10)" value="{{ old('discount') }}" />
                                                                <select name="discount_type" id="productDiscountType" class="form-control" style="max-width:160px">
                                                                    <option value="flat" {{ old('discount_type') == 'flat' ? 'selected' : '' }}>Flat</option>
                                                                    <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Percentage</option>
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
                                                            <input name="low_stock_quantity" id="lowStockQuantity" type="number" min="0" class="form-control" placeholder="Quantity threshold to trigger low stock warning" value="{{ old('low_stock_quantity') }}" />
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
                                                                <input class="form-check-input" type="radio" name="stock_visibility" id="stockVisQuantity" value="quantity" {{ old('stock_visibility', 'quantity') == 'quantity' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="stockVisQuantity">Show Stock Quantity</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio" name="stock_visibility" id="stockVisTextOnly" value="text_only" {{ old('stock_visibility') == 'text_only' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="stockVisTextOnly">Show Stock With Text Only</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="radio" name="stock_visibility" id="stockVisHidden" value="hidden" {{ old('stock_visibility') == 'hidden' ? 'checked' : '' }}>
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
                                                            <input name="meta_title" type="text" class="form-control" placeholder="Enter meta title for SEO" value="{{ old('meta_title') }}" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Meta Description</label>
                                                        <div class="col-lg-9">
                                                            <textarea name="meta_description" class="form-control" rows="3" placeholder="Enter meta description for SEO">{{ old('meta_description') }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Meta Keywords</label>
                                                        <div class="col-lg-9">
                                                            <input name="meta_keywords" type="text" class="form-control" placeholder="Comma separated keywords" value="{{ old('meta_keywords') }}" />
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
                                                                <input name="cash_on_delivery" class="form-check-input large-toggle" type="checkbox" id="cashOnDeliveryToggle" value="1" {{ old('cash_on_delivery') ? 'checked' : '' }} aria-label="Cash on delivery toggle">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4 shipping-row">
                                                        <label class="col-lg-3 col-form-label">Free Shipping</label>
                                                        <div class="col-lg-9">
                                                            <div class="form-check form-switch">
                                                                <input type="hidden" name="free_shipping" value="0">
                                                                <input name="free_shipping" class="form-check-input large-toggle" type="checkbox" id="freeShippingToggle" value="1" {{ old('free_shipping') ? 'checked' : '' }} aria-label="Free shipping toggle">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4 shipping-row">
                                                        <label class="col-lg-3 col-form-label">Flat Rate</label>
                                                        <div class="col-lg-9">
                                                            <div class="form-check form-switch">
                                                                <input type="hidden" name="flat_rate" value="0">
                                                                <input name="flat_rate" class="form-check-input large-toggle" type="checkbox" id="flatRateToggle" value="1" {{ old('flat_rate') ? 'checked' : '' }} aria-label="Flat rate toggle">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="shippingCostRow" class="row mb-4 {{ old('flat_rate') ? '' : 'd-none' }}">
                                                        <label class="col-lg-3 col-form-label">Shipping cost <label class="text-danger">*</label></label>
                                                        <div class="col-lg-9">
                                                            <input id="shippingCostInput" name="shipping_cost" type="number" min="0" step="0.01" class="form-control" placeholder="0" value="{{ old('shipping_cost', '0') }}" />
                                                        </div>
                                                    </div>

                                                    <!-- Estimate Shipping Time -->
                                                    <div class="mb-3 mt-4"><h4 class="mb-2">Estimate Shipping Time</h4></div>

                                                    <div class="row mb-4">
                                                        <label class="col-lg-3 col-form-label">Shipping Days <label class="text-danger">*</label></label>
                                                        <div class="col-lg-9">
                                                            <div class="input-group" style="max-width:360px">
                                                                <input id="shippingDaysInput" name="shipping_days" type="number" min="0" class="form-control" placeholder="Shipping Days" value="{{ old('shipping_days') }}" />
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
                                                                <input class="form-check-input large-toggle" type="checkbox" id="warrantyToggle" name="warranty_enabled" value="1" {{ old('warranty_enabled') ? 'checked' : '' }} aria-label="Enable warranty">
                                                            </div>

                                                            <div id="warrantyOptions" class="mt-2 {{ old('warranty_enabled') ? '' : 'd-none' }}" style="width:100%;">
                                                                <div style="max-width:420px; width:100%;">
                                                                    <select name="warranty_duration" id="warrantyDuration" class="form-select">
                                                                        <option value="">Select warranty duration</option>
                                                                        <option value="3_months" {{ old('warranty_duration') == '3_months' ? 'selected' : '' }}>3 Months</option>
                                                                        <option value="6_months" {{ old('warranty_duration') == '6_months' ? 'selected' : '' }}>6 Months</option>
                                                                        <option value="1_year" {{ old('warranty_duration') == '1_year' ? 'selected' : '' }}>1 Year</option>
                                                                        <option value="2_years" {{ old('warranty_duration') == '2_years' ? 'selected' : '' }}>2 Years</option>
                                                                        <option value="3_years" {{ old('warranty_duration') == '3_years' ? 'selected' : '' }}>3 Years</option>
                                                                        <option value="5_years" {{ old('warranty_duration') == '5_years' ? 'selected' : '' }}>5 Years</option>
                                                                    </select>
                                                                    <small class="text-muted d-block mt-2">Select how long the product warranty lasts. This will be displayed on the product page.</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    

                                                    
                                                </div>

                                                <!-- row.// -->
                                                <br />
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <button id="prevBtn" class="btn btn-secondary" type="button" style="display: none;">
                                                        <i class="bi bi-arrow-left me-2"></i>Previous
                                                    </button>
                                                    <button id="nextBtn" class="btn btn-primary" type="button">
                                                        Next<i class="bi bi-arrow-right ms-2"></i>
                                                    </button>
                                                    <button id="publishBtn" class="btn btn-success" type="button" style="display: none;">
                                                        <i class="bi bi-check-circle me-2"></i>Publish Product
                                                    </button>
                                                </div>
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
                                                            flashDealToggle.addEventListener('change', function(){ 
                                                                if(flashDealToggle.checked) flashFields.classList.remove('d-none'); 
                                                                else flashFields.classList.add('d-none'); 
                                                            });
                                                        }
                                                    })();

                                                    /* Flash deal validation on submit */
                                                    (function(){
                                                        var form = document.querySelector('form');
                                                        if (form) {
                                                            form.addEventListener('submit', function(e){
                                                                // Validate Flash Deal fields
                                                                var startEl = document.getElementById('flashStart');
                                                                var endEl = document.getElementById('flashEnd');
                                                                var discountInput = document.getElementById('flashDiscount');
                                                                var discountType = document.getElementById('flashDiscountType');
                                                                var startVal = startEl ? startEl.value : '';
                                                                var endVal = endEl ? endEl.value : '';
                                                                var discountVal = discountInput ? parseFloat(discountInput.value || '0') : 0;
                                                                var dtype = discountType ? discountType.value : 'flat';
                                                                var anyFilled = (startVal && startVal.length) || (endVal && endVal.length) || (discountInput && discountInput.value && discountInput.value !== '');
                                                                if (anyFilled) {
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
                                                                }

                                                                // Validate Variant Table fields
                                                                var variantsSection = document.getElementById('variants-section');
                                                                if (variantsSection && !variantsSection.classList.contains('d-none')) {
                                                                    var variantRows = document.querySelectorAll('#variantsTable tbody tr');
                                                                    var hasEmptyFields = false;
                                                                    var emptyFieldNames = [];

                                                                    variantRows.forEach(function(row, index) {
                                                                        var skuInput = row.querySelector('input[name*="[sku]"]');
                                                                        var priceInput = row.querySelector('input[name*="[price]"]');
                                                                        var stockInput = row.querySelector('input[name*="[stock]"]');
                                                                        
                                                                        var variantName = row.cells[1] ? row.cells[1].textContent.trim() : ('Variant ' + (index + 1));

                                                                        if (skuInput && (!skuInput.value || skuInput.value.trim() === '')) {
                                                                            hasEmptyFields = true;
                                                                            emptyFieldNames.push('SKU for ' + variantName);
                                                                            skuInput.style.borderColor = '#dc3545';
                                                                        } else if (skuInput) {
                                                                            skuInput.style.borderColor = '';
                                                                        }

                                                                        if (priceInput && (!priceInput.value || priceInput.value.trim() === '')) {
                                                                            hasEmptyFields = true;
                                                                            emptyFieldNames.push('Price for ' + variantName);
                                                                            priceInput.style.borderColor = '#dc3545';
                                                                        } else if (priceInput) {
                                                                            priceInput.style.borderColor = '';
                                                                        }

                                                                        if (stockInput && (!stockInput.value || stockInput.value.trim() === '')) {
                                                                            hasEmptyFields = true;
                                                                            emptyFieldNames.push('Stock for ' + variantName);
                                                                            stockInput.style.borderColor = '#dc3545';
                                                                        } else if (stockInput) {
                                                                            stockInput.style.borderColor = '';
                                                                        }
                                                                    });

                                                                    if (hasEmptyFields) {
                                                                        e.preventDefault();
                                                                        alert('Please fill all required variant fields:\n\n' + emptyFieldNames.join('\n'));
                                                                        // Scroll to Price & Stock section
                                                                        var priceStockLink = document.querySelector('a[data-target="#section-price-stock"]');
                                                                        if (priceStockLink) {
                                                                            priceStockLink.click();
                                                                        }
                                                                        return false;
                                                                    }
                                                                }
                                                            });
                                                        }
                                                    })();

                                                    /* Nav switching + file previews */
                                                    (function(){
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

                                                        function initNavAndPreviews(){
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
                                                            
                                                            // Show active section
                                                            var activeLink = document.querySelector('nav.nav a.active[data-target]'); 
                                                            if(activeLink){ 
                                                                var t = activeLink.getAttribute('data-target'); 
                                                                var targetEl = document.querySelector(t); 
                                                                if(targetEl) targetEl.classList.remove('d-none'); 
                                                            }
                                                        }

                                                        if (document.readyState === 'loading') { 
                                                            document.addEventListener('DOMContentLoaded', initNavAndPreviews); 
                                                        } else { 
                                                            initNavAndPreviews(); 
                                                        }
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
                                                                rowHtml += '<td><input type="text" name="variants['+idx+'][sku]" class="form-control" placeholder="SKU" required /></td>';
                                                                rowHtml += '<td><input type="number" step="0.01" name="variants['+idx+'][price]" class="form-control variant-price-input" placeholder="0.00" required /></td>';
                                                                rowHtml += '<td><input type="number" name="variants['+idx+'][stock]" class="form-control" placeholder="0" required /></td>';
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
                                                        
                                                        function updateShippingVisibility(){ 
                                                            if(freeToggle && flatToggle && freeToggle.checked && flatToggle.checked){ 
                                                                freeToggle.checked = false; 
                                                            } 
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
                                                        
                                                        if(flatToggle){ 
                                                            flatToggle.addEventListener('change', function(){ 
                                                                if(flatToggle.checked && freeToggle) freeToggle.checked = false; 
                                                                updateShippingVisibility(); 
                                                            });
                                                        }
                                                        
                                                        if(freeToggle){ 
                                                            freeToggle.addEventListener('change', function(){ 
                                                                if(freeToggle.checked && flatToggle) flatToggle.checked = false; 
                                                                updateShippingVisibility(); 
                                                            });
                                                        }
                                                        
                                                        // Initialize on DOM ready
                                                        if(document.readyState === 'loading'){ 
                                                            document.addEventListener('DOMContentLoaded', updateShippingVisibility); 
                                                        } else { 
                                                            updateShippingVisibility(); 
                                                        }
                                                    })();

                                                    /* Warranty visibility */
                                                    (function(){ 
                                                        var toggle = document.getElementById('warrantyToggle'); 
                                                        var options = document.getElementById('warrantyOptions'); 
                                                        if(!toggle || !options) return; 
                                                        
                                                        function updateVisibility(){ 
                                                            if(toggle.checked){ 
                                                                options.classList.remove('d-none'); 
                                                            } else { 
                                                                options.classList.add('d-none'); 
                                                            } 
                                                        } 
                                                        
                                                        toggle.addEventListener('change', updateVisibility);
                                                        
                                                        // Initialize on DOM ready
                                                        if(document.readyState === 'loading'){ 
                                                            document.addEventListener('DOMContentLoaded', updateVisibility); 
                                                        } else { 
                                                            updateVisibility(); 
                                                        } 
                                                    })();

                                                    /* Submit button label updater */
                                                    (function(){ 
                                                        var prevBtn = document.getElementById('prevBtn');
                                                        var nextBtn = document.getElementById('nextBtn');
                                                        var publishBtn = document.getElementById('publishBtn');
                                                        
                                                        if(!prevBtn || !nextBtn || !publishBtn) return;
                                                        
                                                        var sections = [
                                                            '#section-general',
                                                            '#section-files-media',
                                                            '#section-price-stock',
                                                            '#section-seo',
                                                            '#section-shipping',
                                                            '#section-warranty'
                                                        ];
                                                        var currentIndex = 0;
                                                        
                                                        function updateButtons() {
                                                            // Show/hide Previous button
                                                            if(currentIndex === 0) {
                                                                prevBtn.style.display = 'none';
                                                            } else {
                                                                prevBtn.style.display = 'inline-block';
                                                            }
                                                            
                                                            // Show/hide Next and Publish buttons
                                                            if(currentIndex === sections.length - 1) {
                                                                nextBtn.style.display = 'none';
                                                                publishBtn.style.display = 'inline-block';
                                                            } else {
                                                                nextBtn.style.display = 'inline-block';
                                                                publishBtn.style.display = 'none';
                                                            }
                                                        }
                                                        
                                                        function goToSection(index) {
                                                            if(index < 0 || index >= sections.length) return;
                                                            
                                                            currentIndex = index;
                                                            
                                                            // Hide all sections
                                                            document.querySelectorAll('form > div[id^="section-"]').forEach(function(s){ 
                                                                s.classList.add('d-none'); 
                                                            });
                                                            
                                                            // Show current section
                                                            var targetEl = document.querySelector(sections[currentIndex]);
                                                            if(targetEl) targetEl.classList.remove('d-none');
                                                            
                                                            // Update active nav links
                                                            document.querySelectorAll('nav.nav a[data-target]').forEach(function(a){ 
                                                                a.classList.remove('active'); 
                                                            });
                                                            document.querySelectorAll('nav.nav a[data-target="' + sections[currentIndex] + '"]').forEach(function(link){
                                                                link.classList.add('active');
                                                            });
                                                            
                                                            updateButtons();
                                                            
                                                            // Scroll to top
                                                            window.scrollTo({top: 0, behavior: 'smooth'});
                                                        }
                                                        
                                                        // Next button click
                                                        nextBtn.addEventListener('click', function() {
                                                            goToSection(currentIndex + 1);
                                                        });
                                                        
                                                        // Previous button click
                                                        prevBtn.addEventListener('click', function() {
                                                            goToSection(currentIndex - 1);
                                                        });
                                                        
                                                        // Nav link clicks
                                                        document.querySelectorAll('nav.nav a[data-target]').forEach(function(link) {
                                                            link.addEventListener('click', function(e) {
                                                                e.preventDefault();
                                                                var target = link.getAttribute('data-target');
                                                                var index = sections.indexOf(target);
                                                                if(index !== -1) {
                                                                    goToSection(index);
                                                                }
                                                            });
                                                        });
                                                        
                                                        // Initialize
                                                        updateButtons();
                                                    })();

                                                    /* Form validation before submit */
                                                    (function(){
                                                        var form = document.getElementById('productForm');
                                                        var publishBtn = document.getElementById('publishBtn');
                                                        
                                                        if(!form || !publishBtn) return;
                                                        
                                                        publishBtn.addEventListener('click', function(e) {
                                                            e.preventDefault();
                                                            
                                                            var errorMessage = null;
                                                            
                                                            // PRIORITY: Validate flash deal fields FIRST if flash deal is enabled
                                                            var flashDealToggle = document.getElementById('flashDealToggle');
                                                            if(flashDealToggle && flashDealToggle.checked) {
                                                                var flashStart = document.getElementById('flashStart');
                                                                var flashEnd = document.getElementById('flashEnd');
                                                                var flashDiscount = document.getElementById('flashDiscount');
                                                                
                                                                if(!flashStart || !flashStart.value.trim()) {
                                                                    errorMessage = 'Flash Deal is enabled. Please provide Start Date, End Date, and Discount amount.';
                                                                } else if(!flashEnd || !flashEnd.value.trim()) {
                                                                    errorMessage = 'Flash Deal is enabled. Please provide Start Date, End Date, and Discount amount.';
                                                                } else if(!flashDiscount || !flashDiscount.value.trim() || parseFloat(flashDiscount.value) <= 0) {
                                                                    errorMessage = 'Flash Deal is enabled. Please provide Start Date, End Date, and Discount amount.';
                                                                }
                                                            }
                                                            
                                                            // PRIORITY: Validate flat rate shipping cost if flat rate is enabled
                                                            if(!errorMessage) {
                                                                var flatRateToggle = document.getElementById('flatRateToggle');
                                                                if(flatRateToggle && flatRateToggle.checked) {
                                                                    var shippingCost = document.querySelector('input[name="shipping_cost"]');
                                                                    if(!shippingCost || !shippingCost.value.trim() || parseFloat(shippingCost.value) < 0) {
                                                                        errorMessage = 'Flat Rate is enabled. Please provide the shipping cost.';
                                                                    }
                                                                }
                                                            }
                                                            
                                                            // Validate required fields - stop at first error
                                                            if(!errorMessage) {
                                                                var name = document.querySelector('input[name="name"]');
                                                                if(!name || !name.value.trim()) {
                                                                    errorMessage = 'Product name is required';
                                                                }
                                                            }
                                                            
                                                            // Validate category is selected (check for checked radio button)
                                                            if(!errorMessage) {
                                                                var categoryRadio = document.querySelector('input[name="main_category"]:checked');
                                                                if(!categoryRadio || !categoryRadio.value) {
                                                                    errorMessage = 'Please select a category';
                                                                }
                                                            }
                                                            
                                                            if(!errorMessage) {
                                                                var description = document.querySelector('textarea[name="description"]');
                                                                if(!description || !description.value.trim()) {
                                                                    errorMessage = 'Description is required';
                                                                }
                                                            }
                                                            
                                                            // Validate gallery images
                                                            if(!errorMessage) {
                                                                var galleryImages = document.querySelectorAll('input[name="gallery_images[]"]');
                                                                var hasGalleryImage = false;
                                                                galleryImages.forEach(function(input) {
                                                                    if(input.files && input.files.length > 0) {
                                                                        hasGalleryImage = true;
                                                                    }
                                                                });
                                                                if(!hasGalleryImage) {
                                                                    errorMessage = 'At least one gallery image is required';
                                                                }
                                                            }
                                                            
                                                            // Validate colours (check hidden input created by Choices.js)
                                                            if(!errorMessage) {
                                                                var coloursSelect = document.getElementById('coloursSelect');
                                                                
                                                                // Check if any colours are selected in the multi-select
                                                                var hasColours = false;
                                                                if(coloursSelect) {
                                                                    var selectedOptions = Array.from(coloursSelect.options).filter(opt => opt.selected);
                                                                    hasColours = selectedOptions.length > 0;
                                                                }
                                                                
                                                                if(!hasColours) {
                                                                    errorMessage = 'At least one colour is required';
                                                                }
                                                            }
                                                            
                                                            // Validate attributes - if any attribute is selected, its values must be selected
                                                            if(!errorMessage) {
                                                                var attributesSelect = document.getElementById('attributesSelect');
                                                                if(attributesSelect) {
                                                                    var selectedAttributes = Array.from(attributesSelect.options).filter(opt => opt.selected);
                                                                    
                                                                    if(selectedAttributes.length > 0) {
                                                                        // Check each selected attribute has values selected
                                                                        for(var i = 0; i < selectedAttributes.length; i++) {
                                                                            var attrId = selectedAttributes[i].value;
                                                                            var attrName = selectedAttributes[i].text;
                                                                            var valueSelect = document.querySelector('select[name="attribute_values[' + attrId + '][]"]');
                                                                            
                                                                            if(valueSelect) {
                                                                                var selectedValues = Array.from(valueSelect.options).filter(opt => opt.selected);
                                                                                if(selectedValues.length === 0) {
                                                                                    errorMessage = 'Please select at least one value for attribute: ' + attrName;
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            
                                                            // Validate variants table (SKU, Price, Stock fields)
                                                            if(!errorMessage) {
                                                                var variantRows = document.querySelectorAll('#variantsTable tbody tr');
                                                                if(variantRows.length === 0) {
                                                                    errorMessage = 'Please generate product variants by selecting colours and attributes';
                                                                } else {
                                                                    // Check each variant row for required fields
                                                                    for(var i = 0; i < variantRows.length; i++) {
                                                                        var row = variantRows[i];
                                                                        
                                                                        // Check SKU
                                                                        var skuInput = row.querySelector('input[name*="[sku]"]');
                                                                        if(!skuInput || !skuInput.value.trim()) {
                                                                            errorMessage = 'SKU is required for variant ' + (i + 1);
                                                                            break;
                                                                        }
                                                                        
                                                                        // Check Price
                                                                        var priceInput = row.querySelector('input[name*="[price]"]');
                                                                        if(!priceInput || !priceInput.value.trim() || parseFloat(priceInput.value) < 0) {
                                                                            errorMessage = 'Valid price is required for variant ' + (i + 1);
                                                                            break;
                                                                        }
                                                                        
                                                                        // Check Stock
                                                                        var stockInput = row.querySelector('input[name*="[stock]"]');
                                                                        if(!stockInput || stockInput.value.trim() === '' || parseInt(stockInput.value) < 0) {
                                                                            errorMessage = 'Valid stock quantity is required for variant ' + (i + 1);
                                                                            break;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            
                                                            // Validate shipping days
                                                            if(!errorMessage) {
                                                                var shippingDays = document.querySelector('input[name="shipping_days"]');
                                                                if(!shippingDays || !shippingDays.value.trim() || parseInt(shippingDays.value) < 0) {
                                                                    errorMessage = 'Shipping days is required';
                                                                }
                                                            }
                                                            
                                                            // If there's an error, show only the first one as toast
                                                            if(errorMessage) {
                                                                if(typeof toastr !== 'undefined') {
                                                                    toastr.error(errorMessage, "Validation Error", {
                                                                        closeButton: true,
                                                                        progressBar: true,
                                                                        timeOut: 5000,
                                                                        positionClass: "toast-top-right"
                                                                    });
                                                                } else {
                                                                    alert(errorMessage);
                                                                }
                                                                return false;
                                                            }
                                                            
                                                            // If validation passes, submit the form
                                                            form.submit();
                                                        });
                                                    })();
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

@push('scripts')
<script>
    // Display only the first validation error as toast message
    @if($errors->any())
        @php
            $firstError = $errors->first();
        @endphp
        toastr.error("{{ $firstError }}", "Validation Error", {
            closeButton: true,
            progressBar: true,
            timeOut: 5000,
            positionClass: "toast-top-right"
        });
    @endif

    // Display error message as toast
    @if(session('error'))
        toastr.error("{{ session('error') }}", "Error", {
            closeButton: true,
            progressBar: true,
            timeOut: 5000,
            positionClass: "toast-top-right"
        });
    @endif

    // Display success message as toast
    @if(session('success'))
        toastr.success("{{ session('success') }}", "Success", {
            closeButton: true,
            progressBar: true,
            timeOut: 3000,
            positionClass: "toast-top-right"
        });
    @endif
</script>
@endpush