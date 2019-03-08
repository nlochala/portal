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
Route::get('/teacher_dashboard/{id}', 'TeacherDashboardController@index');
Route::get('/dashboard', function(){
    if($id = auth()->user()->id){
        return redirect()->to('teacher_dashboard/' . $id);
    }
});

Route::match(['get', 'post'], '/login', function(){
    return redirect()->to('/login/microsoft');
});


/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
*/
Route::get('employee/lookup', 'EmployeeController@lookup');

/*
|--------------------------------------------------------------------------
| PARENTS
|--------------------------------------------------------------------------
*/
Route::get('parent/lookup', 'ParentController@lookup');


/*
|--------------------------------------------------------------------------
| STUDENTS
|--------------------------------------------------------------------------
*/
Route::get('student/lookup', 'StudentController@lookup');



/*
|--------------------------------------------------------------------------
| PERSON
|--------------------------------------------------------------------------
*/
//Create
Route::get('person/create','PersonController@create');
Route::post('person/create','PersonController@store');
//Edit
Route::get('person/{id}/edit','PersonController@edit');
Route::patch('person/{id}','PersonController@update');
//Delete
Route::get('person/{id}/delete','PersonController@destroy');
//View
Route::get('person/{id}','PersonController@show');
//Index
Route::get('person','PersonController@index');

