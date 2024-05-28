<?php

use App\Http\Controllers\Controller;
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

Route::get('/', [Controller::class, 'LoginPage']);
Route::post('/', [Controller::class, 'LoginLogic']);

Route::get('/register', [Controller::class, 'RegisterPage']);
Route::post('/register', [Controller::class, 'RegisterLogic']);

Route::get('/developer', [Controller::class, 'DeveloperPage']);
Route::get('/task/{id}', [Controller::class, 'ShowTaskLogic']);
Route::post('/task/{taskid}', [Controller::class, 'FinishLogic']);
Route::post('/comment/{id}', [Controller::class, 'CommentLogic']);

Route::get('/manager', [Controller::class, 'ManagerPage']);
Route::get('/add/{id}', [Controller::class, 'AddPage']);
Route::post('/add/{id}', [Controller::class, 'AddLogic']);
Route::get('/edit/{id}', [Controller::class, 'EditPage']);
Route::put('/edit/{id}', [Controller::class, 'EditLogic']);
Route::get('/delete/{id}', [Controller::class, 'DeleteLogic']);
Route::post('/store', [Controller::class, 'StoreProjectLogic']); // async
Route::get('/delete-project/{id}', [Controller::class, 'DeleteProjectLogic']); // async

Route::post('/logout', [Controller::class, 'LogoutLogic']);