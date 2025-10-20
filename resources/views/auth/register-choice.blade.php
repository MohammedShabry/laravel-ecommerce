<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') }} - Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/theme/favicon.svg') }}" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Match login page styles */
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 400px;
        }

        .card-body {
            padding: 2rem;
        }

        .btn-primary {
            background-color: #FF8C00;
            border: none;
        }

        .btn-primary:hover {
            background-color: #FF4500;
        }

        /* Add green customer button styles */
        .btn-success {
            background-color: #28a745;
            border: none;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
            color: #fff;
        }

        .btn-light {
            border: 1px solid #ddd;
        }

        .icon-svg {
            margin-right: 8px;
            vertical-align: middle;
        }

        a {
            text-decoration: none;
        }

        .text-muted a {
            color: #FF8C00;
            font-weight: 500;
        }

        /* Compact circular social icon buttons kept for parity with login (if needed) */
        .social-btn {
            width: 44px;
            height: 44px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: none;
        }

        .social-btn .icon-svg {
            margin-right: 0;
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body text-center">
            <h5 class="mb-4">Register</h5>

            <div class="d-grid gap-2 mb-3">
                <a href="{{ route('register.seller') }}" class="btn btn-primary text-white py-2">Register as Seller</a>
                <!-- Changed to green -->
                <a href="{{ route('register.customer') }}" class="btn btn-success text-white py-2">Register as Customer</a>
            </div>

            <div class="mt-3 small">
                <p class="mb-0">Already have an account? <a href="{{ route('login.form') }}">Login</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
