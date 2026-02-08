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
</head>
<body>

  @include('header')

  @yield('content')

  @include('footer')

</body>
</html>
