@extends('admin.layout')

@section('title', 'Service Management')
@section('subtitle', 'Manage platform services and offerings')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="admin-grid">
        <!-- Add Service Form -->
        <div class="admin-card">
            <h3>Add New Service</h3>
            <form action="{{ route('admin.services.store') }}" method="POST" class="admin-form">
                @csrf
                <div class="form-group">
                    <label>Service Title</label>
                    <input type="text" name="title" required placeholder="e.g. Graphic Design Masterclass">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" placeholder="e.g. Design">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" placeholder="Briefly describe the service..."></textarea>
                </div>
                <button type="submit" class="btn primary">Add Service</button>
            </form>
        </div>

        <!-- Services List -->
        <div class="admin-card">
            <h3>Existing Services</h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr>
                                <td>
                                    <strong>{{ $service->title }}</strong>
                                    <p class="small muted">{{ Str::limit($service->description, 50) }}</p>
                                </td>
                                <td><span class="badge">{{ $service->category ?? 'N/A' }}</span></td>
                                <td>
                                    <form action="{{ route('admin.services.delete', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No services found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper">
                {{ $services->links('partials.pagination') }}
            </div>
        </div>
    </div>
</div>

<style>
    .admin-container { padding: 2rem; }
    .admin-header { margin-bottom: 2rem; }
    .muted { color: #6c757d; }
    .admin-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; }
    .admin-card { background: #fff; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .admin-form .form-group { margin-bottom: 1rem; }
    .admin-form label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.95rem; color: var(--text-slate); }
    .admin-form input, .admin-form textarea { width: 100%; padding: 0.85rem; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; transition: border 0.3s; }
    .admin-form input:focus, .admin-form textarea:focus { border-color: var(--primary-teal); outline: none; }
    .btn-icon.delete { color: #dc3545; background: none; border: none; cursor: pointer; padding: 0.5rem; border-radius: 4px; transition: background 0.2s; }
    .btn-icon.delete:hover { background: #fff5f5; }
    .pagination-wrapper { margin-top: 1.5rem; }
    .small { font-size: 0.85rem; }
    
    @media (max-width: 992px) {
        .admin-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection
