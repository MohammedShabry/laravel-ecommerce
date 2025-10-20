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
        /* Updated to match login page spacing and controls */
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
            max-width: 400px; /* matched to login */
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

        .btn-light {
            border: 1px solid #ddd;
        }

        .icon-svg {
            margin-right: 8px;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-4 text-center">Register</h5>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="form-control">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="form-control">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" required class="form-control">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" required class="form-select">
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                    </select>
                    @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
