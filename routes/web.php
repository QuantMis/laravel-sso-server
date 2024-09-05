<?php

use App\Http\Controllers\HandleClietController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/client', [HandleClietController::class, 'index'])->name('client.index');
    //getAllClient
    Route::get('/client/list', [HandleClietController::class, 'getAllClient'])->name('client.list');
    //add client
    Route::get('/client/add', [HandleClietController::class, 'create'])->name('client.create');
    Route::post('/client', [HandleClietController::class, 'store'])->name('client.store');
    //edit client
    Route::get('/client/edit/{client_id}/{user_id}', [HandleClietController::class, 'edit'])->name('client.edit');
    Route::put('/client/edit/{client_id}/{user_id}', [HandleClietController::class, 'update'])->name('client.update');
    //delete client
    Route::delete('/client/destroy/{client_id}/{user_id}', [HandleClietController::class, 'destroy'])->name('client.destroy');


    //User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    //getAlluser
    Route::get('/user/list', [UserController::class, 'getAllUser'])->name('user.list');

});
