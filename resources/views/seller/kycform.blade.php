<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Seller KYC</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="shortcut icon" href="{{ asset('assetsbackend/imgs/theme/favicon.svg') }}" />
	<link href="{{ asset('assetsbackend/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />

	<style>
		/* Fullscreen hero-style status page */
		.kyc-overlay {
			position: fixed;
			inset: 0;
			width: 100vw;
			height: 100vh;
			/* dashboard-inspired palette: soft warm ivory with light orange tint */
			background: linear-gradient(135deg, #fffaf0 0%, #fff7ed 50%, #fffef9 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			z-index: 99999; /* ensure overlay sits above other UI layers */
			pointer-events: auto;
			color: #05264a; /* deep slate text for contrast */
			animation: fadeIn 360ms ease-out both;
			/* allow scrolling on small screens so content isn't clipped */
			overflow-y: auto;
			-webkit-overflow-scrolling: touch;
		}

		/* container that becomes the full-bleed hero */
		.kyc-card {
			width: 100%;
			/* use auto height so overlay can scroll when content exceeds viewport */
			height: auto;
			display: flex;
			/* top align so layout reads like a page header rather than a centered popup */
			align-items: flex-start;
			justify-content: center;
			padding: 80px 48px;
			box-sizing: border-box;
			min-height: 100vh;
			padding-bottom: 120px; /* space for mobile safe-area */
		}

		.kyc-hero {
			display: grid;
			grid-template-columns: 1fr 520px;
			gap: 48px;
			align-items: center;
			width: min(1200px, calc(100% - 80px));
		}

		.kyc-hero-left h1{ font-size: 40px; margin:0 0 12px; line-height:1.02; color: #1f2937 }
		.kyc-hero-left p{ color: rgba(31,41,55,0.85); margin:0 0 18px; font-size:18px }
		.kyc-hero-left .meta { color: rgba(31,41,55,0.6); font-size:14px; margin-bottom:20px }

		.kyc-hero-right{ display:flex; align-items:center; justify-content:center }

		/* visual for pending: animated ring */
/* visual for pending: animated ring */
/* visual for pending: animated ring */
		.pending-ring {
			width: 360px;
			height: 360px;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	/* warm amber gradient for strong visibility */
	background: radial-gradient(circle at 30% 30%, rgba(255,215,0,0.35), rgba(234,179,8,0.25), rgba(245,158,11,0.15));
	box-shadow: 0 30px 80px rgba(234,179,8,0.3), inset 0 0 50px rgba(255,215,0,0.2);
	animation: pulseGlow 2.6s ease-in-out infinite;
}

/* inner ring */
		.ring {
			width: 220px;
			height: 220px;
	border-radius: 50%;
	border: 8px solid rgba(234,179,8,0.5);
	position: relative;
	display: flex;
	align-items: center;
	justify-content: center;
	background: radial-gradient(circle, rgba(255,249,196,0.6) 0%, rgba(250,204,21,0.1) 100%);
	box-shadow: 0 0 40px rgba(234,179,8,0.35);
}

/* glowing border */
.ring:before {
	content: '';
	position: absolute;
	inset: 0;
	border-radius: 50%;
	box-shadow: 0 0 0 8px rgba(234,179,8,0.25) inset;
}

/* animated spinner */
		.ring .spinner {
			width: 92px;
			height: 92px;
	border-radius: 50%;
	border: 8px solid rgba(234,179,8,0.25);
	border-top-color: #eab308; /* rich amber accent */
	animation: spin 1.4s linear infinite;
	box-shadow: 0 0 25px rgba(234,179,8,0.5);
}

		/* Responsive adjustments */
		@media (max-width: 980px) {
			.kyc-hero { grid-template-columns: 1fr; gap: 20px; width: calc(100% - 48px); }
			.kyc-card { padding: 32px 20px 80px; }
			.kyc-hero-left { text-align: left; }
			.pending-ring { width: 240px; height: 240px; }
			.ring { width: 160px; height: 160px; border-width: 6px; }
			.ring .spinner { width: 66px; height: 66px; border-width: 6px; }
			.kyc-hero-left h1{ font-size: 28px; }
		}

		@media (max-width: 520px) {
			.kyc-card { padding: 20px 14px 80px; }
			.kyc-hero { gap: 16px; }
			.pending-ring { width: 180px; height: 180px; }
			.ring { width: 120px; height: 120px; border-width: 5px; }
			.ring .spinner { width: 52px; height: 52px; border-width: 5px; }
			.kyc-hero-left h1{ font-size: 22px; }
			.kyc-hero-left p{ font-size: 15px; }
			.kyc-hero-left .meta{ font-size:13px }
			/* Make action buttons stack and be full-width on very small screens */
			.kyc-actions{ flex-direction: column; align-items: stretch; gap:10px }
			.kyc-actions .btn, .kyc-actions a{ width:100%; display:block; text-align:center }
			/* ensure form cards are full-width and readable */
			.card { margin: 0; border-radius: 8px; }
			.card .card-body { padding: 12px; }
			.form-control { font-size: 14px; }
		}

/* spinner rotation */
@keyframes spin {
	to { transform: rotate(360deg); }
}

/* subtle breathing glow animation */
@keyframes pulseGlow {
	0%, 100% {
		box-shadow: 0 30px 80px rgba(234,179,8,0.25), inset 0 0 40px rgba(255,215,0,0.15);
		transform: scale(1);
	}
	50% {
		box-shadow: 0 30px 90px rgba(255,215,0,0.4), inset 0 0 60px rgba(255,215,0,0.25);
		transform: scale(1.03);
	}
}



		/* approved / rejected large icon */
		.status-hero-icon{ font-size:86px; line-height:1; }
		.status-hero-icon.success{ color: #10b981; text-shadow: 0 6px 18px rgba(16,185,129,0.12); }
		.status-hero-icon.error{ color: #ef4444; font-size:110px; text-shadow: 0 10px 30px rgba(239,68,68,0.18); }

		.kyc-actions { display:flex; gap:12px; align-items:center }
		.btn-ghost{ background: transparent; border:1px solid rgba(31,41,55,0.06); color: #1f2937 }
		/* primary color (dashboard orange) */
		.btn.btn-primary{ background-color: #f97316; border-color: #f97316; color:#fff }
		.btn.btn-danger{ background-color:#ef4444; border-color:#ef4444; color:#fff }

		@media (max-width:900px){ .kyc-hero{ grid-template-columns: 1fr; text-align:center } .kyc-hero-right{ margin-top:24px } .kyc-hero-left h1{ font-size:32px } }

		@keyframes fadeIn { from { opacity: 0 } to { opacity: 1 } }
	</style>
</head>

<body>
	<div class="screen-overlay"></div>

	@php
		// Ensure $kyc is loaded early so we can decide to render a dedicated full-page KYC status screen
		if (! isset($kyc)) {
			$kyc = auth()->check() ? \App\Models\SellerKyc::where('user_id', auth()->id())->orWhere('seller_id', optional(auth()->user()->sellerProfile)->id)->first() : null;
		}

		// decide whether to show the dedicated full-page KYC status screen
		$showStatusPage = isset($kyc) && in_array(optional($kyc)->verification_status, ['pending','approved','rejected']);
		// if user explicitly wants to resubmit, show the form again even if a KYC exists
		if(request()->query('resubmit') == '1'){
			$showStatusPage = false;
		}
	@endphp

	@if($showStatusPage)
		{{-- Full-page KYC status screen (replaces the rest of the page until admin action) --}}
		<div class="kyc-overlay">
			<div class="kyc-card" role="document" aria-labelledby="kyc-title">
				@php $status = $kyc->verification_status; @endphp
				<div class="kyc-hero">
					<div class="kyc-hero-left">
						@if($status === 'pending')
							<h1 id="kyc-title">KYC Under Review</h1>
							<div class="meta">Submitted {{ optional($kyc)->submitted_at ? optional($kyc)->submitted_at->diffForHumans() : '' }}</div>
							<p>Your documentation is being reviewed by our verification team. This usually takes 24–72 hours. We'll notify you when it's complete. You can safely leave this page and return later to check the status.</p>
							<div class="kyc-actions">

							</div>
						@elseif($status === 'approved')
							<h1 id="kyc-title">KYC Approved</h1>
							<div class="meta">Approved on {{ optional($kyc)->updated_at ? optional($kyc)->updated_at->format('M d, Y') : '' }}</div>
							<p>Your account has been verified. You can now access the seller dashboard and list products.</p>
							<div class="kyc-actions">
								<button class="btn btn-primary btn-done">Done</button>
							</div>
						@elseif($status === 'rejected')
							<h1 id="kyc-title">KYC Rejected</h1>
							<div class="meta">Last reviewed {{ optional($kyc)->updated_at ? optional($kyc)->updated_at->diffForHumans() : '' }}</div>
							<p class="small">Your submission was rejected. Please review and resubmit with correct information.</p>
							@if(!empty($kyc->rejection_reason))
								<p class="small" style="margin-top:8px;font-weight:600">Reason for rejection: <span style="font-weight:400">{{ $kyc->rejection_reason }}</span></p>
							@endif
							<div class="kyc-actions">
								<a href="{{ route('seller.kyc', ['resubmit' => 1]) }}" class="btn btn-danger">Resubmit KYC</a>
							</div>
						@endif
					</div>

					<div class="kyc-hero-right">
						@if($status === 'pending')
							<div class="pending-ring" aria-hidden="true">
								<div class="ring">
									<div class="spinner" role="img" aria-label="processing"></div>
								</div>
							</div>
						@elseif($status === 'approved')
							<div class="status-hero-icon success">✅</div>
						@elseif($status === 'rejected')
							<div class="status-hero-icon error">✖</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	@endif

	<!-- Sidebar, Header (navbar) and Footer intentionally omitted for this page -->

	<main class="">
		@unless($showStatusPage)
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


							@if($kyc)
								{{-- KYC exists; full-page status is shown at top of document when appropriate. --}}
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
					@endunless

	<!-- Scripts (same as seller layout) -->
	<script src="{{ asset('assetsbackend/js/vendors/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/select2.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/jquery.fullscreen.min.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/vendors/chart.js') }}"></script>
	<script src="{{ asset('assetsbackend/js/main.js?v=6.0') }}"></script>
	<script src="{{ asset('assetsbackend/js/custom-chart.js') }}"></script>

	<script>
		// One-time acknowledgement for approved KYC: store flag in sessionStorage and redirect to dashboard
		document.addEventListener('DOMContentLoaded', function(){
			var overlay = document.querySelector('.kyc-overlay');
			if(!overlay) return;
			var status = '{{ optional($kyc)->verification_status }}';
			// If already acknowledged, immediately send to dashboard (so the approved screen is only shown once)
			if(status === 'approved'){
				try{
					if(sessionStorage.getItem('kyc_accepted_seen') === '1'){
						window.location.href = "{{ url('/seller/dashboard') }}";
						return;
					}
				}catch(e){}

				var done = overlay.querySelector('.btn-done');
				if(done){
					done.addEventListener('click', function(e){
						e.preventDefault();
						try{ sessionStorage.setItem('kyc_accepted_seen','1'); }catch(err){}
						window.location.href = "{{ url('/seller/dashboard') }}";
					});
				}
			}
		});
	</script>


</body>
</html>
