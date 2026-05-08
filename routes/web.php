<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

// ─── SEO ────────────────────────────────────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/fix-storage', function () {
    // We use the absolute path from your error message
    $target = '/home/u276054823/domains/midlandproperti.id/midland_web/Midland/storage/app/public';
    $shortcut = '/home/u276054823/domains/midlandproperti.id/public_html/storage';

    // 1. Ensure the target directory actually exists
    if (!file_exists($target)) {
        mkdir($target, 0775, true);
    }

    // 2. If a file/folder/link already exists at the shortcut location, remove it
    // symlink() will fail if something is already there.
    if (file_exists($shortcut) || is_link($shortcut)) {
        // If it's a directory, we need to delete it or rename it
        if (is_dir($shortcut) && !is_link($shortcut)) {
            rename($shortcut, $shortcut . '_backup_' . time());
        } else {
            unlink($shortcut);
        }
    }

    // 3. Create the link
    if (symlink($target, $shortcut)) {
        return 'Storage link created successfully!';
    } else {
        return 'Link creation failed. Check if symlink function is enabled in hPanel PHP Options.';
    }
});
// ─── Public Website ────────────────────────────────────────────────────────
Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('/project', [FrontController::class, 'project'])->name('project');
Route::get('/project/{slug}', [FrontController::class, 'projectShow'])->name('project.show');
Route::get('/property/{slug}', [FrontController::class, 'propertyShow'])->name('property.show');
Route::get('/gallery', [FrontController::class, 'gallery'])->name('gallery');
Route::get('/articles', [FrontController::class, 'articles'])->name('articles');
Route::get('/articles/{slug}', [FrontController::class, 'articleShow'])->name('articles.show');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
Route::get('/karir', [FrontController::class, 'karir'])->name('karir');
Route::get('/simulasi-cicilan', [FrontController::class, 'simulasiCicilan'])->name('simulasi-cicilan');
Route::get('/simulasi-cicilan/recommend', [FrontController::class, 'simulasiRecommend'])->name('simulasi-cicilan.recommend');
Route::post('/simulasi-cicilan/lead', [FrontController::class, 'simulasiStoreLead'])->name('simulasi-cicilan.lead');
Route::get('/chat', [ChatController::class, 'index'])->name('chat');
Route::post('/api/chat/send', [ChatController::class, 'send'])->name('chat.send')->middleware('throttle:chat');
Route::get('/api/chat/history', [ChatController::class, 'history'])->name('chat.history');

// ─── Admin Auth ────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Settings (menu labels + site info)
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Pages content
        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{slug}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{slug}', [PageController::class, 'update'])->name('pages.update');

        // Projects CRUD
        Route::post('projects/reorder', [ProjectController::class, 'reorder'])->name('projects.reorder');
        Route::resource('projects', ProjectController::class)->names('projects');

        // Properties CRUD (nested under projects)
        Route::get('/projects/{projectSlug}/properties', [PropertyController::class, 'index'])->name('properties.index');
        Route::get('/projects/{projectSlug}/properties/create', [PropertyController::class, 'create'])->name('properties.create');
        Route::post('/projects/{projectSlug}/properties', [PropertyController::class, 'store'])->name('properties.store');
        Route::get('/projects/{projectSlug}/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::put('/projects/{projectSlug}/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/projects/{projectSlug}/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

        // Gallery CRUD
        Route::resource('galleries', GalleryController::class)->names('galleries');

        // Organization CRUD
        Route::resource('organizations', OrganizationController::class)->names('organizations');

        // Articles CRUD
        Route::resource('articles', ArticleController::class)->names('articles');

        // Leads (Simulasi Cicilan)
        Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
        Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');

        // Testimonials CRUD
        Route::resource('testimonials', TestimonialController::class)->names('testimonials');

        // Careers CRUD
        Route::resource('careers', CareerController::class)->names('careers');
    });
});
