<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Use App\Models\Actions;
Use App\Models\Activity;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::post('/start-activity', function (Request $request) {
    // send push notification to slack to update status

});

Route::post('/stop-activity', function (Request $request) {
    // store stats in database
    Activity::create([
        'activity' => $request->activity,
        'duration' => $request->duration,
        'duration_measurement' => $request->duration_measurement,
        'description' => $request->description
    ]);

    // take off status in slack?
});


Route::post('/action', function (Request $request) {
    // store stats in database
    Action::create([
        'action' => $request->action,
        'description' => $request->description,
    ]);
});

