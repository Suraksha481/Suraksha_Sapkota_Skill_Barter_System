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
        <h4>Total Skills</h4>
        <p>{{ $totalSkills }}</p>
    </div>

    <div class="stat-card">
        <h4>Total Requests</h4>
        <p>{{ $totalRequests }}</p>
    </div>

    <div class="stat-card">
        <h4>Premium Members</h4>
        <p>{{ $totalPremium }}</p>
    </div>

    <div class="stat-card" style="background: #2ecc71; color: white;">
        <h4>Platform Revenue</h4>
        <p>NPR {{ number_format($totalRevenue, 2) }}</p>
    </div>

    <div class="stat-card" style="background: #3498db; color: white;">
        <h4>Admin Share (50%)</h4>
        <p>NPR {{ number_format($adminShare, 2) }}</p>
    </div>

    <div class="stat-card" style="background: #f1c40f; color: white;">
        <h4>Teacher Payouts (50%)</h4>
        <p>NPR {{ number_format($teacherShare, 2) }}</p>
    </div>
</div>

@endsection
