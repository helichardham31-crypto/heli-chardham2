<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Superadmin\SuperAdminController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckBookingController;

/*
| Deployment diagnostics. Reports the things that most often cause a blank
| 500 on a container host: a missing APP_KEY, unwritable storage, a missing
| PHP extension, or an unreachable database.
|
| Hidden unless DEBUG_TOKEN is set AND matched, so it is a 404 by default:
|   https://helichardham.co.in/__diagnostics?token=YOUR_TOKEN
|
| getenv() is used rather than env() so it keeps working after config:cache.
| Safe to delete once the deployment is healthy.
*/
Route::get('/__diagnostics', function () {
    $token = getenv('DEBUG_TOKEN') ?: null;
    abort_unless($token && hash_equals($token, (string) request('token')), 404);

    $writable = [];
    foreach ([
        'storage',
        'storage/logs',
        'storage/framework',
        'storage/framework/views',
        'storage/framework/cache',
        'storage/framework/sessions',
        'bootstrap/cache',
    ] as $relative) {
        $path = base_path($relative);
        $writable[$relative] = ! is_dir($path)
            ? 'MISSING'
            : (is_writable($path) ? 'ok' : 'NOT WRITABLE');
    }

    $extensions = [];
    foreach (['pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'json', 'ctype', 'fileinfo', 'gd', 'zip', 'bcmath', 'exif'] as $ext) {
        $extensions[$ext] = extension_loaded($ext) ? 'ok' : 'MISSING';
    }

    // The database is the most common failure and the one env vars get wrong.
    try {
        DB::connection()->getPdo();
        $database = [
            'status' => 'connected',
            'host' => config('database.connections.mysql.host'),
            'port' => config('database.connections.mysql.port'),
            'database' => DB::connection()->getDatabaseName(),
            'tables' => count(DB::select('SHOW TABLES')),
        ];
    } catch (\Throwable $e) {
        $database = [
            'status' => 'FAILED',
            'host' => config('database.connections.mysql.host'),
            'port' => config('database.connections.mysql.port'),
            'database' => config('database.connections.mysql.database'),
            'error' => get_class($e) . ': ' . $e->getMessage(),
        ];
    }

    // Which of the credential sources actually arrived in the container.
    $present = [];
    foreach (['DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD',
              'MYSQLHOST', 'MYSQLPORT', 'MYSQLDATABASE', 'MYSQLUSER', 'MYSQLPASSWORD',
              'MYSQL_URL', 'DATABASE_URL', 'APP_KEY', 'PORT', 'RAILWAY_ENVIRONMENT'] as $var) {
        // Report only presence - never the value.
        $present[$var] = (getenv($var) !== false && getenv($var) !== '') ? 'set' : 'not set';
    }

    return response()->json([
        'app' => [
            'php' => PHP_VERSION,
            'laravel' => app()->version(),
            'env' => config('app.env'),
            'debug' => config('app.debug'),
            'url' => config('app.url'),
            'app_key_set' => (bool) config('app.key'),
            'log_channel' => config('logging.default'),
            'session_driver' => config('session.driver'),
            'cache_driver' => config('cache.default'),
            'config_cached' => app()->configurationIsCached(),
            'routes_cached' => app()->routesAreCached(),
        ],
        'env_vars_present' => $present,
        'writable' => $writable,
        'extensions' => $extensions,
        'database' => $database,
    ], 200, [], JSON_PRETTY_PRINT);
});

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


