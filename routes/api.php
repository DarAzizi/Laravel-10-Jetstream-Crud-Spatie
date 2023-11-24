<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\UniversityController;
use App\Http\Controllers\Api\GraduationController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\UserCertificatesController;
use App\Http\Controllers\Api\CityCertificatesController;
use App\Http\Controllers\Api\CountryCertificatesController;
use App\Http\Controllers\Api\UniversityCertificatesController;
use App\Http\Controllers\Api\GraduationCertificatesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('users', UserController::class);

        // User Certificates
        Route::get('/users/{user}/certificates', [
            UserCertificatesController::class,
            'index',
        ])->name('users.certificates.index');
        Route::post('/users/{user}/certificates', [
            UserCertificatesController::class,
            'store',
        ])->name('users.certificates.store');

        Route::apiResource('countries', CountryController::class);

        // Country Certificates
        Route::get('/countries/{country}/certificates', [
            CountryCertificatesController::class,
            'index',
        ])->name('countries.certificates.index');
        Route::post('/countries/{country}/certificates', [
            CountryCertificatesController::class,
            'store',
        ])->name('countries.certificates.store');

        Route::apiResource('cities', CityController::class);

        // City Certificates
        Route::get('/cities/{city}/certificates', [
            CityCertificatesController::class,
            'index',
        ])->name('cities.certificates.index');
        Route::post('/cities/{city}/certificates', [
            CityCertificatesController::class,
            'store',
        ])->name('cities.certificates.store');

        Route::apiResource('universities', UniversityController::class);

        // University Certificates
        Route::get('/universities/{university}/certificates', [
            UniversityCertificatesController::class,
            'index',
        ])->name('universities.certificates.index');
        Route::post('/universities/{university}/certificates', [
            UniversityCertificatesController::class,
            'store',
        ])->name('universities.certificates.store');

        Route::apiResource('graduations', GraduationController::class);

        // Graduation Certificates
        Route::get('/graduations/{graduation}/certificates', [
            GraduationCertificatesController::class,
            'index',
        ])->name('graduations.certificates.index');
        Route::post('/graduations/{graduation}/certificates', [
            GraduationCertificatesController::class,
            'store',
        ])->name('graduations.certificates.store');

        Route::apiResource('certificates', CertificateController::class);

        Route::apiResource('books', BookController::class);
    });
