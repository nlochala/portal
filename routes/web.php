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
Route::get('/dashboard', function () {
    if ($uuid = auth()->user()->uuid) {
        return redirect()->to('teacher_dashboard/'.$uuid);
    }
});

Route::match(['get', 'post'], '/login', function () {
    return redirect()->to('/login/microsoft');
});

Route::get('download_file/{file}', 'MediaController@downloadFile');
Route::post('api/store_file', 'MediaController@store');

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
| ADDRESS
|--------------------------------------------------------------------------
*/
//Profile Edit

//Profile Destroy
Route::get('address/{address}/profile/delete', 'AddressController@profileDestroy');

/*
|--------------------------------------------------------------------------
| PHONE
|--------------------------------------------------------------------------
*/
//Profile Destroy
Route::get('phone/{phone}/profile/delete', 'PhoneController@profileDestroy');

/*
|--------------------------------------------------------------------------
| PASSPORT
|--------------------------------------------------------------------------
*/
Route::get('passport/{passport}/cancel', 'PassportController@cancel');
Route::get('passport/{passport}/delete', 'PassportController@delete');

/*
|--------------------------------------------------------------------------
| VISA
|--------------------------------------------------------------------------
*/
Route::get('visa/{visa}/cancel', 'VisaController@cancel');
Route::get('visa/{visa}/delete', 'VisaController@delete');

/*
|--------------------------------------------------------------------------
| ID CARDS
|--------------------------------------------------------------------------
*/
Route::get('id_card/{id_card}/cancel', 'IdCardController@cancel');
Route::get('id_card/{id_card}/delete', 'IdCardController@delete');

/*
|--------------------------------------------------------------------------
| ADDRESS
|--------------------------------------------------------------------------
*/
Route::get('address/{address}/delete', 'AddressController@delete');

/*
|--------------------------------------------------------------------------
| EMPLOYEE
|--------------------------------------------------------------------------
*/
//Overview
Route::get('employee/{employee}/profile', 'EmployeeProfileController@profile');
Route::patch('employee/{employee}/profile', 'EmployeeProfileController@updateProfile');
Route::post('employee/{employee}/profile', 'EmployeeProfileController@updateProfile');

//Contact Information
Route::get('employee/{employee}/contact', 'EmployeeContactController@contact');
Route::post('employee/{employee}/profile/store_phone', 'EmployeeContactController@storePhone');
Route::post('employee/{employee}/profile/store_address', 'EmployeeContactController@storeAddress');
Route::patch('employee/{employee}/profile/store_email', 'EmployeeContactController@storeEmail');
Route::patch('employee/{employee}/address/{address}/update_address', 'EmployeeContactController@updateAddress');

//Passports and Visas
Route::get('employee/{employee}/passports_visas', 'EmployeePassportVisaController@passportVisa');
Route::get('employee/{employee}/create_passport', 'EmployeePassportVisaController@createPassport');
Route::post('employee/{employee}/create_passport', 'EmployeePassportVisaController@storePassport');
Route::post('employee/{employee}/passport/{passport}/create_visa', 'EmployeePassportVisaController@storeVisa');
Route::patch('employee/{employee}/visa/{visa}/update_visa', 'EmployeePassportVisaController@updateVisa');
Route::patch('employee/{employee}/passport/{passport}/update_passport', 'EmployeePassportVisaController@updatePassport');
Route::get('employee/{employee}/passport/{passport}/update_passport', 'EmployeePassportVisaController@updatePassportForm');

//ID Cards
Route::get('employee/{employee}/id_card', 'EmployeeIdCardController@idCard');
Route::get('employee/{employee}/create_id_card', 'EmployeeIdCardController@createForm');
Route::post('employee/{employee}/create_id_card', 'EmployeeIdCardController@store');
Route::get('employee/{employee}/id_card/{id_card}/update_id_card', 'EmployeeIdCardController@editForm');
Route::patch('employee/{employee}/id_card/{id_card}/update_id_card', 'EmployeeIdCardController@update');

//Official Documents
Route::get('employee/{employee}/official_documents', 'EmployeeOfficialDocumentsController@officialDocuments');
Route::post('employee/{employee}/official_documents', 'EmployeeOfficialDocumentsController@store');
Route::post('employee/{employee}/official_documents', 'EmployeeOfficialDocumentsController@store');
Route::get('employee/{employee}/official_documents/{document}/delete', 'EmployeeOfficialDocumentsController@delete');

//Employment Details
Route::get('employee/{employee}/position', 'EmployeeController@position');

/*
|--------------------------------------------------------------------------
| PERSON
|--------------------------------------------------------------------------
*/
//Create
Route::get('person/create', 'PersonController@create');
Route::post('person/create', 'PersonController@store');
//Edit
Route::get('person/{file}/edit', 'PersonController@edit');
Route::patch('person/{file}', 'PersonController@update');
//Delete
Route::get('person/{file}/delete', 'PersonController@destroy');
//View
Route::get('person/{file}', 'PersonController@show');
//Index
Route::get('person', 'PersonController@index');
