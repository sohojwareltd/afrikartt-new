// Global CSRF token setup for AJAX requests
(function() {
    'use strict';
    
    // Get CSRF token from meta tag
    const token = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = token ? token.getAttribute('content') : null;
    
    if (!csrfToken) {
        console.error('CSRF token not found in meta tag');
        return;
    }
    
    // Setup jQuery AJAX defaults if jQuery is available
    if (typeof $ !== 'undefined') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
    }
    
    // Setup fetch defaults
    const originalFetch = window.fetch;
    window.fetch = function(url, options = {}) {
        // Only add CSRF token for same-origin requests
        if (url.startsWith('/') || url.startsWith(window.location.origin)) {
            options.headers = options.headers || {};
            if (!options.headers['X-CSRF-TOKEN']) {
                options.headers['X-CSRF-TOKEN'] = csrfToken;
            }
        }
        return originalFetch(url, options);
    };
    
    // Function to get current CSRF token (useful for dynamic updates)
    window.getCsrfToken = function() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : null;
    };
    
    // Function to refresh CSRF token
    window.refreshCsrfToken = function() {
        return fetch('/refresh-csrf-token', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.csrf_token) {
                const token = document.querySelector('meta[name="csrf-token"]');
                if (token) {
                    token.setAttribute('content', data.csrf_token);
                }
                return data.csrf_token;
            }
        })
        .catch(error => {
            console.error('Failed to refresh CSRF token:', error);
        });
    };
})();
