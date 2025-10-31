<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;

class AllGetRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_public_get_routes_do_not_return_server_errors()
    {
        $routes = collect(Route::getRoutes())->filter(fn($route) => in_array('GET', $route->methods()));

        $skipPatterns = ['_debugbar', 'telescope', 'horizon', 'vendor', 'ignition', 'api/'];
        $errors = [];

        foreach ($routes as $route) {
            $uri = '/' . ltrim($route->uri(), '/');

            if (Str::contains($uri, '{')) {
                continue;
            }

            if (collect($skipPatterns)->contains(fn($p) => Str::contains($uri, $p))) {
                continue;
            }

            $middleware = $route->gatherMiddleware();

            if (collect($middleware)->contains(fn($m) => Str::contains($m, 'auth'))) {
                continue;
            }

            $response = $this->get($uri);

            if ($response->status() >= 500) {
                $errors[] = ['uri' => $uri, 'status' => $response->status()];
            }
        }

        $this->assertEmpty($errors, 'Some public GET routes returned 500+ errors: ' . json_encode($errors));
    }

    public function test_all_auth_get_routes_do_not_return_server_errors_for_authenticated_user()
    {
        $user = User::factory()->create();

        $routes = collect(Route::getRoutes())->filter(fn($route) => in_array('GET', $route->methods()));

        $skipPatterns = ['_debugbar', 'telescope', 'horizon', 'vendor', 'ignition', 'api/'];
        $errors = [];

        foreach ($routes as $route) {
            $uri = '/' . ltrim($route->uri(), '/');

            if (Str::contains($uri, '{')) {
                continue;
            }

            if (collect($skipPatterns)->contains(fn($p) => Str::contains($uri, $p))) {
                continue;
            }

            $middleware = $route->gatherMiddleware();

            if (!collect($middleware)->contains(fn($m) => Str::contains($m, 'auth'))) {
                continue;
            }

            $response = $this->actingAs($user)->get($uri);

            if ($response->status() >= 500) {
                $errors[] = ['uri' => $uri, 'status' => $response->status()];
            }
        }

        $this->assertEmpty($errors, 'Some auth GET routes returned 500+ errors: ' . json_encode($errors));
    }
}
