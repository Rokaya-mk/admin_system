<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\UserController;
use App\Mail\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['namespace' => 'api', 'prefix' => 'v1'], function () {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);
  
  Route::middleware('auth:api')->group(function () {
      Route::post('logout', [AuthController::class, 'logout']);
      Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
      Route::get('searchProject', [ProjectController::class, 'searchProject']);
      Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
      Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
      Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
      Route::get('user-profile',[AuthController::class,'userProfile']);
      Route::get('userProjects/{id}', [UserController::class, 'userProjects']);
      Route::get('users', [UserController::class, 'index'])->name('users.index');
      Route::post('users', [UserController::class, 'store'])->name('users.store');
      Route::put('users/{project}', [UserController::class, 'update'])->name('users.update');
      Route::delete('users/{project}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('profile',[UserController::class,'profile']);
    Route::post('profile/passwordUpdate/{id}',[UserController::class,'updatePassword']);
      Route::get('getBarChartData/{year}', [ProjectController::class, 'getBarChartData']);
      // Notification routes
      Route::get('getUnreadNotifications', [NotificationController::class, 'getUnreadNotifications']);
      Route::get('getAllNotifications', [NotificationController::class, 'getAllNotifications']);
      Route::get('markNotificationAsRead/{id}', [NotificationController::class, 'markNotificationAsRead']);
      Route::get('clearAllNotifications', [NotificationController::class, 'clearAllNotifications']);

      
  });
});
