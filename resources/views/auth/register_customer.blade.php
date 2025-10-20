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

    <!-- Using native select for country (no Select2) -->

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding-top: 4rem;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 600px; /* Wider for side-by-side layout */
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

        label {
            font-weight: 500;
        }

        @media (max-width: 576px) {
            .row .col-md-6 {
                margin-bottom: 1rem;
            }
        }

        /* Added: match login page social button styles */
        .icon-svg {
            margin-right: 8px;
            vertical-align: middle;
        }

        /* Compact circular social icon buttons */
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

        /* match login page link styles */
        a {
            text-decoration: none;
        }

        .text-muted a {
            color: #FF8C00;
            font-weight: 500;
        }


    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-4 text-center">Create your account</h5>
            <p class="text-center text-muted mb-4">
                Register as a {{ ucfirst($role ?? 'customer') }} to start shopping.
            </p>

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                <input type="hidden" name="role" value="{{ $role ?? 'customer' }}">

                <!-- Full Name (Full width) -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full name</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                        class="form-control">
                </div>

                <!-- Email & Phone -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                            class="form-control">
                    </div>
                </div>

                <!-- Date of Birth & Country -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="birthdate" class="form-label">Date of birth</label>
                        <input id="birthdate" name="birthdate" type="date" value="{{ old('birthdate') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <select id="country" name="country" class="form-select country-select">
                            <option value="" disabled {{ old('country') ? '' : 'selected' }}>Select your country</option>
                            @php
                                $countries = [
                                    'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Argentina', 'Armenia', 'Australia', 'Austria',
                                    'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin',
                                    'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso',
                                    'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Central African Republic', 'Chad', 'Chile',
                                    'China', 'Colombia', 'Comoros', 'Congo', 'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic',
                                    'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea',
                                    'Eritrea', 'Estonia', 'Eswatini', 'Ethiopia', 'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia',
                                    'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guyana', 'Haiti', 'Honduras', 'Hungary',
                                    'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan',
                                    'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia',
                                    'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali',
                                    'Malta', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro',
                                    'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua',
                                    'Niger', 'Nigeria', 'North Korea', 'North Macedonia', 'Norway', 'Oman', 'Pakistan', 'Palestine', 'Panama',
                                    'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Qatar', 'Romania', 'Russia',
                                    'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino',
                                    'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia',
                                    'Solomon Islands', 'Somalia', 'South Africa', 'South Korea', 'South Sudan', 'Spain', 'Sri Lanka', 'Sudan',
                                    'Suriname', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste',
                                    'Togo', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraine',
                                    'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City',
                                    'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe', 'Other'
                                ];
                            @endphp
                            @foreach ($countries as $country)
                                <option value="{{ $country }}" {{ old('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>

                <!-- Password & Confirm Password -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" required class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="form-control">
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>

            <!-- Added: social sign-in area (same as login page) -->
            <p class="text-center text-muted small mb-2">or sign up with</p>

            <div class="d-flex justify-content-center gap-2 mb-3">
                <a href="#" class="btn btn-light social-btn" aria-label="Sign in with Google">
                    <svg aria-hidden="true" class="icon-svg" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M16.51 8H8.98v3h4.3c-.18 1-.74 1.48-1.6 2.04v2.01h2.6a7.8 7.8 0 002.38-5.88c0-.57-.05-.66-.15-1.18z" fill="#4285F4"></path>
                        <path d="M8.98 17c2.16 0 3.97-.72 5.3-1.94l-2.6-2a4.8 4.8 0 01-7.18-2.54H1.83v2.07A8 8 0 008.98 17z" fill="#34A853"></path>
                        <path d="M4.5 10.52a4.8 4.8 0 010-3.04V5.41H1.83a8 8 0 000 7.18l2.67-2.07z" fill="#FBBC05"></path>
                        <path d="M8.98 4.18c1.17 0 2.23.4 3.06 1.2l2.3-2.3A8 8 0 001.83 5.4L4.5 7.49a4.77 4.77 0 014.48-3.3z" fill="#EA4335"></path>
                    </svg>
                </a>

                <a href="#" class="btn btn-light social-btn" aria-label="Sign in with Facebook">
                    <svg aria-hidden="true" class="icon-svg" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M3 1a2 2 0 00-2 2v12c0 1.1.9 2 2 2h12a2 2 0 002-2V3a2 2 0 00-2-2H3zm6.55 16v-6.2H7.46V8.4h2.09V6.61c0-2.07 1.26-3.2 3.1-3.2.88 0 1.64.07 1.87.1v2.16h-1.29c-1 0-1.19.48-1.19 1.18V8.4h2.39l-.31 2.42h-2.08V17h-2.5z" fill="#4167B2"></path>
                    </svg>
                </a>
            </div>

            <p class="text-center text-muted small mb-1">Already have an account? <a href="{{ route('login.form') }}">Log in</a></p>
        </div>
    </div>

    <!-- No Select2 - using native browser select so selected country is visible -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                                
</body>
</html>
