<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SkillBarter — Exchange Knowledge</title>
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('css/service.css') }}">
  <link rel="stylesheet" href="{{ asset('css/find-skill.css') }}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
  <link rel="stylesheet" href="{{ asset('css/blogs.css') }}">
  <link rel="stylesheet" href="{{ asset('css/about.css') }}">
  <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/my-skills.css') }}">
  <link rel="stylesheet" href="{{ asset('css/role.css') }}">
  <link rel="stylesheet" href="{{ asset('css/rewards.css') }}">
  <link rel="stylesheet" href="{{ asset('css/skill-detail.css') }}">
</head>
<body>

  @include('header')

  @yield('content')

  @include('footer')

  @stack('scripts')

  <script>
    (function(){
      const addUrl = "{{ route('my.skills.store') }}";
      const csrf = "{{ csrf_token() }}";

      document.addEventListener('click', function(e){
        const btn = e.target.closest('.add-skill-btn');
        if (!btn) return;
        e.preventDefault();

        const skillId = btn.dataset.skillId;
        let type = btn.dataset.type || null;
        if (!type) {
          const sel = btn.closest('.inline-add')?.querySelector('.add-skill-type');
          if (sel) type = sel.value;
          else type = 'request';
        }

        // Prefer using existing helper if present
        if (window.addUserSkill) {
          window.addUserSkill(skillId, type).then(res => {
            if (res.ok) {
              btn.disabled = true;
              btn.textContent = 'Added';
            } else {
              const err = res.error?.error || res.error?.message || 'Could not add skill';
              alert(err);
            }
          });
          return;
        }

        // Fallback: direct fetch to store route
        const fd = new FormData();
        fd.append('skill_id', skillId);
        fd.append('type', type);

        fetch(addUrl, {
          method: 'POST',
          headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
          body: fd
        })
        .then(res => res.json().then(data => ({ status: res.status, data })))
        .then(result => {
          if (result.status >= 200 && result.status < 300) {
            btn.disabled = true;
            btn.textContent = 'Added';
          } else {
            alert(result.data?.error || result.data?.message || 'Could not add skill');
          }
        }).catch(() => alert('Network error while adding skill'));
      });
    })();
  </script>

</body>
</html>
