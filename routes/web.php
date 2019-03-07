<?php

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

Route::view('/', 'landing');
Route::get('/teacher_dashboard', 'TeacherDashboardController@index');

Route::match(['get', 'post'], '/login', function(){
    return redirect()->to('/login/microsoft');
});

Route::view('/examples/plugin', 'examples.plugin');
Route::view('/examples/blank', 'examples.blank');
