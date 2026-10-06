<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['meta_title'] ?? $profile->localized('name').' — '.$profile->localized('professional_title') }}</title>
    
    <!-- SEO & Metadata -->
    <meta name="description" content="{{ $settings['meta_description'] ?? $profile->short_bio }}">
    <meta name="keywords" content="{{ $settings['keywords'] ?? '' }}">
    <meta name="author" content="{{ $profile->localized('name') }}">
    <link rel="canonical" href="{{ url('/') }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $settings['og_title'] ?? $profile->localized('name').' — '.$profile->localized('professional_title') }}">
    <meta property="og:description" content="{{ $settings['og_description'] ?? $profile->localized('short_bio') }}">
    <meta property="og:type" content="website">
    @if (! empty($settings['favicon_path']))
        <link rel="icon" href="{{ Storage::url($settings['favicon_path']) }}">
    @endif
    @if (! empty($settings['og_image']))
        <meta property="og:image" content="{{ Storage::url($settings['og_image']) }}">
    @endif
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Stylesheet -->
    @vite(['resources/css/portfolio.css', 'resources/js/portfolio.js'])
</head>
<body>

    <!-- =========================================================================
         NAVIGATION BAR
         ========================================================================= -->
    <header class="navbar" id="navbar">
        <div class="container nav-wrapper">
            <a href="#hero" class="brand-logo">
                <span>{{ $profile->localized('name') }}</span>
                <span class="brand-badge">&lt;/&gt; {{ $profile->localized('professional_title') }}</span>
            </a>

            <nav>
                <ul class="nav-links" id="navLinks">
                    @foreach ([['about', 'home_about'], ['skills', 'home_skills'], ['projects', 'home_projects'], ['experience', 'home_experience'], ['github', 'github'], ['resume', 'home_resume'], ['contact', 'home_contact']] as [$key, $labelKey])
                        @if ($sections->has($key))
                            <li><a href="#{{ $key }}" class="nav-link">{{ __('ui.'.$labelKey) }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </nav>

            <div class="nav-actions">
                <a href="{{ route('locale.switch', ['locale' => app()->isLocale('ar') ? 'en' : 'ar']) }}" class="btn btn-secondary btn-sm" title="{{ __('ui.language') }}">{{ __('ui.language') }}</a>
                @if ($profile->cv_path)
                    <a href="{{ Storage::url($profile->cv_path) }}" download class="btn btn-secondary btn-sm" id="navCvBtn" title="{{ __('ui.download_cv') }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    <span>CV</span>
                    </a>
                @endif
                @if ($profile->github_url)
                    <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm" title="{{ __('ui.github') }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                    <span>GitHub</span>
                    </a>
                @endif
                <button class="mobile-toggle" id="mobileToggle" aria-label="{{ __('ui.toggle_navigation') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        <!-- =========================================================================
             HERO SECTION
             ========================================================================= -->
        @if ($hero)
        <section class="hero-section" id="hero">
            <div class="container">
                <div class="hero-kicker">
                    <span class="kicker-line"></span>
                    <span>{{ $profile->localized('status') }}</span>
                </div>

                <h1 class="hero-title">{{ $profile->localized('name') }}</h1>
                <div class="hero-role">{{ $profile->localized('professional_title') }}</div>
                
                <p class="hero-lead">
                    {{ $profile->localized('short_bio') }}
                </p>

                <div class="hero-actions">
                    <a href="{{ $profile->hero_cta_url ?: '#' }}" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                        <span>{{ $profile->localized('hero_cta_text') }}</span>
                    </a>
                    <a href="#contact" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <span>{{ __('ui.contact_me') }}</span>
                    </a>
                    @if ($profile->cv_path)
                        <a href="{{ Storage::url($profile->cv_path) }}" download class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        <span>{{ __('ui.download_cv') }}</span>
                        </a>
                    @endif
                    @if ($profile->github_url)
                        <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                        <span>{{ __('ui.github') }}</span>
                        </a>
                    @endif
                </div>

                @php($heroContent = $hero->localized('content', []))
                <aside class="hero-aside" aria-label="{{ $heroContent['aside_label'] ?? '' }}">
                    <div class="terminal-window" dir="ltr">
                        <div class="terminal-topbar">
                            <span class="terminal-dots"><i></i><i></i><i></i></span>
                            <span class="terminal-file">{{ $heroContent['terminal_file'] ?? '' }}</span>
                        </div>
                        <div class="terminal-code">
                            @foreach (($heroContent['terminal_lines'] ?? []) as $line)
                                <div><span class="code-muted">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span> <span class="code-key">{{ $line }}</span></div>
                            @endforeach
                        </div>
                    </div>
                    <p class="hero-note"><span>{{ $heroContent['note_label'] ?? '' }}</span> {{ $heroContent['note_text'] ?? '' }}</p>
                </aside>

                <!-- Engineering Pillars -->
                <div class="hero-pillars-grid" id="heroPillarsContainer">
                    @foreach ($pillars as $pillar)
                        <div class="pillar-card">
                            <div class="pillar-header">
                                <span class="pillar-icon">{{ $pillar->icon ?: '✦' }}</span>
                            <h3 class="pillar-title">{{ $pillar->localized('title') }}</h3>
                            </div>
                            <p class="pillar-desc">{{ $pillar->localized('description') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- =========================================================================
             ABOUT ME SECTION
             ========================================================================= -->
        @if ($about)
        <section class="about-section" id="about">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">{{ $about->localized('tag') }}</span>
                    <h2 class="section-title">{{ $about->localized('title') }}</h2>
                    <p class="section-desc">{{ $about->localized('description') }}</p>
                </div>

                <div class="about-grid">
                    <div class="about-text">
                        @php($aboutContent = $about->localized('content', []))
                        @foreach (($aboutContent['paragraphs'] ?? []) as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach

                        <div class="about-philosophy-card">
                            <div class="about-philosophy-title">{{ $aboutContent['philosophy_title'] ?? '' }}</div>
                            <div class="about-philosophy-text">
                                {{ $aboutContent['philosophy_text'] ?? '' }}
                            </div>
                        </div>
                    </div>

                    <div class="about-specs">
                        @foreach (($aboutContent['specs'] ?? []) as $spec)
                            <div class="spec-item">
                                <span class="spec-label">
                                    @include('components.icon', ['name' => $spec['icon'] ?? null])
                                    {{ $spec['label'] }}
                                </span>
                                <span class="spec-val">{{ $spec['value'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- =========================================================================
             TECHNICAL SKILLS SECTION
             ========================================================================= -->
        @if ($skillsSection)
        <section class="skills-section" id="skills">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">{{ $skillsSection->localized('tag') }}</span>
                    <h2 class="section-title">{{ $skillsSection->localized('title') }}</h2>
                    <p class="section-desc">{{ $skillsSection->localized('description') }}</p>
                </div>

                <div class="skills-tabs" id="skillsTabs">
                    <button class="skill-tab-btn active" data-skill-category="all">{{ __('ui.all_technical_skills') }}</button>
                    @foreach ($skillsByCategory as $category => $categorySkills)
                        <button class="skill-tab-btn" data-skill-category="{{ $category }}">{{ $categorySkills->first()?->localized('category_label', ucfirst($category)) }}</button>
                    @endforeach
                </div>

                <div class="skills-grid" id="skillsContainer">
                    @foreach ($skills as $skill)
                        <div class="skill-card" data-skill-category="{{ $skill->category }}">
                            <div>
                                <div class="skill-name">{{ $skill->localized('name') }}</div>
                                <div class="skill-level">{{ $skill->localized('level') }}</div>
                            </div>
                            <span class="skill-tag">{{ $skill->localized('tag') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- =========================================================================
             PROJECTS CASE STUDIES (FLAGSHIP SECTION)
             ========================================================================= -->
        @if ($projectsSection)
        <section class="projects-section" id="projects">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">{{ $projectsSection->localized('tag') }}</span>
                    <h2 class="section-title">{{ $projectsSection->localized('title') }}</h2>
                    <p class="section-desc">{{ $projectsSection->localized('description') }}</p>
                </div>

                <div class="project-filters" id="projectFilters">
                    <button class="filter-btn active" data-filter="all">{{ __('ui.all_case_studies') }}</button>
                    @foreach ($categories as $category)
                        <button class="filter-btn" data-filter="{{ $category->slug }}">{{ $category->localized('name') }}</button>
                    @endforeach
                </div>

                <div class="projects-grid" id="projectsGrid">
                    @foreach ($projects as $project)
                        <article class="project-card" data-category="{{ $project->category?->slug }}">
                            <div class="project-card-header">
                                <span class="project-card-badge">{{ $project->localized('badge') }}</span>
                                <h3 class="project-card-title">{{ $project->localized('title') }}</h3>
                                <div class="project-card-subtitle">{{ $project->localized('short_description') }}</div>
                                <p class="project-card-desc">{{ $project->localized('full_description') ?: $project->localized('short_description') }}</p>

                                <div class="project-tech-pills">
                                    @foreach ($project->technologies->take(5) as $technology)
                                        <span class="tech-pill">{{ $technology->name }}</span>
                                    @endforeach
                                    @if ($project->technologies->count() > 5)
                                        <span class="tech-pill">+{{ $project->technologies->count() - 5 }} {{ __('ui.more') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="project-card-actions">
                                <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-primary btn-sm">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                    {{ __('ui.view_case_study') }}
                                </a>
                                @if ($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                                        {{ __('ui.github') }}
                                    </a>
                                @endif
                                @if ($project->live_demo_url)
                                    <a href="{{ $project->live_demo_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">{{ __('ui.live_demo') }}</a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- =========================================================================
             WORK EXPERIENCE & TRAINING
             ========================================================================= -->
        @if ($experienceSection)
        <section class="experience-section" id="experience">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">{{ $experienceSection->localized('tag') }}</span>
                    <h2 class="section-title">{{ $experienceSection->localized('title') }}</h2>
                    <p class="section-desc">{{ $experienceSection->localized('description') }}</p>
                </div>

                <div class="timeline" id="experienceTimeline">
                    @foreach ($experiences as $experience)
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-card">
                                <div class="timeline-header">
                                    <div>
                                        <h3 class="timeline-role">{{ $experience->localized('position') }}</h3>
                                        <div class="timeline-company">{{ $experience->localized('company') }}</div>
                                    </div>
                                    <span class="timeline-period">
                                        {{ $experience->start_date?->format('M Y') }} — {{ $experience->current ? __('ui.present') : $experience->end_date?->format('M Y') }}
                                    </span>
                                </div>
                                <ul class="timeline-highlights">
                                    @foreach ($experience->localized('highlights', []) as $highlight)
                                        <li>{{ $highlight }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- =========================================================================
             GITHUB REPOSITORIES SHOWCASE
             ========================================================================= -->
        @if ($githubSection)
        <section class="github-section" id="github">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">{{ $githubSection->localized('tag') }}</span>
                    <h2 class="section-title">{{ $githubSection->localized('title') }}</h2>
                    <p class="section-desc">{{ $githubSection->localized('description') }}</p>
                </div>

                <div class="github-profile-card">
                    <div class="github-user-info">
                        @if ($profile->profile_image_path)
                            <img src="{{ Storage::url($profile->profile_image_path) }}" alt="{{ $profile->localized('name') }} {{ __('ui.avatar') }}" class="github-avatar">
                        @else
                            <div class="github-avatar" aria-hidden="true"></div>
                        @endif
                        <div>
                            <div class="github-user-name">{{ $profile->localized('name') }}</div>
                            <div class="github-user-handle">{{ Str::after($profile->github_url, 'github.com/') }}</div>
                        </div>
                    </div>

                    @if ($profile->github_url)
                        <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        <span>{{ __('ui.visit_github') }}</span>
                        </a>
                    @endif
                </div>

                <div class="github-repos-grid" id="githubReposGrid">
                    @foreach ($githubProjects as $project)
                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="github-repo-card">
                            <div>
                                <div class="repo-header">
                                    <span class="repo-title">{{ Str::afterLast($project->github_url, '/') }}</span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                </div>
                                <p class="repo-desc">{{ $project->localized('short_description') }}</p>
                            </div>
                            <div class="repo-meta">
                                <span><span class="repo-lang-dot" style="background-color: #38BDF8;"></span>{{ $project->technologies->take(2)->pluck('name')->join(' / ') }}</span>
                                <span>{{ __('ui.public_repository') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- =========================================================================
             RESUME DOWNLOAD SECTION
             ========================================================================= -->
        @if ($resumeSection)
        <section class="about-section" id="resume">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">{{ $resumeSection->localized('tag') }}</span>
                    <h2 class="section-title">{{ $resumeSection->localized('title') }}</h2>
                    <p class="section-desc">{{ $resumeSection->localized('description') }}</p>
                </div>

                <div class="pillar-card" style="padding: 2.5rem; text-align: center; max-width: 600px; margin: 0 auto;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(244, 63, 94, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <h3 style="font-size: 1.4rem; margin-bottom: 0.5rem;">{{ $profile->localized('name') }} — {{ __('ui.cv_pdf') }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.925rem; margin-bottom: 1.5rem;">
                        {{ $resumeSection->localized('content', [])['note'] ?? '' }}
                    </p>
                    @if ($profile->cv_path)
                        <a href="{{ Storage::url($profile->cv_path) }}" download class="btn btn-primary" style="display: inline-flex;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        <span>{{ __('ui.download_resume') }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </section>
        @endif

        <!-- =========================================================================
             CONTACT SECTION
             ========================================================================= -->
        @if ($contactSection)
        <section class="contact-section" id="contact">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">{{ $contactSection->localized('tag') }}</span>
                    <h2 class="section-title">{{ $contactSection->localized('title') }}</h2>
                    <p class="section-desc">{{ $contactSection->localized('description') }}</p>
                </div>

                <div class="contact-grid">
                    <div>
                        <h3 style="font-size: 1.35rem; margin-bottom: 0.75rem;">{{ __('ui.contact_information') }}</h3>
                        <p style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 1.5rem;">
                            {{ $contactSection->localized('content', [])['intro'] ?? '' }}
                        </p>

                        <div class="contact-info-list">
                            @if ($profile->email)
                            <a href="mailto:{{ $profile->email }}" class="contact-item" id="contactEmailItem">
                                <div class="contact-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                </div>
                                <div>
                                    <div class="contact-label">{{ __('ui.email') }}</div>
                                    <div class="contact-val">{{ $profile->email }}</div>
                                </div>
                            </a>
                            @endif

                            @if ($profile->phone)
                            <a href="tel:{{ $profile->phone }}" class="contact-item" id="contactPhoneItem">
                                <div class="contact-icon" style="color: var(--secondary); background: rgba(56, 189, 248, 0.1);">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </div>
                                <div>
                                    <div class="contact-label">{{ __('ui.phone') }}</div>
                                    <div class="contact-val">{{ $profile->phone }}</div>
                                </div>
                            </a>
                            @endif

                            @if ($profile->github_url)
                            <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" class="contact-item">
                                <div class="contact-icon" style="color: #cbd5e1; background: rgba(255, 255, 255, 0.05);">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                                </div>
                                <div>
                                    <div class="contact-label">{{ __('ui.github') }}</div>
                                    <div class="contact-val">{{ Str::after($profile->github_url, 'https://') }}</div>
                                </div>
                            </a>
                            @endif

                            @if ($profile->linkedin_url)
                            <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="contact-item" id="contactLinkedinItem">
                                <div class="contact-icon" style="color: #0A66C2; background: rgba(10, 102, 194, 0.1);">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                                </div>
                                <div>
                                    <div class="contact-label">LinkedIn</div>
                                    <div class="contact-val">{{ Str::after($profile->linkedin_url, 'https://') }}</div>
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <form class="contact-form" id="contactForm" method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
                        <div class="form-group">
                            <label class="form-label" for="formName">{{ __('ui.full_name') }}</label>
                            <input type="text" id="formName" name="name" class="form-control" placeholder="{{ __('ui.full_name') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="formEmail">{{ __('ui.email_address') }}</label>
                            <input type="email" id="formEmail" name="email" class="form-control" placeholder="{{ __('ui.email_address') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="formSubject">{{ __('ui.subject') }}</label>
                            <input type="text" id="formSubject" name="subject" class="form-control" placeholder="{{ __('ui.subject') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="formMessage">{{ __('ui.message') }}</label>
                            <textarea id="formMessage" name="message" class="form-control" placeholder="{{ __('ui.message_placeholder') }}" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            <span>{{ __('ui.send_message') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </section>
        @endif
    </main>

    <!-- =========================================================================
         FOOTER
         ========================================================================= -->
    <footer class="footer">
        <div class="container">
            <div class="footer-text">
                &copy; {{ now()->year }} {{ $profile->localized('name') }}.
            </div>
            <div class="footer-note">
                {{ $settings['footer_text'] ?? '' }}
            </div>
        </div>
    </footer>

    <!-- Toast Notification -->
    <div class="toast" id="toast" role="status" aria-live="polite">
        {{ session('contact_success') ?? '' }}
    </div>

</body>
</html>
