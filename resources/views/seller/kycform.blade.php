<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Seller KYC</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="shortcut icon" href="{{ asset('assetsbackend/imgs/theme/favicon.svg') }}" />
	<link href="{{ asset('assetsbackend/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="screen-overlay"></div>

	<!-- Sidebar, Header (navbar) and Footer intentionally omitted for this page -->

	<main class="">
		<section class="content-main">
			<div class="row">
				<div class="col-12">
					<div class="content-header">
						<h2 class="content-title">Seller KYC</h2>
					</div>

					<div class="card mb-4">
						<div class="card-header">
							<h4>Business & Bank Details</h4>
						</div>
						<div class="card-body">
							@php
								if (! isset($kyc)) {
									$kyc = auth()->check() ? \App\Models\SellerKyc::where('user_id', auth()->id())->orWhere('seller_id', optional(auth()->user()->sellerProfile)->id)->first() : null;
								}
							@endphp

							@if($kyc)
								@if($kyc->verification_status === 'pending')
									<div class="alert alert-warning" role="alert">
										<h4 class="alert-heading">Awaiting Admin Approval</h4>
										<p>Your KYC has been submitted and is awaiting review by an administrator. We'll notify you when the status changes.</p>
									</div>
								@elseif($kyc->verification_status === 'approved')
									<div class="alert alert-success" role="alert">
										<h4 class="alert-heading">You're verified</h4>
										<p>Your account is verified and you can access seller features.</p>
									</div>
								@elseif($kyc->verification_status === 'rejected')
									<div class="alert alert-danger" role="alert">
										<h4 class="alert-heading">KYC Rejected</h4>
										<p>{{ $kyc->rejection_reason ?? 'Your submission was rejected. Please review and resubmit with correct information.' }}</p>
									</div>
								@endif
							@endif

							@if(! $kyc || ($kyc && $kyc->verification_status === 'rejected'))
								<form id="kyc-form" method="POST" action="{{ route('seller.kyc.submit') }}" enctype="multipart/form-data">
									@csrf

									<!-- 1. Business Information -->
									<div class="card mb-4">
										<div class="card-header">
											<h4>1. Business Information</h4>
										</div>
										<div class="card-body">
											<div class="mb-4">
												<label class="form-label">Shop Name</label>
												<input type="text" name="shop_name" class="form-control" value="{{ old('shop_name', optional($kyc)->shop_name) }}" />
											</div>

											<div class="mb-4">
												<label class="form-label">Business Type</label>
												<select name="business_type" class="form-control">
													<option value="">Select business type</option>
													<option value="sole_proprietorship" {{ old('business_type', optional($kyc)->business_type)=='sole_proprietorship' ? 'selected' : '' }}>Sole proprietorship</option>
													<option value="partnership" {{ old('business_type', optional($kyc)->business_type)=='partnership' ? 'selected' : '' }}>Partnership</option>
													<option value="private_limited" {{ old('business_type', optional($kyc)->business_type)=='private_limited' ? 'selected' : '' }}>Private limited</option>
													<option value="public_limited" {{ old('business_type', optional($kyc)->business_type)=='public_limited' ? 'selected' : '' }}>Public limited</option>
													<option value="other" {{ old('business_type', optional($kyc)->business_type)=='other' ? 'selected' : '' }}>Other</option>
												</select>
											</div>

											<div class="mb-4">
												<label class="form-label">Business Description</label>
												<textarea name="business_description" class="form-control" rows="3">{{ old('business_description', optional($kyc)->business_description) }}</textarea>
											</div>

											<div class="mb-4">
												<label class="form-label">Business Registration Number</label>
												<input type="text" name="business_registration_number" class="form-control" value="{{ old('business_registration_number', optional($kyc)->business_registration_number) }}" />
											</div>
										</div>
									</div>

									<!-- 2. Business Address -->
									<div class="card mb-4">
										<div class="card-header">
											<h4>2. Business Address</h4>
										</div>
										<div class="card-body">
											<div class="mb-3">
												<label class="form-label">Street / Building Name</label>
												<input type="text" name="address_street" class="form-control" value="{{ old('address_street', optional($kyc)->address_street) }}" />
											</div>

											<div class="row">
												<div class="col-lg-4">
													<div class="mb-3">
														<label class="form-label">City / Town</label>
														<input type="text" name="address_city" class="form-control" value="{{ old('address_city', optional($kyc)->address_city) }}" />
													</div>
												</div>
												<div class="col-lg-4">
													<div class="mb-3">
														<label class="form-label">State / Province / Region</label>
														<input type="text" name="address_state" class="form-control" value="{{ old('address_state', optional($kyc)->address_state) }}" />
													</div>
												</div>
												<div class="col-lg-4">
													<div class="mb-3">
														<label class="form-label">Postal / ZIP Code</label>
														<input type="text" name="address_postal" class="form-control" value="{{ old('address_postal', optional($kyc)->address_postal) }}" />
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- 3. Bank Account Details -->
									<div class="card mb-4">
										<div class="card-header">
											<h4>3. Bank Account Details</h4>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-lg-6">
													<div class="mb-4">
														<label class="form-label">Bank Name</label>
														<input type="text" name="bank_name" required class="form-control" value="{{ old('bank_name', optional($kyc)->bank_name) }}" />
													</div>
												</div>
												<div class="col-lg-6">
													<div class="mb-4">
														<label class="form-label">Branch Name</label>
														<input type="text" name="branch_name" class="form-control" value="{{ old('branch_name', optional($kyc)->branch_name) }}" />
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-lg-6">
													<div class="mb-4">
														<label class="form-label">Account Holder Name</label>
														<input type="text" name="account_holder_name" required class="form-control" value="{{ old('account_holder_name', optional($kyc)->account_holder_name) }}" />
													</div>
												</div>
												<div class="col-lg-6">
													<div class="mb-4">
														<label class="form-label">Account Number</label>
														<input type="text" name="account_number" required class="form-control" value="{{ old('account_number', optional($kyc)->account_number) }}" />
													</div>
												</div>
											</div>

											<div class="mb-4">
												<!-- Bank Code removed -->
											</div>
										</div>
									</div>

									<!-- 4. Identity Verification -->
									<div class="card mb-4">
										<div class="card-header">
											<h4>4. Identity Verification</h4>
										</div>
										<div class="card-body">
											<div class="mb-4">
												<label class="form-label">National ID / Passport Number</label>
												<input type="text" name="national_id_number" required class="form-control" value="{{ old('national_id_number', optional($kyc)->national_id_number) }}" />
											</div>

											<div class="mb-3">
												<label class="form-label">Upload ID Front Image (required)</label>
												<input type="file" name="id_proof_front" required class="form-control" />
												@if(optional($kyc)->id_proof_front)
													<p class="small text-muted">Previously uploaded: {{ basename(optional($kyc)->id_proof_front) }}</p>
												@endif
											</div>

											<div class="mb-3">
												<label class="form-label">Upload ID Back Image (optional)</label>
												<input type="file" name="id_proof_back" class="form-control" />
											</div>

											<div class="mb-3">
												<label class="form-label">Additional Document (optional)</label>
												<input type="file" name="additional_doc" class="form-control" />
											</div>
										</div>
									</div>

									<label class="form-check mb-4">
										<input class="form-check-input" type="checkbox" name="terms_agreed" value="1" required />
										<span class="form-check-label"> I agree to terms &amp; conditions </span>
									</label>

									<!-- keep an inline submit in case user uses this area -->
									<div class="d-flex justify-content-end">
										<button type="submit" class="btn btn-primary">Submit KYC</button>
									</div>
									</form>
							@endif

						</div>
					</div>
					<!-- card end// -->
				</div>

				<!-- removed sidebar Upload Documents and Summary cards as requested -->
			</div> <!-- row end -->
		</section>
	</main>

	<!-- Scripts (same as seller layout) -->
	<script src="{{ asset('assetsbackend/js/vendors/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/select2.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/jquery.fullscreen.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/chart.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/main.js?v=6.0') }}"></script>
	<script src="{{ asset('assetsbackend/js/custom-chart.js') }}"></script>
</body>
</html>
