@extends('layouts.site')
@section('title', 'Knowledge base')
@section('content')
<div class="page-hero"><div class="wrap"><h1>Knowledge base</h1><p>Common issues, guides, admin manual, and troubleshooting for Northclad siding projects.</p></div></div>
<section><div class="wrap">
    @foreach ($groups as $category => $articles)
        <div class="kb-group">
            <h2>{{ ucfirst($category) }}</h2>
            @foreach ($articles as $article)
                <a class="service-link" href="{{ route('knowledge.show', $article) }}">
                    <strong>{{ $article->title }}</strong>
                    <span>{{ $article->summary }}</span>
                </a>
            @endforeach
        </div>
    @endforeach
</div></section>
@endsection
