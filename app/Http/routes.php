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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/layout', function () {
    return view('layout/layout');
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
    Route::resource('emails', 'EmailsController'); // in emails module, for CRUD
    Route::get('/', ['as' => 'home', 'uses' => 'EmailsController@inbox']); // in emails module, for CRUD
    Route::get('/readmail/{id}', 'EmailsController@fetchmail'); // in emails module, for CRUD
    Route::get('/readmails', 'MailController@readmails'); // in emails module, for CRUD
    Route::get('image/{id}', ['as' => 'image', 'uses' => 'MailController@get_data']); /* get image */
    Route::post('validating-email-settings', ['as' => 'validating.email.settings', 'uses' => 'EmailsController@validatingEmailSettings']);
    Route::get('/diagnos-email', ['as' => 'diag.email', 'uses' => 'DiagnosticController@getDiag']);
    Route::post('/diagnos-email-post', ['as' => 'post.diag.email', 'uses' => 'DiagnosticController@postDiag']);
});

Route::PUT('validating-email-settings-on-update/{id}', ['as' => 'validating.email.settings.update', 'uses' => 'EmailsController@validatingEmailSettingsUpdate']); // route to check email input validation

/*
  |=============================================================
  |  View all the Routes
  |=============================================================
 */
//Route::get('/aaa', function () {
//    $routeCollection = Route::getRoutes();
//    echo "<table style='width:100%'>";
//    echo '<tr>';
//    echo "<td width='10%'><h4>HTTP Method</h4></td>";
//    echo "<td width='10%'><h4>Route</h4></td>";
//    echo "<td width='10%'><h4>Url</h4></td>";
//    echo "<td width='80%'><h4>Corresponding Action</h4></td>";
//    echo '</tr>';
//    foreach ($routeCollection as $value) {
//        echo '<tr>';
//        echo '<td>' . $value->getMethods()[0] . '</td>';
//        echo '<td>' . $value->getName() . '</td>';
//        echo '<td>' . $value->getPath() . '</td>';
//        echo '<td>' . $value->getActionName() . '</td>';
//        echo '</tr>';
//    }
//    echo '</table>';
//});
