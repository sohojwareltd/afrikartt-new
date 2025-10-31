@extends('auth.seller.registration.layout', ['current_step' => 4])
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <style>
        .select2-container .select2-selection--single {
            box-sizing: border-box !important;
            cursor: pointer;
            display: block;
            height: 48px !important;
            user-select: none !important;
            -webkit-user-select: none;
        
            display: flex !important    ;
            align-items: center !important;
        }

     

        /* Step indicator animations */
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 3px 12px rgba(var(--accent-color-rgb), 0.25);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 5px 20px rgba(var(--accent-color-rgb), 0.4);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 3px 12px rgba(var(--accent-color-rgb), 0.25);
            }
        }

        @keyframes checkmark {
            0% {
                transform: scale(0) rotate(0deg);
            }

            50% {
                transform: scale(1.2) rotate(180deg);
            }

            100% {
                transform: scale(1) rotate(360deg);
            }
        }

        @keyframes progressFill {
            0% {
                background: #e5e7eb;
            }

            100% {
                background: var(--accent-color);
            }
        }

        .step-transition {
            animation: checkmark 0.6s ease-in-out;
        }

        .progress-fill {
            animation: progressFill 0.5s ease-in-out forwards;
        }

        /* Enhanced button states */
        .btn.btn-enabled {
            background: var(--accent-color) !important;
            color: white !important;
            cursor: pointer !important;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .btn.btn-enabled:hover {
            background: #c58514 !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(var(--accent-color-rgb), 0.3);
        }

        /* Registration progress */
        .registration-progress {
            background: #fff;
            border: 1px solid #eee;
            border-left: 4px solid var(--accent-color);
            padding: 12px 16px;
            margin: 16px 0 24px 0;
        }
        .registration-progress .progress-track {
            width: 100%;
            height: 8px;
            background: #f1f5f9;
            border-radius: 999px;
            overflow: hidden;
        }
        .registration-progress .progress-bar {
            height: 100%;
            width: 0%;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }

        /* Highlight for missing ID uploads */
        .id-required-missing {
            outline: 2px solid #dc3545;
            outline-offset: 3px;
        }

        /* Validation error visibility */
        .invalid-feedback {
            display: block !important;
            font-size: 0.95rem;
            color: #b00020;
            margin-top: 6px;
        }
        .is-invalid,
        .is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.1rem rgba(220, 53, 69, 0.15) !important;
        }
    </style>
@endsection
@section('registration-content')
    <section class="ec-page-content section-space-p" style="background: #f4fbfd; min-height: 100vh; padding: 48px 0;">
        <div class="container">
            <div class="row justify-content-center">

                <div class="card shadow-lg border-0" style="border-left: 8px solid var(--accent-color);">
                    <div class="card-body p-4 p-md-5">

                        <div class="mt-3 text-center">
                            <span id="section-title" class="fw-bold text-dark" style="font-size: 2.5rem;"> Vendor
                                Verification</span>

                        </div>

                        <div
                            style="width: 80px; height: 4px; background: var(--accent-color); border-radius: 2px; margin-bottom: 1.5rem;">
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert" style="border-radius:0;">
                                <div class="fw-bold mb-1"><i class="fas fa-times-circle me-1"></i> Please fix the following errors:</div>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div id="id-upload-alert" class="alert alert-danger d-none" role="alert" style="border-radius:0;">
                            <i class="fas fa-exclamation-triangle me-1"></i> Please upload both front and back of your ID to continue.
                        </div>

                        <div class="registration-progress">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="small text-secondary">
                                    <span id="registration-progress-text">0 of 0 fields completed</span>
                                </div>
                                <div class="small fw-bold" style="color: var(--accent-color);">
                                    <span id="registration-progress-percent">0%</span>
                                </div>
                            </div>
                            <div class="progress-track">
                                <div id="registration-progress-bar" class="progress-bar"></div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('vendor.registration.verification.store') }}" enctype="multipart/form-data"
                            id="verification-form">
                            @csrf

                            <!-- Hidden field for signature -->
                            <input type="hidden" name="signature" id="verification-signature-input">

                            <h4 class="fw-bold text-dark mb-2 d-flex align-items-center" style="letter-spacing: 1px;">
                                <i class="fas fa-user me-2" style="color: var(--accent-color);"></i> Personal Info
                            </h4>
                            <div
                                style="width: 60px; height: 4px; background: var(--accent-color); border-radius: 2px; margin-bottom: 0.5rem;">
                            </div>
                            <div class="mb-3 text-secondary small" style="margin-bottom: 1.5rem !important;">
                                <i class="fas fa-info-circle me-1"></i> Please provide your personal details for
                                verification.
                            </div>
                            <div class="shadow-sm mb-4"
                                style="background:#fafdff; border-left:4px solid var(--accent-color); padding:32px 24px 24px 24px; border-radius: 0;">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">Phone<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-1" style="border-radius:0;"><i
                                                    class="fas fa-user" style="color: var(--accent-color);"></i></span>
                                            <input id="phone" type="text" placeholder="Enter your phone number"
                                                class="form-control bg-white border-1 px-4 py-2 @error('phone') is-invalid @enderror"
                                                name="phone" value="{{ old('phone') ?? '' }}" required
                                                autocomplete="phone" autofocus style="box-shadow:none; border-radius:0;">
                                        </div>
                                        @error('phone')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="birth_date" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">Date Of Birth<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-1" style="border-radius:0;"><i
                                                    class="fas fa-calendar-alt"
                                                    style="color: var(--accent-color);"></i></span>
                                            <input id="birth_date" type="date" max="2003-05-29"
                                                placeholder="Date Of Birth"
                                                class="form-control bg-white border-1 px-4 py-2 @error('dob') is-invalid @enderror"
                                                name="dob" value="{{ old('dob') ?? '' }}" required
                                                autocomplete="birth_date" autofocus
                                                style="box-shadow:none; border-radius:0;">
                                        </div>
                                        @error('dob')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label for="tax_no" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">Employer
                                            identification
                                            number (EIN) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-1" style="border-radius:0;"><i
                                                    class="fas fa-id-card" style="color: var(--accent-color);"></i></span>
                                            <input id="tax_no" type="text"
                                                placeholder="Enter your EIN or leave blank if you don't have one"
                                                class="form-control bg-white border-1 px-4 py-2 @error('tax_no') is-invalid @enderror"
                                                name="tax_no" value="{{ old('tax_no') ?? '' }}" autocomplete="tax_no"
                                                autofocus style="box-shadow:none; border-radius:0;">
                                        </div>
                                        @error('tax_no')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="govt_id_front" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">ID Front side
                                            <span class="text-danger">*</span></label>
                                        <label for="govt_id_front"
                                            class="w-100 d-flex flex-column align-items-center justify-content-center mb-2"
                                            style="border:2px dashed var(--accent-color); border-radius:0; padding:28px 0; cursor:pointer; background:#fafdff; transition:box-shadow 0.2s;"
                                            onmouseover="this.style.boxShadow='0 0 0 2px rgba(var(--accent-color-rgb), 0.13)'"
                                            onmouseout="this.style.boxShadow='none'">
                                            <i class="fas fa-id-badge mb-2"
                                                style="font-size:2rem;color: var(--accent-color);"></i>
                                            <span class="fw-bold text-secondary">Click or drag file to upload (JPEG
                                                or
                                                PNG)</span>
                                            <input id="govt_id_front" type="file"
                                                class="d-none @error('govt_id_front') is-invalid @enderror"
                                                name="govt_id_front" required
                                                accept="image/*"
                                                onchange="document.getElementById('govt_id_front_name').textContent = this.files[0]?.name || 'No file chosen'">
                                        </label>
                                        <span id="govt_id_front_name"
                                            class="ms-2 align-self-center text-secondary small">No file
                                            chosen</span>
                                        @error('govt_id_front')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="govt_id_back" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">ID Back side <span
                                                class="text-danger">*</span></label>
                                        <label for="govt_id_back"
                                            class="w-100 d-flex flex-column align-items-center justify-content-center mb-2"
                                            style="border:2px dashed var(--accent-color); border-radius:0; padding:28px 0; cursor:pointer; background:#fafdff; transition:box-shadow 0.2s;"
                                            onmouseover="this.style.boxShadow='0 0 0 2px rgba(var(--accent-color-rgb), 0.13)'"
                                            onmouseout="this.style.boxShadow='none'">
                                            <i class="fas fa-id-badge mb-2"
                                                style="font-size:2rem;color: var(--accent-color);"></i>
                                            <span class="fw-bold text-secondary">Click or drag file to
                                                upload</span>
                                            <input id="govt_id_back" type="file"
                                                class="d-none @error('govt_id_back') is-invalid @enderror"
                                                name="govt_id_back" required
                                                accept="image/*"
                                                onchange="document.getElementById('govt_id_back_name').textContent = this.files[0]?.name || 'No file chosen'">
                                        </label>
                                        <span id="govt_id_back_name"
                                            class="ms-2 align-self-center text-secondary small">No file
                                            chosen</span>
                                        @error('govt_id_back')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>




                            <h4 class="fw-bold text-dark mb-2 d-flex align-items-center" style="letter-spacing: 1px;">
                                <i class="fas fa-store-alt me-2" style="color: var(--accent-color);"></i> Shop
                                Address
                            </h4>
                            <div
                                style="width: 60px; height: 4px; background: var(--accent-color); border-radius: 2px; margin-bottom: 0.5rem;">
                            </div>
                            <div class="mb-3 text-secondary small" style="margin-bottom: 1.5rem !important;">
                                <i class="fas fa-info-circle me-1"></i> Please provide your shop’s address for
                                verification and payments.
                            </div>
                            <div class="shadow-sm mb-4"
                                style="background:#fafdff; border-left:4px solid var(--accent-color); padding:32px 24px 24px 24px; border-radius: 0;">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="store_name" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">
                                            Store Name<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" id="name"
                                            class="bg-light form-control mx-0 border @error('name') is-invalid @enderror"
                                            value="{{ old('name') ?? '' }}" required>
                                        @error('name')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    </select>
                             

                                    <div class="col-md-6">
                                        <label for="store_email" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">
                                            Store Email<span class="text-danger">*</span>
                                        </label>
                                        <input type="email" name="store_email" id="store_email"
                                            class="bg-light form-control mx-0 border @error('store_email') is-invalid @enderror"
                                            value="{{ old('store_email') ?? '' }}" required>
                                        @error('store_email')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    </select>
                                    @error('store_email')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror

                                    <div class="col-md-6">
                                        <label for="company_name" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">
                                            Company Name<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="company_name" id="company_name"
                                            class="bg-light form-control mx-0 border @error('company_name') is-invalid @enderror"
                                            value="{{ old('company_name') ?? '' }}" required>
                                        @error('company_name')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    </select>
                                    @error('company_name')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror

                                    <div class="col-md-6">
                                        <label for="company_registration" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">
                                            Company Registration<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="company_registration" id="company_registration"
                                            class="bg-light form-control mx-0 border @error('company_registration') is-invalid @enderror"
                                            value="{{ old('company_registration') ?? '' }}" required>
                                        @error('company_registration')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    </select>
                                    @error('company_registration')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror


                                    <div class="col-md-6">
                                        <label for="country" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">
                                            Country<span class="text-danger">*</span>
                                        </label>
                                        <select
                                            class="bg-light form-select form-control mx-0 border @error('country') is-invalid @enderror"
                                            name="country" id="country" required>
                                            <option value="">Loading countries...</option>
                                        </select>
                                        @error('country')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="state" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">
                                            State<span class="text-danger">*</span>
                                        </label>
                                        <select
                                            class="bg-light form-select form-control mx-0 border @error('state') is-invalid @enderror"
                                            name="state" id="state" required>
                                            <option value="">Select State</option>
                                        </select>
                                        @error('state')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="city" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">City<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-1" style="border-radius:0;"><i
                                                    class="fas fa-map-marker-alt"
                                                    style="color: var(--accent-color);"></i></span>
                                            <input type="text"
                                                class="form-control bg-white border-1 px-4 py-2 @error('city') is-invalid @enderror"
                                                value="{{ auth()->user()->shop ? auth()->user()->shop->city : ' ' }}"
                                                name="city" id="city" required
                                                style="box-shadow:none; border-radius:0;" placeholder="Enter your city">
                                        </div>
                                        @error('city')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="post_code" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">Zip</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-1" style="border-radius:0;"><i
                                                    class="fas fa-map-pin" style="color: var(--accent-color);"></i></span>
                                            <input type="text" placeholder="Enter your postal/zip code"
                                                class="form-control bg-white border-1 px-4 py-2 @error('post_code') is-invalid @enderror"
                                                value="{{ auth()->user()->shop ? auth()->user()->shop->post_code : ' ' }}"
                                                name="post_code" id="post_code" required
                                                style="box-shadow:none; border-radius:0;">
                                        </div>
                                        @error('post_code')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="address" class="form-label fw-bold"
                                            style="font-size: 1rem; color: var(--accent-color);">Street
                                            address<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-1" style="border-radius:0;"><i
                                                    class="fas fa-home" style="color: var(--accent-color);"></i></span>
                                            <textarea id="address" placeholder="Enter your shop's street address"
                                                class="form-control bg-white border-1 px-4 py-2 @error('address') is-invalid @enderror" name="address" required
                                                style="box-shadow:none; border-radius:0; min-height: 48px;">{{ old('address') ?? '' }}</textarea>
                                        </div>
                                        @error('address')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between align-items-center">
                                <div class="">
                                    <button type="submit" id="submit" class="btn fw-bold shadow" disabled
                                        style="background-color:#FF0000;color:white; transition:transform 0.2s; font-size:1.1rem;"
                                        onmouseover="this.style.transform='translateY(-2px) scale(1.03)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                        Submit
                                    </button>
                                </div>


                            </div>
                        </form>

                    </div>




                </div>
            </div>
        </div>


    </section>


    <script>
        $(document).ready(function() {
            // Initialize Select2
            $(document).ready(function() {
                $('#country').select2({
                    placeholder: "Select a country",
                    allowClear: true,
                    width: '100%'
                });

                $('#state').select2({
                    placeholder: "Select a state",
                    allowClear: true,
                    width: '100%'
                });
            });

            // Progress calculation for required fields within the form
            function getRequiredFields() {
                return $('#verification-form').find('input[required], select[required], textarea[required]');
            }

            function isFieldFilled($el) {
                const tag = $el.prop('tagName').toLowerCase();
                const type = ($el.attr('type') || '').toLowerCase();
                if (type === 'file') {
                    return $el[0].files && $el[0].files.length > 0;
                }
                if (tag === 'select') {
                    const val = $el.val();
                    return val !== null && String(val).trim() !== '';
                }
                const val = $el.val();
                return val !== null && String(val).trim() !== '';
            }

            // ID uploads enforcement
            function hasBothIds() {
                const front = document.getElementById('govt_id_front');
                const back = document.getElementById('govt_id_back');
                const hasFront = front && front.files && front.files.length > 0;
                const hasBack = back && back.files && back.files.length > 0;
                return hasFront && hasBack;
            }

            function updateIdRequirementUI() {
                const ok = hasBothIds();
                const $frontLabel = $('label[for="govt_id_front"]');
                const $backLabel = $('label[for="govt_id_back"]');
                $('#id-upload-alert').toggleClass('d-none', ok);
                $('#submit').prop('disabled', !ok);
                $frontLabel.toggleClass('id-required-missing', !ok && (!document.getElementById('govt_id_front').files.length));
                $backLabel.toggleClass('id-required-missing', !ok && (!document.getElementById('govt_id_back').files.length));
            }

            function updateProgress() {
                const $fields = getRequiredFields();
                const total = $fields.length;
                let complete = 0;
                $fields.each(function() {
                    if (isFieldFilled($(this))) complete++;
                });
                const percent = total === 0 ? 0 : Math.round((complete / total) * 100);
                $('#registration-progress-text').text(complete + ' of ' + total + ' fields completed');
                $('#registration-progress-percent').text(percent + '%');
                $('#registration-progress-bar').css('width', percent + '%');
                updateIdRequirementUI();
            }

            // Bind events for live updates
            $(document).on('input change', '#verification-form input, #verification-form textarea', updateProgress);
            $(document).on('change', '#verification-form select', updateProgress);
            $('#govt_id_front, #govt_id_back').on('change', function() {
                updateIdRequirementUI();
                updateProgress();
            });
            // Select2 triggers
            $('#country').on('select2:select select2:clear', updateProgress);
            $('#state').on('select2:select select2:clear', updateProgress);

            // Load countries
            $.get("https://countriesnow.space/api/v0.1/countries/positions", function(res) {
                $('#country').empty().append('<option value="">Select Country</option>');
                res.data.forEach(function(country) {
                    $('#country').append(new Option(country.name, country.name));
                });
                updateProgress();
            });

            // Load states when country changes
            $('#country').on('change', function() {
                const selectedCountry = $(this).val();
                $('#state').empty().append('<option value="">Loading...</option>').trigger('change');
                $('#state').prop('disabled', true);

                if (!selectedCountry) {
                    $('#state').empty().append('<option value="">Select Country First</option>');
                    updateProgress();
                    return;
                }

                $.ajax({
                    url: "https://countriesnow.space/api/v0.1/countries/states",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        country: selectedCountry
                    }),
                    success: function(res) {
                        $('#state').empty().append('<option value="">Select State</option>');
                        if (res.data && res.data.states.length > 0) {
                            res.data.states.forEach(function(st) {
                                $('#state').append(new Option(st.name, st.name));
                            });
                            $('#state').prop('disabled', false);
                        } else {
                            $('#state').append('<option value="">No states found</option>');
                        }
                        updateProgress();
                    }
                });
            });

            // Initial calculation
            updateProgress();

            // On submit, enforce IDs and scroll to missing
            $('#verification-form').on('submit', function(e) {
                if (!hasBothIds()) {
                    e.preventDefault();
                    $('#id-upload-alert').removeClass('d-none');
                    const $target = !$('input#govt_id_front')[0].files.length ? $('label[for="govt_id_front"]') : $('label[for="govt_id_back"]');
                    $('html, body').animate({ scrollTop: $target.offset().top - 120 }, 300);
                    $target.addClass('id-required-missing');
                }
            });
        });
    </script>
@endsection
