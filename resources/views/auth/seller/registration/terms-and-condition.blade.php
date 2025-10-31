@extends('auth.seller.registration.layout', ['current_step' => 3])

@section('registration-content')
    <div class="afrikart-page-wrapper py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-6 px-4">

                    {{-- HEADER: AFRIKART Logo and Title --}}
                    <header class="text-center mb-5">
                        <div class="afrikart-logo-container mb-3 d-flex">

                            <img src="{{ asset('assets/img/afrilogo.png') }}" alt="" width="40">

                            <h1 class="afrikart-brand-text ps-2">AFRIKART</h1>
                        </div>

                        <h2 class="h5 fw-bold afrikart-title-color" id="section-title">Vendor Terms & Agreement</h2>
                        <p class="text-secondary small-text-desc" id="section-description">Please review each section of the
                            agreement before signing below.</p>
                    </header>

                    <form id="signature-form" action="{{ route('vendor.registration.terms-and-conditions.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- TERMS CONTENT AREA: Accordions with all PDF content --}}
                        <div class="afrikart-terms-content-area shadow-sm mb-4 p-0">
                            <div class="accordion afrikart-accordion" id="termsAccordion">

                                {{-- 1. About Afrikart --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne">
                                            1. About Afrikart
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                        data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <p>Afrikart is more than a marketplace — it's a multiplatform e-commerce gateway
                                                that connects Africa's finest artisans, entrepreneurs, and producers
                                                directly with U.S. consumers.</p>
                                            <p>Our mission is simple: to give African vendors direct access to U.S.
                                                customers while providing buyers with authentic, premium, and ethically
                                                sourced products.</p>
                                            <p>By joining Afrikart, you're not just selling products — you're becoming part
                                                of a movement to elevate African creativity and commerce worldwide.</p>
                                            <ul>
                                                <li><strong>Who we are:</strong> Afrikart is a U.S.-based e-commerce
                                                    multiplatform online marketplace that connects African vendors directly
                                                    with U.S. consumers.</li>
                                                <li><strong>Where we sell:</strong> Products listed on Afrikart are
                                                    showcased on our website as well as other connected e-commerce platforms
                                                    and sales channels, ensuring maximum reach.</li>
                                                <li><strong>Our role:</strong> We provide the platform, tools, and logistics
                                                    support that make it easier for African vendors to sell internationally.
                                                </li>
                                                <li><strong>Our promise:</strong> To create opportunities for African
                                                    businesses by bridging the gap between local supply and global demand.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- 2. Business Model Overview --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            2. Business Model Overview
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <p>Afrikart is a consignment-based multiplatform marketplace. Vendors are paid
                                                when their products are sold.</p>
                                            <ul>
                                                <li>There is <strong>no subscription or listing fees</strong> to join
                                                    Afrikart (this may change in the future).</li>
                                                <li>Products are sold not only through Afrikart's website, but also through
                                                    partner marketplaces, affiliate networks, and additional digital sales
                                                    platforms.</li>
                                                <li>Vendors must upload their products directly through the Vendor Portal,
                                                    which Afrikart reviews and approves before publishing.</li>
                                                <li>Afrikart and Vendors work together to find the best shipping solutions,
                                                    balancing cost, reliability, and speed.</li>
                                                <li>Vendors are generally responsible for shipping costs to the U.S., while
                                                    Afrikart advises on the most effective solutions.</li>
                                                <li>Afrikart also provides warehousing, fulfillment, and returns management
                                                    services in the U.S.</li>
                                                <li><strong>Afrikart does not take a commission. Instead, Afrikart applies a
                                                        markup on products sold to cover platform, marketing, and
                                                        operational costs.</strong></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- 3. Vendor Responsibilities --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            3. Vendor Responsibilities
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <h6>Product Handling & Quality</h6>
                                            <ul>
                                                <li>Supplying high-quality products free of defects.</li>
                                                <li>Properly handling and storing products before shipment.</li>
                                                <li>Providing clear and accurate product descriptions.</li>
                                                <li><strong>Providing a price listing for each product.</strong></li>
                                            </ul>

                                            <h6>Product Listings</h6>
                                            <ul>
                                                <li>Vendors are responsible for posting their own products through
                                                    Afrikart's Vendor Portal.</li>
                                                <li>Listings must include accurate descriptions, clear pricing, and
                                                    high-quality images.</li>
                                                <li>Afrikart reserves the right to review and approve all listings before
                                                    they appear on Afrikart's website or other platforms.</li>
                                            </ul>

                                            <h6>Packaging & Presentation</h6>
                                            <ul>
                                                <li>Products must be securely packaged to prevent damage during shipping.
                                                </li>
                                                <li>Packaging should reflect professionalism and, when possible, cultural
                                                    authenticity.</li>
                                            </ul>

                                            <h6>Compliance</h6>
                                            <ul>
                                                <li>Products must comply with U.S. import laws, safety regulations, and
                                                    certifications where required.</li>
                                                <li>Vendors must secure any necessary export permits in their country of
                                                    origin.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- 4. Onboarding Process --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour">
                                            4. Onboarding Process
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                        data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <ul>
                                                <li><strong>Step 1: Application</strong> - Submit a vendor application with
                                                    your company profile and product details.</li>
                                                <li><strong>Step 2: Approval</strong> - Afrikart reviews your application to
                                                    confirm alignment with our product categories and quality standards.
                                                </li>
                                                <li><strong>Step 3: Product Catalog Submission & Upload</strong> - Vendors
                                                    prepare product photos, descriptions, and wholesale pricing. Vendors
                                                    upload their products directly into Afrikart's Vendor Portal. Afrikart
                                                    reviews and approves listings before they go live across Afrikart's
                                                    website and connected platforms.</li>
                                                <li><strong>Step 4: Shipping & Storage</strong> - Afrikart and Vendor agree
                                                    on the best shipping plan and coordinate delivery of products to
                                                    customers or Afrikart's U.S. warehouse (if warehousing is chosen).</li>
                                                <li><strong>Step 5: Sales & Tracking</strong> - Once approved, products are
                                                    live on Afrikart's multiplatform network. Vendors can track sales,
                                                    payments, and inventory through Afrikart's systems.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- 5. Payment & Financial Terms --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false"
                                            aria-controls="collapseFive">
                                            5. Payment & Financial Terms
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                        data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <ul>
                                                <li>Vendors are paid only as products are sold on Afrikart and its connected
                                                    platforms.</li>
                                                <li>Payout timelines depend on product type and return policies. For
                                                    example, consumables such as honey that do not require returns are
                                                    processed faster, while other items may require a return window before
                                                    payout.</li>
                                                <li>Payments are adjusted for returns, refunds, and other applicable
                                                    factors.</li>
                                                <li>Afrikart issues vendor payouts promptly after sales are finalized, but
                                                    final processing time may vary depending on the vendor's bank.</li>
                                                <li><strong>Afrikart does not take a commission but applies a markup for
                                                        platform, marketing, and operational costs.</strong></li>
                                                <li>If a Vendor requests advance payment before sales, Afrikart will
                                                    negotiate terms on a case-by-case basis.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- 6. Termination Policy --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingSix">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false"
                                            aria-controls="collapseSix">
                                            6. Termination Policy
                                        </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse"
                                        aria-labelledby="headingSix" data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <ul>
                                                <li>Afrikart or the Vendor may terminate this agreement at any time with
                                                    written notice.</li>
                                                <li><strong>Vendor-Initiated Termination:</strong> Vendor must notify
                                                    Afrikart in writing at least 30 days before stopping product listings or
                                                    shipments.</li>
                                                <li><strong>Afrikart-Initiated Termination:</strong> Afrikart may terminate
                                                    if:
                                                    <ul>
                                                        <li>Products consistently fail quality standards.</li>
                                                        <li>Vendor fails to comply with U.S. import laws or export
                                                            regulations.</li>
                                                        <li>Vendor engages in unethical or fraudulent activities.</li>
                                                        <li>Vendor fails to fulfill orders or respond to customer service
                                                            issues.</li>
                                                    </ul>
                                                </li>
                                                <li><strong>Post-Termination:</strong> Vendor remains responsible for
                                                    outstanding orders. Afrikart will settle any pending payouts for
                                                    products sold prior to termination, adjusted for returns, refunds, or
                                                    other applicable factors.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- 7. Marketing & Promotion --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingSeven">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSeven"
                                            aria-expanded="false" aria-controls="collapseSeven">
                                            7. Marketing & Promotion
                                        </button>
                                    </h2>
                                    <div id="collapseSeven" class="accordion-collapse collapse"
                                        aria-labelledby="headingSeven" data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <p>Afrikart promotes products across multiple channels: websites, affiliate
                                                platforms, social media, newsletters, and partnerships.</p>
                                            <h6>Vendor Role:</h6>
                                            <ul>
                                                <li>Provide high-quality photos and descriptions</li>
                                                <li>Share brand story</li>
                                                <li>Participate in optional campaigns</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- 8. Vendor Benefits --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingEight">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseEight"
                                            aria-expanded="false" aria-controls="collapseEight">
                                            8. Vendor Benefits
                                        </button>
                                    </h2>
                                    <div id="collapseEight" class="accordion-collapse collapse"
                                        aria-labelledby="headingEight" data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <ul>
                                                <li>Direct access to U.S. consumers.</li>
                                                <li><strong>Free subscription and no storage fees until further
                                                        notice.</strong></li>
                                                <li>Warehousing and fulfillment services in the U.S.</li>
                                                <li>Customer service and returns management.</li>
                                                <li>Scalability — focus on production while Afrikart manages sales and
                                                    logistics.</li>
                                                <li>Increased exposure through Afrikart's marketing campaigns, partner
                                                    platforms, and newsletters.</li>
                                                <li>Participation in seasonal or themed product collections and featured
                                                    vendor spotlights.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- 9. Compliance & Legal --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingNine">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseNine"
                                            aria-expanded="false" aria-controls="collapseNine">
                                            9. Compliance & Legal
                                        </button>
                                    </h2>
                                    <div id="collapseNine" class="accordion-collapse collapse"
                                        aria-labelledby="headingNine" data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <ul>
                                                <li>Afrikart is legally registered in the U.S.</li>
                                                <li>Vendors must comply with all U.S. safety and import requirements.</li>
                                                <li>Vendors retain ownership of their intellectual property.</li>
                                                <li>Afrikart is not liable for product damage before arrival at the
                                                    warehouse or delivery if shipped directly.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                {{-- 10. Communication & Support --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingTen">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false"
                                            aria-controls="collapseTen">
                                            10. Communication & Support
                                        </button>
                                    </h2>
                                    <div id="collapseTen" class="accordion-collapse collapse"
                                        aria-labelledby="headingTen" data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <ul>
                                                <li><strong>Support:</strong> via email for onboarding, catalog updates, and
                                                    account questions.</li>
                                                <li><strong>Sales Dashboard:</strong> real-time tracking.</li>
                                                <li><strong>Policy Updates:</strong> written notice for changes.</li>
                                            </ul>
                                            <p><strong>Contact:</strong> Website: Afrikart.com | Email: Afrikart@gmail.com
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- 11. Vendor Agreement --}}
                                <div class="accordion-item afrikart-terms-item">
                                    <h2 class="accordion-header" id="headingEleven">
                                        <button class="accordion-button afrikart-section-btn collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseEleven"
                                            aria-expanded="false" aria-controls="collapseEleven">
                                            11. Vendor Agreement
                                        </button>
                                    </h2>
                                    <div id="collapseEleven" class="accordion-collapse collapse"
                                        aria-labelledby="headingEleven" data-bs-parent="#termsAccordion">
                                        <div class="accordion-body">
                                            <p>This Agreement is entered into between <strong>Afrikart, LLC</strong> and the
                                                Vendor, governing participation in Afrikart's marketplace. It refers to the
                                                Onboarding Packet for operational details.</p>

                                            <h6>1. Vendor Information</h6>
                                            <p>Vendor must provide: Company Name, Contact Name, Email, Phone, Address, and
                                                Country of Origin.</p>

                                            <h6>2. Term</h6>
                                            <p>Starts on the date signed and continues until terminated by either party.</p>

                                            <h6>3. Product Listings & Quality</h6>
                                            <ul>
                                                <li>Vendor ensures compliance with U.S. laws and quality standards.</li>
                                                <li>Afrikart may review/reject listings.</li>
                                            </ul>

                                            <h6>4. Shipping & Fulfillment</h6>
                                            <ul>
                                                <li>Afrikart provides warehousing, fulfillment, and returns management in
                                                    the U.S.</li>
                                                <li>Afrikart works with vendors to find effective shipping solutions.</li>
                                                <li>Vendor ensures products are packaged securely.</li>
                                                <li>Vendors are highly encouraged to have necessary exporting licenses.</li>
                                            </ul>

                                            <h6>5. Payment Terms</h6>
                                            <ul>
                                                <li>Vendor earns the agreed wholesale price; Afrikart applies a markup, no
                                                    commission.</li>
                                                <li>Payments after sales, adjusted for returns/refunds.</li>
                                                <li>Advance payments on case-by-case basis.</li>
                                            </ul>

                                            <h6>6. Termination</h6>
                                            <ul>
                                                <li>Either party may terminate with written notice (30 days for vendors).
                                                </li>
                                                <li>Afrikart may terminate immediately for non-compliance, unethical
                                                    practices, or order failures.</li>
                                                <li>Outstanding payouts settled post-termination.</li>
                                            </ul>

                                            <h6>7. Intellectual Property & Marketing</h6>
                                            <ul>
                                                <li>Vendor retains ownership; Afrikart has limited license to use images and
                                                    brand content for sales and promotion.</li>
                                            </ul>

                                            <h6>8. Limitation of Liability</h6>
                                            <ul>
                                                <li>Afrikart not liable for damage prior to warehouse receipt or direct
                                                    delivery.</li>
                                                <li>Vendor indemnifies Afrikart against claims from defective products or
                                                    non-compliance.</li>
                                            </ul>

                                            <h6>9. Acknowledgment</h6>
                                            <p>By signing, Vendor acknowledges reading and agreeing to this Agreement and
                                                receiving the Onboarding Packet.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- SIGNATURE PAD --}}
                        <div class="mb-4 afrikart-signature-card p-3 shadow-sm">
                            <label class="form-label fw-bold mb-2 card-title-text"
                                style="color: var(--afrikart-color-text-title);">
                                Digital Signature <span class="text-danger">*</span>
                            </label>
                            <div id="signature-pad-container">
                                <canvas id="signature-canvas" width="800" height="150"
                                    style="width:100%; height:150px; border: 1px solid #ccc;"></canvas>
                                <button type="button" id="clear-signature"
                                    class="btn btn-sm afrikart-clear-btn position-absolute end-0 bottom-0 m-2">Clear</button>
                            </div>
                            <input type="hidden" name="signature" id="signature-input" required>
                            @error('signature')
                                <span class="invalid-feedback d-block"
                                    role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- TERMS CHECKBOX & CONTINUE BUTTON --}}
                        <div class="d-flex flex-column align-items-start mb-4">
                            <div class="d-flex align-items-center mb-1">
                                <input type="checkbox" required
                                    class="form-check-input me-2 afrikart-checkbox @error('terms') is-invalid @enderror"
                                    id="TermsConditions">

                                <label for="TermsConditions" class="form-check-label mb-0 afrikart-checkbox-label"
                                    style="cursor: pointer;">
                                    I have read and agree to the
                                    <a href="#" class="afrikart-link">Terms &amp; Conditions</a>
                                </label>
                            </div>

                            @error('terms')
                                <span class="invalid-feedback d-block ms-4" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <div class="align-items-center d-flex justify-content-between mt-4">
                            <a href="{{ asset('assets/Afrikart - Vendor Onboarding Packet And Agreement.pdf') }}">View Full
                                Vendor Agreement (PDF)</a>
                            <button type="submit" id="continueBtn" class="btn afrikart-submit-btn" disabled>
                                AGREE & CONTINUE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- CUSTOM AFRIKART STYLES --}}
    <style>
        /* Custom Fonts and Colors for Pixel Perfection */
        :root {
            --afrikart-color-primary: #375945;
            /* Dark Green */
            --afrikart-color-secondary: #E4AA5F;
            /* Gold/Tan */
            --afrikart-color-text-title: #363636;
            /* Dark text color */
            --afrikart-color-background: #F8F7F2;
            /* Light creamy background */
            --afrikart-submit-maroon: #922020;
            /* Dark Maroon for submit button */
            --afrikart-font-family: 'Poppins', sans-serif;
            --afrikart-terms-border: #D8D8D8;
            /* Setting the accent color to the primary dark green */
        }

        /* Base Styling */
        .afrikart-page-wrapper {
            background-color: var(--afrikart-color-background);
            min-height: 100vh;
        }

        body {
            font-family: var(--afrikart-font-family);
            color: var(--afrikart-color-text-title);
            line-height: 1.5;
        }

        .afrikart-title-color {
            color: var(--afrikart-color-text-title);
        }

        .small-text-desc {
            font-size: 0.95rem;
            color: #6c757d !important;
        }

        /* Header/Logo */
        .afrikart-logo-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            line-height: 1;
            margin-bottom: 1.5rem;
        }

        .afrikart-map-icon-bg {
            width: 30px;
            height: 30px;
            background-color: var(--afrikart-color-secondary);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.3rem;
        }

        .afrikart-brand-text {
            font-weight: 700;
            font-size: 1.85rem;
            margin-bottom: 0;
            color: var(--afrikart-color-text-title);
            letter-spacing: 2px;
        }

        /* Terms Content Area (Accordion Styling) */
        .afrikart-terms-content-area {
            background: white;
            border: 1px solid var(--afrikart-terms-border);
            border-radius: 0.5rem;
            overflow: hidden;
            /* Important for clean borders */
        }

        .afrikart-terms-item {
            border-left: none;
            border-right: none;
            border-color: #ededed;
        }

        .afrikart-terms-item:first-of-type {
            border-top: none;
        }

        /* Accordion Button Overrides */
        .accordion-button {
            /* Main appearance styles */
            background-color: var(--accent-color);
            color: var(--text-secondary);
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-radius: 0 !important;
            /* Remove rounding */
            text-align: left;
            font-size: 0.95rem;

            box-shadow: none;
            border: none !important;
            transition: background-color 0.2s, color 0.2s;
        }

        .accordion-button:hover {
            background-color: var(--hunter-green);
        }

        /* ACCENT COLOR IMPLEMENTATION: OPEN ACCORDION (GREEN) */
        .accordion-button:not(.collapsed) {
            background-color: var(--accent-color);
            /* Dark Green */
            color: white;
            /* White text for contrast */
            box-shadow: none;
        }

        /* Customizing the Chevron Icon */
        .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%236c757d'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            transition: transform 0.2s ease-in-out;
        }

        /* Chevron change for open state (now white to match text) */
        .accordion-button:not(.collapsed)::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            transform: rotate(-180deg);
        }

        .accordion-body {
            padding: 1rem 1.5rem 1.5rem;
            background-color: #fff;
            color: #4a4a4a;
            font-size: 0.9rem;
        }

        .accordion-body ul {
            padding-left: 20px;
            margin-bottom: 0;
            list-style-type: disc;
        }

        .accordion-body ul li {
            margin-bottom: 8px;
        }

        .accordion-body ul li ul {
            padding-left: 25px;
            /* Indent nested list */
            list-style-type: circle;
            /* Use circles for nested lists */
            margin-top: 5px;
        }

        .accordion-body h6 {
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--afrikart-color-primary);
        }

        /* Signature Pad */
        .afrikart-signature-card {
            background: #FFFBF5;
            border: 1px solid var(--afrikart-color-secondary);
            border-radius: 0.5rem;
        }

        #signature-pad-container {
            border: 2px dashed #ddd;
            border-radius: 0.3rem;
            background: #f7f7f7;
            padding: 8px;
            position: relative;
        }

        .afrikart-clear-btn {
            background-color: #6c757d !important;
            color: white !important;
            border: none;
            font-size: 0.8rem;
        }

        .card-title-text {
            font-size: 0.95rem;
        }



        .afrikart-checkbox:checked {
            background-color: var(--afrikart-color-primary);
            border-color: var(--afrikart-color-primary);
        }

        .afrikart-checkbox-label {
            font-size: 0.95rem;
            color: var(--afrikart-color-text-title);
        }

        .afrikart-link {
            color: var(--afrikart-color-primary);
            /* Use dark green for links */
            text-decoration: underline;
            font-weight: 600;
        }

        /* Submit Button (AGREE & CONTINUE) */
        .afrikart-submit-btn {
            background-color: var(--afrikart-submit-maroon);
            color: white;
            font-weight: bold;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: background-color 0.2s;
            border: none;
        }

        .afrikart-submit-btn:hover:not(:disabled) {
            background-color: #7a1b1b;
            color: white;
        }

        /* Disabled Button Style (Matching the original code) */
        #continueBtn:disabled {
            background-color: #6c757d !important;
            color: white !important;
            cursor: not-allowed !important;
            opacity: 0.7;
        }
    </style>

    {{-- SCRIPTS (RETAINED & CLEANED) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Starting signature pad initialization...');

            const canvas = document.getElementById('signature-canvas');
            const input = document.getElementById('signature-input');
            const clearBtn = document.getElementById('clear-signature');
            const continueBtn = document.getElementById('continueBtn');
            const termsCheckbox = document.getElementById('TermsConditions');

            if (!canvas) {
                console.error('Canvas not found!');
                return;
            }

            const ctx = canvas.getContext('2d');
            let isDrawing = false;
            let lastX = 0;
            let lastY = 0;

            // Set up canvas properties
            ctx.strokeStyle = 'var(--afrikart-color-primary)'; // Use brand color for signature
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';

            console.log('Canvas setup complete');

            function getMousePos(e) {
                const rect = canvas.getBoundingClientRect();
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;

                return {
                    x: (e.clientX - rect.left) * scaleX,
                    y: (e.clientY - rect.top) * scaleY
                };
            }

            function getTouchPos(e) {
                const rect = canvas.getBoundingClientRect();
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;

                return {
                    x: (e.touches[0].clientX - rect.left) * scaleX,
                    y: (e.touches[0].clientY - rect.top) * scaleY
                };
            }

            function startDrawing(e) {
                isDrawing = true;
                const pos = e.type.includes('touch') ? getTouchPos(e) : getMousePos(e);
                lastX = pos.x;
                lastY = pos.y;
            }

            function draw(e) {
                if (!isDrawing) return;

                e.preventDefault();
                const pos = e.type.includes('touch') ? getTouchPos(e) : getMousePos(e);

                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();

                lastX = pos.x;
                lastY = pos.y;
            }

            function stopDrawing() {
                if (isDrawing) {
                    isDrawing = false;
                    // Save the signature
                    input.value = canvas.toDataURL('image/png');
                    checkFormValidity(); // Check validity after drawing
                }
            }

            // Mouse events
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseout', stopDrawing);

            // Touch events
            canvas.addEventListener('touchstart', function(e) {
                e.preventDefault();
                startDrawing(e);
            });

            canvas.addEventListener('touchmove', function(e) {
                e.preventDefault();
                draw(e);
            });

            canvas.addEventListener('touchend', function(e) {
                e.preventDefault();
                stopDrawing();
            });

            // Clear button
            clearBtn.addEventListener('click', function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                input.value = '';
                checkFormValidity();
            });

            // Check form validity
            function checkFormValidity() {
                const hasSignature = input.value.trim() !== '';
                const hasAgreed = termsCheckbox.checked;

                continueBtn.disabled = !(hasSignature && hasAgreed);
            }

            // Checkbox change
            termsCheckbox.addEventListener('change', checkFormValidity);

            // Initial check
            checkFormValidity();

            console.log('Signature pad initialization complete');
        });
    </script>
@endsection
