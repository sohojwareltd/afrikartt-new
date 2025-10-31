@extends('layouts.app')

@section('title', 'Local Admin - Users & Shops Management')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-dark">
                        <i class="fas fa-tools me-2 text-warning"></i>
                        Local Admin Panel
                    </h1>
                    <p class="text-muted mb-0">Development environment only - Manage users and shops</p>
                </div>
                @if(session('original_admin_id'))
                    <form method="POST" action="{{ route('local-admin.return-to-admin') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Return to Admin
                        </button>
                    </form>
                @endif
            </div>

            <!-- Environment Warning -->
            <div class="alert alert-warning border-0 shadow-sm mb-4">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Development Mode:</strong> This panel is only accessible in local environment.
            </div>

            <!-- Search and Filter -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('local-admin.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ $search }}" 
                                   placeholder="Search by name, email, or slug...">
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="users" {{ $type === 'users' ? 'selected' : '' }}>Users</option>
                                <option value="shops" {{ $type === 'shops' ? 'selected' : '' }}>Shops</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i>
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create Test User</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('local-admin.create-test-user') }}">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="email" name="email" class="form-control form-control-sm" placeholder="Email" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="password" name="password" class="form-control form-control-sm" placeholder="Password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-plus me-1"></i>
                                    Create User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-store me-2"></i>Create Test Shop</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('local-admin.create-test-shop') }}">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Shop Name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="slug" class="form-control form-control-sm" placeholder="Slug" required>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="user_id" class="form-select form-select-sm" required>
                                            <option value="">Select User</option>
                                            @foreach(\App\Models\User::latest()->take(10)->get() as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm mt-2">
                                    <i class="fas fa-plus me-1"></i>
                                    Create Shop
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        {{ ucfirst($type) }} 
                        @if($search)
                            - Search results for "{{ $search }}"
                        @endif
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($type === 'users' && isset($users))
                        @if($users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td><span class="badge bg-secondary">{{ $user->id }}</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($user->avatar)
                                                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                                                 class="rounded-circle me-2" 
                                                                 width="32" height="32" 
                                                                 alt="{{ $user->name }}">
                                                        @else
                                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                                 style="width: 32px; height: 32px;">
                                                                <i class="fas fa-user text-white" style="font-size: 14px;"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-semibold">{{ $user->name }}</div>
                                                            @if($user->l_name)
                                                                <small class="text-muted">{{ $user->l_name }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ $user->email }}</span>
                                                    @if($user->email_verified_at)
                                                        <i class="fas fa-check-circle text-success ms-1" title="Verified"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($user->role_id)
                                                        <span class="badge bg-info">Role {{ $user->role_id }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">User</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('local-admin.login-as-user', $user->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-sign-in-alt me-1"></i>
                                                            Login As
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-light">
                                {{ $users->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No users found</h5>
                                <p class="text-muted">Try adjusting your search criteria</p>
                            </div>
                        @endif
                    @elseif($type === 'shops' && isset($shops))
                        @if($shops->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Shop Name</th>
                                            <th>Owner</th>
                                            <th>Slug</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($shops as $shop)
                                            <tr>
                                                <td><span class="badge bg-secondary">{{ $shop->id }}</span></td>
                                                <td>
                                                    <div class="fw-semibold">{{ $shop->name }}</div>
                                                    @if($shop->description)
                                                        <small class="text-muted">{{ Str::limit($shop->description, 50) }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($shop->user)
                                                        <div class="d-flex align-items-center">
                                                            @if($shop->user->avatar)
                                                                <img src="{{ asset('storage/' . $shop->user->avatar) }}" 
                                                                     class="rounded-circle me-2" 
                                                                     width="24" height="24" 
                                                                     alt="{{ $shop->user->name }}">
                                                            @else
                                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                                     style="width: 24px; height: 24px;">
                                                                    <i class="fas fa-user text-white" style="font-size: 10px;"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <div class="fw-semibold">{{ $shop->user->name }}</div>
                                                                <small class="text-muted">{{ $shop->user->email }}</small>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">No owner</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <code class="text-muted">{{ $shop->slug }}</code>
                                                </td>
                                                <td>
                                                    @if($shop->status)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">{{ $shop->created_at->format('M d, Y') }}</small>
                                                </td>
                                                <td>
                                                    @if($shop->user)
                                                        <form method="POST" action="{{ route('local-admin.login-as-shop', $shop->id) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                                <i class="fas fa-store me-1"></i>
                                                                Login As Owner
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted">No owner</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-light">
                                {{ $shops->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-store fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No shops found</h5>
                                <p class="text-muted">Try adjusting your search criteria</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 0.5rem;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .form-control-sm, .form-select-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection
