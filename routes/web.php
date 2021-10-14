<?php

use App\Http\Controllers\CharacterController;
use App\Models\Character;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function() {
    Route::get('/', [CharacterController::class, 'index'])->name('characters.index');
    Route::get('/character/{character:login}', [CharacterController::class, 'show'])->name('characters.show');
});

require __DIR__.'/auth.php';
