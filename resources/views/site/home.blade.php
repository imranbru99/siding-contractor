@extends('layouts.site')

@section('title', 'Northclad Siding')
@section('meta_description', 'Premium siding installation and replacement for Minneapolis–Saint Paul. Fiber cement, vinyl, wood, and metal systems with Minnesota winter detailing.')

@section('content')
<section class="hero">
    <div class="hero-media" aria-hidden="true"></div>
    <div class="wrap hero-copy">
        <div class="eyebrow">Twin Cities exterior cladding</div>
        <h1>Northclad Siding</h1>
        <p>We re-clad homes with weather-tight fiber cement, vinyl, wood, and metal systems — managing moisture, flashing, and trim so your exterior survives ice dams, wind-driven rain, and long Minnesota winters.</p>
        <div class="cta-row">
            <a class="btn btn-primary" href="{{ route('contact') }}">Book a free estimate</a>
            <a class="btn btn-ghost" href="{{ route('services.index') }}" style="color:#fff;border-color:rgba(255,255,255,.4);">Explore cladding systems</a>
        </div>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="section-head">
            <h2>Protect the shell. Elevate the curb.</h2>
            <p>From full-home fiber cement replacements to targeted repair and commercial cladding, Northclad matches material to architecture, HOA rules, and budget — then installs with continuous WRB and flashings that actually work.</p>
        </div>
        <div>
            @foreach ($services as $service)
                <a class="service-link" href="{{ route('services.show', $service) }}">
                    <strong>{{ $service->title }}</strong>
                    <span>{{ $service->summary }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section style="padding-top:0;">
    <div class="wrap about-split">
        <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1400&q=80" alt="Modern home exterior with clean siding lines">
        <div>
            <div class="eyebrow" style="color:var(--cl-amber);">About Northclad</div>
            <h2 style="color:var(--cl-slate);">Built for Minnesota weather</h2>
            <p>Siding failures here rarely start with the face boards — they start at windows, decks, and roof-to-wall transitions. Our crews treat weather-resistive barrier, kickout flashing, and ventilated rainscreens as first-class work, not add-ons.</p>
            <p>Homeowners and property managers hire us for failing vinyl replacements, James Hardie and fiber cement installs, board-and-batten refreshes, and storm-damage restoration across Minneapolis, Saint Paul, Edina, and the north metro.</p>
            <a class="btn btn-primary" href="{{ route('knowledge.index') }}">Read the knowledge base</a>
        </div>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="section-head">
            <h2>Operations dashboard preview</h2>
            <p>The same ERP your project lead uses — cladding jobs, material inventory, invoices, and estimate appointments in one pine-cedar Filament workspace.</p>
        </div>
        <div class="visual-board">
            <div class="dash-preview">
                <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1400&q=80" alt="Suburban home with freshly finished exterior">
            </div>
            <div style="display:grid;gap:.8rem;">
                <div class="metric"><b>{{ $stats['jobs'] }}</b> tracked siding jobs in demo ERP</div>
                <div class="metric"><b>{{ $stats['completed'] }}</b> completed installs</div>
                <div class="metric"><b>{{ number_format($stats['sqft']) }}</b> sq ft in pipeline data</div>
                <a class="btn btn-ghost" style="color:#fff;border-color:rgba(255,255,255,.35);" href="/admin">Open admin demo</a>
            </div>
        </div>
    </div>
</section>

<section style="padding-top:0;">
    <div class="wrap">
        <div class="section-head">
            <h2>From the field notes</h2>
            <p>Practical guidance on WRB, fiber cement detailing, ice-dam prep, and color selection for northern light.</p>
        </div>
        <div class="post-list">
            @foreach ($posts as $post)
                <article>
                    <a href="{{ route('blog.show', $post) }}">
                        <strong style="font-size:1.2rem;">{{ $post->title }}</strong>
                        <p style="margin:.35rem 0 0;color:#3d5360;">{{ $post->excerpt }}</p>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section>
    <div class="wrap grid-2">
        <div>
            <h2 style="color:var(--cl-slate);">Ready to reclad your home?</h2>
            <p>Tell us material preference, approximate wall square footage, and whether moisture or ice dams are an issue. We’ll schedule a Twin Cities estimate and scoped proposal.</p>
        </div>
        <div class="cta-row" style="align-items:center;">
            <a class="btn btn-primary" href="{{ route('contact') }}">Contact Northclad</a>
            <a class="btn btn-ghost" href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" rel="noopener">WhatsApp</a>
        </div>
    </div>
</section>
@endsection
