@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Upload Teaching Resource</h1>
        <p>Share your knowledge materials with students</p>
    </div>

    <div class="form-container">
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        <form action="{{ route('teacher.resources.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Resource Title *</label>
                <input type="text" id="title" name="title" placeholder="e.g., Python Basics Tutorial"
                       value="{{ old('title') }}" required>
                @error('title') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Describe what this resource contains..."
                          rows="4">{{ old('description') }}</textarea>
                @error('description') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category">
                    <option value="">-- Select Category --</option>
                    <option value="tutorial" {{ old('category') == 'tutorial' ? 'selected' : '' }}>Tutorial</option>
                    <option value="notes" {{ old('category') == 'notes' ? 'selected' : '' }}>Notes</option>
                    <option value="assignment" {{ old('category') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                    <option value="reference" {{ old('category') == 'reference' ? 'selected' : '' }}>Reference</option>
                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="file">Upload File * (PDF, DOC, DOCX, TXT max 10MB)</label>
                <input type="file" id="file" name="file"
                       accept=".pdf,.doc,.docx,.txt" required>
                @error('file') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-pill primary" style="padding: 12px 30px; border: none; font-size: 1rem; cursor: pointer; display: inline-block;">Upload Resource</button>
                <a href="{{ route('teacher.resources.index') }}" class="btn-pill secondary" style="padding: 12px 30px; font-size: 1rem; display: inline-block; text-align: center;">Cancel</a>
            </div>
        </form>
    </div>

</section>

<style>
<style>
    .form-container {
        max-width: 600px;
        margin: 30px auto;
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid var(--primary-teal-light);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-slate);
        font-size: 0.95rem;
    }

    .form-group input[type="text"],
    .form-group input[type="file"],
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 14px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="file"]:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: var(--primary-teal);
        box-shadow: 0 0 0 4px rgba(32, 166, 138, 0.15);
        background: #fff;
        outline: none;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 40px;
    }

    .error {
        color: #ef4444;
        font-size: 0.85rem;
        display: block;
        margin-top: 6px;
        font-weight: 500;
    }
</style>

@endsection
