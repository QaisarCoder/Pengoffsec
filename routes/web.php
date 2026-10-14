<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);


Route::get('/services', function () {
    return view('services');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/work', [CaseStudyController::class, 'index']);
Route::get('/work/{caseStudy:slug}', [CaseStudyController::class, 'show'])->name('work.show');

Route::get('/contact', [ContactController::class, 'show']);
Route::post('/contact', [ContactController::class, 'submit']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    // Only register the methods these controllers actually implement, so
    // missing methods 404 instead of throwing a 500.
    Route::resource('work', App\Http\Controllers\Admin\CaseStudyController::class, [
        'as' => 'admin',
        'parameters' => ['work' => 'caseStudy'],
        'only' => ['index', 'create', 'store', 'edit', 'update', 'destroy'],
    ]);
    Route::resource('leads', App\Http\Controllers\Admin\LeadController::class, ['as' => 'admin', 'only' => ['index']]);
    Route::patch('/leads/{lead}/status', [App\Http\Controllers\Admin\LeadController::class, 'updateStatus'])->name('admin.leads.update-status');
    
    // New CMS Routes
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class, [
        'as' => 'admin',
        'only' => ['index', 'create', 'store', 'edit', 'update', 'destroy'],
    ]);
    Route::patch('/services/{service}/toggle-active', [App\Http\Controllers\Admin\ServiceController::class, 'toggleActive'])->name('admin.services.toggle');
    // The hero is a singleton edited in place, so only index/update are real.
    // A full resource would register create/show/edit/destroy routes pointing at
    // methods that do not exist, which surfaces as a 500 rather than a 404.
    Route::get('/hero', [App\Http\Controllers\Admin\HomepageController::class, 'index'])->name('admin.hero.index');
    Route::put('/hero', [App\Http\Controllers\Admin\HomepageController::class, 'update'])->name('admin.hero.update');
    
    // AI assistant bookings (written by AIAssistantController to `appointments`)
    Route::get('/ai-leads', [App\Http\Controllers\Admin\AILeadController::class, 'index'])->name('admin.ai-leads.index');
    Route::patch('/ai-leads/{appointment}/status', [App\Http\Controllers\Admin\AILeadController::class, 'updateStatus'])->name('admin.ai-leads.update-status');
});

Route::get('/process', function () {
    return view('process');
});

// AI assistant routes (Outside admin group)
Route::post('/api/ai/chat', [App\Http\Controllers\AIAssistantController::class, 'chat'])
    ->middleware('throttle:ai_chat')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

require __DIR__.'/auth.php';
