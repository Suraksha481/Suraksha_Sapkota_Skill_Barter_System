@extends('app')

@section('content')


<section class="blog-hero">
    <h1>Our Latest Blogs</h1>
    <p>Guides, tips, and insights to help you grow your skills and career.</p>
</section>

<section class="blog-container">

    <div class="blog-grid">

       @foreach($blogs as $blog)
    <div class="blog-card">
        <img src="{{ $blog['image'] }}">
        <div class="blog-content">
            <h3>{{ $blog['title'] }}</h3>
            <p>{{ $blog['desc'] }}</p>
            <a href="#" class="read-more">Read More</a>
        </div>
    </div>
@endforeach

    </div>
</section>

@endsection
