<?php
use App\Http\Controllers\yo_print_controller;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/YoPrint', [yo_print_controller::class, 'index']);
Route::get('/YoPrint/create', [yo_print_controller::class, 'create']);
Route::post('/YoPrint', [yo_print_controller::class, 'store']);
Route::get('/YoPrint/{id}', [yo_print_controller::class, 'show']);

