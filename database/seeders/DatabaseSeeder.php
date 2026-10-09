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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
        $this->seedProfile();
        $this->seedSettings();
        $this->seedSections();
        $this->seedPillars();
        $this->seedSkills();
        $this->seedExperience();
        $this->seedEducation();
        $this->seedProjects();
        $this->seedArabicTranslations();
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

    private function seedArabicTranslations(): void
    {
        $profile = PortfolioProfile::query()->first();
        if ($profile) {
            $this->setArabic($profile, [
                'professional_title' => 'مطور Backend — PHP / Laravel',
                'status' => 'أنظمة Backend / PHP / Laravel',
                'short_bio' => 'مطور Backend متخصص في PHP وLaravel، مع خبرة عملية في التجارة الإلكترونية، وحجز المواعيد، وسير العمل للخدمات العامة، والتطبيقات المعتمدة على APIs.',
                'full_bio' => 'أبني أنظمة Backend قابلة للصيانة بقواعد عمل واضحة، وواجهات APIs آمنة، ونماذج بيانات مترابطة، ومعمارية تظل مستقرة مع نمو المنتجات.',
                'hero_cta_text' => 'عرض المشاريع',
            ]);
        }

        $sections = [
            'hero' => ['tag' => 'أنظمة Backend / PHP / Laravel', 'description' => 'مطور Backend — PHP / Laravel', 'content' => ['aside_label' => 'لمحة عن أعمال إبراهيم في Backend', 'note_label' => 'نعرض حاليًا', 'note_text' => 'القرارات الهندسية خلف مجموعة من المشاريع المختارة.']],
            'about' => ['tag' => 'نبذة عن العمل', 'title' => 'نبذة عني', 'description' => 'العمل في Backend يدور غالبًا حول جعل الأجزاء المعقدة قابلة للتوقع.', 'content' => ['paragraphs' => ['أنا مطور Backend أركز على بناء أنظمة قوية وقابلة للصيانة باستخدام PHP وLaravel. بدلًا من الاعتماد على مولدات CRUD البسيطة، أضع وضوح المعمارية أولًا من خلال فصل قواعد العمل في طبقات Services، وعزل التخزين خلف عقود Repositories، وفرض انتقالات البيانات بواسطة Enums واضحة.', 'لدي خبرة في تصميم RESTful APIs آمنة محمية بـLaravel Sanctum، ومنع مشاكل التزامن باستخدام قفل صفوف قاعدة البيانات، ودمج بوابات دفع حقيقية مثل MyFatoorah.', 'أؤمن أن جودة هندسة Backend تقاس بمدى تعامل النظام مع الحالات الخاصة بشكل متوقع، وحماية سلامة البيانات داخل المعاملات متعددة الخطوات، وإضافة الميزات الجديدة دون كسر العقود الحالية.'], 'philosophy_title' => 'فلسفة هندسية', 'philosophy_text' => 'الـControllers تنسق، والـForm Requests تتحقق، والـServices تقرر، والـRepositories تحفظ، والمعاملات تضمن سلامة العملية.', 'specs' => [['label' => 'اللغة الأساسية', 'value' => 'PHP 8.2+'], ['label' => 'الإطار الأساسي', 'value' => 'Laravel (10/11/12)'], ['label' => 'قاعدة البيانات', 'value' => 'MySQL / Eloquent'], ['label' => 'المصادقة', 'value' => 'Sanctum / RBAC / OTP'], ['label' => 'التزامن', 'value' => 'lockForUpdate / Atomic DB'], ['label' => 'الموقع', 'value' => 'مصر']]]],
            'skills' => ['tag' => 'الأدوات التي أستخدمها', 'title' => 'المهارات والتقنيات', 'description' => 'تقنيات وأنماط استخدمتها أثناء بناء المشاريع التالية.'],
            'projects' => ['tag' => 'أعمال مختارة', 'title' => 'مشاريع مميزة', 'description' => 'نظرة أقرب على الأنظمة والقرارات والمشكلات التقنية خلف مشاريع حقيقية.'],
            'experience' => ['tag' => 'الخبرة', 'title' => 'الخبرة العملية', 'description' => 'الأدوار والتدريبات التي شكلت طريقتي في تطوير أنظمة Backend.'],
            'github' => ['tag' => 'الكود', 'title' => 'مستودعات GitHub', 'description' => 'الكود متاح للعامة. ابدأ بالمستودعات التي توضح أسلوبي في العمل.'],
            'resume' => ['tag' => 'السيرة الذاتية', 'title' => 'السيرة الذاتية والخلفية المهنية', 'description' => 'ملخص مختصر عن خبرتي ومهاراتي ومشاريعي المختارة.', 'content' => ['note' => 'يتم الاحتفاظ بالملف هنا ليكون استبداله بالنسخة الأحدث سهلًا عند جاهزيتها.']],
            'contact' => ['tag' => 'تواصل معي', 'title' => 'تواصل معي', 'description' => 'لوظيفة أو مشروع أو حتى نقاش تقني، يمكنك التواصل معي من هنا.', 'content' => ['intro' => 'تتم إدارة بيانات التواصل والرسائل من لوحة تحكم البورتفوليو.']],
        ];
        foreach ($sections as $key => $translations) {
            $section = Section::query()->where('key', $key)->first();
            if ($section) {
                $this->setArabic($section, $translations);
            }
        }

        $pillars = [
            'Clean Architecture' => ['title' => 'معمارية نظيفة', 'description' => 'فصل منطق المجال باستخدام Repository Pattern وطبقات Service.'],
            'Concurrency Safety' => ['title' => 'أمان التزامن', 'description' => 'منع حالات التنافس باستخدام معاملات قاعدة البيانات والقفل التشاؤمي.'],
            'Robust REST APIs' => ['title' => 'REST APIs قوية', 'description' => 'استجابات HTTP موحدة، والتحقق عبر Form Requests، وتحويل البيانات باستخدام API Resources.'],
            'Type Safety & States' => ['title' => 'سلامة الأنواع والحالات', 'description' => 'إدارة انتقالات الحالة باستخدام PHP Enums للحفاظ على سلامة البيانات.'],
        ];
        foreach ($pillars as $title => $translations) {
            $pillar = PortfolioPillar::query()->where('title', $title)->first();
            if ($pillar) {
                $this->setArabic($pillar, $translations);
            }
        }

        foreach ([
            'clean-architecture' => 'معمارية نظيفة',
            'full-stack' => 'Full Stack',
            'concurrency-apis' => 'التزامن وواجهات APIs',
            'enterprise-system' => 'أنظمة مؤسسية',
            'cms-apis' => 'CMS وواجهات APIs',
        ] as $slug => $name) {
            $category = Category::query()->where('slug', $slug)->first();
            if ($category) {
                $this->setArabic($category, ['name' => $name]);
            }
        }

        $categoryLabels = ['backend' => 'Backend والأساسيات', 'database' => 'قواعد البيانات والتزامن', 'apis' => 'APIs والأمان', 'architecture' => 'المعمارية والأنماط', 'frontend' => 'تكامل الواجهات', 'tools' => 'الأدوات وسير العمل'];
        $skillLevels = ['Core Language' => 'اللغة الأساسية', 'Primary Framework' => 'الإطار الأساسي', 'Core' => 'أساسي', 'Used in projects' => 'مستخدم في المشاريع', 'Design Principles' => 'مبادئ التصميم', 'Framework Standard' => 'معيار الإطار', 'Relational Database' => 'قاعدة بيانات علائقية', 'Data Modeling' => 'نمذجة البيانات', 'Optimized Queries' => 'استعلامات محسنة', 'Atomicity & Rollbacks' => 'الذرية والتراجع', 'Race Condition Prevention' => 'منع Race Conditions', 'Standard Compliant' => 'متوافق مع المعايير', 'Token Authentication' => 'مصادقة بالـTokens', 'Response Transformation' => 'تحويل الاستجابات', 'Input Validation' => 'التحقق من المدخلات', 'Custom Middleware & Gates' => 'Middleware وGates مخصصة', 'Mobile & Email Lifecycle' => 'دورة حياة الهاتف والبريد', 'Data Layer Decoupling' => 'فصل طبقة البيانات', 'Business Logic Encapsulation' => 'تغليف منطق العمل', 'Enum-based Status Transitions' => 'انتقالات حالة باستخدام Enums', 'Historical Change Tracking' => 'تتبع التغييرات التاريخية', 'Order & Invoice Integrity' => 'سلامة الطلبات والفواتير', 'Client-side SPAs (CivicFix)' => 'SPA للعميل (CivicFix)', 'Fullstack Interface (Clinic)' => 'واجهة Fullstack (Clinic)', 'Frontend Build Tooling' => 'أدوات بناء الواجهة', 'Server-side Rendering' => 'تصيير من الخادم', 'Laravel Core' => 'نواة Laravel', 'Utility Styling' => 'تنسيق Utility', 'Version Control' => 'إدارة الإصدارات', 'API Testing & Docs' => 'اختبار وتوثيق APIs', 'Local Development' => 'تطوير محلي', 'IDE' => 'بيئة التطوير'];
        $skillTags = ['Used in projects' => 'مستخدم في المشاريع', 'Core' => 'أساسي', 'Database' => 'قواعد بيانات', 'Security' => 'أمان', 'Architecture' => 'معمارية', 'Data Integrity' => 'سلامة البيانات', 'History' => 'سجل تاريخي', 'Integration' => 'تكامل', 'Tooling' => 'أدوات', 'Styling' => 'تنسيق', 'Essential' => 'أساسي', 'API Testing' => 'اختبار APIs', 'Environment' => 'بيئة', 'Workflow' => 'سير عمل'];
        foreach (Skill::query()->get() as $skill) {
            $this->setArabic($skill, ['category_label' => $categoryLabels[$skill->category] ?? $skill->category_label, 'level' => $skillLevels[$skill->level] ?? $skill->level, 'tag' => $skillTags[$skill->tag] ?? $skill->tag]);
        }

        $experiences = [
            'Kabret' => ['position' => 'مطور Backend', 'description' => 'خبرة عملية', 'highlights' => ['تصميم ونشر خدمات Backend وRESTful APIs باستخدام PHP وLaravel.', 'هندسة مخططات قواعد البيانات وتحسين استعلامات MySQL.', 'دمج APIs وWebhooks خارجية مع ضمان موثوقية الاتصال بالخدمات.', 'المشاركة في مراجعات الكود وتعزيز معايير Clean Code ومبدأ DRY.']],
            '7L Soft' => ['position' => 'مطور Backend', 'description' => 'خبرة عملية', 'highlights' => ['بناء وصيانة أنظمة Laravel التي تدعم تطبيقات الويب والعملاء.', 'تحسين أداء قواعد البيانات عبر الفهارس والتحميل المسبق المدروس.', 'تنفيذ تكاملات APIs خارجية ومعالجة Webhooks تلقائيًا.', 'المساهمة في تنفيذ الميزات ومراجعة Pull Requests.']],
            'Finteck' => ['position' => 'متدرب تطوير Backend', 'description' => 'برنامج مكثف لمدة 3 أشهر • المنصورة', 'highlights' => ['برنامج تدريبي مكثف لمدة 3 أشهر في PHP وLaravel الحديث.', 'إتقان تصميم قواعد البيانات العلائقية والقيود والفهارس في MySQL.', 'بناء RESTful APIs عملية مع مصادقة بالـTokens والتحقق الآمن من المدخلات.', 'تطبيق سير العمل باستخدام Git وGitHub بشكل تعاوني.']],
        ];
        foreach ($experiences as $company => $translations) {
            $experience = Experience::query()->where('company', $company)->first();
            if ($experience) {
                $this->setArabic($experience, $translations);
            }
        }

        $projects = [
            'awfar' => ['badge' => 'معمارية نظيفة • Repository Pattern • State Machine', 'short_description' => 'API للتجارة الإلكترونية والتوصيل', 'full_description' => 'API للمنتجات والسلال والطلبات والتوصيل، مع وضع قواعد الطلبات وتغييرات البيانات في مكان واضح ومتماسك.', 'case_study' => ['problem' => 'تعاني أنظمة التجارة الإلكترونية من Controllers متضخمة، وترابط قوي بين ORM وطبقة HTTP، ومشاكل التزامن، وسجل طلبات غير موثوق.', 'solution' => 'بناء Laravel API مفصول باستخدام Repository Pattern وContracts وService Layer مستقل وPHP Enums وSnapshots للطلبات.', 'architecture' => 'Controllers ← Service Layer ← Repository Contracts ← عمليات قاعدة بيانات داخل معاملات.', 'keyFeatures' => ['Repository Contracts', 'آلة حالات للطلبات باستخدام Enums', 'تحديث ذري للمخزون', 'Snapshots غير قابلة للتغيير للعناوين', 'نظام نقاط الولاء', 'واجهات متعددة الأدوار', 'مصادقة Sanctum مع OTP']]],
            'civicfix' => ['badge' => 'Laravel API • React 18 • Vite • سجل تدقيق • تحليلات', 'short_description' => 'الإبلاغ عن مشكلات المدن ومتابعتها', 'full_description' => 'Laravel API وواجهة React لإرسال مشكلات الأماكن العامة وتوزيعها على الفنيين وحفظ تاريخ ما حدث لكل بلاغ.', 'case_study' => ['problem' => 'تواجه الجهات المحلية شكاوى غير منظمة، وضعفًا في المتابعة الشفافة، وضياع المرفقات، وصعوبة توزيع الفنيين.', 'solution' => 'هندسة Laravel API مؤمنة مع React 18/Vite وعمليات تعتمد على الأدوار ولوحات متابعة وسجل تدقيق تلقائي.', 'architecture' => 'REST API في Laravel محمي بـSanctum وMiddleware للأدوار وتستهلكه واجهة React.', 'keyFeatures' => ['إرسال بلاغات المواطنين', 'صلاحيات حسب الدور', 'سجل تاريخي للتعديلات', 'تحليلات عامة', 'توزيع البلاغات على الفنيين', 'واجهة React متجاوبة']]],
            'clinic-booking' => ['badge' => 'التحكم في التزامن • lockForUpdate • Next.js • Sanctum', 'short_description' => 'حجز المواعيد مع قفل المواعيد', 'full_description' => 'نظام حجز عيادات ينشر فيه الأطباء مواعيدهم ويحجز المرضى الفترات المتاحة، مع منع حجز نفس الفترة مرتين.', 'case_study' => ['problem' => 'قد تؤدي طلبات الحجز المتزامنة لنفس الموعد إلى Race Conditions وحجز مزدوج.', 'solution' => 'تنفيذ قفل تشاؤمي على مستوى قاعدة البيانات باستخدام المعاملات وlockForUpdate.', 'architecture' => 'Laravel REST API مع Controllers وواجهة Next.js/TypeScript.', 'keyFeatures' => ['قفل تشاؤمي', 'مزامنة حالات المواعيد', 'إعادة التحقق عند إعادة التفعيل', 'صلاحيات على مستوى الصفوف', 'مولد أوقات التوافر', 'واجهة Next.js وTypeScript']]],
            'alamaal' => ['badge' => 'Laravel 11 • MyFatoorah • سير علاج • OTP • CMS', 'short_description' => 'خدمات تأهيل ومدفوعات إلكترونية', 'full_description' => 'منصة Laravel تربط العائلات بالمتخصصين، وتدير الطلبات والمدفوعات، وتمنح الفريق أدوات لإدارة الخطط العلاجية ومحتوى الموقع.', 'case_study' => ['problem' => 'تحتاج العائلات لاستشارات مخصصة وخطط علاج منظمة ومدفوعات آمنة وتواصل مع المتخصصين.', 'solution' => 'بناء منصة Laravel متعددة الأدوار لمتابعة التأهيل وCallbacks الدفع وتسليم الخطط العلاجية واستعادة الحساب عبر OTP.', 'architecture' => 'Laravel MVC متكامل مع Blade وAlpine.js وTailwind ولوحة إدارة ومعالجات بوابة الدفع.', 'keyFeatures' => ['تكامل MyFatoorah', 'سجل ملفات الأطفال', 'سير الخطط العلاجية', 'بوابات تحكم في الظهور', 'استعادة كلمة المرور عبر OTP', 'حساب الكوبونات', 'لوحة CMS']]],
            'ezzhal' => ['badge' => 'Laravel 13 • Blade • CMS • مكتبة الوسائط', 'short_description' => 'موقع توصيل مياه ولوحة إدارة محتوى', 'full_description' => 'موقع Laravel ثنائي اللغة لخدمة توصيل المياه، مع لوحة تحكم لإدارة المحتوى العام دون تعديل الكود.', 'case_study' => ['problem' => 'يحتاج موقع الخدمة لتغيير البنرات والميزات والأسئلة والتقييمات وبيانات التواصل دون انتظار إصدار برمجي.', 'solution' => 'بناء تطبيق Laravel بموقع عام Server-rendered ولوحة مصادقة لإدارة المحتوى العام.', 'architecture' => 'Laravel MVC مع Blade وEloquent وSession Authentication وForm Requests وVite ورفع الوسائط.', 'keyFeatures' => ['محتوى عربي وإنجليزي', 'موارد محتوى من لوحة التحكم', 'رفع واستبدال الصور', 'حالات التفعيل والترتيب', 'نموذج تواصل متحقق منه', 'صفحة رئيسية مبنية من قاعدة البيانات']]],
            'dentcare' => ['badge' => 'Laravel 13 • MySQL • Service + Repository • Sanctum', 'short_description' => 'نظام إدارة عيادة أسنان', 'full_description' => 'منصة متكاملة لإدارة محتوى العيادة والأطباء والمواعيد والجداول وتقييمات المرضى وعمليات الحجز من نظام إداري واحد.', 'case_study' => ['problem' => 'تحتاج عيادات الأسنان لمساحة موحدة لإدارة المحتوى والأطباء والمواعيد وتواصل المرضى وإعدادات العيادة.', 'solution' => 'بناء نظام Laravel بإدارة CMS وتدفقات عمل حسب الأدوار وحجز يعتمد على Services وقواعد عيادة محفوظة.', 'architecture' => 'Laravel MVC مع Blade وEloquent وService Layer وRepository Contracts وForm Requests وAPI Resources وSanctum.', 'keyFeatures' => ['لوحة CMS', 'إدارة الأطباء', 'حجز المواعيد والجداول', 'مراجعة تقييمات المرضى', 'مدونة وأسئلة شائعة ومعرض وإعدادات العيادة', 'REST API محمي بـSanctum']]],
        ];
        foreach ($projects as $slug => $translations) {
            $project = Project::query()->where('slug', $slug)->first();
            if ($project) {
                $this->setArabic($project, $translations);
            }
        }

        foreach ([
            'meta_title' => 'إبراهيم علاء — مطور Backend',
            'meta_description' => 'إبراهيم علاء مطور Backend يعمل باستخدام PHP وLaravel وMySQL وREST APIs.',
            'og_title' => 'إبراهيم علاء — مطور Backend | PHP وLaravel',
            'og_description' => 'استكشف دراسات حالة حقيقية في Laravel ومعمارية نظيفة وحلول لمشكلات التزامن وقواعد البيانات.',
            'footer_text' => 'تم البناء باستخدام HTML دلالي وCSS وLaravel وMySQL.',
        ] as $key => $value) {
            $setting = SiteSetting::query()->where('key', $key)->first();
            if ($setting) {
                $this->setArabic($setting, ['value' => $value]);
            }
        }
    }

    private function setArabic(Model $model, array $translations): void
    {
        $current = $model->translations ?? [];
        $model->update(['translations' => array_replace_recursive($current, ['ar' => $translations])]);
    }
}
