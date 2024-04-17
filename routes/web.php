<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', [FormController::class, 'index'])->name('home');
Route::post('/', [FormController::class, 'submit']);

Route::get('/dashboard', function () {
    return view('dashboard', [
        "users" => User::where('admin', 0)->get()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/toggle-user/{user}', [UserController::class, 'toggleStatus'])->name('user-toggle');
});

require __DIR__.'/auth.php';
