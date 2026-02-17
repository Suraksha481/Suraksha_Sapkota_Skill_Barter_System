@extends('app')

@section('content')

<section class="dashboard">

    <div class="dashboard-header">
        <h1>Upload Teaching Resource</h1>
        <p>Share your knowledge materials with students</p>
    </div>

    <div class="form-container">
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
                <label for="category">🏷️ Category</label>
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
                <label for="file">📁 Upload File * (PDF, DOC, DOCX, TXT max 10MB)</label>
                <input type="file" id="file" name="file"
                       accept=".pdf,.doc,.docx,.txt" required>
                @error('file') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">✅ Upload Resource</button>
                <a href="{{ route('teacher.resources.index') }}" class="btn secondary">❌ Cancel</a>
            </div>
        </form>
    </div>

</section>

<style>
    .form-container {
        max-width: 600px;
        margin: 30px auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-group input[type="text"],
    .form-group input[type="file"],
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: inherit;
        font-size: 14px;
    }

    .form-group textarea {
        resize: vertical;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn.primary {
        background: #2196f3;
        color: white;
    }

    .btn.primary:hover {
        background: #1976d2;
    }

    .btn.secondary {
        background: #999;
        color: white;
    }

    .error {
        color: #d32f2f;
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }
</style>

@endsection
