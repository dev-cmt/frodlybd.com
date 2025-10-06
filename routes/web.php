<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PageSeoController;
use App\Http\Controllers\PricingPlanController;
use App\Http\Controllers\DeveloperApiController;


Route::get('/', [HomeController::class, 'welcome'])->name('home');
// Route::get('/page/frodly', [HomeController::class, 'pageFrodly'])->name('page.frodly');
Route::get('/get/frodly', [HomeController::class, 'getFrodly'])->name('get.frodly');

// Admin dashboard
Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/change-password', [ProfileController::class, 'editPassword'])->name('password.change');
    Route::put('/change-password', [ProfileController::class, 'updatePassword'])->name('password.update');
});


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Pricing Management
    Route::get('/pricing', [PricingPlanController::class, 'index'])->name('pricing.index');
    Route::get('/pricing/create', [PricingPlanController::class, 'create'])->name('pricing.create');
    Route::post('/pricing/store', [PricingPlanController::class, 'store'])->name('pricing.store');
    Route::get('/pricing/{pricing}/edit', [PricingPlanController::class, 'edit'])->name('pricing.edit');
    Route::post('/pricing/update', [PricingPlanController::class, 'update'])->name('pricing.update');
    Route::delete('/pricing/{id}', [PricingPlanController::class, 'destroy'])->name('pricing.destroy');

    // Developer API
    Route::get('/developer-api', [DeveloperApiController::class, 'index'])->name('developer-api.index');
    Route::post('/developer-api/generate-token', [DeveloperApiController::class, 'generateToken'])->name('developer-api.generate-token');


    /**----------------------------------------------------------------------------------------------
     * ----------------------------------------------------------------------------------------------
     * BACKEND TEMPLATE
     * ----------------------------------------------------------------------------------------------
     * ----------------------------------------------------------------------------------------------
     */
    Route::resource('roles', RoleController::class);

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/settings-update', [SettingController::class, 'update'])->name('setting.update');

    // SEO settings
    Route::get('seo-pages',[PageSeoController::class,'index'])->name('settings.seo.index');
    Route::post('seo-pages/{page}',[PageSeoController::class,'update'])->name('settings.seo.update');
});

require __DIR__.'/auth.php';
