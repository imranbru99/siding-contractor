@extends('layouts.site')
@section('title', $post->title)
@section('content')
<div class="page-hero"><div class="wrap">
    <h1>{{ $post->title }}</h1>
    <p>{{ optional($post->published_at)->format('F j, Y') }} · {{ $post->author_name }}</p>
</div></div>
<section><div class="wrap prose">
    @if($post->cover_image)
        <img src="{{ $post->cover_image }}" alt="" style="border-radius:20px;margin-bottom:1.5rem;width:100%;max-height:420px;object-fit:cover;">
    @endif
    <p style="font-size:1.1rem;color:#405248;">{{ $post->excerpt }}</p>
    {!! $post->body !!}
</div></section>
@endsection
