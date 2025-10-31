<x-filament-forms::field-wrapper label="Admin Email" statePath="admin_email" hint="Enter admin contact email">
    <input type="email" id="admin_email" name="admin_email"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="admin@example.com" value="{{ old('admin_email', $settings['admin_email'] ?? '') }}" />
</x-filament-forms::field-wrapper>

<x-filament-forms::field-wrapper label="Admin Phone" statePath="admin_phone" hint="Enter admin contact phone">
    <input type="tel" id="admin_phone" name="admin_phone"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="+1 234 567 8900" value="{{ old('admin_phone', $settings['admin_phone'] ?? '') }}" />
</x-filament-forms::field-wrapper>

<x-filament-forms::field-wrapper label="Admin Shipping" statePath="admin_shipping" hint="Enter admin shipping phone">
    <input type="text" id="admin_shipping" name="admin_shipping"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="Shipping Cost" value="{{ old('admin_shipping', $settings['admin_shipping'] ?? '') }}" />
</x-filament-forms::field-wrapper>

<x-filament-forms::field-wrapper label="Admin Address" statePath="about" hint="Enter admin address">
    <textarea id="about" name="about" rows="3"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="Enter admin address">{{ old('about', $settings['about'] ?? '') }}</textarea>
</x-filament-forms::field-wrapper>

<x-filament-forms::field-wrapper label="Admin Terms & Conditions" statePath="admin_terms_conditions" hint="Enter admin terms & conditions">
    <textarea id="admin_terms_conditions" name="admin_terms_conditions" rows="5"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500 summernote"
        placeholder="Enter admin terms & conditions">{{ old('admin_terms_conditions', $settings['admin_terms_conditions'] ?? '') }}</textarea>
</x-filament-forms::field-wrapper>

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<!-- Dark/Light Theme Styles for Summernote -->
<style>
    /* Light Theme (default) */
    .note-editor {
        border: 1px solid #d1d5db !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important;
    }
    
    .note-toolbar {
        background-color: #f9fafb !important;
        border-bottom: 1px solid #e5e7eb !important;
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    
    .note-editing-area {
        background-color: #ffffff !important;
    }
    
    .note-editable {
        background-color: #ffffff !important;
        color: #111827 !important;
        padding: 1rem !important;
        min-height: 200px !important;
    }

    /* Dark Theme */
    .dark .note-editor {
        border: 1px solid #4b5563 !important;
        background-color: #1f2937 !important;
    }
    
    .dark .note-toolbar {
        background-color: #374151 !important;
        border-bottom: 1px solid #4b5563 !important;
    }
    
    .dark .note-toolbar .btn-group .btn {
        background-color: #4b5563 !important;
        border-color: #6b7280 !important;
        color: #f3f4f6 !important;
    }
    
    .dark .note-toolbar .btn-group .btn:hover {
        background-color: #6b7280 !important;
        color: #ffffff !important;
    }
    
    .dark .note-toolbar .btn-group .btn.active {
        background-color: #DE991B !important;
        border-color: #DE991B !important;
        color: #ffffff !important;
    }
    
    .dark .note-editing-area {
        background-color: #1f2937 !important;
    }
    
    .dark .note-editable {
        background-color: #1f2937 !important;
        color: #f3f4f6 !important;
    }
    
    .dark .note-editable:focus {
        background-color: #1f2937 !important;
        color: #f3f4f6 !important;
    }

    /* Dropdown menus in dark mode */
    .dark .note-dropdown-menu {
        background-color: #374151 !important;
        border-color: #4b5563 !important;
    }
    
    .dark .note-dropdown-menu .dropdown-item {
        color: #f3f4f6 !important;
    }
    
    .dark .note-dropdown-menu .dropdown-item:hover {
        background-color: #4b5563 !important;
        color: #ffffff !important;
    }

    /* Modal dialogs in dark mode */
    .dark .modal-content {
        background-color: #1f2937 !important;
        border-color: #4b5563 !important;
    }
    
    .dark .modal-header {
        background-color: #374151 !important;
        border-bottom-color: #4b5563 !important;
    }
    
    .dark .modal-title {
        color: #f3f4f6 !important;
    }
    
    .dark .modal-body {
        background-color: #1f2937 !important;
        color: #f3f4f6 !important;
    }
    
    .dark .form-control {
        background-color: #374151 !important;
        border-color: #4b5563 !important;
        color: #f3f4f6 !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .note-toolbar {
            flex-wrap: wrap;
        }
        
        .note-toolbar .btn-group {
            margin-bottom: 0.25rem;
        }
    }
</style>
@endpush

@push('scripts')
<!-- jQuery (if not already loaded) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        // Function to apply theme-specific styles
        function applyThemeStyles() {
            const isDarkMode = document.documentElement.classList.contains('dark');
            
            if (isDarkMode) {
                // Dark theme styles
                $('.note-editor').css({
                    'border-color': '#4b5563',
                    'background-color': '#1f2937'
                });
                $('.note-toolbar').css({
                    'background-color': '#374151',
                    'border-bottom-color': '#4b5563'
                });
                $('.note-editable').css({
                    'background-color': '#1f2937',
                    'color': '#f3f4f6'
                });
            } else {
                // Light theme styles
                $('.note-editor').css({
                    'border-color': '#d1d5db',
                    'background-color': '#ffffff'
                });
                $('.note-toolbar').css({
                    'background-color': '#f9fafb',
                    'border-bottom-color': '#e5e7eb'
                });
                $('.note-editable').css({
                    'background-color': '#ffffff',
                    'color': '#111827'
                });
            }
        }

        // Check if element exists
        if ($('#admin_terms_conditions').length) {
            // Initialize Summernote
            $('#admin_terms_conditions').summernote({
                height: 300,
                placeholder: 'Enter admin terms and conditions...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ],
                styleTags: [
                    'p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                ],
                callbacks: {
                    onInit: function() {
                        console.log('Summernote initialized successfully');
                        
                        // Apply initial theme styles
                        applyThemeStyles();
                        
                        // Listen for theme changes
                        const observer = new MutationObserver(function(mutations) {
                            mutations.forEach(function(mutation) {
                                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                                    applyThemeStyles();
                                }
                            });
                        });
                        
                        observer.observe(document.documentElement, {
                            attributes: true,
                            attributeFilter: ['class']
                        });
                    },
                    onChange: function(contents, $editable) {
                        // Update the original textarea value
                        $('#admin_terms_conditions').val(contents);
                    },
                    onFocus: function() {
                        // Reapply theme styles on focus
                        applyThemeStyles();
                    }
                }
            });
        } else {
            console.error('Summernote target element not found');
        }
    });
</script>
@endpush
