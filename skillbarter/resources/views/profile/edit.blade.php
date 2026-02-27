@extends('app')

@section('content')
<div class="container" style="max-width: 700px; padding: 40px 20px;">

    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); padding: 40px;">

        <h2 style="font-size: 28px; font-weight: 700; margin-bottom: 30px; color: #000;">Edit Profile</h2>

        {{-- Success Message --}}
        @if(session('status'))
            <div style="background: #dcfce7; color: #166534; border-left: 4px solid #16a34a; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px;">
                ✓ {{ session('status') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div style="background: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px;">
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 10px 0 0 20px; padding: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Name Field --}}
            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #000; font-size: 14px;">
                    Name
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit; transition: border-color 0.3s ease;"
                    onmouseover="this.style.borderColor='#ccc'"
                    onmouseout="this.style.borderColor='#e0e0e0'"
                    onfocus="this.style.borderColor='#000'; this.style.outline='none';"
                    onblur="this.style.borderColor='#e0e0e0';"
                >
                @error('name')
                    <p style="color: #dc2626; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email Field --}}
            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #000; font-size: 14px;">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit; transition: border-color 0.3s ease;"
                    onmouseover="this.style.borderColor='#ccc'"
                    onmouseout="this.style.borderColor='#e0e0e0'"
                    onfocus="this.style.borderColor='#000'; this.style.outline='none';"
                    onblur="this.style.borderColor='#e0e0e0';"
                >
                @error('email')
                    <p style="color: #dc2626; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bio Field --}}
            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #000; font-size: 14px;">
                    Bio <span style="color: #999;">(optional)</span>
                </label>
                <textarea
                    name="bio"
                    rows="5"
                    style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit; resize: vertical; transition: border-color 0.3s ease;"
                    onmouseover="this.style.borderColor='#ccc'"
                    onmouseout="this.style.borderColor='#e0e0e0'"
                    onfocus="this.style.borderColor='#000'; this.style.outline='none';"
                    onblur="this.style.borderColor='#e0e0e0';"
                >{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <p style="color: #dc2626; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; gap: 15px;">
                <button
                    type="submit"
                    style="flex: 1; background: #000; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; transition: all 0.3s ease;"
                    onmouseover="this.style.background='#333'"
                    onmouseout="this.style.background='#000'"
                    onclick="this.style.transform='scale(0.98)'"
                    onmouseup="this.style.transform='scale(1)'"
                >
                    Save Changes
                </button>
                <a
                    href="{{ route('profile.show') }}"
                    style="flex: 1; background: #f5f5f5; color: #000; padding: 12px 24px; border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 600; text-decoration: none; text-align: center; font-size: 14px; transition: all 0.3s ease;"
                    onmouseover="this.style.background='#e8e8e8'"
                    onmouseout="this.style.background='#f5f5f5'"
                >
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>
@endsection
