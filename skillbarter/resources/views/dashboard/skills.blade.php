@extends('app')

@section('content')

<section class="manage-skills">

    <h1>Manage My Skills</h1>
    <p class="subtitle">Add skills you can teach or want to learn</p>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <!-- ADD SKILL FORM -->
    <div class="skill-form-card">
        <form id="user-skill-form" method="POST" action="{{ route('my.skills.store') }}">
            @csrf

            <div class="form-group">
                <label>Select Skill</label>
                <select name="skill_id" required>
                    <option value="">-- Choose a skill --</option>
                    @foreach($allSkills as $skill)
                        <option value="{{ $skill->id }}">
                            {{ $skill->title }} ({{ $skill->category }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>I want to</label>
                @php $user = auth()->user(); @endphp
                @if($user && $user->isTeacher() && ! $user->isStudent())
                    <input type="hidden" name="type" value="offer">
                    <div class="muted">(You are registered as a teacher — adding teaching skills)</div>
                @elseif($user && $user->isStudent() && ! $user->isTeacher())
                    <input type="hidden" name="type" value="request">
                    <div class="muted">(You are registered as a student — adding learning skills)</div>
                @else
                    <select name="type" required>
                        <option value="offer">Teach this skill</option>
                        <option value="request">Learn this skill</option>
                    </select>
                @endif
            </div>

            <button type="submit" class="btn primary">Add Skill</button>
        </form>
    </div>

    <!-- SKILLS LIST -->
    <div class="skills-columns">

        <!-- TEACH -->
        <div class="skills-box">
            <h2>Skills I Teach</h2>

            <ul>
                @forelse($teachSkills as $userSkill)
                    <li>
                        {{ $userSkill->skill->title ?? 'Unknown Skill' }}
                        <form method="POST" action="{{ route('my.skills.destroy', $userSkill->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-btn">✕</button>
                        </form>
                    </li>
                @empty
                    <li class="empty">You haven't added teaching skills yet.</li>
                @endforelse
            </ul>
        </div>

        <!-- LEARN -->
        <div class="skills-box">
            <h2>Skills I Want to Learn</h2>

            <ul>
                @forelse($learnSkills as $userSkill)
                    <li>
                        {{ $userSkill->skill->title ?? 'Unknown Skill' }}
                        <form method="POST" action="{{ route('my.skills.destroy', $userSkill->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-btn">✕</button>
                        </form>
                    </li>
                @empty
                    <li class="empty">You haven't added learning skills yet.</li>
                @endforelse
            </ul>
        </div>

    </div>

</section>

@endsection

@push('scripts')
<script>
    (function(){
        const form = document.getElementById('user-skill-form');
        const csrf = '{{ csrf_token() }}';
        const addUrl = '{{ route('my.skills.store') }}';

        function appendSkillToList(userSkill) {
            try {
                const type = userSkill.type; // 'offer' or 'request'
                const title = userSkill.skill?.title ?? 'Unknown Skill';
                const id = userSkill.id;
                const ul = document.querySelector(type === 'offer' ? '.skills-columns .skills-box:nth-child(1) ul' : '.skills-columns .skills-box:nth-child(2) ul');
                if (!ul) return;

                const li = document.createElement('li');
                li.innerHTML = `${title} <form method="POST" action="/my-skills/${id}" style="display:inline">` +
                    `<input type="hidden" name="_token" value="${csrf}">` +
                    `<input type="hidden" name="_method" value="DELETE">` +
                    `<button type="submit" class="remove-btn">✕</button>` +
                    `</form>`;

                // If empty message exists, remove it
                const empty = ul.querySelector('.empty');
                if (empty) empty.remove();

                ul.appendChild(li);
            } catch (e) {
                console.error('appendSkillToList error', e);
            }
        }

        async function submitSkill(formData) {
            const resp = await fetch(addUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: formData
            });

            return resp.json().then(data => ({status: resp.status, data}));
        }

        if (form) {
            form.addEventListener('submit', function(e){
                e.preventDefault();
                const fd = new FormData(form);

                submitSkill(fd).then(result => {
                    if (result.status >= 200 && result.status < 300) {
                        // success
                        if (result.data.user_skill) {
                            appendSkillToList(result.data.user_skill);
                        }
                        alert(result.data.message || 'Skill added');
                        // reset select
                        form.querySelector('select[name="skill_id"]').value = '';
                    } else {
                        const msg = result.data?.error || (result.data?.message) || 'Could not add skill';
                        alert(msg);
                    }
                }).catch(err => {
                    console.error(err);
                    alert('Network error while adding skill');
                });
            });
        }

        // Expose global helper so other pages/buttons can call it
        window.addUserSkill = async function(skillId, type = 'request'){
            const fd = new FormData();
            fd.append('skill_id', skillId);
            fd.append('type', type);

            try {
                const result = await submitSkill(fd);
                if (result.status >= 200 && result.status < 300) {
                    if (result.data.user_skill) appendSkillToList(result.data.user_skill);
                    return { ok: true, data: result.data };
                }
                return { ok: false, error: result.data };
            } catch (e) {
                return { ok: false, error: e };
            }
        }
    })();
</script>
@endpush
