<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? __('ui.portfolio_cms') }} · {{ __('ui.portfolio_cms') }}</title>
    @vite('resources/css/admin.css')
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            <span class="admin-brand-mark">IA</span>
            <span class="admin-brand-copy"><strong>{{ __('ui.portfolio_cms') }}</strong><small>{{ __('ui.workspace') }}</small></span>
        </a>

        <div class="admin-nav-section">{{ __('ui.content') }}</div>
        <nav class="admin-nav" aria-label="{{ __('ui.content') }}">
            @foreach ([
                ['admin.dashboard', 'dashboard', '⌂'],
                ['admin.projects.*', 'projects', '◈'],
                ['admin.categories.*', 'categories', '◌'],
                ['admin.technologies.*', 'technologies', '⌘'],
                ['admin.skills.*', 'skills', '✦'],
                ['admin.experiences.*', 'experience', '◷'],
                ['admin.education.*', 'education', '▣'],
                ['admin.services.*', 'services', '◇'],
                ['admin.testimonials.*', 'testimonials', '♡'],
                ['admin.messages.*', 'messages', '✉'],
            ] as [$routePattern, $label, $icon])
                <a href="{{ route(str_replace('.*', '.index', $routePattern)) }}" class="{{ request()->routeIs($routePattern) ? 'active' : '' }}">
                    <span class="nav-icon" aria-hidden="true">{{ $icon }}</span><span>{{ __('ui.'.$label) }}</span>
                </a>
            @endforeach
        </nav>

        <div class="admin-nav-section">{{ __('ui.system') }}</div>
        <nav class="admin-nav" aria-label="{{ __('ui.system') }}">
            @foreach ([['admin.profile.edit', 'profile', '◎'], ['admin.sections.index', 'sections', '☷'], ['admin.settings.edit', 'settings', '⚙']] as [$routeName, $label, $icon])
                <a href="{{ route($routeName) }}" class="{{ request()->routeIs($routeName) ? 'active' : '' }}">
                    <span class="nav-icon" aria-hidden="true">{{ $icon }}</span><span>{{ __('ui.'.$label) }}</span>
                </a>
            @endforeach
        </nav>
    </aside>

    <main class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <button class="admin-menu-toggle" id="adminMenuToggle" type="button" aria-label="{{ __('ui.content') }}">☰</button>
                <div class="admin-topbar-avatar">{{ Str::upper(Str::substr(auth()->user()->name, 0, 2)) }}</div>
                <div class="admin-topbar-user"><span>{{ __('ui.signed_in_as') }}</span>{{ auth()->user()->name }}</div>
            </div>
            <div class="admin-topbar-actions">
                <a href="{{ route('locale.switch', ['locale' => app()->isLocale('ar') ? 'en' : 'ar']) }}" class="language-switcher" title="{{ __('ui.language') }}">
                    <span aria-hidden="true">◎</span><span>{{ __('ui.language') }}</span>
                </a>
                <a href="{{ route('home') }}" class="btn secondary">↗ <span>{{ __('ui.view_portfolio') }}</span></a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn secondary" type="submit">⇥ <span>{{ __('ui.logout') }}</span></button></form>
            </div>
        </header>

        <div class="page-content">
            @if (session('success')) <div class="alert">{{ session('success') }}</div> @endif
            @if ($errors->any()) <div class="alert errors"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
            @yield('content')
        </div>
    </main>
</div>
<script>
    (() => {
        const toggle = document.getElementById('adminMenuToggle');
        const sidebar = document.getElementById('adminSidebar');
        if (toggle && sidebar) toggle.addEventListener('click', () => sidebar.classList.toggle('is-open'));
    })();
</script>
</body>
</html>
