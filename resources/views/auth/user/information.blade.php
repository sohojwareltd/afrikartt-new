@extends('layouts.user_dashboard')

@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="address-update-container">
            <!-- Header Section -->
            <div class="address-header mb-5">
                <h2 class="address-title"><i class="fas fa-map-marker-alt me-2"></i> Update Address</h2>
                <p class="address-subtitle">Manage your shipping and billing addresses</p>
            </div>

            <!-- Address Form -->
            <div class="address-form-card">
                <form action="{{ route('user.address.update') }}" method="post">
                    @csrf
                    <div class="row g-4">
                        <!-- Country -->
                        <div class="col-md-6">
                            <div class="form-group floating-label">
                                <input id="country" type="text" name="country"
                                    class="form-control @error('country') is-invalid @enderror"
                                    value="{{ $address->country }}" placeholder=" ">
                                <label for="country">Country</label>
                                <div class="form-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                @error('country')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- City -->
                        <div class="col-md-6">
                            <div class="form-group floating-label">
                                <input id="city" type="text" name="city"
                                    class="form-control @error('city') is-invalid @enderror" 
                                    value="{{ $address->city }}" placeholder=" ">
                                <label for="city">City</label>
                                <div class="form-icon">
                                    <i class="fas fa-city"></i>
                                </div>
                                @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- State -->
                        <div class="col-md-6">
                            <div class="form-group floating-label">
                                <input id="state" type="text" name="state"
                                    class="form-control @error('state') is-invalid @enderror" 
                                    value="{{ $address->state }}" placeholder=" ">
                                <label for="state">State/Province</label>
                                <div class="form-icon">
                                    <i class="fas fa-map"></i>
                                </div>
                                @error('state')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Post Code -->
                        <div class="col-md-6">
                            <div class="form-group floating-label">
                                <input id="post_code" type="text" name="post_code"
                                    class="form-control @error('post_code') is-invalid @enderror" 
                                    value="{{ $address->post_code }}" placeholder=" ">
                                <label for="post_code">Postal Code</label>
                                <div class="form-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                @error('post_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Permanent Address -->
                        <div class="col-12">
                            <div class="form-group floating-label">
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                    name="address_1" id="address" placeholder=" ">{{ $address->address_1 }}</textarea>
                                <label for="address">Permanent Address</label>
                                <div class="form-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Home Address -->
                        <div class="col-12">
                            <div class="form-group floating-label">
                                <textarea class="form-control @error('home_address') is-invalid @enderror" 
                                    name="address_2" id="home_address" placeholder=" ">{{ $address->address_2 }}</textarea>
                                <label for="home_address">Home Address (Optional)</label>
                                <div class="form-icon">
                                    <i class="fas fa-house-user"></i>
                                </div>
                                @error('home_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="col-12 mt-4">
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i> Update Address
                                </button>                              
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    /* Address Update Container */
    .address-update-container {
        background: #fff;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    /* Header Styles */
    .address-header {
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 1.5rem;
    }

    .address-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .address-subtitle {
        color: #7f8c8d;
        font-size: 1rem;
        margin-bottom: 0;
    }

    /* Form Card */
    .address-form-card {
        padding: 1.5rem 0;
    }

    /* Floating Label Form Groups */
    .form-group.floating-label {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-group.floating-label .form-control {
        height: 56px;
        padding: 1.5rem 1rem 0.5rem 3rem;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    .form-group.floating-label textarea.form-control {
        height: auto;
        min-height: 120px;
        padding-top: 1.8rem;
        resize: vertical;
    }

    .form-group.floating-label label {
        position: absolute;
        top: 1rem;
        left: 3rem;
        color: #7f8c8d;
        transition: all 0.3s ease;
        pointer-events: none;
    }

    .form-group.floating-label .form-icon {
        position: absolute;
        left: 1rem;
        top: 1rem;
        color: #7f8c8d;
        font-size: 1.1rem;
    }

    /* Focus States */
    .form-group.floating-label .form-control:focus {
        border-color: #3bb77e;
        box-shadow: 0 0 0 2px rgba(59, 183, 126, 0.2);
        background-color: #fff;
    }

    .form-group.floating-label .form-control:focus ~ label,
    .form-group.floating-label .form-control:not(:placeholder-shown) ~ label {
        top: 0.5rem;
        left: 3rem;
        font-size: 0.75rem;
        color: #3bb77e;
    }

    /* Invalid States */
    .form-group.floating-label .form-control.is-invalid,
    .form-group.floating-label .form-control.is-invalid:focus {
        border-color: #dc3545;
    }

    .form-group.floating-label .form-control.is-invalid ~ label {
        color: #dc3545;
    }

    .invalid-feedback {
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }

    /* Button Styles */
    .form-actions {
        display: flex;
        gap: 1rem;
    }


    .btn-cancel {
        background-color: #f8f9fa;
        color: #6c757d;
        border: 1px solid #e0e0e0;
        padding: 0.75rem 1.75rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background-color: #e9ecef;
        color: #495057;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .address-update-container {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
    }
</style>
@endsection