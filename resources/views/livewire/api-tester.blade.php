<div class="card">
    <div class="card-header">
        <h5 class="card-title">Advanced API Tester</h5>
        <p class="text-muted">Test any API endpoint with custom parameters</p>
    </div>
    <div class="card-body">
        <!-- Quick Endpoint Selection -->
        <div class="mb-4">
            <label class="form-label">Quick Select Endpoint:</label>
            <select wire:model="endpoint" class="form-select" wire:change="selectEndpoint($event.target.value)">
                @foreach($availableEndpoints as $key => $endpoint)
                    <option value="{{ $key }}">{{ $key }} - {{ $endpoint['description'] }}</option>
                @endforeach
            </select>
        </div>

        <!-- Manual Configuration -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Endpoint URL:</label>
                    <input type="text" wire:model="endpoint" class="form-control" placeholder="/api/endpoint">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">HTTP Method:</label>
                    <select wire:model="method" class="form-select">
                        <option value="GET">GET</option>
                        <option value="POST">POST</option>
                        <option value="PUT">PUT</option>
                        <option value="PATCH">PATCH</option>
                        <option value="DELETE">DELETE</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Request Body (for POST/PUT/PATCH) -->
        @if(in_array($method, ['POST', 'PUT', 'PATCH']))
        <div class="mb-3">
            <label class="form-label">Request Body (JSON):</label>
            <textarea wire:model="body" class="form-control" rows="6" placeholder='{"key": "value"}'></textarea>
            <small class="text-muted">Enter valid JSON for POST/PUT/PATCH requests</small>
        </div>
        @endif

        <!-- Test Button -->
        <div class="mb-4">
            <button wire:click="testApi" class="btn btn-primary" wire:loading.attr="disabled">
                <span wire:loading.remove>Test API</span>
                <span wire:loading>Testing...</span>
            </button>
        </div>

        <!-- Response Section -->
        @if($response)
        <div class="border rounded p-3 bg-light">
            <h6>Response (Status: {{ $responseStatus }})</h6>
            <pre class="mb-0" style="max-height: 400px; overflow-y: auto;">{{ $response }}</pre>
        </div>
        @endif

        <!-- Endpoint Documentation -->
        <div class="mt-4">
            <h6>Available Endpoints:</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Method</th>
                            <th>Endpoint</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($availableEndpoints as $key => $endpoint)
                        <tr>
                            <td><span class="badge bg-{{ $endpoint['method'] === 'GET' ? 'info' : 'success' }}">{{ $endpoint['method'] }}</span></td>
                            <td><code>{{ $endpoint['url'] }}</code></td>
                            <td>{{ $endpoint['description'] }}</td>
                            <td>
                                <button wire:click="selectEndpoint('{{ $key }}')" class="btn btn-sm btn-outline-primary">Load</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 