<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Use App\Models\Action;
Use App\Models\Activity;;
Use App\Models\User;


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
    $token = User::where('email', 'betterlife@betterlife.com')->first()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::post('/start-activity', function (Request $request) {
    // send push notification to slack to update status
    $slack_user_id = "U03E1G2NTGV";

    switch ($request->activity) {
        case "reboot":
            $status = 'Reboot Time';
            $status_emoji = ':robot_face:';
            break;
        case "volunteer":
            $status = 'volunteer';
            $status_emoji = '';
            break;
        case "walk":
            $status = 'Walking';
            $status_emoji = '';
            break;;
        case "eatting":
            $status = 'Eatting';
            $status_emoji = ':robot_face:';
            break;
        case "done":
            $status = 'Done for the day';
            $status_emoji = '';
            break;
    }

    // take off status in slack?
    Http::withHeaders([
        'Authorization' => "Bearer ".env('SLACK_APP_TOKEN'),
        'Content-Type' => 'application/json'
    ])->post(env('SLACK_URL').'/api/users.profile.set', [
        "user" => $slack_user_id,
        "profile" => ["status_text" => $status, "status_emoji" => $status_emoji, "status_expiration" => 0]
    ]);

});

Route::post('/stop-activity', function (Request $request) {
    // store stats in database
    Activity::create([
        'activity' => $request->activity,
        'duration' => $request->duration,
        'duration_measurement' => $request->duration_measurement,
        'description' => $request->description
    ]);
});


Route::post('/action', function (Request $request) {
    // store stats in database
    Action::create([
        'action' => $request->action,
        'description' => $request->description,
    ]);
});

