@extends('app')

@section('content')

<h2>Online Classroom</h2>

<p>Skill: {{ $session->skill->title }}</p>

<p>Teacher: {{ $session->teacher->name }}</p>

<p>Student: {{ $session->student->name }}</p>

<p>Start Time: {{ $session->start_time }}</p>

<p>End Time: {{ $session->end_time }}</p>


@if($session->meeting_link)

<a href="{{ $session->meeting_link }}" target="_blank">

Join Live Class

</a>

@endif


<h3>Materials</h3>

@foreach($session->materials as $material)

<a href="{{ asset('storage/'.$material->file_path) }}">

{{ $material->title }}

</a>

@endforeach


@endsection
