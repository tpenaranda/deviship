<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return 'Please use games/1 or games/2';
});
Route::get('/games', function () {
    return 'Player number is missing.';
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/games/{player}',
      ['as' => 'show_boards', 'uses' => 'GameController@showBoards']);
    Route::post('/input',
      ['as' => 'player_input', 'uses' => 'GameController@playerInput']);
});
