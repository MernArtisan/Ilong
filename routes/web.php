<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfessionalController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return "Cache is cleared";
});

Route::name('admin.')->group(function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('authenticate');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::post('logout', [DashboardController::class, 'destroy'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('customer', UserController::class);
        Route::resource('professionals', ProfessionalController::class);
        Route::put('/update-earning-status/{id}', [ProfessionalController::class, 'updateEarningStatus'])->name('update.earning.status');
        Route::post('/user/change-status/{id}', [ProfessionalController::class, 'changeStatus'])->name('user.changeStatus');
        Route::resource('faq', FaqsController::class);
        Route::get('privacy-policy', [ContentController::class, 'privacyPolicy'])->name('privacyPolicy');
        Route::post('privacy-policy/update', [ContentController::class, 'updatePrivacyPolicy'])->name('updatePrivacyPolicy');
        Route::get('term-condition', [ContentController::class, 'termCondition'])->name('termCondition');
        Route::post('term-condition/update', [ContentController::class, 'updateTermCondition'])->name('updateTermCondition');
        Route::get('profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('profile', [AdminController::class, 'profileUpdate'])->name('profile.update');
        Route::get('/super-search', [AdminController::class, 'superSearch'])->name('super-search');
        Route::get('/get-earnings', [DashboardController::class, 'getEarnings'])->name('get-earnings');
        Route::get('app-request', [UserController::class, 'appRequest'])->name('appRequest');
        Route::get('request-show/{id}', [UserController::class, 'requestShow'])->name('requestShow');
        Route::get('contacts', [UserController::class, 'Contacts'])->name('Contacts');
        Route::get('contact/{id}', [UserController::class, 'contactShow'])->name('contactShow');
        Route::post('/send-notification', [DashboardController::class, 'sendDummyNotification']);
        Route::resource('users', SocialController::class);
    });
});
