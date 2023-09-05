<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\EventController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/events', [EventController::class, 'index']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::get('/analytics/total-revenue', [AnalyticsController::class, 'totalRevenue']);
    Route::get('/analytics/total-followers-gained', [AnalyticsController::class, 'totalFollowersGained']);
    Route::get('/analytics/top-selling-items', [AnalyticsController::class, 'topSellingItems']);
});
