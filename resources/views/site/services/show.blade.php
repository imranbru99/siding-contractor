@extends('layouts.site')
@section('title', $service->title)
@section('content')
<div class="page-hero"><div class="wrap">
    <h1>{{ $service->title }}</h1>
    <p>{{ $service->summary }}</p>
</div></div>
<section><div class="wrap grid-2">
    <div class="prose">
        {!! $service->description !!}
        @if($service->starting_price)
            <p><strong>Starting around ${{ number_format($service->starting_price, 0) }}</strong> — final pricing after site measure.</p>
        @endif
        <a class="btn btn-primary" href="{{ route('contact') }}">Request this service</a>
    </div>
    <div>
        <img src="{{ $service->image_url }}" alt="{{ $service->title }}" style="border-radius:24px;width:100%;min-height:320px;object-fit:cover;">
        <div style="margin-top:1.5rem;">
            <h3 style="color:var(--cl-slate);">Related</h3>
            @foreach($others as $other)
                <a class="service-link" href="{{ route('services.show', $other) }}"><strong>{{ $other->title }}</strong></a>
            @endforeach
        </div>
    </div>
</div></section>
@endsection
