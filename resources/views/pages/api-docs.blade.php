@extends('layouts.app')

@section('title', 'API Documentation')

@section('content')
<style>
/* Postman-like Design */
:root {
    --primary-color: #dc3545;
    --secondary-color: #2c3e50;
    --background-color: #f8f9fa;
    --sidebar-bg: #ffffff;
    --border-color: #e9ecef;
    --text-primary: #2c3e50;
    --text-secondary: #6c757d;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --info-color: #17a2b8;
}

body {
    background-color: var(--background-color);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Main Layout */
.api-container {
    display: flex;
    height: calc(100vh - 100px);
    background: var(--background-color);
}

/* Left Sidebar - API Index */
.api-sidebar {
    width: 300px;
    background: var(--sidebar-bg);
    border-right: 1px solid var(--border-color);
    overflow-y: auto;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.sidebar-header {
    padding: 20px;
    border-bottom: 1px solid var(--border-color);
    background: linear-gradient(135deg, var(--primary-color), #ff8c42);
    color: white;
}

.sidebar-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

.api-category {
    border-bottom: 1px solid var(--border-color);
}

.category-header {
    padding: 15px 20px;
    background: #f8f9fa;
    font-weight: 600;
    color: var(--text-primary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background-color 0.2s;
}

.category-header:hover {
    background: #e9ecef;
}

.category-header i {
    transition: transform 0.2s;
}

.category-header.collapsed i {
    transform: rotate(-90deg);
}

.api-list {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.api-list.expanded {
    max-height: 500px;
}

.api-item {
    padding: 12px 20px 12px 40px;
    cursor: pointer;
    border-bottom: 1px solid #f8f9fa;
    transition: background-color 0.2s;
    display: flex;
    align-items: center;
    gap: 10px;
}

.api-item:hover {
    background: #f8f9fa;
}

.api-item.active {
    background: var(--primary-color);
    color: white;
}

.method-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    min-width: 50px;
    text-align: center;
}

.method-get { background: var(--success-color); color: white; }
.method-post { background: var(--primary-color); color: white; }
.method-put { background: var(--warning-color); color: #212529; }
.method-delete { background: var(--danger-color); color: white; }

/* Middle Panel - API Details */
.api-details {
    flex: 1;
    background: var(--sidebar-bg);
    border-right: 1px solid var(--border-color);
    overflow-y: auto;
}

.details-header {
    padding: 20px;
    border-bottom: 1px solid var(--border-color);
    background: #f8f9fa;
}

.details-header h2 {
    margin: 0 0 10px 0;
    color: var(--text-primary);
    font-size: 24px;
}

.details-header .method-badge {
    font-size: 14px;
    padding: 6px 12px;
}

.endpoint-url {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    margin: 15px 0;
}

.details-content {
    padding: 20px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 20px 0 15px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid var(--primary-color);
}

.parameter-list {
    list-style: none;
    padding: 0;
}

.parameter-item {
    padding: 10px 0;
    border-bottom: 1px solid #f8f9fa;
    display: flex;
    align-items: center;
    gap: 15px;
}

.parameter-name {
    font-weight: 600;
    color: var(--text-primary);
    min-width: 120px;
}

.parameter-type {
    color: var(--text-secondary);
    font-size: 12px;
    background: #e9ecef;
    padding: 2px 6px;
    border-radius: 4px;
}

.parameter-description {
    color: var(--text-secondary);
    flex: 1;
}

/* Right Panel - Testing */
.api-testing {
    width: 400px;
    background: var(--sidebar-bg);
    overflow-y: auto;
}

.testing-header {
    padding: 20px;
    border-bottom: 1px solid var(--border-color);
    background: #f8f9fa;
}

.testing-header h3 {
    margin: 0;
    color: var(--text-primary);
    font-size: 18px;
}

.testing-content {
    padding: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text-primary);
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(255, 108, 55, 0.2);
}

.btn-test {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s;
    width: 100%;
    margin-bottom: 20px;
}

.btn-test:hover {
    background: #e55a2b;
}

.btn-test:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.response-section {
    margin-top: 20px;
}

.response-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.response-title {
    font-weight: 600;
    color: var(--text-primary);
}

.response-status {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

.status-success { background: var(--success-color); color: white; }
.status-error { background: var(--danger-color); color: white; }

.response-body {
    background: #f8f9fa;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    padding: 15px;
    font-family: 'Courier New', monospace;
    font-size: 12px;
    max-height: 300px;
    overflow-y: auto;
    white-space: pre-wrap;
}

/* Loading Animation */
.spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .api-sidebar { width: 250px; }
    .api-testing { width: 350px; }
}

@media (max-width: 768px) {
    .api-container {
        flex-direction: column;
        height: auto;
    }
    
    .api-sidebar, .api-details, .api-testing {
        width: 100%;
        height: auto;
    }
}
</style>

<div class="api-container mb-5">
    <!-- Left Sidebar - API Index -->
    <div class="api-sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-book me-2"></i>API Documentation</h3>
            <small>v1.0</small>
        </div>
        
        <div class="api-category">
            <div class="category-header" onclick="toggleCategory(this)">
                <span><i class="fas fa-key me-2"></i>Authentication</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="api-list expanded">
                <div class="api-item" data-endpoint="login" data-method="POST">
                    <span class="method-badge method-post">POST</span>
                    <span>Login</span>
                </div>
                <div class="api-item" data-endpoint="register" data-method="POST">
                    <span class="method-badge method-post">POST</span>
                    <span>Register</span>
                </div>
            </div>
        </div>
        
        <div class="api-category">
            <div class="category-header" onclick="toggleCategory(this)">
                <span><i class="fas fa-database me-2"></i>Data Endpoints</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="api-list expanded">
                <div class="api-item" data-endpoint="products" data-method="GET">
                    <span class="method-badge method-get">GET</span>
                    <span>Get Products</span>
                </div>
                <div class="api-item" data-endpoint="product-details" data-method="GET">
                    <span class="method-badge method-get">GET</span>
                    <span>Get Product Details</span>
                </div>
                <div class="api-item" data-endpoint="categories" data-method="GET">
                    <span class="method-badge method-get">GET</span>
                    <span>Get Categories</span>
                </div>
            </div>
        </div>
        
        <div class="api-category">
            <div class="category-header" onclick="toggleCategory(this)">
                <span><i class="fas fa-store me-2"></i>Vendor Endpoints</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="api-list expanded">
                <div class="api-item" data-endpoint="vendors" data-method="GET">
                    <span class="method-badge method-get">GET</span>
                    <span>Get Vendors</span>
                </div>
                <div class="api-item" data-endpoint="vendor-details" data-method="GET">
                    <span class="method-badge method-get">GET</span>
                    <span>Get Vendor Details</span>
                </div>
                <div class="api-item" data-endpoint="vendor-products" data-method="GET">
                    <span class="method-badge method-get">GET</span>
                    <span>Get Vendor Products</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Middle Panel - API Details -->
    <div class="api-details">
        <div class="details-header">
            <h2 id="api-title">Select an API endpoint</h2>
            <span class="method-badge method-get" id="api-method">GET</span>
        </div>
        
        <div class="details-content">
            <div id="api-description">
                <p class="text-muted">Click on an API endpoint from the sidebar to view its details and test it.</p>
            </div>
            
            <div id="api-endpoint" class="endpoint-url" style="display: none;">
                <strong>Endpoint:</strong> <span id="endpoint-url"></span>
            </div>
            
            <div id="api-parameters" style="display: none;">
                <h4 class="section-title">Parameters</h4>
                <ul class="parameter-list" id="parameters-list">
                </ul>
            </div>
            
            <div id="api-description-full" style="display: none;">
                <h4 class="section-title">Description</h4>
                <p id="description-text"></p>
            </div>
            
            <div id="api-response" style="display: none;">
                <h4 class="section-title">Response Format</h4>
                <pre id="response-format" class="response-body"></pre>
            </div>
        </div>
    </div>
    
    <!-- Right Panel - Testing -->
    <div class="api-testing">
        <div class="testing-header">
            <h3><i class="fas fa-play me-2"></i>Test API</h3>
        </div>
        
        <div class="testing-content">
            <div id="testing-form">
                <p class="text-muted">Select an API endpoint to start testing.</p>
            </div>
            
            <div id="auth-section" style="display: none;">
                <h5 class="section-title">Authentication</h5>
                <div class="form-group">
                    <label class="form-label">Bearer Token</label>
                    <input type="text" id="auth-token" class="form-control" placeholder="Enter your token here">
                    <small class="text-muted">Get token from login/register response</small>
                </div>
            </div>
            
            <div id="params-section" style="display: none;">
                <h5 class="section-title">Parameters</h5>
                <div id="params-form">
                </div>
            </div>
            
            <button id="test-button" class="btn-test" style="display: none;">
                <i class="fas fa-play me-2"></i>Send Request
            </button>
            
            <div id="response-section" class="response-section" style="display: none;">
                <div class="response-header">
                    <span class="response-title">Response</span>
                    <span class="response-status" id="response-status">200 OK</span>
                </div>
                <div class="response-body" id="response-body">
                    Response will appear here...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// API Data
const apiData = {
    'login': {
        title: 'User Login',
        method: 'POST',
        endpoint: '/api/login',
        description: 'Authenticate user and get access token',
        parameters: [
            { name: 'email', type: 'string', required: true, description: 'User email address' },
            { name: 'password', type: 'string', required: true, description: 'User password' }
        ],
        responseFormat: {
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "user@example.com"
            },
            "token": "1|abc123...",
            "role_id": 2
        }
    },
    'register': {
        title: 'User Registration',
        method: 'POST',
        endpoint: '/api/register',
        description: 'Create a new user account',
        parameters: [
            { name: 'name', type: 'string', required: true, description: 'User first name' },
            { name: 'l_name', type: 'string', required: true, description: 'User last name' },
            { name: 'email', type: 'string', required: true, description: 'User email address' },
            { name: 'password', type: 'string', required: true, description: 'User password' },
            { name: 'password_confirmation', type: 'string', required: true, description: 'Confirm password' }
        ],
        responseFormat: {
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "user@example.com"
            },
            "token": "1|abc123...",
            "role_id": 2
        }
    },
    'products': {
        title: 'Get Products',
        method: 'GET',
        endpoint: '/api/products',
        description: 'Get all products with pagination',
        parameters: [
            { name: 'page', type: 'integer', required: false, description: 'Page number for pagination' },
            { name: 'per_page', type: 'integer', required: false, description: 'Items per page' }
        ],
        responseFormat: {
            "data": [
                {
                    "id": 1,
                    "name": "Product Name",
                    "slug": "product-slug",
                    "price": "99.99",
                    "image": "path/to/image.jpg"
                }
            ],
            "links": {},
            "meta": {}
        }
    },
    'product-details': {
        title: 'Get Product Details',
        method: 'GET',
        endpoint: '/api/products/{slug}',
        description: 'Get specific product details by slug',
        parameters: [
            { name: 'slug', type: 'string', required: true, description: 'Product slug in URL' }
        ],
        responseFormat: {
            "id": 1,
            "name": "Product Name",
            "slug": "product-slug",
            "price": "99.99",
            "description": "Product description",
            "images": ["image1.jpg", "image2.jpg"]
        }
    },
    'categories': {
        title: 'Get Categories',
        method: 'GET',
        endpoint: '/api/categories',
        description: 'Get all product categories',
        parameters: [],
        responseFormat: {
            "data": [
                {
                    "id": 1,
                    "name": "Category Name",
                    "slug": "category-slug",
                    "description": "Category description"
                }
            ]
        }
    },
    'vendors': {
        title: 'Get Vendors',
        method: 'GET',
        endpoint: '/api/vendors',
        description: 'Get all vendors/shops with filtering options',
        parameters: [
            { name: 'category', type: 'string', required: false, description: 'Filter by category slug' },
            { name: 'post_city', type: 'string', required: false, description: 'Filter by location' },
            { name: 'state', type: 'string', required: false, description: 'Filter by state' },
            { name: 'type', type: 'string', required: false, description: 'Filter type (e.g., liked)' },
            { name: 'per_page', type: 'integer', required: false, description: 'Items per page (default: 12)' }
        ],
        responseFormat: {
            "data": [
                {
                    "id": 1,
                    "name": "Vendor Name",
                    "slug": "vendor-slug",
                    "description": "Vendor description",
                    "rating": 4.5
                }
            ],
            "links": {},
            "meta": {}
        }
    },
    'vendor-details': {
        title: 'Get Vendor Details',
        method: 'GET',
        endpoint: '/api/vendors/{slug}',
        description: 'Get specific vendor details with products',
        parameters: [
            { name: 'slug', type: 'string', required: true, description: 'Vendor slug in URL' }
        ],
        responseFormat: {
            "id": 1,
            "name": "Vendor Name",
            "slug": "vendor-slug",
            "description": "Vendor description",
            "products": [],
            "rating": 4.5
        }
    },
    'vendor-products': {
        title: 'Get Vendor Products',
        method: 'GET',
        endpoint: '/api/vendor/{shop:slug}/products',
        description: 'Get all products from a specific vendor',
        parameters: [
            { name: 'shop', type: 'string', required: true, description: 'Vendor slug in URL' }
        ],
        responseFormat: {
            "data": [
                {
                    "id": 1,
                    "name": "Product Name",
                    "price": "99.99",
                    "image": "path/to/image.jpg"
                }
            ],
            "links": {},
            "meta": {}
        }
    }
};

// Current selected API
let currentApi = null;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Add click handlers to API items
    document.querySelectorAll('.api-item').forEach(item => {
        item.addEventListener('click', function() {
            selectApi(this.dataset.endpoint);
        });
    });
});

// Toggle category expansion
function toggleCategory(header) {
    const list = header.nextElementSibling;
    const icon = header.querySelector('i.fa-chevron-down');
    
    if (list.classList.contains('expanded')) {
        list.classList.remove('expanded');
        header.classList.add('collapsed');
    } else {
        list.classList.add('expanded');
        header.classList.remove('collapsed');
    }
}

// Select API endpoint
function selectApi(endpoint) {
    // Update active state
    document.querySelectorAll('.api-item').forEach(item => {
        item.classList.remove('active');
    });
    document.querySelector(`[data-endpoint="${endpoint}"]`).classList.add('active');
    
    // Get API data
    const api = apiData[endpoint];
    currentApi = api;
    
    // Update details panel
    document.getElementById('api-title').textContent = api.title;
    document.getElementById('api-method').textContent = api.method;
    document.getElementById('api-method').className = `method-badge method-${api.method.toLowerCase()}`;
    
    // Show endpoint URL
    document.getElementById('api-endpoint').style.display = 'block';
    document.getElementById('endpoint-url').textContent = api.endpoint;
    
    // Show description
    document.getElementById('api-description-full').style.display = 'block';
    document.getElementById('description-text').textContent = api.description;
    
    // Show parameters if any
    if (api.parameters.length > 0) {
        document.getElementById('api-parameters').style.display = 'block';
        const paramsList = document.getElementById('parameters-list');
        paramsList.innerHTML = '';
        
        api.parameters.forEach(param => {
            const li = document.createElement('li');
            li.className = 'parameter-item';
            li.innerHTML = `
                <span class="parameter-name">${param.name}</span>
                <span class="parameter-type">${param.type}</span>
                <span class="parameter-description">${param.description}</span>
            `;
            paramsList.appendChild(li);
        });
    } else {
        document.getElementById('api-parameters').style.display = 'none';
    }
    
    // Show response format
    document.getElementById('api-response').style.display = 'block';
    document.getElementById('response-format').textContent = JSON.stringify(api.responseFormat, null, 2);
    
    // Update testing panel
    updateTestingPanel(api);
}

// Update testing panel
function updateTestingPanel(api) {
    const testingForm = document.getElementById('testing-form');
    const authSection = document.getElementById('auth-section');
    const paramsSection = document.getElementById('params-section');
    const testButton = document.getElementById('test-button');
    
    // Show testing form
    testingForm.innerHTML = `<h5 class="section-title">${api.title}</h5>`;
    
    // Show auth section for POST requests
    if (api.method === 'POST') {
        authSection.style.display = 'block';
    } else {
        authSection.style.display = 'none';
    }
    
    // Show parameters section
    if (api.parameters.length > 0) {
        paramsSection.style.display = 'block';
        const paramsForm = document.getElementById('params-form');
        paramsForm.innerHTML = '';
        
        api.parameters.forEach(param => {
            const div = document.createElement('div');
            div.className = 'form-group';
            div.innerHTML = `
                <label class="form-label">${param.name}${param.required ? ' *' : ''}</label>
                <input type="text" class="form-control" id="param-${param.name}" placeholder="${param.description}">
            `;
            paramsForm.appendChild(div);
        });
    } else {
        paramsSection.style.display = 'none';
    }
    
    // Show test button
    testButton.style.display = 'block';
    testButton.onclick = () => testApi(api);
}

// Test API
function testApi(api) {
    const button = document.getElementById('test-button');
    const responseSection = document.getElementById('response-section');
    const responseStatus = document.getElementById('response-status');
    const responseBody = document.getElementById('response-body');
    
    // Show loading
    button.disabled = true;
    button.innerHTML = '<span class="spinner"></span> Sending...';
    
    // Build URL
    let url = api.endpoint;
    if (api.parameters.length > 0) {
        api.parameters.forEach(param => {
            const value = document.getElementById(`param-${param.name}`).value;
            if (value && param.name !== 'slug' && param.name !== 'shop') {
                url += (url.includes('?') ? '&' : '?') + `${param.name}=${encodeURIComponent(value)}`;
            }
        });
    }
    
    // Replace path parameters
    api.parameters.forEach(param => {
        const value = document.getElementById(`param-${param.name}`).value;
        if (value && (param.name === 'slug' || param.name === 'shop')) {
            url = url.replace(`{${param.name}}`, value);
        }
    });
    
    // Build request options
    const options = {
        method: api.method,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    };
    
    // Add body for POST requests
    if (api.method === 'POST') {
        const body = {};
        api.parameters.forEach(param => {
            const value = document.getElementById(`param-${param.name}`).value;
            if (value) {
                body[param.name] = value;
            }
        });
        options.body = JSON.stringify(body);
    }
    
    // Add auth token if available
    const token = document.getElementById('auth-token').value;
    if (token) {
        options.headers['Authorization'] = `Bearer ${token}`;
    }
    
    // Make request
    fetch(url, options)
        .then(response => {
            responseStatus.textContent = `${response.status} ${response.statusText}`;
            responseStatus.className = `response-status ${response.ok ? 'status-success' : 'status-error'}`;
            return response.json();
        })
        .then(data => {
            responseBody.textContent = JSON.stringify(data, null, 2);
            responseSection.style.display = 'block';
        })
        .catch(error => {
            responseStatus.textContent = 'Error';
            responseStatus.className = 'response-status status-error';
            responseBody.textContent = `Error: ${error.message}`;
            responseSection.style.display = 'block';
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = '<i class="fas fa-play me-2"></i>Send Request';
        });
}
</script>
@endsection 