<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superadmin\SuperAdminController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckBookingController;

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
## home page
Route::get('/', function () {
    return view('frontend.index');
});
Route::get('/about', function () {
    return view('frontend.about');
});
Route::get('/destinations', function () {
    return view('frontend.destinations');
});
Route::get('/trvel-insights', function () {
    return view('frontend.trvel-insights');
});
Route::get('/contact', function () {
    return view('frontend.contact');
});

Route::get('/checkbooking', function () {
    return view('frontend.checkbookingstatus');
});
Route::post('/check-booking-status', [CheckBookingController::class, 'checkBookingStatus'])->name('check.booking.status');

## super admin login
Route::controller(SuperAdminController::class)->group(function() {
        
    Route::get('superadmin/', 'superadminlogin')->name('superadminlogin');
    Route::post('superadmin/authenticate', 'superadminauthenticate')->name('superadminauthenticate');
    Route::get('superadmin/dashboard', 'dashboard')->name('dashboard');
    Route::post('superadmin/logout', 'superadminlogout')->name('superadminlogout');
});


##super admin routes
Route::prefix('superadmin')->middleware(['superadmin'])->group(function () {
    Route::controller(SuperAdminController::class)->group(function() {
        
        Route::get('superadmin/dashboard', 'dashboard')->name('dashboard');
    });
    Route::get('/addadmin', [SuperAdminController::class, 'addadmin']);
    Route::post('/saveadmin', [SuperAdminController::class, 'saveadmin']);
    Route::get('/editadmin/{id}', [SuperAdminController::class, 'editadmin'])->name('editadmin');
    Route::post('/update/{id}', [SuperAdminController::class, 'update'])->name('update');
    Route::get('/dltadmin/{id}', [SuperAdminController::class, 'dltadmin'])->name('dltadmin');

    Route::get('/adminlist', [SuperAdminController::class, 'adminlist']);

    Route::get('/doctorlist', [SuperAdminController::class, 'doctorlist']);
    Route::get('/doctors-accompanies', [SuperAdminController::class, 'listAllDoctorsAndAccompanies'])->name('doctors.accompanies.list');
     Route::get('/staffs-meal', [SuperAdminController::class, 'listAllstaffs'])->name('listAllstaffs');
     Route::get('/meals-list', [SuperAdminController::class, 'listMeals'])->name('meals.list');
    Route::get('/doctorregistration', [SuperAdminController::class, 'doctorregistration']);
    Route::post('/savedoctor', [SuperAdminController::class, 'savedoctor']);
    Route::get('/dltdoctor/{id}', [SuperAdminController::class, 'dltdoctor'])->name('doctor.deactivate');

});


## admins start here
Route::controller(AdminController::class)->group(function() {
        
    Route::get('/admin', 'adminlogin')->name('adminlogin');
    Route::post('admin/authenticate', 'adminauthenticate')->name('adminauthenticate');
    Route::post('admin/logout', 'adminlogout')->name('adminlogout');

});
## admin routes
Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::controller(AdminController::class)->group(function() {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
       
        Route::get('/submit-data', 'showSubmitData')->name('admin.submit-data');

    // Route to save user data after form submission
    Route::post('/save-user-data', 'saveUserData')->name('admin.save-user-data');
    
    });
    Route::get('/all-contacts', [AdminController::class, 'contactList'])->name('admin.contact-list');
    
    Route::get('/all-bookings', [BookingController::class, 'bookingList'])->name('admin.booking-list');
    Route::post('/bookings', [BookingController::class, 'store'])->name('admin.booking.store');
    Route::get('/booking/edit/{id}', [BookingController::class, 'edit'])->name('admin.booking.edit');
    Route::post('/booking/update/{id}', [BookingController::class, 'update'])->name('admin.booking.update');
    
 
    
});
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


