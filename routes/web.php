<?php

use Illuminate\Support\Facades\Route;
use App\Facade\SiteSetting;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
*/
Artisan::call('view:clear');


Route::group(
    [
        'middleware' => 'guest',
    ], function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authUser'])->name('user-login');
});
Route::group(
    [
        'middleware' => 'auth',
    ], function () {
    Route::get('/logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return redirect(\route('login'));
    })->name('logout');

    Route::get('/calendar', [\App\Http\Controllers\CalendarController::class, 'index'])->name('calendar');
    Route::get('/archive-applications', [\App\Http\Controllers\ApplicationController::class, 'archive'])->name('archive_applications');

    Route::post('/application-active', [\App\Http\Controllers\ApplicationController::class, 'active'])->name('application_active');
    Route::post('/application-deactive', [\App\Http\Controllers\ApplicationController::class, 'deActive'])->name('application_deactive');
    Route::post('/application-archive', [\App\Http\Controllers\ApplicationController::class, 'archiveAction'])->name('archive_action');
    Route::post('/application-remove', [\App\Http\Controllers\ApplicationController::class, 'remove'])->name('archive_remove');
    Route::post('/application-restore', [\App\Http\Controllers\ApplicationController::class, 'restore'])->name('archive_restore');
    Route::post('/agent-add', [\App\Http\Controllers\ApplicationController::class, 'agentAdd'])->name('agent_add');
    Route::post('/events-add', [\App\Http\Controllers\ApplicationController::class, 'eventAdd'])->name('event_add');


    Route::get('/', function () {
        return redirect(\route('events.index'));
    })->name('home');
    Route::post('update-event', [\App\Http\Controllers\EventController::class, 'updateElement'])->name('update-event');
    Route::post('delete-items', [\App\Http\Controllers\GeneralController::class, 'deleteElements'])->name('delete-items');
    Route::resources([
        'events' => App\Http\Controllers\EventController::class,
        'applications' => App\Http\Controllers\ApplicationController::class,
        'customers' => App\Http\Controllers\CustomerController::class,
        'platforms' => App\Http\Controllers\PlatformController::class,

    ], ['except' => 'show']);


    Route::group(
        [
            'namespace' => 'App\Http\Controllers\Admin',
            'middleware' => 'admin',
        ], function () {
        Route::resources([
             'employers' => EmployerController::class,
             'archive' => ArchiveController::class,
        ], ['except' => 'show']);
    });
});




