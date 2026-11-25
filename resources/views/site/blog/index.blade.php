@extends('layouts.site')
@section('title', 'Field notes')
@section('content')
<div class="page-hero"><div class="wrap"><h1>Field notes</h1><p>Siding insights from Northclad crews across the Twin Cities.</p></div></div>
<section><div class="wrap post-list">
    @foreach ($posts as $post)
        <article>
            <a href="{{ route('blog.show', $post) }}">
                <strong style="font-size:1.25rem;">{{ $post->title }}</strong>
                <p style="margin:.4rem 0 0;color:#3d5360;">{{ $post->excerpt }}</p>
            </a>
        </article>
    @endforeach
</div></section>
@endsection
