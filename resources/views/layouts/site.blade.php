<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Northclad Siding') — Twin Cities Siding Contractor</title>
    <meta name="description" content="@yield('meta_description', 'Northclad Siding installs fiber cement, vinyl, wood, and metal siding across Minneapolis–Saint Paul with moisture detailing built for Minnesota winters.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --cl-ink: #0F1A17;
            --cl-slate: #1A3D32;
            --cl-steel: #3D7A65;
            --cl-amber: #C06A2F;
            --cl-stone: #6B7F76;
            --cl-mist: #E6EEF1;
            --cl-glow: rgba(61, 122, 101, 0.2);
            --font-display: "Syne", sans-serif;
            --font-body: "Manrope", sans-serif;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: var(--font-body);
            color: var(--cl-ink);
            background:
                radial-gradient(1100px 480px at 8% -8%, rgba(192, 106, 47, 0.12), transparent 50%),
                radial-gradient(900px 420px at 95% 5%, var(--cl-glow), transparent 55%),
                linear-gradient(180deg, #f2f7f5 0%, var(--cl-mist) 48%, #d9e6e1 100%);
            line-height: 1.6;
        }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }
        .wrap { width: min(1120px, calc(100% - 2rem)); margin-inline: auto; }
        .site-header {
            position: sticky; top: 0; z-index: 40;
            backdrop-filter: blur(14px);
            background: rgba(230, 238, 241, 0.9);
            border-bottom: 1px solid rgba(26, 61, 50, 0.1);
        }
        .nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 0; gap: 1rem;
        }
        .brand {
            font-family: var(--font-display);
            font-weight: 800; font-size: 1.2rem; letter-spacing: -0.03em;
            color: var(--cl-slate);
        }
        .brand span { color: var(--cl-amber); }
        .nav-links { display: flex; gap: 1.1rem; flex-wrap: wrap; align-items: center; font-weight: 600; font-size: 0.95rem; }
        .nav-links a:hover { color: var(--cl-steel); }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
            border: 0; border-radius: 10px; padding: .85rem 1.35rem;
            font-weight: 700; cursor: pointer; transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary {
            background: linear-gradient(135deg, var(--cl-slate), var(--cl-steel));
            color: #fff; box-shadow: 0 12px 30px rgba(26, 61, 50, 0.28);
        }
        .btn-ghost {
            background: transparent; color: var(--cl-slate);
            border: 1.5px solid rgba(26, 61, 50, 0.28);
        }
        .hero {
            min-height: calc(100vh - 74px);
            display: grid; align-items: end;
            position: relative; overflow: hidden;
            color: #fff;
        }
        .hero-media {
            position: absolute; inset: 0;
            background:
                linear-gradient(180deg, rgba(15,26,23,.18) 0%, rgba(15,26,23,.66) 62%, rgba(15,26,23,.92) 100%),
                url('https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=2000&q=80') center/cover no-repeat;
            animation: heroZoom 18s ease-in-out infinite alternate;
        }
        @keyframes heroZoom {
            from { transform: scale(1); }
            to { transform: scale(1.05); }
        }
        .hero-copy {
            position: relative; z-index: 1;
            padding: 5rem 0 4rem;
            max-width: 740px;
            animation: riseIn .9s ease both;
        }
        @keyframes riseIn {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: none; }
        }
        .eyebrow {
            text-transform: uppercase; letter-spacing: .18em; font-size: .75rem;
            color: #e8a574; font-weight: 700; margin-bottom: .8rem;
        }
        h1, h2, h3 { font-family: var(--font-display); letter-spacing: -0.03em; line-height: 1.1; }
        .hero h1 { font-size: clamp(2.6rem, 6vw, 4.3rem); margin: 0 0 1rem; }
        .hero p { font-size: 1.15rem; max-width: 36rem; color: rgba(255,255,255,.88); }
        .cta-row { display: flex; flex-wrap: wrap; gap: .8rem; margin-top: 1.6rem; }
        section { padding: 4.5rem 0; }
        .section-head { max-width: 640px; margin-bottom: 2rem; }
        .section-head h2 { font-size: clamp(1.8rem, 3vw, 2.5rem); color: var(--cl-slate); margin: 0 0 .6rem; }
        .grid-3 { display: grid; gap: 1.25rem; grid-template-columns: repeat(3, 1fr); }
        .grid-2 { display: grid; gap: 1.5rem; grid-template-columns: repeat(2, 1fr); }
        .service-link {
            display: block; padding: 1.4rem 0; border-top: 1px solid rgba(26,61,50,.12);
            transition: padding-left .25s ease, color .25s ease;
        }
        .service-link:hover { padding-left: .5rem; color: var(--cl-steel); }
        .service-link strong { display: block; font-size: 1.15rem; margin-bottom: .35rem; }
        .visual-board {
            display: grid; grid-template-columns: 1.2fr .8fr; gap: 1rem;
            background: linear-gradient(145deg, #102820, #1A3D32 45%, #2a5a48);
            color: #fff; border-radius: 20px; padding: 1.4rem; overflow: hidden;
            box-shadow: 0 30px 60px rgba(15, 26, 23, 0.2);
        }
        .metric {
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
            border-radius: 14px; padding: 1.1rem 1.2rem;
        }
        .metric b { display: block; font-family: var(--font-display); font-size: 1.8rem; }
        .dash-preview img { width: 100%; height: 100%; object-fit: cover; border-radius: 14px; min-height: 260px; }
        .about-split { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: center; }
        .about-split img { border-radius: 20px; min-height: 360px; object-fit: cover; width: 100%; }
        .post-list article { padding: 1.2rem 0; border-bottom: 1px solid rgba(26,61,50,.12); }
        .site-footer {
            background: var(--cl-ink); color: rgba(255,255,255,.82); padding: 3rem 0 2rem; margin-top: 2rem;
        }
        .site-footer a:hover { color: var(--cl-amber); }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 2rem; }
        .wa-float {
            position: fixed; right: 1.2rem; bottom: 1.2rem; z-index: 50;
            width: 58px; height: 58px; border-radius: 50%;
            background: #25D366; color: #fff; display: grid; place-items: center;
            box-shadow: 0 12px 28px rgba(37, 211, 102, .4);
            font-weight: 800; font-size: 1.2rem;
            animation: pulse 2.4s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.06); }
        }
        .chatbot {
            position: fixed; right: 1.2rem; bottom: 5.2rem; z-index: 50; width: min(340px, calc(100vw - 2rem));
            background: #fff; border-radius: 16px; box-shadow: 0 24px 50px rgba(15,26,23,.22);
            overflow: hidden; border: 1px solid rgba(26,61,50,.1); display: none;
        }
        .chatbot.open { display: flex; flex-direction: column; max-height: 460px; }
        .chatbot-head {
            background: linear-gradient(135deg, var(--cl-slate), var(--cl-steel));
            color: #fff; padding: .9rem 1rem; font-weight: 700;
            display: flex; justify-content: space-between; align-items: center;
        }
        .chatbot-body { padding: 1rem; overflow: auto; flex: 1; background: #f3f8f6; }
        .chat-msg { margin-bottom: .7rem; padding: .7rem .85rem; border-radius: 12px; font-size: .92rem; }
        .chat-msg.bot { background: #fff; border: 1px solid rgba(26,61,50,.08); }
        .chat-msg.user { background: var(--cl-slate); color: #fff; margin-left: 2rem; }
        .chatbot-form { display: flex; gap: .4rem; padding: .75rem; border-top: 1px solid rgba(26,61,50,.08); }
        .chatbot-form input {
            flex: 1; border: 1px solid rgba(26,61,50,.18); border-radius: 10px; padding: .65rem .9rem;
            font: inherit;
        }
        .chat-toggle {
            position: fixed; right: 5.2rem; bottom: 1.35rem; z-index: 50;
            border: 0; border-radius: 10px; padding: .75rem 1rem;
            background: var(--cl-ink); color: #fff; font-weight: 700; cursor: pointer;
        }
        .flash {
            background: #d5ebe3; color: #0f3a2e; padding: .9rem 1rem; border-radius: 12px; margin: 1rem 0;
        }
        .form-card {
            background: rgba(255,255,255,.78); border: 1px solid rgba(26,61,50,.1);
            border-radius: 18px; padding: 1.5rem; backdrop-filter: blur(8px);
        }
        label { display: block; font-weight: 600; margin-bottom: .35rem; font-size: .92rem; }
        input, textarea, select {
            width: 100%; border: 1px solid rgba(26,61,50,.2); border-radius: 10px;
            padding: .75rem .9rem; font: inherit; background: #fff; margin-bottom: .9rem;
        }
        .page-hero {
            padding: 3.5rem 0 2rem;
            background:
                linear-gradient(120deg, rgba(26,61,50,.92), rgba(61,122,101,.78)),
                url('https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1600&q=80') center/cover;
            color: #fff;
        }
        .page-hero h1 { margin: 0 0 .5rem; font-size: clamp(2rem, 4vw, 3rem); }
        .prose { max-width: 720px; }
        .prose h2 { color: var(--cl-slate); }
        .kb-group { margin-bottom: 2rem; }
        .kb-group h2 { color: var(--cl-slate); margin-bottom: .8rem; }
        @media (max-width: 900px) {
            .grid-3, .grid-2, .about-split, .visual-board, .footer-grid { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .hero { min-height: 78vh; }
        }
    </style>
    @stack('head')
</head>
<body>
<header class="site-header">
    <div class="wrap nav">
        <a class="brand" href="{{ route('home') }}">North<span>clad</span></a>
        <nav class="nav-links">
            <a href="{{ route('services.index') }}">Services</a>
            <a href="{{ route('blog.index') }}">Field Notes</a>
            <a href="{{ route('knowledge.index') }}">Knowledge</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a href="/admin" class="btn btn-ghost" style="padding:.55rem 1rem;">ERP Login</a>
        </nav>
        <a class="btn btn-primary" href="{{ route('contact') }}">Free Estimate</a>
    </div>
</header>

@if (session('success'))
    <div class="wrap"><div class="flash">{{ session('success') }}</div></div>
@endif

<main>@yield('content')</main>

<footer class="site-footer">
    <div class="wrap footer-grid">
        <div>
            <div class="brand" style="color:#fff;margin-bottom:.6rem;">North<span style="color:#e8a574;">clad</span></div>
            <p>Fiber cement, vinyl, wood, and metal siding for Twin Cities homes — moisture-managed, winter-ready, and finished with clean trim details that hold up through Minnesota freeze–thaw seasons.</p>
        </div>
        <div>
            <strong style="color:#fff;">Visit</strong>
            <p>1840 Marshall St NE<br>Minneapolis, MN 55413</p>
        </div>
        <div>
            <strong style="color:#fff;">Reach us</strong>
            <p><a href="tel:+16125550184">(612) 555-0184</a><br>
            <a href="mailto:hello@northclad.example">hello@northclad.example</a></p>
        </div>
    </div>
</footer>

<button class="chat-toggle" id="chatToggle" type="button">Ask AI</button>
<a class="wa-float" href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" rel="noopener" aria-label="WhatsApp">WA</a>

<div class="chatbot" id="chatbot" aria-live="polite">
    <div class="chatbot-head">
        <span>Northclad AI</span>
        <button type="button" id="chatClose" style="background:transparent;border:0;color:#fff;font-size:1.2rem;cursor:pointer;">×</button>
    </div>
    <div class="chatbot-body" id="chatBody">
        <div class="chat-msg bot">Hi — ask about siding materials, moisture wrap, timelines, costs, or booking a Twin Cities estimate.</div>
    </div>
    <form class="chatbot-form" id="chatForm">
        <input type="text" id="chatInput" placeholder="Ask a siding question..." required maxlength="2000">
        <button class="btn btn-primary" style="padding:.65rem 1rem;" type="submit">Send</button>
    </form>
</div>

<script>
(() => {
    const bot = document.getElementById('chatbot');
    const body = document.getElementById('chatBody');
    const form = document.getElementById('chatForm');
    const input = document.getElementById('chatInput');
    const token = document.querySelector('meta[name="csrf-token"]').content;
    document.getElementById('chatToggle').addEventListener('click', () => bot.classList.toggle('open'));
    document.getElementById('chatClose').addEventListener('click', () => bot.classList.remove('open'));
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        body.insertAdjacentHTML('beforeend', `<div class="chat-msg user">${message.replace(/</g,'&lt;')}</div>`);
        input.value = '';
        body.scrollTop = body.scrollHeight;
        try {
            const res = await fetch('{{ route('ai.chat') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                body: JSON.stringify({ message })
            });
            const data = await res.json();
            body.insertAdjacentHTML('beforeend', `<div class="chat-msg bot">${(data.reply || 'Sorry, try again.').replace(/</g,'&lt;')}</div>`);
        } catch (err) {
            body.insertAdjacentHTML('beforeend', `<div class="chat-msg bot">Connection issue — please try again or use WhatsApp.</div>`);
        }
        body.scrollTop = body.scrollHeight;
    });
})();
</script>
@stack('scripts')
</body>
</html>
