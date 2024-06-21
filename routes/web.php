<?php

use Illuminate\Support\Facades\Route;
use App\Models\Game;

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

// Route::get('/games', function () {
//     $games = Game::all();

//     // dd($game);
//     return view('games', ['games' => $games]);

// });



