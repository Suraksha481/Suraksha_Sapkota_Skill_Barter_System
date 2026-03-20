@extends('admin.layout')

@section('title', 'Skill Management')
@section('subtitle', 'Monitor and manage all skills available on the platform')

@section('content')

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Name</th>
                        <th style="width: 40%;">Category</th>
                        <th style="width: 20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($skills as $s)
                    <tr>
                        <td>
                            <div class="skill-info">
                                <span class="skill-name">{{ $s->title }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge">{{ $s->category ?? 'Uncategorized' }}</span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.skills.delete', $s->id) }}" onsubmit="return confirm('Are you sure you want to delete this skill?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Delete Skill">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $skills->links('partials.pagination') }}
        </div>
    </div>
</div>

<style>
    .admin-container { padding: 2rem; max-width: 1200px; margin: 0 auto; }
    .admin-header { margin-bottom: 2.5rem; }
    .admin-header h1 { font-size: 2.5rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.5rem; }
    .muted { color: #6c757d; font-size: 1.1rem; }
    
    .admin-card { 
        background: #fff; 
        padding: 0; 
        border-radius: 16px; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.03); 
        overflow: hidden;
        border: 1px solid var(--primary-teal-light);
    }
    
    .table-responsive { width: 100%; overflow-x: auto; }
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { 
        background: #f8fafc; 
        padding: 18px 20px;
        text-align: left; 
        font-weight: 800; 
        text-transform: uppercase; 
        font-size: 0.85rem; 
        letter-spacing: 0.5px;
        color: var(--text-slate);
        border-bottom: 2px solid var(--primary-teal-light);
    }
    .admin-table td { 
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.95rem;
        color: #475569;
        vertical-align: middle;
    }
    .admin-table tr { transition: all 0.2s ease; }
    .admin-table tbody tr:hover { background: #f8fafc; }
    
    .skill-name { font-weight: 700; color: #1a1a1a; font-size: 1rem; }
    .badge { 
        background: #f0f4f8; 
        color: #476282; 
        padding: 6px 12px; 
        border-radius: 6px; 
        font-size: 0.8rem; 
        font-weight: 700;
        display: inline-block;
    }
    
    .btn-icon.delete { 
        color: #e03131; 
        background: #fff5f5; 
        border: none; 
        cursor: pointer; 
        padding: 10px; 
        border-radius: 8px; 
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-icon.delete:hover { background: #ffe3e3; transform: scale(1.05); }
    
    .pagination-wrapper { 
        padding: 1.5rem; 
        background: #fafafa; 
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: center;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        background: #ebfbee;
        color: #2b8a3e;
        font-weight: 600;
        border: 1px solid #d3f9d8;
    }
</style>
@endsection
