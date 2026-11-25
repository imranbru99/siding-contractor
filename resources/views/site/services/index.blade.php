@extends('layouts.site')
@section('title', 'Services')
@section('content')
<div class="page-hero"><div class="wrap"><h1>Services</h1><p>Siding installation, replacement, and repair for Twin Cities exteriors.</p></div></div>
<section><div class="wrap">
    @foreach ($services as $service)
        <a class="service-link" href="{{ route('services.show', $service) }}">
            <strong>{{ $service->title }}</strong>
            <span>{{ $service->summary }}</span>
            @if ($service->starting_price)
                <span style="display:block;margin-top:.4rem;color:var(--cl-steel);font-weight:700;">From ${{ number_format($service->starting_price) }}</span>
            @endif
        </a>
    @endforeach
</div></section>
@endsection
