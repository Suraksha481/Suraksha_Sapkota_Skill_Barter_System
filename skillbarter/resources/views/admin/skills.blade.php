@extends('admin.layout')

@section('title', 'Skill Management')
@section('subtitle', 'Monitor, manage and add skills available on the platform')

@section('content')

    @if(session('status') || session('success'))
        <div class="alert alert-success">{{ session('status') ?? session('success') }}</div>
    @endif

    {{-- ── ADD SKILL FORM ── --}}
    <div class="admin-card add-skill-card">
        <div class="add-skill-header" onclick="toggleAddForm()" style="cursor:pointer; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:12px;">
                <span class="add-icon">＋</span>
                <span>Add New Skill</span>
            </div>
            <svg id="add-chevron" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="transition:transform 0.3s;">
                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
            </svg>
        </div>

        <div id="add-skill-form" style="display:none; margin-top: 24px;">
            <form method="POST" action="{{ route('admin.skills.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group-inline">
                        <label>Skill Title <span class="req">*</span></label>
                        <input type="text" name="title" placeholder="e.g. Python Programming" required class="form-control-dark">
                    </div>
                    <div class="form-group-inline">
                        <label>Category <span class="req">*</span></label>
                        <input type="text" name="category" placeholder="e.g. Technology" required class="form-control-dark">
                    </div>
                </div>
                <div class="form-group-inline" style="margin-top:16px;">
                    <label>Description</label>
                    <textarea name="description" rows="2" placeholder="Brief description of this skill..." class="form-control-dark"></textarea>
                </div>
                <div class="form-group-inline" style="margin-top:16px;">
                    <label>Skill Image</label>
                    <div class="file-upload-wrap">
                        <input type="file" name="image" accept="image/*" id="skill-image-input" onchange="previewImage(event)">
                        <div class="file-upload-label" onclick="document.getElementById('skill-image-input').click()">
                            <span id="image-preview-wrap" style="display:none;">
                                <img id="image-preview" style="width:60px; height:60px; border-radius:10px; object-fit:cover;">
                            </span>
                            <span id="upload-placeholder">📁 Click to upload image (PNG, JPG, WebP)</span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-add-skill">Add Skill</button>
            </form>
        </div>
    </div>

    {{-- ── SKILLS TABLE ── --}}
    <div class="admin-card" style="margin-top: 20px;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:8%;">Image</th>
                        <th style="width:32%;">Name</th>
                        <th style="width:30%;">Category</th>
                        <th style="width:30%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($skills as $s)
                    <tr>
                        <td>
                            @if($s->image)
                                <img src="{{ asset($s->image) }}" alt="{{ $s->title }}"
                                     class="skill-thumb"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                <div class="skill-thumb-placeholder" style="display:none;">
                                    <span>🎯</span>
                                </div>
                            @else
                                <div class="skill-thumb-placeholder">
                                    <span>🎯</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="skill-info">
                                <span class="skill-name">{{ $s->title }}</span>
                                @if($s->description)
                                    <span class="skill-desc">{{ Str::limit($s->description, 50) }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge">{{ $s->category ?? 'Uncategorized' }}</span>
                        </td>
                        <td>
                            <div style="display:flex; gap:10px; align-items:center;">
                                {{-- Edit image inline --}}
                                <form method="POST" action="{{ route('admin.skills.update', $s->id) }}" enctype="multipart/form-data" style="display:flex; align-items:center; gap:6px;">
                                    @csrf
                                    @method('PUT')
                                    <label class="btn-icon edit" title="Change Image" style="cursor:pointer; padding: 8px 12px; font-size:0.8rem; font-weight:700; gap:4px; display:flex; align-items:center; white-space:nowrap;">
                                        📷 Update Image
                                        <input type="file" name="image" accept="image/*" style="display:none;" onchange="this.form.submit()">
                                    </label>
                                </form>
                                {{-- Delete --}}
                                <form method="POST" action="{{ route('admin.skills.delete', $s->id) }}" onsubmit="return confirm('Delete this skill?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="Delete Skill">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
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

<style>
    /* ── ADD SKILL CARD ── */
    .add-skill-card {
        background: #fff;
        border-radius: 16px;
        border: 2px dashed var(--primary-teal-light);
        padding: 24px 28px;
        box-shadow: none;
        transition: border-color 0.2s;
    }
    .add-skill-card:hover { border-color: var(--primary-teal); }
    .add-skill-header { font-size: 1rem; font-weight: 800; color: var(--text-slate); }
    .add-icon {
        width: 32px; height: 32px;
        background: var(--primary-teal);
        color: #fff;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1.2rem;
    }
    .req { color: var(--primary-teal); }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group-inline { display: flex; flex-direction: column; gap: 6px; }
    .form-group-inline label { font-size: 0.82rem; font-weight: 700; color: #374151; }
    .form-control-dark {
        padding: 11px 14px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.9rem;
        color: #1a1a1a;
        outline: none;
        transition: border-color 0.2s;
        font-family: inherit;
        resize: vertical;
        width: 100%;
    }
    .form-control-dark:focus { border-color: var(--primary-teal); box-shadow: 0 0 0 3px rgba(32,166,138,0.1); }

    .file-upload-wrap { position: relative; }
    .file-upload-label {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 16px;
        border: 2px dashed #e5e7eb;
        border-radius: 10px;
        cursor: pointer;
        color: #9ca3af;
        font-size: 0.88rem;
        transition: border-color 0.2s;
    }
    .file-upload-label:hover { border-color: var(--primary-teal); color: var(--primary-teal); }

    .btn-add-skill {
        margin-top: 20px;
        padding: 12px 32px;
        background: linear-gradient(135deg, var(--primary-teal), var(--primary-teal-dark));
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-add-skill:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(32,166,138,0.3); }

    /* ── SKILLS TABLE ── */
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
        font-size: 0.82rem;
        letter-spacing: 0.5px;
        color: var(--text-slate);
        border-bottom: 2px solid var(--primary-teal-light);
    }
    .admin-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.95rem;
        color: #475569;
        vertical-align: middle;
    }
    .admin-table tr { transition: all 0.2s ease; }
    .admin-table tbody tr:hover { background: #f8fafc; }

    /* Skill thumbnail */
    .skill-thumb {
        width: 52px; height: 52px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #f0f0f0;
        display: block;
    }
    .skill-thumb-placeholder {
        width: 52px; height: 52px;
        border-radius: 10px;
        background: var(--primary-teal-light);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
    }

    .skill-name { font-weight: 700; color: #1a1a1a; font-size: 1rem; display: block; }
    .skill-desc { font-size: 0.78rem; color: #94a3b8; display: block; margin-top: 2px; }

    .badge {
        background: #f0f4f8;
        color: #476282;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-block;
    }

    .btn-icon.edit {
        background: #eff6ff;
        color: #2563eb;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 700;
        transition: all 0.2s;
    }
    .btn-icon.edit:hover { background: #dbeafe; transform: scale(1.03); }

    .btn-icon.delete {
        color: #e03131;
        background: #fff5f5;
        border: none;
        cursor: pointer;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.2s;
        display: flex; align-items: center; justify-content: center;
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
        margin-bottom: 1.5rem;
        background: #ebfbee;
        color: #2b8a3e;
        font-weight: 600;
        border: 1px solid #d3f9d8;
    }
    .alert-success { background: #ebfbee; border-color: #d3f9d8; color: #2b8a3e; }
</style>

<script>
function toggleAddForm() {
    const form = document.getElementById('add-skill-form');
    const chevron = document.getElementById('add-chevron');
    const open = form.style.display !== 'none';
    form.style.display = open ? 'none' : 'block';
    chevron.style.transform = open ? '' : 'rotate(180deg)';
}

function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('image-preview').src = e.target.result;
        document.getElementById('image-preview-wrap').style.display = 'inline';
        document.getElementById('upload-placeholder').textContent = file.name;
    };
    reader.readAsDataURL(file);
}
</script>

@endsection
