<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;



use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\TestController;

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
Route::get('/', function () {
    return view('welcome');
});
// Route::get('/', function () {
//     if (auth()->user()) {
//         return redirect(route('login'));
//     } else {
//         return redirect(route('dashboard'));
//     }
// });

// Route::get('signup', [RegisteredUserController::class, 'create'])->name('signup');
// Route::post('register-user', [RegisteredUserController::class, 'store'])->name('register');
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store'])->name('register');

Route::get('levels_seeder', [UserController::class, 'test']);
// =================================




Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('get-stats', [DashboardController::class, 'getStats'])->name('dashboard.getStats');

    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::get('change-password', [UserController::class, 'changePassword'])->name('users.changePassword');
    Route::post('update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');

    ############# Institution
    // Route::resource('institutions', InstitutionController::class)->only('index')->middleware('permission:Institutions List');
    // Route::resource('institutions', InstitutionController::class)->only(['create', 'store'])->middleware('permission:Create Institution');
    // Route::resource('institutions', InstitutionController::class)->only('show')->middleware('permission:View Institution|Review Institution');
    // Route::resource('institutions', InstitutionController::class)->only(['edit', 'update'])->middleware('permission:Update Institution');
    // Route::resource('institutions', InstitutionController::class)->only('destroy')->middleware('permission:Delete Institution');
    // Route::post('institutions/datatable', [InstitutionController::class, 'index'])->name('institutions.datatable')->middleware('permission:Institutions List');
    // Route::get('institutions/closed/{institution}', [InstitutionController::class, 'closed'])->name('institutions.closed')->middleware('permission:Closed Institution');
    // Route::post('institution-review', [InstitutionController::class, 'addReview'])->name('institutions.review')->middleware('permission:Review Institution');
    // Route::get('institutions/status/modal', [InstitutionController::class, 'statusModal'])->name('institutions.status.modal')->middleware('can:View Institution Status');
    // Route::get('institutions/challan/{institution}', [InstitutionController::class, 'getChallan'])->name('institutions.challan')->middleware('permission:Institution Challan');
    // Route::post('institutions/mark-paid-challan/{institution}', [InstitutionController::class, 'markPaidChallan'])->name('institutions.markPaidChallan')->middleware('permission:Institution Challan Mark Paid');
    // Route::get('institutions/certificate/{institution}', [InstitutionController::class, 'getCertificate'])->name('institutions.certificate')->middleware('permission:Institution Certificate');
    // Route::post('/institutions/renew/{institution}', [InstitutionController::class, 'renewLicense'])->name('institutions.renew')->middleware('permission:Renew Institution');

    Route::resource('users', UserController::class)->only('index')->middleware('permission:Users Index');
    Route::resource('users', UserController::class)->only(['create', 'store'])->middleware('permission:Create User');
    Route::resource('users', UserController::class)->only(['edit', 'update'])->middleware('permission:Update User');
    Route::resource('users', UserController::class)->only('destroy')->middleware('permission:Delete User');
    Route::post('users/datatable', [UserController::class, 'index'])->name('users.datatable')->middleware('permission:Users Index');
    Route::get('users/update-status/{user}', [UserController::class, 'updateStatus'])->name('users.updateStatus')->middleware('permission:Update User Status');

    ############# Roles
    Route::resource('roles', RoleController::class)->only('index')->middleware('permission:Roles List');
    Route::resource('roles', RoleController::class)->only(['create', 'store'])->middleware('permission:Create Role');
    Route::resource('roles', RoleController::class)->only(['edit', 'update'])->middleware('permission:Update Role');
    Route::resource('roles', RoleController::class)->only('destroy')->middleware('permission:Delete Role');
    Route::post('roles/datatable', [RoleController::class, 'index'])->name('roles.datatable')->middleware('permission:Roles List');
    Route::get('roles/update-status/{role}', [RoleController::class, 'updateStatus'])->name('roles.updateStatus')->middleware('permission:Update Role Status');
    Route::get('roles/permissions/{role}', [RoleController::class, 'getRolePermissions'])->name('roles.getPermissions');
    Route::post('roles/permissions/{role}', [RoleController::class, 'updateRolePermission'])->name('roles.permissions');

    ############## Permissions
    Route::resource('permissions', PermissionController::class)->only('index')->middleware('permission:Permissions List');
    Route::resource('permissions', PermissionController::class)->only(['create', 'store'])->middleware('permission:Create Permission');
    Route::resource('permissions', PermissionController::class)->only(['edit', 'update'])->middleware('permission:Update Permission');
    Route::resource('permissions', PermissionController::class)->only('destroy')->middleware('permission:Delete Permission');
    Route::post('permissions/datatable', [PermissionController::class, 'index'])->name('permissions.datatable')->middleware('permission:Permissions List');

    Route::resource('permission-groups', PermissionGroupController::class);
    Route::post('permission-groups-datatable', [PermissionGroupController::class, 'index'])->name('permission-groups.datatable');

    ############# Bookings
    Route::resource('bookings', BookingController::class)->only('index')->middleware('permission:Bookings List');
    Route::resource('bookings', BookingController::class)->only(['create', 'store'])->middleware('permission:Create Booking');
    Route::resource('bookings', BookingController::class)->only(['edit', 'update'])->middleware('permission:Update Booking');
    // Route::resource('bookings', BookingController::class)->only('destroy')->middleware('permission:Delete Booking');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy')->middleware('permission:Update Booking');
    Route::post('bookings/datatable', [BookingController::class, 'index'])->name('bookings.datatable')->middleware('permission:Bookings List');
    Route::get('bookings/update-status/{booking}',[BookingController::class, 'updateStatus'])->name('bookings.updateStatus')->middleware('permission:Update Booking Status');
    
    ############# Vehicles
    Route::resource('vehicles', VehicleController::class)->only('index')->middleware('permission:Vehicles List');
    Route::resource('vehicles', VehicleController::class)->only(['create', 'store'])->middleware('permission:Create Vehicle');
    Route::resource('vehicles', VehicleController::class)->only(['edit', 'update'])->middleware('permission:Update Vehicle');
    Route::resource('vehicles', VehicleController::class)->only('destroy')->middleware('permission:Delete Vehicle');
    Route::post('vehicles/datatable', [VehicleController::class, 'index'])->name('vehicles.datatable')->middleware('permission:Vehicles List');
    Route::get('vehicles/update-status/{vehicle}',[VehicleController::class, 'updateStatus'])->name('vehicles.updateStatus')->middleware('permission:Update Vehicle Status');
    
    ############# Reviews
    Route::resource('reviews', ReviewController::class)->only('index')->middleware('permission:Reviews List');
    Route::resource('reviews', ReviewController::class)->only(['create', 'store'])->middleware('permission:Create Review');
    Route::resource('reviews', ReviewController::class)->only(['edit', 'update'])->middleware('permission:Update Review');
    Route::resource('reviews', ReviewController::class)->only('destroy')->middleware('permission:Delete Review');
    Route::post('reviews/datatable', [ReviewController::class, 'index'])->name('reviews.datatable')->middleware('permission:Reviews List');
    Route::get('reviews/update-status/{review}',[ReviewController::class, 'updateStatus'])->name('reviews.updateStatus')->middleware('permission:Update Review Status');
});

Route::post('refresh-captcha', [UserController::class, 'refreshCaptcha'])->name('refresh-captcha');


// images
// Route::get('uploads/documents/{foldername}/{filename}', [StorageController::class, 'show'])->name('document.file');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    echo 'Cache Cleared';
});

Route::get('test', [TestController::class, 'index']);
require __DIR__ . '/auth.php';
