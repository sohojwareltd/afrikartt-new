<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ApiTester extends Component
{
    public $endpoint = '';
    public $method = 'GET';
    public $headers = [];
    public $body = '';
    public $response = '';
    public $responseStatus = '';
    public $isLoading = false;
    
    public $availableEndpoints = [
        'POST /api/login' => [
            'url' => '/api/login',
            'method' => 'POST',
            'description' => 'Authenticate user and get access token',
            'sample_body' => '{"email":"test@example.com","password":"password"}'
        ],
        'POST /api/register' => [
            'url' => '/api/register',
            'method' => 'POST',
            'description' => 'Create a new user account',
            'sample_body' => '{"name":"John","l_name":"Doe","email":"newuser@example.com","password":"password123","password_confirmation":"password123"}'
        ],
        'GET /api/products' => [
            'url' => '/api/products',
            'method' => 'GET',
            'description' => 'Get all products with pagination',
            'sample_body' => ''
        ],
        'GET /api/categories' => [
            'url' => '/api/categories',
            'method' => 'GET',
            'description' => 'Get all product categories',
            'sample_body' => ''
        ]
    ];

    public function mount()
    {
        $this->endpoint = '/api/products';
        $this->method = 'GET';
    }

    public function selectEndpoint($key)
    {
        $endpoint = $this->availableEndpoints[$key];
        $this->endpoint = $endpoint['url'];
        $this->method = $endpoint['method'];
        $this->body = $endpoint['sample_body'];
    }

    public function testApi()
    {
        $this->isLoading = true;
        $this->response = '';
        $this->responseStatus = '';

        try {
            $request = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            if ($this->method === 'GET') {
                $response = $request->get(url($this->endpoint));
            } else {
                $body = json_decode($this->body, true) ?: [];
                $response = $request->post(url($this->endpoint), $body);
            }

            $this->responseStatus = $response->status();
            $this->response = json_encode($response->json(), JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            $this->responseStatus = 'Error';
            $this->response = 'Error: ' . $e->getMessage();
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.api-tester');
    }
} 