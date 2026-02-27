@extends('admin.layout')

@section('content')
<section class="container">
    <h1>Skills</h1>
    @if(session('status'))<div class="alert">{{ session('status') }}</div>@endif

    <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden">
        <thead style="background:#f8fafc"><tr><th style="padding:8px">Name</th><th style="padding:8px">Category</th><th style="padding:8px">Actions</th></tr></thead>
        <tbody>
        @foreach($skills as $s)
            <tr>
                <td style="padding:8px">{{ $s->name }}</td>
                <td style="padding:8px">{{ $s->category ?? '-' }}</td>
                <td style="padding:8px">
                    <form method="POST" action="{{ route('admin.skills.delete', $s->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this skill?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:1rem">{{ $skills->links() }}</div>
</section>

@endsection
