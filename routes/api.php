<?php

use App\Http\Controllers\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/statistics', [StatisticsController::class, 'index']);
Route::get('/customers', [StatisticsController::class, 'customers']);
Route::get('/clients', [StatisticsController::class, 'clients']);
Route::get('/jobs', [StatisticsController::class, 'jobs']);

Route::middleware('auth:sanctum')->group(function () {
});
