@extends('layouts.site')
@section('title', $article->title)
@section('content')
<div class="page-hero"><div class="wrap">
    <h1>{{ $article->title }}</h1>
    <p>{{ $article->summary }}</p>
</div></div>
<section><div class="wrap prose">
    {!! $article->body !!}
    <p style="margin-top:2rem;"><a class="btn btn-ghost" href="{{ route('knowledge.index') }}">← All articles</a></p>
</div></section>
@endsection
