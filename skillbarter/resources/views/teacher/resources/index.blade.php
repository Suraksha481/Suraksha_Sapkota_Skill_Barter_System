@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Teaching Resources</h1>
        <p>Manage your learning materials and resources</p>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif
    @if ($error = Session::get('error'))
        <div class="alert alert-error">{{ $error }}</div>
    @endif

    <!-- UPLOAD BUTTON -->
    <div class="resource-header">
        <a href="{{ route('teacher.resources.create') }}" class="btn primary">Upload New Resource</a>
    </div>

    <!-- RESOURCES LIST -->
    <div class="resources-grid">
        @forelse($resources as $resource)
            <div class="resource-card">
                <div class="resource-header">
                    <h3>📄 {{ $resource->title }}</h3>
                    @if($resource->category)
                        <span class="category-badge">{{ $resource->category }}</span>
                    @endif
                </div>

                <p>{{ $resource->description }}</p>

                <div class="resource-meta">
                    <small>Uploaded: {{ $resource->created_at->format('M d, Y') }}</small>
                </div>

                <div class="resource-actions">
                    <a href="{{ route('teacher.resources.download', $resource) }}" class="btn small">⬇Download</a>
                    <form action="{{ route('teacher.resources.destroy', $resource) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn small danger" onclick="return confirm('Delete this resource?')">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>📭 No resources uploaded yet.</p>
                <a href="{{ route('teacher.resources.create') }}" class="btn primary">Upload Your First Resource</a>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="pagination-wrapper">
        {{ $resources->links() }}
    </div>

</section>

<style>
    .resource-header {
        margin-bottom: 20px;
    }

    .resources-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }

    .resource-card {
        background: white;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .resource-card h3 {
        margin: 0 0 10px 0;
    }

    .category-badge {
        display: inline-block;
        background: #e3f2fd;
        color: #1976d2;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        margin-left: 10px;
    }

    .resource-meta {
        margin: 15px 0;
        color: #999;
    }

    .resource-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn.danger {
        background: #f44336;
        color: white;
    }

    .btn.small {
        padding: 6px 12px;
        font-size: 12px;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: #f5f5f5;
        border-radius: 8px;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }
</style>

@endsection
