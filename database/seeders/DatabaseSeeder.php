<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PortfolioPillar;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Section;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdmin();
        $this->seedProfile();
        $this->seedSettings();
        $this->seedSections();
        $this->seedPillars();
        $this->seedSkills();
        $this->seedExperience();
        $this->seedEducation();
        $this->seedProjects();
    }

    private function seedAdmin(): void
    {
        User::query()->updateOrCreate(['email' => env('ADMIN_EMAIL', 'admin@example.com')], ['name' => env('ADMIN_NAME', 'Portfolio Administrator'), 'password' => Hash::make(env('ADMIN_PASSWORD', 'password')), 'is_admin' => true, 'email_verified_at' => now()]);
    }

    private function seedProfile(): void
    {
        PortfolioProfile::query()->updateOrCreate(['id' => 1], ['name' => 'Ibrahim Alaa', 'professional_title' => 'Backend Developer — PHP / Laravel', 'status' => 'Backend systems / PHP / Laravel', 'short_bio' => 'Backend Developer focused on PHP and Laravel, with hands-on work across e-commerce, appointment booking, public-service workflows, and API-driven applications.', 'full_bio' => 'I build maintainable backend systems with clear business rules, secure APIs, relational data models, and architecture that remains predictable as products grow.', 'cv_path' => 'cv/Ibrahim_Alaa_CV.pdf', 'location' => 'Egypt', 'github_url' => 'https://github.com/ibraaaahim00', 'available' => true, 'hero_cta_text' => 'View Projects', 'hero_cta_url' => '#projects']);
    }

    private function seedSettings(): void
    {
        $settings = [['key' => 'site_name', 'value' => 'Ibrahim Alaa Portfolio', 'group' => 'general'], ['key' => 'logo_path', 'value' => null, 'group' => 'general'], ['key' => 'favicon_path', 'value' => null, 'group' => 'general'], ['key' => 'default_language', 'value' => 'en', 'group' => 'general'], ['key' => 'timezone', 'value' => 'Africa/Cairo', 'group' => 'general'], ['key' => 'meta_title', 'value' => 'Ibrahim Alaa — Backend Developer', 'group' => 'seo'], ['key' => 'meta_description', 'value' => 'Ibrahim Alaa is a Backend Developer working with PHP, Laravel, MySQL, and REST APIs.', 'group' => 'seo'], ['key' => 'keywords', 'value' => 'Ibrahim Alaa, Backend Developer, PHP, Laravel, REST API, MySQL, Portfolio', 'group' => 'seo'], ['key' => 'og_title', 'value' => 'Ibrahim Alaa — Backend Developer | PHP & Laravel', 'group' => 'seo'], ['key' => 'og_description', 'value' => 'Explore real Laravel case studies, clean architecture implementations, and database concurrency solutions.', 'group' => 'seo'], ['key' => 'og_image', 'value' => null, 'group' => 'seo'], ['key' => 'footer_text', 'value' => 'Built with semantic HTML, CSS, Laravel, and MySQL.', 'group' => 'footer']];
        foreach ($settings as $setting) {
            SiteSetting::query()->updateOrCreate(['key' => $setting['key']], $setting + ['type' => 'string']);
        }
    }

    private function seedSections(): void
    {
        $sections = [
            ['key' => 'hero', 'tag' => 'Backend systems / PHP / Laravel', 'title' => 'Ibrahim Alaa', 'description' => 'Backend Developer — PHP / Laravel', 'content' => ['aside_label' => "A glimpse at Ibrahim's backend work", 'terminal_file' => 'BookingService.php', 'terminal_lines' => ['return DB::transaction(function () {', '$slot = AvailabilitySlot::lockForUpdate();', '$slot->update([\'is_booked\' => true]);', 'return Appointment::create($data);', '});'], 'note_label' => 'Currently showing', 'note_text' => 'the decisions behind a few selected projects.']],
            ['key' => 'about', 'tag' => 'A little about the work', 'title' => 'About Me', 'description' => 'Backend work is mostly about making the complicated parts predictable.', 'content' => ['paragraphs' => ['I am a Backend Developer focused on building robust, maintainable systems using PHP and Laravel. Rather than relying on simple CRUD generators, I prioritize architectural clarity: separating business rules into dedicated Service layers, isolating persistence behind Repository contracts, and enforcing strict data transitions through typed Enums.', 'My experience includes designing secure RESTful APIs protected by Laravel Sanctum, preventing concurrency race conditions through pessimistic database row locking, and integrating real-world payment gateways like MyFatoorah.', 'I believe good backend engineering is measured by how predictably a system handles edge cases, protects data integrity across multi-step transactions, and allows new features to be added without breaking existing contracts.'], 'philosophy_title' => 'Engineering Philosophy', 'philosophy_text' => 'Controllers should orchestrate, Form Requests should validate, Services should decide, Repositories should persist, and Database Transactions should guarantee.', 'specs' => [['label' => 'Primary Language', 'value' => 'PHP 8.2+', 'icon' => 'code'], ['label' => 'Primary Framework', 'value' => 'Laravel (10/11/12)', 'icon' => 'server'], ['label' => 'Database Engine', 'value' => 'MySQL / Eloquent', 'icon' => 'database'], ['label' => 'Authentication', 'value' => 'Sanctum / RBAC / OTP', 'icon' => 'shield'], ['label' => 'Concurrency', 'value' => 'lockForUpdate / Atomic DB', 'icon' => 'concurrency'], ['label' => 'Location', 'value' => 'Egypt', 'icon' => 'location']]]],
            ['key' => 'skills', 'tag' => 'The toolkit', 'title' => 'Skills & Technologies', 'description' => 'Technologies and patterns I have used while building the projects below', 'content' => []],
            ['key' => 'projects', 'tag' => 'Selected work', 'title' => 'Featured Projects', 'description' => 'A closer look at the systems, trade-offs, and backend problems behind real codebases.', 'content' => []],
            ['key' => 'experience', 'tag' => 'Experience', 'title' => 'Work Experience', 'description' => 'The roles and training that shaped how I approach backend development.', 'content' => []],
            ['key' => 'github', 'tag' => 'The code', 'title' => 'GitHub Repositories', 'description' => 'The source is public. Start with the repositories that best show how I work.', 'content' => []],
            ['key' => 'resume', 'tag' => 'Resume', 'title' => 'Resume & Background', 'description' => 'A concise version of my experience, skills, and selected projects.', 'content' => ['note' => 'The file is kept here so it can be replaced with the latest version whenever it is ready.']],
            ['key' => 'contact', 'tag' => 'Say hello', 'title' => 'Get in Touch', 'description' => 'For a role, a project, or just a technical conversation, you can find me here.', 'content' => ['intro' => 'Contact details and messages are managed from the Portfolio CMS.']],
        ];
        foreach ($sections as $order => $section) {
            Section::query()->updateOrCreate(['key' => $section['key']], $section + ['active' => true, 'sort_order' => $order]);
        }
    }

    private function seedPillars(): void
    {
        foreach ([['title' => 'Clean Architecture', 'description' => 'Decoupled domain logic using Repository Pattern and Service Layer abstractions.'], ['title' => 'Concurrency Safety', 'description' => 'Preventing race conditions with database transactions and pessimistic locking (lockForUpdate).'], ['title' => 'Robust REST APIs', 'description' => 'Standardized HTTP responses, Form Requests validation, and API Resources transformers.'], ['title' => 'Type Safety & States', 'description' => 'Strict PHP 8+ Enums managing validated status transitions and business rules.']] as $order => $pillar) {
            PortfolioPillar::query()->updateOrCreate(['title' => $pillar['title']], $pillar + ['sort_order' => $order, 'active' => true]);
        }
    }

    private function seedSkills(): void
    {
        $skills = ['backend' => ['Backend & Core', [['PHP 8.2+', 'Core Language', 'Used in projects'], ['Laravel (10/11/12)', 'Primary Framework', 'Used in projects'], ['OOP & SOLID', 'Design Principles', 'Core'], ['MVC Architecture', 'Framework Standard', 'Core']]], 'database' => ['Database & Concurrency', [['MySQL', 'Relational Database', 'Core'], ['Eloquent ORM', 'Data Modeling', 'Used in projects'], ['Query Builder', 'Optimized Queries', 'Used in projects'], ['DB Transactions', 'Atomicity & Rollbacks', 'Database'], ['Pessimistic Locking', 'Race Condition Prevention', 'Database']]], 'apis' => ['APIs & Security', [['RESTful APIs', 'Standard Compliant', 'Core'], ['Laravel Sanctum', 'Token Authentication', 'Security'], ['API Resources', 'Response Transformation', 'Core'], ['Form Requests', 'Input Validation', 'Security'], ['Role Authorization', 'Custom Middleware & Gates', 'Security'], ['OTP Authentication', 'Mobile & Email Lifecycle', 'Workflow']]], 'architecture' => ['Architecture & Patterns', [['Repository Pattern', 'Data Layer Decoupling', 'Architecture'], ['Service Layer', 'Business Logic Encapsulation', 'Architecture'], ['State Machines', 'Enum-based Status Transitions', 'Data Integrity'], ['Audit Trail Logging', 'Historical Change Tracking', 'History'], ['Immutable Snapshots', 'Order & Invoice Integrity', 'Data Integrity']]], 'frontend' => ['Frontend Integration', [['React 18', 'Client-side SPAs (CivicFix)', 'Integration'], ['Next.js / TypeScript', 'Fullstack Interface (Clinic)', 'Integration'], ['Vite', 'Frontend Build Tooling', 'Tooling'], ['Blade Templates', 'Server-side Rendering', 'Laravel Core'], ['Tailwind CSS', 'Utility Styling', 'Styling']]], 'tools' => ['Tools & Workflow', [['Git & GitHub', 'Version Control', 'Essential'], ['Postman & Apidog', 'API Testing & Docs', 'API Testing'], ['XAMPP / MySQL', 'Local Development', 'Environment'], ['PhpStorm / VS Code', 'IDE', 'Tooling']]]];
        foreach ($skills as $category => [$label, $items]) {
            foreach ($items as $order => [$name, $level, $tag]) {
                Skill::query()->updateOrCreate(['name' => $name], ['category' => $category, 'category_label' => $label, 'level' => $level, 'tag' => $tag, 'sort_order' => $order, 'active' => true]);
            }
        }
    }

    private function seedExperience(): void
    {
        $experience = [['position' => 'Backend Developer', 'company' => 'Kabret', 'description' => 'Professional Experience', 'highlights' => ['Architected and deployed backend services and RESTful APIs using PHP and Laravel.', 'Engineered relational database schemas and performed MySQL query optimizations.', 'Integrated third-party APIs and webhooks ensuring reliable external service communications.', 'Participated in active code reviews, promoting clean code standards and DRY principles.']], ['position' => 'Backend Developer', 'company' => '7L Soft', 'description' => 'Professional Experience', 'highlights' => ['Built and maintained Laravel backend systems powering web and client applications.', 'Optimized database performance through thoughtful index placement and eager loading.', 'Implemented external API integrations and automated webhook processing.', 'Contributed to core feature implementations and peer pull request reviews.']], ['position' => 'Backend Development Trainee', 'company' => 'Finteck', 'description' => '3-Month Intensive Program • Mansoura', 'highlights' => ['Intensive 3-month backend training focused on modern PHP and Laravel development.', 'Mastered relational database design, foreign key constraints, and indexing in MySQL.', 'Built practical RESTful APIs with token-based authentication and secure input validation.', 'Adopted version control workflows using Git and collaborative GitHub practices.']]];
        foreach ($experience as $order => $item) {
            Experience::query()->updateOrCreate(['company' => $item['company'], 'position' => $item['position']], $item + ['sort_order' => $order, 'active' => true, 'current' => false]);
        }
    }

    private function seedEducation(): void
    {
        Education::query()->updateOrCreate(['institution' => 'Professional Development', 'degree' => 'Backend Development'], ['field' => 'PHP and Laravel', 'description' => 'Continuous practical development across production-oriented backend systems.', 'active' => true, 'sort_order' => 0]);
    }

    private function seedProjects(): void
    {
        $categoryIds = [];
        foreach (['Clean Architecture', 'Full Stack', 'Concurrency & APIs', 'Enterprise System', 'CMS & APIs'] as $order => $name) {
            $categoryIds[Str::slug($name)] = Category::query()->updateOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'sort_order' => $order, 'active' => true])->id;
        }
        $projects = [
            ['title' => 'Awfar', 'slug' => 'awfar', 'category' => 'Clean Architecture', 'featured' => true, 'github_url' => 'https://github.com/ibraaaahim00/awfar', 'badge' => 'Clean Architecture • Repository Pattern • State Machine', 'short_description' => 'E-commerce and delivery API', 'full_description' => 'An API for products, carts, orders, and delivery. The interesting part is how the code keeps order rules and data changes in one place.', 'technologies' => ['PHP 8.3', 'Laravel', 'MySQL', 'Laravel Sanctum', 'Repository Pattern', 'Service Layer', 'PHP Enums', 'Form Requests', 'API Resources'], 'case_study' => ['problem' => 'Typical e-commerce backends suffer from bloated controllers, tight coupling between ORM queries and HTTP layers, race conditions in stock decrements, and corrupted order history.', 'solution' => 'Architected a decoupled Laravel API utilizing the Repository Pattern with Contracts, an autonomous Service Layer, strict PHP Enums, and snapshot serialization for orders.', 'architecture' => 'Controllers → Service Layer → Repository Contracts → transactional database operations.', 'keyFeatures' => ['Repository Contracts', 'Enum-driven Order State Machine', 'Atomic inventory stock decrement', 'Immutable address snapshots', 'Loyalty points engine', 'Multi-role endpoints', 'Sanctum authentication paired with OTP']], 'sort_order' => 0],
            ['title' => 'CivicFix', 'slug' => 'civicfix', 'category' => 'Full Stack', 'featured' => true, 'github_url' => 'https://github.com/ibraaaahim00/civicfix', 'badge' => 'Laravel API • React 18 • Vite • Audit Trails • Analytics', 'short_description' => 'Citizen issue reporting and tracking', 'full_description' => 'A Laravel API and React interface for submitting public-space issues, assigning them to technicians, and keeping a history of what happened to each report.', 'technologies' => ['PHP 8.3', 'Laravel', 'MySQL', 'Laravel Sanctum', 'React 18', 'Vite', 'Axios', 'RESTful API', 'Tailwind CSS'], 'case_study' => ['problem' => 'Municipalities struggle with unstructured citizen complaints, lack of transparent tracking, lost attachments, and difficulty assigning field technicians.', 'solution' => 'Engineered a secured Laravel API paired with a React 18/Vite SPA, role-based workflows, dashboards, and automated audit history.', 'architecture' => 'Laravel REST API protected by Sanctum and role middleware, consumed by a React SPA.', 'keyFeatures' => ['Citizen issue submission', 'Role-Based Access Control', 'Audit trail history', 'Overview analytics', 'Technician dispatching workflow', 'Responsive React interface']], 'sort_order' => 1],
            ['title' => 'Clinic Booking', 'slug' => 'clinic-booking', 'category' => 'Concurrency & APIs', 'featured' => true, 'github_url' => 'https://github.com/ibraaaahim00/clinic_booking', 'badge' => 'Concurrency Control • lockForUpdate • Next.js • Sanctum', 'short_description' => 'Appointment booking with slot locking', 'full_description' => 'A clinic booking system where doctors publish availability and patients book a slot. The API locks the slot during booking so two requests cannot take it at once.', 'technologies' => ['PHP 8.3', 'Laravel', 'MySQL', 'Pessimistic Locking', 'Laravel Sanctum', 'Next.js', 'TypeScript', 'Tailwind CSS', 'Radix UI'], 'case_study' => ['problem' => 'Simultaneous appointment requests for the same time slot can lead to race conditions and double booking.', 'solution' => 'Implemented database-level pessimistic locking via DB transactions and lockForUpdate.', 'architecture' => 'Laravel REST API with resource controllers paired with a Next.js/TypeScript interface.', 'keyFeatures' => ['Pessimistic locking', 'Slot state synchronization', 'Re-validation on reactivation', 'Row-level access control', 'Availability generator', 'Next.js TypeScript frontend']], 'sort_order' => 2],
            ['title' => 'ALAMAAL — جسر الأمل', 'slug' => 'alamaal', 'category' => 'Enterprise System', 'featured' => true, 'github_url' => 'https://github.com/ibraaaahim00/ALAMAAL', 'badge' => 'Laravel 11 • MyFatoorah • Treatment Workflows • OTP • CMS', 'short_description' => 'Rehabilitation services and online payments', 'full_description' => 'A Laravel platform connecting families with specialists, handling service orders and payments, and giving the team a way to manage treatment plans and site content.', 'technologies' => ['PHP 8.3', 'Laravel 11/12', 'MySQL', 'MyFatoorah Payment Gateway', 'Blade', 'Tailwind CSS', 'Alpine.js', 'OTP Verification'], 'case_study' => ['problem' => 'Families require customized consulting, structured treatment plans, secure online payments, and communication with specialists.', 'solution' => 'Engineered a multi-role Laravel platform providing rehabilitation tracking, payment callbacks, treatment plan delivery, and OTP recovery.', 'architecture' => 'Full-Stack Laravel MVC with Blade, Alpine.js, Tailwind CSS, an isolated admin panel, and payment gateway handlers.', 'keyFeatures' => ['MyFatoorah integration', 'Child profile registry', 'Treatment plan workflow', 'Controlled visibility gates', 'OTP password recovery', 'Coupon calculation', 'CMS dashboard']], 'sort_order' => 3],
            ['title' => 'Ezhal — إذهل', 'slug' => 'ezzhal', 'category' => 'CMS & APIs', 'featured' => false, 'github_url' => 'https://github.com/ibraaaahim00/ezzhal', 'badge' => 'Laravel 13 • Blade • CMS • Media Library', 'short_description' => 'Water delivery website and content dashboard', 'full_description' => 'A bilingual Laravel website for a water-delivery service, backed by a dashboard that lets the team manage the public content without changing the code.', 'technologies' => ['PHP 8.3', 'Laravel 13', 'Blade', 'Eloquent', 'Vite', 'Tailwind CSS', 'Spatie Media Library', 'Bootstrap 5'], 'case_study' => ['problem' => 'A service website needs to change banners, features, FAQs, reviews, and contact information without waiting for a code release.', 'solution' => 'Built a Laravel application with a server-rendered public site and authenticated dashboard for managing public content.', 'architecture' => 'Laravel MVC with Blade, Eloquent, session authentication, Form Requests, Vite, and media uploads.', 'keyFeatures' => ['Arabic and English content', 'Dashboard content resources', 'Image upload and replacement', 'Active flags and sort order', 'Validated contact form', 'Database-assembled public home page']], 'sort_order' => 4],
            ['title' => 'DentCare', 'slug' => 'dentcare', 'category' => 'CMS & APIs', 'featured' => true, 'github_url' => 'https://github.com/ibraaaahim00/dentcare', 'badge' => 'Laravel 13 • MySQL • Service + Repository • Sanctum', 'short_description' => 'Dental Clinic Management System', 'full_description' => 'A full-stack dental clinic platform for managing clinic content, doctors, appointments, schedules, patient reviews, and booking operations from one administration system.', 'technologies' => ['PHP 8.4', 'Laravel 13', 'MySQL', 'Laravel Sanctum', 'Blade', 'Eloquent', 'Service Layer', 'Repository Pattern', 'Tailwind CSS'], 'case_study' => ['problem' => 'Dental clinics need one reliable workspace for public content, doctor operations, appointment scheduling, patient communication, and administrative settings.', 'solution' => 'Built a Laravel-based clinic management system with an admin CMS, role-aware workflows, and a booking flow backed by validated services and persistent clinic rules.', 'architecture' => 'Laravel MVC with Blade, Eloquent, Service Layer, Repository Contracts, Form Requests, API Resources, Sanctum, and web authentication.', 'keyFeatures' => ['Admin CMS', 'Doctor management', 'Appointment booking and schedules', 'Reviews moderation', 'Blog, FAQ, gallery, and clinic settings', 'Versioned REST API protected by Sanctum']], 'sort_order' => 5],
        ];
        foreach ($projects as $projectData) {
            $technologyIds = [];
            foreach ($projectData['technologies'] as $order => $name) {
                $technology = Technology::query()->updateOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'category' => 'technology', 'sort_order' => $order, 'active' => true]);
                $technologyIds[] = $technology->id;
            }
            $category = $projectData['category'];
            unset($projectData['technologies'], $projectData['category']);
            $project = Project::query()->updateOrCreate(['slug' => $projectData['slug']], $projectData + ['category_id' => $categoryIds[Str::slug($category)], 'published' => true, 'active' => true, 'project_status' => 'completed']);
            $project->technologies()->sync($technologyIds);
        }
    }
}
