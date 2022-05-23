<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\EtudiantController;
use App\Http\Controllers\API\MatiereController;
use App\Http\Controllers\API\ProfesseurController;

use App\Models\Professeur;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::resource('etudiant', EtudiantController::class);
});
Route::middleware('auth:api')->group( function () {
    Route::resource('matiere', MatiereController::class);
});
Route::middleware('auth:api')->group( function () {
    Route::resource('professeur', ProfesseurController::class);
});

// Route::get('professeur/{id}', function (Request $request) {
//  $comments =   Professeur::find(1)->matieres;
// // var_dump();
// return $comments ;
// });

// Post::find(1)->comments;
