<?php

use App\Http\Controllers\Apps\DashboardController;
use App\Http\Controllers\Apps\ActivityController;
use App\Http\Controllers\Apps\CustomerContactController;
use App\Http\Controllers\Apps\CustomerController;
use App\Http\Controllers\Apps\LeadController;
use App\Http\Controllers\Apps\LeadSourceController;
use App\Http\Controllers\Apps\OpportunityController;
use App\Http\Controllers\Apps\OpportunityItemController;
use App\Http\Controllers\Apps\PermissionController;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'apps', 'as' => 'apps.' , 'middleware' => ['auth']], function(){
    // dashboard route
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    // permissions route
    Route::get('/permissions', PermissionController::class)->name('permissions.index');
    // roles route
    Route::resource('/roles', RoleController::class)->except(['create', 'edit', 'show']);
    // users route
    Route::resource('/users', UserController::class)->except('show');
    Route::resource('/customers', CustomerController::class)->except('show');
    Route::resource('/customer-contacts', CustomerContactController::class)->except('show');
    Route::resource('/lead-sources', LeadSourceController::class)->except('show');
    Route::resource('/leads', LeadController::class)->except('show');
    Route::resource('/activities', ActivityController::class)->except('show');
    Route::resource('/opportunities', OpportunityController::class)->except('show');
    Route::resource('/opportunity-items', OpportunityItemController::class)->except('show');
});

require __DIR__.'/auth.php';
