<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Game;
use App\Models\Reports;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/games', function () {
    $games = Game::all();
    return response()->json($games);
});

Route::get('/games/demo', function () {
    $games = Game::where('demo', 1)
        ->inRandomOrder()
        ->get();
    return response()->json($games);
});

Route::get('/games/earlyaccess', function () {
    $games = Game::where('earlyaccess', 1)
        ->inRandomOrder()
        ->get();
    return response()->json($games);
});

Route::get('/games/recentlyreleased', function () {
    $today = date("Y-m-d");
    $games = Game::where('release_date', '<=', $today)
        ->orderBy('release_date', 'DESC')
        ->get();
    return response()->json($games);
});

Route::get('/games/comingsoon', function () {
    $today = date("Y-m-d");
    $games = Game::where('release_date', '>=', $today)
        ->orderBy('release_date', 'ASC')
        ->get();
    return response()->json($games);
});

Route::get('/games/kickstarter/upcoming', function () {
    $games = Game::where('kickstarter_status', 'Upcoming')
        ->inRandomOrder()
        ->get();
    return response()->json($games);
});

Route::get('/games/kickstarter/live', function () {
    $games = Game::where('kickstarter_status', 'Live')
        ->inRandomOrder()    
        ->get();
    return response()->json($games);
});

Route::get('/games/TBD', function () {
    $games = Game::where('release_window', 'TBD')->get();
    return response()->json($games);
});

Route::get('/games/2024', function () {
    $tomorrow = date("Y-m-d",strtotime("tomorrow"));
    $games = Game::where('release_window', 'LIKE', '%2024%')
        ->orWhereBetween('release_date', [$tomorrow,'2024-12-31'])
        ->inRandomOrder() 
        ->get();
    return response()->json($games);
});

Route::get('/games/2025', function () {
    $games = Game::where('release_window', 'LIKE', '%2025%')
        ->orWhereBetween('release_date', ['2025-01-01','2025-12-31'])
        ->inRandomOrder() 
        ->get();
    return response()->json($games);
});

Route::get('/games/2026', function () {
    $games = Game::where('release_window', 'LIKE', '%2026%')
        ->orWhereBetween('release_date', ['2026-01-01','2026-12-31'])
        ->inRandomOrder() 
        ->get();
    return response()->json($games);
});

Route::get('/games/steam', function () {
    $games = Game::where('steam', '!=', '')
        ->inRandomOrder() 
        ->get();
    return response()->json($games);
});

Route::get('/games/epic', function () {
    $games = Game::where('epic', '!=', '')
        ->inRandomOrder() 
        ->get();
    return response()->json($games);
});

Route::get('/games/gog', function () {
    $games = Game::where('gog', '!=', '')
        ->inRandomOrder() 
        ->get();
    return response()->json($games);
});

Route::get('/games/playstation', function () {
    $games = Game::where('playstation', '!=', '')
        ->inRandomOrder() 
        ->get();
    return response()->json($games);
});

Route::get('/games/xbox', function () {
    $games = Game::where('xbox', '!=', '')
        ->inRandomOrder() 
        ->get();
    return response()->json($games);
});

Route::get('/games/switch', function () {
    $games = Game::where('nintendo', '!=', '')
        ->inRandomOrder() 
        ->get();
    return response()->json($games);
});

Route::get('/games/{slug}', function ($slug) {
    $game = Game::where('slug', $slug)->first();
    if ($game) {
        return response()->json($game);
    } else {
        return response()->json(['message' => 'Entry not found'], 404);
    }
});

Route::get('/games/steamID/{steamappid}', function ($steamAppId){

    $external_api = 'https://store.steampowered.com/appreviews/' . $steamAppId . '?json=1&purchase_type=all';
    $steamReviews = Http::get($external_api);
    if ($steamReviews){
        return response()->json($steamReviews->json());
    } else {
        return response()->json(['error' => 'failed to fetch from steam api'], $steamReviews->status());
    }
});

Route::get('/report', function() {
    $reports = Reports::all();
    return response()->json($reports);
});

Route::post('/report', function (Request $request) {

    $validated = $request->validate([
        'game' => 'required|string',
        'report' => 'required|string',
        'status' => 'required|string',
    ]); 

    $report = new Reports;
    $report->game_name = $request->game;
    $report->report = $request->report;
    $report->status = $request->status; 
    $report->save();

    return response()->json("Thank you for your report!");

});