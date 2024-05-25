<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// ======================= Routes for all Crud operation ==================//

Route::get('/', [RegisterController::class,'index']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/check-email', [RegisterController::class, 'checkEmail']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

Route::get('/student', [StudentController::class,'index']);
Route::post('/store-student', [StudentController::class,'store']);
Route::get('/student/{id}', [StudentController::class,'show']);
Route::get('/edit-student/{id}', [StudentController::class, 'edit']);
Route::put('/update-student/{id}', [StudentController::class, 'update']);
Route::delete('/student-delete/{id}', [StudentController::class, 'destroy']);
Route::get('/inactive-student-details',[StudentController::class,'inactiveStudentId']);
Route::post('/inactive-student',[StudentController::class,'inactive']);
Route::get('/active-student-details',[StudentController::class,'activestudentId']);
Route::post('/active-student',[StudentController::class, 'active']);








