<?php

use Illuminate\Support\Facades\Route;

Use App\Models\Actions;
Use App\Models\Activity;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stats', function () {
    $action = Action::all();
    $activity = Activity::all();

    return view('stats', ['activity' => $activity, 'action' => $action]);
});
