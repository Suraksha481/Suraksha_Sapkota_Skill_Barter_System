@extends('admin.layout')

@section('title','Dashboard')

@section('content')

<div class="card-grid">

    <div class="stat-card">
        <h4>Total Users</h4>
        <p>{{ $totalUsers }}</p>
    </div>

    <div class="stat-card">
        <h4>Total Teachers</h4>
        <p>{{ $totalTeachers }}</p>
    </div>

    <div class="stat-card">
        <h4>Total Students</h4>
        <p>{{ $totalStudents }}</p>
    </div>

    <div class="stat-card">
        <h4>Total Sessions</h4>
        <p>{{ $totalSessions }}</p>
    </div>

    <div class="stat-card">
        <h4>Premium Members</h4>
        <p>{{ $totalPremium }}</p>
    </div>

</div>

@endsection
