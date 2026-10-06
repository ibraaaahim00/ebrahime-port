<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/projects/{project:slug}', [PortfolioController::class, 'project'])->name('projects.show');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/language/{locale}', [LocaleController::class, 'update'])->whereIn('locale', ['en', 'ar'])->name('locale.switch');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact')->name('contact.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('projects', AdminProjectController::class)->except(['show']);
    Route::post('projects/{project}/toggle/{attribute}', [AdminProjectController::class, 'toggle'])->name('projects.toggle');

    foreach (['categories', 'technologies', 'skills', 'experiences', 'education', 'services', 'testimonials', 'pillars'] as $resource) {
        Route::get($resource, [ResourceController::class, 'index'])->defaults('resource', $resource)->name($resource.'.index');
        Route::get($resource.'/create', [ResourceController::class, 'create'])->defaults('resource', $resource)->name($resource.'.create');
        Route::post($resource, [ResourceController::class, 'store'])->defaults('resource', $resource)->name($resource.'.store');
        Route::get($resource.'/{item}/edit', [ResourceController::class, 'edit'])->defaults('resource', $resource)->name($resource.'.edit');
        Route::put($resource.'/{item}', [ResourceController::class, 'update'])->defaults('resource', $resource)->name($resource.'.update');
        Route::delete($resource.'/{item}', [ResourceController::class, 'destroy'])->defaults('resource', $resource)->name($resource.'.destroy');
    }

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('account', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('account', [AccountController::class, 'update'])->name('account.update');
    Route::get('sections', [SectionController::class, 'index'])->name('sections.index');
    Route::put('sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    Route::post('sections/{section}/toggle', [SectionController::class, 'toggle'])->name('sections.toggle');
    Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('messages/{message}/read', [MessageController::class, 'read'])->name('messages.read');
    Route::post('messages/{message}/archive', [MessageController::class, 'archive'])->name('messages.archive');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});
