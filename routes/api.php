<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::get('/healthcheck', function (Request $request) {
    return response()->json(
        ['healthcheck' => 'OK'],
        200
    );
});


// TASKS
Route::group(
    [
        'middleware' => [
            'auth:sanctum',
            // 'isAdmin'
        ]
    ],
    function () {
        Route::post('/tasks', [TaskController::class, 'createTask']);
        Route::get('/tasks', [TaskController::class, 'getAllTasksCreatedByUser']);
        Route::put('/tasks/{id}', [TaskController::class, 'updateTaskById']);
        Route::delete('/tasks/{id}', [TaskController::class, 'deleteTaskById']);
        Route::get('/get-task/{id}', [TaskController::class, 'getTaskByIdByAdmin']);
        Route::put('/attach-to-task/{id}', [TaskController::class, 'addTaskToUser']);
        Route::put('/remove-user-from-task/{id}', [TaskController::class, 'removeTaskUserAssociate']);
        Route::get('/assigned-user-tasks', [TaskController::class, 'tasksAssociateWithUser']);
        Route::get('/get-users-associated-tasks/{id}', [TaskController::class, 'getUsersAssocitedToTaskId']);
    }
);

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');

// USERS
Route::get('users', [UserController::class, 'getAllUsers'])->middleware(['auth:sanctum', 'isAdmin']);
