<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Import patient controller
use App\Http\Controllers\PatientController;
// Import patient controller
use App\Http\Controllers\AuthController;

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


Route::middleware(['auth:sanctum'])->group(function (){
    # Get All Patients
    Route::get("/patients", [PatientController::class, 'index']);

    # Add Resource
    Route::post('/patients', [PatientController::class, 'store']);

    # Get Detail Resource
    Route::get('/patients/{id}', [PatientController::class, 'show']);

    # Update Resource
    Route::put('/patients/{id}', [PatientController::class, 'update']);

    # Delete Resource
    Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

    # Search By Name
    Route::get('/patients/search/{name}', [PatientController::class, 'search']);

    # Search By Status
    Route::get('/patients/status/{status}', [PatientController::class, 'search_by_status']);

});

# User Registration Authentication
Route::post('/register', [AuthController::class, 'register']);

# Login User 
Route::post('/login', [AuthController::class, 'login']);