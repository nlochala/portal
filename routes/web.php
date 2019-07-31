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
Route::get('authenticated', 'OAuthController@login')->name('login');
Route::get('logout', 'OAuthController@logout')->name('logout');
Route::get('/', 'LandingController')->name('landing');

//TODO: Change the link location to api/download_file
Route::get('download_file/{file}', 'MediaController@downloadFile');
Route::get('api/download_file/{file}', 'MediaController@downloadFile');
Route::post('api/store_file', 'MediaController@store');

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

//Directory
Route::get('employee/index', 'EmployeeController@index');
Route::post('employee/index', 'EmployeeController@storeNewEmployee');
Route::get('api/employee/ajaxshowemployee', 'EmployeeAjaxController@ajaxShow');

//Dashboard
Route::get('employee/{employee}', 'EmployeeController@dashboard');

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
Route::get('employee/{employee}/employment_overview', 'EmployeePositionController@employmentOverview');
Route::post('employee/{employee}/employment_overview', 'EmployeePositionController@storeOverview');
Route::get('employee/{employee}/position/{position}/add', 'EmployeePositionController@addPosition');
Route::get('employee/{employee}/position/{position}/remove', 'EmployeePositionController@removePosition');
Route::get('employee/{employee}/position/view_details', 'EmployeePositionController@viewPositions');

/*
|--------------------------------------------------------------------------
| STUDENT
|--------------------------------------------------------------------------
*/
//Directory
Route::get('student/index', 'StudentController@index');
Route::post('student/index', 'StudentController@storeNewStudent');
Route::get('api/student/ajaxshowstudent', 'StudentAjaxController@ajaxShow');

//Dashboard
Route::get('student/{student}', 'StudentController@dashboard');

//Overview
Route::get('student/{student}/profile', 'StudentProfileController@profile');
Route::patch('student/{student}/profile', 'StudentProfileController@updateProfile');
Route::post('student/{student}/profile', 'StudentProfileController@updateProfile');

//Contact Information
Route::get('student/{student}/contact', 'StudentContactController@contact');
Route::post('student/{student}/profile/store_phone', 'StudentContactController@storePhone');
Route::post('student/{student}/profile/store_address', 'StudentContactController@storeAddress');
Route::patch('student/{student}/profile/store_email', 'StudentContactController@storeEmail');
Route::patch('student/{student}/address/{address}/update_address', 'StudentContactController@updateAddress');

//Passports and Visas
Route::get('student/{student}/passports_visas', 'StudentPassportVisaController@passportVisa');
Route::get('student/{student}/create_passport', 'StudentPassportVisaController@createPassport');
Route::post('student/{student}/create_passport', 'StudentPassportVisaController@storePassport');
Route::post('student/{student}/passport/{passport}/create_visa', 'StudentPassportVisaController@storeVisa');
Route::patch('student/{student}/visa/{visa}/update_visa', 'StudentPassportVisaController@updateVisa');
Route::patch('student/{student}/passport/{passport}/update_passport', 'StudentPassportVisaController@updatePassport');
Route::get('student/{student}/passport/{passport}/update_passport', 'StudentPassportVisaController@updatePassportForm');

//ID Cards
Route::get('student/{student}/id_card', 'StudentIdCardController@idCard');
Route::get('student/{student}/create_id_card', 'StudentIdCardController@createForm');
Route::post('student/{student}/create_id_card', 'StudentIdCardController@store');
Route::get('student/{student}/id_card/{id_card}/update_id_card', 'StudentIdCardController@editForm');
Route::patch('student/{student}/id_card/{id_card}/update_id_card', 'StudentIdCardController@update');

//Official Documents
Route::get('student/{student}/official_documents', 'StudentOfficialDocumentsController@officialDocuments');
Route::post('student/{student}/official_documents', 'StudentOfficialDocumentsController@store');
Route::post('student/{student}/official_documents', 'StudentOfficialDocumentsController@store');
Route::get('student/{student}/official_documents/{document}/delete', 'StudentOfficialDocumentsController@delete');

//Academics
Route::get('student/{student}/academics/overview', 'StudentAcademicController@overview');
Route::patch('student/{student}/academics/overview', 'StudentAcademicController@storeOverview');

//Family
Route::get('student/{student}/new_family', 'StudentFamilyController@newFamily');
Route::get('student/{student}/view_family', 'StudentFamilyController@viewFamily');
Route::get('student/{student}/add_to_existing_family/{family}', 'StudentFamilyController@addToExistingFamily');
Route::get('student/{student}/create_new_family', 'StudentFamilyController@createNewFamily');

/*
|--------------------------------------------------------------------------
| GUARDIAN
|--------------------------------------------------------------------------
*/
//Directory
Route::get('guardian/index', 'GuardianController@index');
Route::post('guardian/index', 'GuardianController@storeNewGuardian');
Route::get('api/guardian/ajaxshowguardian', 'GuardianAjaxController@ajaxShow');

//Dashboard
Route::get('guardian/{guardian}', 'GuardianController@dashboard');

//Overview
Route::get('guardian/{guardian}/profile', 'GuardianProfileController@profile');
Route::patch('guardian/{guardian}/profile', 'GuardianProfileController@updateProfile');
Route::post('guardian/{guardian}/profile', 'GuardianProfileController@updateProfile');

//Contact Information
Route::get('guardian/{guardian}/contact', 'GuardianContactController@contact');
Route::post('guardian/{guardian}/profile/store_phone', 'GuardianContactController@storePhone');
Route::post('guardian/{guardian}/profile/store_address', 'GuardianContactController@storeAddress');
Route::patch('guardian/{guardian}/profile/store_email', 'GuardianContactController@storeEmail');
Route::patch('guardian/{guardian}/address/{address}/update_address', 'GuardianContactController@updateAddress');

//Passports and Visas
Route::get('guardian/{guardian}/passports_visas', 'GuardianPassportVisaController@passportVisa');
Route::get('guardian/{guardian}/create_passport', 'GuardianPassportVisaController@createPassport');
Route::post('guardian/{guardian}/create_passport', 'GuardianPassportVisaController@storePassport');
Route::post('guardian/{guardian}/passport/{passport}/create_visa', 'GuardianPassportVisaController@storeVisa');
Route::patch('guardian/{guardian}/visa/{visa}/update_visa', 'GuardianPassportVisaController@updateVisa');
Route::patch('guardian/{guardian}/passport/{passport}/update_passport', 'GuardianPassportVisaController@updatePassport');
Route::get('guardian/{guardian}/passport/{passport}/update_passport', 'GuardianPassportVisaController@updatePassportForm');

//ID Cards
Route::get('guardian/{guardian}/id_card', 'GuardianIdCardController@idCard');
Route::get('guardian/{guardian}/create_id_card', 'GuardianIdCardController@createForm');
Route::post('guardian/{guardian}/create_id_card', 'GuardianIdCardController@store');
Route::get('guardian/{guardian}/id_card/{id_card}/update_id_card', 'GuardianIdCardController@editForm');
Route::patch('guardian/{guardian}/id_card/{id_card}/update_id_card', 'GuardianIdCardController@update');

//Official Documents
Route::get('guardian/{guardian}/official_documents', 'GuardianOfficialDocumentsController@officialDocuments');
Route::post('guardian/{guardian}/official_documents', 'GuardianOfficialDocumentsController@store');
Route::post('guardian/{guardian}/official_documents', 'GuardianOfficialDocumentsController@store');
Route::get('guardian/{guardian}/official_documents/{document}/delete', 'GuardianOfficialDocumentsController@delete');

//Family
Route::get('guardian/{guardian}/new_family', 'GuardianFamilyController@newFamily');
Route::get('guardian/{guardian}/view_family', 'GuardianFamilyController@viewFamily');
Route::get('guardian/{guardian}/add_to_existing_family/{family}', 'GuardianFamilyController@addToExistingFamily');
Route::get('guardian/{guardian}/create_new_family', 'GuardianFamilyController@createNewFamily');

/*
|--------------------------------------------------------------------------
| FAMILY
|--------------------------------------------------------------------------
*/
//API
Route::get('api/family/ajaxshowfamilies', 'FamilyAjaxController@ajaxShow');
Route::get('family/{family}', 'FamilyController@show');

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
//Search
Route::post('person/search', 'PersonController@search');

/*
|--------------------------------------------------------------------------
| EMPLOYEE POSITIONS
|--------------------------------------------------------------------------
*/
//API
Route::get('api/position/ajaxshowposition', 'PositionAjaxController@ajaxShow');
//Overview
Route::get('position/summary', 'PositionController@summary');
Route::get('position/index', 'PositionController@index');
Route::get('position/archived', 'PositionController@archived');
//New
Route::get('position/create', 'PositionController@create');
Route::post('position/create', 'PositionController@store');
//View
Route::get('position/{position}', 'PositionController@view');
//Update
Route::patch('position/{position}/edit', 'PositionController@update');
Route::get('position/{position}/edit', 'PositionController@updateForm');
Route::get('position/{position}/archive', 'PositionController@archive');

/*
|--------------------------------------------------------------------------
| SCHOOL YEAR
|--------------------------------------------------------------------------
*/
//Year
Route::get('year/index', 'YearController@index');
Route::get('api/year/ajaxshowyear', 'YearAjaxController@ajaxShow');
Route::post('api/year/ajaxstoreyear', 'YearAjaxController@ajaxStore');
//Quarter
Route::get('quarter/index', 'QuarterController@index');
Route::get('api/quarter/ajaxshowquarter', 'QuarterAjaxController@ajaxShow');
Route::post('api/quarter/ajaxstorequarter', 'QuarterAjaxController@ajaxStore');

/*
|--------------------------------------------------------------------------
| GRADE LEVELS
|--------------------------------------------------------------------------
*/
Route::get('grade_level/index', 'GradeLevelController@index');
Route::get('api/grade_level/ajaxshowgrade_level', 'GradeLevelAjaxController@ajaxShow');
Route::post('api/grade_level/ajaxstoregrade_level', 'GradeLevelAjaxController@ajaxStore');

/*
|--------------------------------------------------------------------------
| DEPARTMENTS
|--------------------------------------------------------------------------
*/
Route::get('department/index', 'DepartmentController@index');
Route::get('api/department/ajaxshowdepartment', 'DepartmentAjaxController@ajaxShow');
Route::post('api/department/ajaxstoredepartment', 'DepartmentAjaxController@ajaxStore');

/*
|--------------------------------------------------------------------------
| ROOMS
|--------------------------------------------------------------------------
*/
Route::get('room/index', 'RoomController@index');
Route::get('api/room/ajaxshowroom', 'RoomAjaxController@ajaxShow');
Route::post('api/room/ajaxstoreroom', 'RoomAjaxController@ajaxStore');

/*
|--------------------------------------------------------------------------
| BUILDINGS
|--------------------------------------------------------------------------
*/
Route::get('building/index', 'BuildingController@index');
Route::get('api/building/ajaxshowbuilding', 'BuildingAjaxController@ajaxShow');
Route::post('api/building/ajaxstorebuilding', 'BuildingAjaxController@ajaxStore');

/*
|--------------------------------------------------------------------------
| ROOM TYPES
|--------------------------------------------------------------------------
*/
Route::get('room_type/index', 'RoomTypeController@index');
Route::get('api/room_type/ajaxshowroom_type', 'RoomTypeAjaxController@ajaxShow');
Route::post('api/room_type/ajaxstoreroom_type', 'RoomTypeAjaxController@ajaxStore');

/*
|--------------------------------------------------------------------------
| GRADE SCALES
|--------------------------------------------------------------------------
*/
Route::get('api/grade_scale/ajaxshowgrade_scale', 'GradeScaleAjaxController@ajaxShow');
Route::get('grade_scale/index', 'GradeScaleController@index');
Route::post('grade_scale/index', 'GradeScaleController@store');
Route::get('grade_scale/{grade_scale}', 'GradeScaleController@show');
Route::patch('grade_scale/{grade_scale}', 'GradeScaleController@update');
Route::get('grade_scale/{grade_scale}/delete', 'GradeScaleController@delete');
Route::get('api/grade_scale/{grade_scale}/percentage/ajaxshowitem', 'GradeScalePercentageAjaxController@ajaxShow');
Route::get('api/grade_scale/{grade_scale}/standards/ajaxshowitem', 'GradeScaleStandardsAjaxController@ajaxShow');
Route::post('api/grade_scale/{grade_scale}/percentage/ajaxstoreitem', 'GradeScalePercentageAjaxController@ajaxStore');
Route::post('api/grade_scale/{grade_scale}/standards/ajaxstoreitem', 'GradeScaleStandardsAjaxController@ajaxStore');

/*
|--------------------------------------------------------------------------
| CLASSES
|--------------------------------------------------------------------------
*/
Route::get('class/index', 'ClassController@index');
Route::post('class/index', 'ClassController@store');
Route::get('class/{class}', 'ClassController@show');
Route::patch('class/{class}', 'ClassController@storeUpdateShow');
Route::get('class/{class}/audits', 'ClassController@showAudits');
//Edit Overview
Route::get('class/{class}/edit_overview', 'ClassController@update');
Route::patch('class/{class}/edit_overview', 'ClassController@storeUpdate');
//Edit Enrollment
Route::get('class/{class}/edit_enrollment/{filter?}', 'ClassEnrollmentController@enrollment');
Route::patch('class/{class}/edit_enrollment', 'ClassEnrollmentController@storeEnrollment');
//AJAX
Route::post('api/class/ajaxstoreclass', 'ClassAjaxController@ajaxStore');
Route::get('api/class/ajaxshowclass', 'ClassAjaxController@ajaxShow');

/*
|--------------------------------------------------------------------------
| COURSES
|--------------------------------------------------------------------------
*/
Route::get('course/index', 'CourseController@index');
Route::post('course/index', 'CourseController@store');
Route::get('course/{course}', 'CourseController@show');
Route::patch('course/{course}', 'CourseController@storeUpdateShow');
Route::get('course/{course}/audits', 'CourseController@showAudits');
Route::get('course/{course}/edit', 'CourseController@update');
Route::patch('course/{course}/edit', 'CourseController@storeUpdate');

Route::post('course/{course}/report_card_options', 'CourseController@storeCourseDisplayOptions');
Route::patch('course/{course}/transcript_options', 'CourseController@storeTranscriptOptions');
Route::patch('course/{course}/scheduling_options', 'CourseController@storeSchedulingOptions');
Route::patch('course/{course}/required_materials', 'CourseController@storeRequiredMaterials');

Route::post('api/course/ajaxstorecourse', 'CourseAjaxController@ajaxStore');
Route::get('api/course/ajaxshowcourse', 'CourseAjaxController@ajaxShow');

Route::post('api/course/{course}/ajaxstoreprerequisite', 'CoursePrerequisiteAjaxController@ajaxStore');
Route::get('api/course/{course}/ajaxshowprerequisite', 'CoursePrerequisiteAjaxController@ajaxShow');

Route::post('api/course/{course}/ajaxstorecorequisite', 'CourseCorequisiteAjaxController@ajaxStore');
Route::get('api/course/{course}/ajaxshowcorequisite', 'CourseCorequisiteAjaxController@ajaxShow');

Route::post('api/course/{course}/ajaxstoreequivalent', 'CourseEquivalentAjaxController@ajaxStore');
Route::get('api/course/{course}/ajaxshowequivalent', 'CourseEquivalentAjaxController@ajaxShow');
