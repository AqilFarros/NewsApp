<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Frontend\FrontendController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontendController::class, 'index']);
Route::get('/detail/news/{slug}', [FrontendController::class, 'detailNews'])->name('detail-news');
Route::get('/detail/category/{slug}', [FrontendController::class, 'detailCategory'])->name('detail-category');

Auth::routes();

// Route::match(['get', 'post'], '/register', function() {
//     return redirect('/login');
// });

// Route Middleware
Route::middleware('auth')->group(function() {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/changepassword', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    Route::get('/create-profile', [ProfileController::class, 'createProfile'])->name('create-profile');
    Route::post('/store-profile', [ProfileController::class, 'storeProfile'])->name('store-profile');

    // Route for admin 
    Route::middleware(['auth', 'admin'])->group(function() {
        Route::resource('news', NewsController::class);
        Route::resource('category', CategoryController::class)->except('show');
        Route::get('all-user', [ProfileController::class, 'allUser'])->name('all-user');
        Route::put('/reset-password/{id}', [ProfileController::class, 'resetPassword'])->name('reset-password');
        Route::get('/edit-profile', [ProfileController::class, 'editProfile'])->name('edit-profile');
        Route::put('/update-profile', [ProfileController::class, 'updateProfile'])->name('update-profile');
    });
});