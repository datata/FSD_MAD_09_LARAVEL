<?php

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
    return 'Healthcheck ok';
});


// TASKS
Route::post('/tasks', function (Request $request) {
    return 'CREATE TASKS';
});

Route::get('/tasks', function (Request $request) {
    return 'GET ALL TASKS';
});

Route::put('/tasks/{id}', function(Request $request, $id) {
    return 'UPDATA TASKS: '.$id;
});

Route::delete('/tasks/{id}', function(Request $request, $id) {
    return 'UPDATA TASKS: '.$id;
});
