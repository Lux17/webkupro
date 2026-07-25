<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Episode {{ $episode->type }} · {{ $episode->nama_eps }}</title>
    <link rel="icon" href="{{ asset('assets/images/icon-stem.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --wt-bg: #0b0f19;
            --wt-panel: #121826;
            --wt-panel-2: #1a2234;
            --wt-text: #f8fafc;
            --wt-muted: #94a3b8;
            --wt-accent: #38bdf8;
            --wt-accent-2: #2563eb;
            --wt-line: rgba(148, 163, 184, 0.18);
            --wt-reader-max: 820px;
        }

        * { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.18), transparent 28%),
                radial-gradient(circle at top left, rgba(14, 165, 233, 0.12), transparent 24%),
                var(--wt-bg);
            color: var(--wt-text);
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            min-height: 100vh;
        }

        /* Progress bar */
        .wt-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0;
            z-index: 1100;
            background: linear-gradient(90deg, var(--wt-accent-2), var(--wt-accent));
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.55);
            transition: width .08s linear;
        }

        /* Top bar */
        .wt-topbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(14px);
            background: rgba(11, 15, 25, 0.82);
            border-bottom: 1px solid var(--wt-line);
        }

        .wt-topbar-inner {
            max-width: calc(var(--wt-reader-max) + 80px);
            margin: 0 auto;
            padding: .85rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
        }

        .wt-top-left,
        .wt-top-right {
            display: flex;
            align-items: center;
            gap: .5rem;
            min-width: 0;
        }

        .wt-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: 1px solid var(--wt-line);
            background: rgba(255, 255, 255, 0.04);
            color: var(--wt-text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: .18s ease;
            flex-shrink: 0;
        }

        .wt-icon-btn:hover {
            background: rgba(56, 189, 248, 0.15);
            border-color: rgba(56, 189, 248, 0.45);
            color: #fff;
        }

        .wt-title-wrap {
            min-width: 0;
        }

        .wt-kicker {
            font-size: .72rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--wt-accent);
            font-weight: 700;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wt-title {
            margin: .1rem 0 0;
            font-size: .98rem;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            letter-spacing: -0.02em;
        }

        /* Hero */
        .wt-hero {
            max-width: var(--wt-reader-max);
            margin: 1.25rem auto 0;
            padding: 0 1rem;
        }

        .wt-hero-card {
            background: linear-gradient(180deg, rgba(26, 34, 52, 0.95), rgba(18, 24, 38, 0.98));
            border: 1px solid var(--wt-line);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        }

        .wt-cover {
            position: relative;
            height: 220px;
            background: linear-gradient(135deg, #1d4ed8, #0ea5e9 55%, #38bdf8);
        }

        .wt-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .wt-cover::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 20%, rgba(11, 15, 25, 0.92) 100%);
        }

        .wt-hero-body {
            padding: 1.25rem 1.35rem 1.4rem;
            margin-top: -2.5rem;
            position: relative;
            z-index: 1;
        }

        .wt-badges {
            display: flex;
            flex-wrap: wrap;
            gap: .45rem;
            margin-bottom: .75rem;
        }

        .wt-badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .35rem .7rem;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 700;
            background: rgba(56, 189, 248, 0.12);
            color: #7dd3fc;
            border: 1px solid rgba(56, 189, 248, 0.25);
        }

        .wt-badge.soft {
            background: rgba(148, 163, 184, 0.1);
            color: #cbd5e1;
            border-color: rgba(148, 163, 184, 0.2);
        }

        .wt-hero h1 {
            font-size: clamp(1.35rem, 2.5vw, 1.85rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            margin: 0 0 .45rem;
            line-height: 1.25;
        }

        .wt-meta {
            display: flex;
            flex-wrap: wrap;
            gap: .65rem 1.1rem;
            color: var(--wt-muted);
            font-size: .88rem;
        }

        .wt-meta i {
            color: var(--wt-accent);
            margin-right: .3rem;
        }

        /* Reader canvas */
        .wt-reader {
            max-width: var(--wt-reader-max);
            margin: 1rem auto 7.5rem;
            padding: 0 1rem;
        }

        .wt-canvas {
            background: #000;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--wt-line);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.4);
        }

        .wt-content {
            color: #e2e8f0;
            font-size: 1.02rem;
            line-height: 1.85;
        }

        .wt-content > *:first-child { margin-top: 0; }
        .wt-content > *:last-child { margin-bottom: 0; }

        /* Webtoon-style stacked images */
        .wt-content img,
        .wt-content video,
        .wt-content iframe {
            display: block;
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            margin: 0 auto;
            border-radius: 0;
            background: #000;
        }

        .wt-content p {
            margin: 0;
            padding: 1rem 1.15rem;
        }

        .wt-content p:empty { display: none; }

        .wt-content p:has(img),
        .wt-content p:has(video) {
            padding: 0;
        }

        .wt-content h1,
        .wt-content h2,
        .wt-content h3,
        .wt-content h4 {
            padding: 1rem 1.15rem .35rem;
            margin: 0;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .wt-content ul,
        .wt-content ol {
            padding: .5rem 1.5rem 1rem 2.25rem;
            margin: 0;
        }

        .wt-content blockquote {
            margin: .75rem 1rem;
            padding: .85rem 1rem;
            border-left: 3px solid var(--wt-accent);
            background: rgba(56, 189, 248, 0.08);
            border-radius: 0 12px 12px 0;
            color: #cbd5e1;
        }

        .wt-end {
            text-align: center;
            padding: 2rem 1rem 1.5rem;
            color: var(--wt-muted);
            border-top: 1px solid var(--wt-line);
            background: linear-gradient(180deg, #0a0d14, #111827);
        }

        .wt-end .dot {
            width: 42px;
            height: 4px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--wt-accent-2), var(--wt-accent));
            margin: 0 auto .85rem;
        }

        /* Bottom nav */
        .wt-bottom {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1000;
            backdrop-filter: blur(14px);
            background: rgba(11, 15, 25, 0.9);
            border-top: 1px solid var(--wt-line);
            padding: .75rem 1rem calc(.75rem + env(safe-area-inset-bottom));
        }

        .wt-bottom-inner {
            max-width: calc(var(--wt-reader-max) + 80px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: .75rem;
        }

        .wt-nav-btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .7rem 1rem;
            border-radius: 14px;
            border: 1px solid var(--wt-line);
            background: var(--wt-panel-2);
            color: var(--wt-text);
            text-decoration: none;
            font-weight: 700;
            font-size: .9rem;
            transition: .18s ease;
            min-height: 46px;
        }

        .wt-nav-btn:hover {
            border-color: rgba(56, 189, 248, 0.45);
            background: rgba(37, 99, 235, 0.25);
            color: #fff;
        }

        .wt-nav-btn.disabled,
        .wt-nav-btn[aria-disabled="true"] {
            opacity: .4;
            pointer-events: none;
        }

        .wt-nav-btn.prev { justify-self: start; }
        .wt-nav-btn.next {
            justify-self: end;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            border: 0;
        }

        .wt-nav-btn.next:hover {
            filter: brightness(1.08);
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
        }

        .wt-center-info {
            text-align: center;
            font-size: .8rem;
            color: var(--wt-muted);
            font-weight: 700;
            letter-spacing: .04em;
        }

        .wt-center-info strong {
            display: block;
            color: var(--wt-text);
            font-size: .95rem;
            letter-spacing: 0;
            margin-top: .1rem;
        }

        /* Scroll top */
        .wt-top {
            position: fixed;
            right: 1rem;
            bottom: 5.5rem;
            width: 46px;
            height: 46px;
            border-radius: 14px;
            border: 1px solid var(--wt-line);
            background: rgba(18, 24, 38, 0.95);
            color: #fff;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1001;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            transition: .18s ease;
        }

        .wt-top.show { display: inline-flex; }
        .wt-top:hover {
            background: rgba(37, 99, 235, 0.85);
            border-color: transparent;
        }

        @media (max-width: 576px) {
            .wt-cover { height: 170px; }
            .wt-nav-btn span.label { display: none; }
            .wt-center-info strong { font-size: .85rem; }
            .wt-title { font-size: .9rem; }
        }
    </style>
</head>
<body>
    <div class="wt-progress" id="wtProgress"></div>

    <header class="wt-topbar">
        <div class="wt-topbar-inner">
            <div class="wt-top-left">
                <a href="{{ $materi ? route('tampil-materi', $materi->id_materi) : route('materi') }}"
                   class="wt-icon-btn" title="Kembali ke materi">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="wt-title-wrap">
                    <p class="wt-kicker">
                        {{ $materi->title ?? 'Materi' }}
                    </p>
                    <h1 class="wt-title">Ep. {{ $episode->type }} · {{ $episode->nama_eps }}</h1>
                </div>
            </div>
            <div class="wt-top-right">
                <a href="{{ route('ubah-episode', $episode->id_eps) }}" class="wt-icon-btn" title="Ubah episode">
                    <i class="far fa-edit"></i>
                </a>
                @if($materi)
                    <a href="{{ route('tampil-materi', $materi->id_materi) }}" class="wt-icon-btn" title="Daftar episode">
                        <i class="fas fa-list-ul"></i>
                    </a>
                @endif
            </div>
        </div>
    </header>

    <section class="wt-hero">
        <div class="wt-hero-card">
            <div class="wt-cover">
                @if(!empty($episode->img))
                    <img src="{{ asset(ltrim($episode->img, '/')) }}"
                         alt="{{ $episode->nama_eps }}"
                         onerror="this.style.display='none'">
                @elseif(!empty($materi?->img))
                    <img src="{{ asset(ltrim($materi->img, '/')) }}"
                         alt="{{ $materi->title }}"
                         onerror="this.style.display='none'">
                @endif
            </div>
            <div class="wt-hero-body">
                <div class="wt-badges">
                    <span class="wt-badge"><i class="fas fa-book-open"></i> Episode {{ $episode->type }}</span>
                    <span class="wt-badge soft">{{ $episodeIndex }} / {{ $episodeTotal }}</span>
                    @if(!empty($episode->tgl))
                        <span class="wt-badge soft"><i class="far fa-calendar"></i> {{ $episode->tgl }}</span>
                    @endif
                </div>
                <h1>{{ $episode->nama_eps }}</h1>
                <div class="wt-meta">
                    @if($materi)
                        <span><i class="fas fa-layer-group"></i>{{ $materi->title }}</span>
                    @endif
                    <span><i class="fas fa-scroll"></i>Mode baca Webtoon</span>
                </div>
            </div>
        </div>
    </section>

    <main class="wt-reader">
        <article class="wt-canvas">
            <div class="wt-content">
                {!! $content !!}
            </div>
            <div class="wt-end">
                <div class="dot"></div>
                <div class="fw-bold text-white mb-1">Selesai membaca episode ini</div>
                <div>Gunakan navigasi di bawah untuk lanjut ke episode berikutnya</div>
            </div>
        </article>
    </main>

    <button type="button" class="wt-top" id="wtTop" title="Kembali ke atas" aria-label="Kembali ke atas">
        <i class="fas fa-chevron-up"></i>
    </button>

    <nav class="wt-bottom" aria-label="Navigasi episode">
        <div class="wt-bottom-inner">
            @if($prevEpisode)
                <a href="{{ route('tampil-episode', $prevEpisode->id_eps) }}" class="wt-nav-btn prev">
                    <i class="fas fa-chevron-left"></i>
                    <span class="label">Sebelumnya</span>
                </a>
            @else
                <span class="wt-nav-btn prev disabled" aria-disabled="true">
                    <i class="fas fa-chevron-left"></i>
                    <span class="label">Sebelumnya</span>
                </span>
            @endif

            <div class="wt-center-info">
                EPISODE
                <strong>{{ $episodeIndex }} / {{ $episodeTotal }}</strong>
            </div>

            @if($nextEpisode)
                <a href="{{ route('tampil-episode', $nextEpisode->id_eps) }}" class="wt-nav-btn next">
                    <span class="label">Berikutnya</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="wt-nav-btn next disabled" aria-disabled="true">
                    <span class="label">Berikutnya</span>
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </nav>

    <script>
        (function () {
            const progress = document.getElementById('wtProgress');
            const topBtn = document.getElementById('wtTop');

            function onScroll() {
                const doc = document.documentElement;
                const scrollTop = doc.scrollTop || document.body.scrollTop;
                const height = doc.scrollHeight - doc.clientHeight;
                const pct = height > 0 ? (scrollTop / height) * 100 : 0;
                if (progress) progress.style.width = pct + '%';
                if (topBtn) topBtn.classList.toggle('show', scrollTop > 420);
            }

            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();

            if (topBtn) {
                topBtn.addEventListener('click', function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Keyboard navigation
            document.addEventListener('keydown', function (e) {
                if (e.target && ['INPUT', 'TEXTAREA'].includes(e.target.tagName)) return;
                if (e.key === 'ArrowLeft') {
                    const prev = document.querySelector('.wt-nav-btn.prev:not(.disabled)');
                    if (prev && prev.href) window.location.href = prev.href;
                }
                if (e.key === 'ArrowRight') {
                    const next = document.querySelector('.wt-nav-btn.next:not(.disabled)');
                    if (next && next.href) window.location.href = next.href;
                }
            });
        })();
    </script>
</body>
</html>
