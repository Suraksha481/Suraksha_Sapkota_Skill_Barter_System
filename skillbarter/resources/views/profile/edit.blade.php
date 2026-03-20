@extends('app')

@section('content')
<div class="container" style="max-width: 700px; padding: 40px 20px;">

    <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); padding: 40px;">

        <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 30px; color: var(--text-slate);">Edit Profile</h2>

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
                    onfocus="this.style.borderColor='var(--primary-teal)'; this.style.boxShadow='0 0 0 4px rgba(32,166,138,0.15)'; this.style.outline='none';"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';"
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
                    onfocus="this.style.borderColor='var(--primary-teal)'; this.style.boxShadow='0 0 0 4px rgba(32,166,138,0.15)'; this.style.outline='none';"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';"
                >
                @error('email')
                    <p style="color: #dc2626; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone Field --}}
            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #000; font-size: 14px;">
                    Phone Number
                </label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="98XXXXXXXX"
                    style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit; transition: border-color 0.3s ease;"
                    onmouseover="this.style.borderColor='#ccc'"
                    onmouseout="this.style.borderColor='#e0e0e0'"
                    onfocus="this.style.borderColor='var(--primary-teal)'; this.style.boxShadow='0 0 0 4px rgba(32,166,138,0.15)'; this.style.outline='none';"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';"
                >
                <p style="color: #666; font-size: 12px; margin-top: 5px;">This number will be used for payments.</p>
                @error('phone')
                    <p style="color: #dc2626; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>
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
                    onfocus="this.style.borderColor='var(--primary-teal)'; this.style.boxShadow='0 0 0 4px rgba(32,166,138,0.15)'; this.style.outline='none';"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';"
                >{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <p style="color: #dc2626; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            @if($user->isTeacher())
            {{-- Khalti ID Field --}}
            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #000; font-size: 14px;">
                    Khalti ID (Mobile Number for Payouts)
                </label>
                <input
                    type="text"
                    name="khalti_id"
                    value="{{ old('khalti_id', $user->teacherProfile->khalti_id ?? '') }}"
                    placeholder="98XXXXXXXX"
                    style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                >
                <p style="color: #666; font-size: 12px; margin-top: 5px;">Admin will use this ID to send your 50% share after payments.</p>
            </div>
            @endif

            {{-- Avatar Field --}}
            <div style="margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #000; font-size: 14px;">
                    Profile Picture (Avatar)
                </label>
                <input
                    type="file"
                    name="avatar"
                    accept="image/*"
                    style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; font-family: inherit; transition: border-color 0.3s ease;"
                    onmouseover="this.style.borderColor='#ccc'"
                    onmouseout="this.style.borderColor='#e0e0e0'"
                    onfocus="this.style.borderColor='var(--primary-teal)'; this.style.boxShadow='0 0 0 4px rgba(32,166,138,0.15)'; this.style.outline='none';"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';"
                >
                @error('avatar')
                    <p style="color: #dc2626; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
                @if($user->avatar)
                    <div style="margin-top: 10px;">
                        <img src="{{ $user->avatar }}" alt="Current Avatar" style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid #e0e0e0; object-fit: cover;">
                        <span style="font-size: 12px; color: #666; vertical-align: middle; margin-left: 10px;">Current Avatar</span>
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; gap: 15px;">
                <button
                    type="submit"
                    style="flex: 1; border: none; padding: 14px 24px; cursor: pointer; text-align: center;"
                    class="btn-pill primary"
                >
                    Save Changes
                </button>
                <a
                    href="{{ route('profile.show') }}"
                    style="flex: 1; padding: 14px 24px; text-decoration: none; text-align: center; border: 2px solid var(--primary-teal); background: white;"
                    class="btn-pill secondary"
                >
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>
@endsection
