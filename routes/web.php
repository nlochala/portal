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
Route::get('authenticated', 'OAuthController@login')
    ->name('login');
Route::get('logout', 'OAuthController@logout')
    ->name('logout');
Route::get('/', 'LandingController')
    ->name('landing');
Route::get('/loginas/{user}', 'LoginAsController');

Route::impersonate();
//TODO: Change the link location to api/download_file
Route::get('download_file/{file}', 'MediaController@downloadFile');
Route::get('api/download_file/{file}', 'MediaController@downloadFile');
Route::post('api/store_file', 'MediaController@store');

//Route::get('pusher', function () {
//  return view('broadcast.test');
//});

/*
|--------------------------------------------------------------------------
| PARENT PORTAL
|--------------------------------------------------------------------------
*/
// Guardian Dashboard
Route::get('g_guardian/guardian/{guardian?}', 'PPGuardianController@landing')
    ->middleware('can:guardian-only');
Route::post('g_guardian/guardian/{guardian?}', 'ParentMessageController@saveMessage')
    ->middleware('can:guardian-only');

// Student Dashboard
Route::get('g_student/student/{student}', 'PPGuardianController@student')
    ->middleware('can:guardian-only');
Route::get('g_student/student/{student}/class/{class}', 'PPGuardianController@class')
    ->middleware('can:guardian-only');

// Class Reports
Route::get('g_student/report/grades/{class}/{quarter}/{student}', 'PPGuardianController@studentDetails')
    ->middleware('can:guardian-only');
Route::get('g_student/report/grades/{class}/{quarter}/{student}/print', 'PPGuardianController@printStudentDetails')
    ->middleware('can:guardian-only');

// Messages
Route::get('g_message/new', 'ParentMessageController@new')
    ->middleware('can:guardian-only');
Route::post('g_message/new', 'ParentMessageController@saveMessage')
    ->middleware('can:guardian-only');
Route::get('g_message/all', 'ParentMessageController@all')
    ->middleware('can:guardian-only');
Route::get('g_message/sent', 'ParentMessageController@sent')
    ->middleware('can:guardian-only');

/*
|--------------------------------------------------------------------------
| STUDENT PORTAL
|--------------------------------------------------------------------------
*/
Route::get('s_student/student/{student}', 'PPStudentController@student')
    ->middleware('can:student-only');
Route::get('s_student/student/{student}/class/{class}', 'PPStudentController@class')
    ->middleware('can:student-only');
Route::get('s_student/report/grades/{class}/{quarter}/{student}', 'PPStudentController@studentDetails')
    ->middleware('can:student-only');
Route::get('s_student/report/grades/{class}/{quarter}/{student}/print', 'PPStudentController@printStudentDetails')
    ->middleware('can:student-only');

/*
|--------------------------------------------------------------------------
| CLASS MESSAGES
|--------------------------------------------------------------------------
*/
Route::get('class/{class}/message/dashboard', 'ClassMessageController@dashboard')
    ->middleware('can:employee-only');
Route::post('class/{class}/message/dashboard', 'ClassMessageController@saveMessage')
    ->middleware('can:employee-only');
Route::get('class/{class}/message/all', 'ClassMessageController@all')
    ->middleware('can:employee-only');
Route::get('class/{class}/message/sent', 'ClassMessageController@sent')
    ->middleware('can:employee-only');
Route::get('api/message/{message}/read', 'ParentMessageController@markRead');

/*
|--------------------------------------------------------------------------
| PERMISSIONS
|--------------------------------------------------------------------------
*/
Route::get('permission/index', 'PermissionController@index')
    ->middleware('can:permissions');
Route::post('api/permission/ajaxstorepermission', 'PermissionAjaxController@ajaxStore')
    ->middleware('can:permissions');
Route::get('api/permission/ajaxshowpermission', 'PermissionAjaxController@ajaxShow')
    ->middleware('can:permissions');

/*
|--------------------------------------------------------------------------
| ROLES
|--------------------------------------------------------------------------
*/
Route::get('role/index', 'RoleController@index')
    ->middleware('can:permissions');
Route::get('api/role/ajaxshowrole', 'RoleAjaxController@ajaxShow')
    ->middleware('can:permissions');
Route::post('role/index', 'RoleController@store')
    ->middleware('can:permissions');

Route::get('role/{role}', 'RoleController@show')
    ->middleware('can:permissions');
Route::patch('role/{role}', 'RoleController@updatePermissions')
    ->middleware('can:permissions');
Route::patch('role/{role}/update_overview', 'RoleController@updateOverview')
    ->middleware('can:permissions');
Route::get('role/{role}/archive', 'RoleController@archive')
    ->middleware('can:permissions');

/*
|--------------------------------------------------------------------------
| STUDENT LOGINS
|--------------------------------------------------------------------------
*/
Route::get('student/logins', 'StudentLoginController@index')
    ->middleware('can:students.show.full_profile');
Route::get('student/export_student_logins', 'StudentLoginController@loginsExport')
    ->middleware('can:permissions');
Route::get('student/export_student_logins/imported', 'StudentLoginController@imported')
    ->middleware('can:permissions');

/*
|--------------------------------------------------------------------------
| GUARDIAN LOGINS
|--------------------------------------------------------------------------
*/
Route::get('guardian/logins', 'GuardianLoginController@index')
    ->middleware('can:guardians.show.full_profile');
Route::get('guardian/export_guardian_logins', 'GuardianLoginController@loginsExport')
    ->middleware('can:permissions');
Route::get('guardian/export_guardian_logins/imported', 'GuardianLoginController@imported')
    ->middleware('can:permissions');
//Welcome Letter
Route::get('guardian/welcome_letter/', 'GuardianLoginLetterController@form')
    ->middleware('can:employee-only');
Route::post('guardian/welcome_letter/', 'GuardianLoginLetterController@print')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| ADDRESS
|--------------------------------------------------------------------------
*/
//Profile Edit

//Profile Destroy
Route::get('address/{address}/profile/delete', 'AddressController@profileDestroy')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| PHONE
|--------------------------------------------------------------------------
*/
//Profile Destroy
Route::get('phone/{phone}/profile/delete', 'PhoneController@profileDestroy')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| PASSPORT
|--------------------------------------------------------------------------
*/
Route::get('passport/{passport}/cancel', 'PassportController@cancel')
    ->middleware('can:employee-only');
Route::get('passport/{passport}/delete', 'PassportController@delete')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| VISA
|--------------------------------------------------------------------------
*/
Route::get('visa/{visa}/cancel', 'VisaController@cancel')
    ->middleware('can:employee-only');
Route::get('visa/{visa}/delete', 'VisaController@delete')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| ID CARDS
|--------------------------------------------------------------------------
*/
Route::get('id_card/{id_card}/cancel', 'IdCardController@cancel')
    ->middleware('can:employee-only');
Route::get('id_card/{id_card}/delete', 'IdCardController@delete')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| ADDRESS
|--------------------------------------------------------------------------
*/
Route::get('address/{address}/delete', 'AddressController@delete')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| EMPLOYEE
|--------------------------------------------------------------------------
*/

//Directory
Route::get('employee/index', 'EmployeeController@index')
    ->middleware('can:employee-only');
Route::post('employee/index', 'EmployeeController@storeNewEmployee')
    ->middleware('can:employees.create.employees');
Route::get('api/employee/ajaxshowemployee', 'EmployeeAjaxController@ajaxShow')
    ->middleware('can:employee-only');

//Dashboard
Route::get('employee/{employee}', 'EmployeeController@dashboard')
    ->middleware('can:employee-only');

//Overview
Route::get('employee/{employee}/profile', 'EmployeeProfileController@profile')
    ->middleware('can:employees.show.full_profile');
Route::patch('employee/{employee}/profile', 'EmployeeProfileController@updateProfile')
    ->middleware('can:employees.update.biographical');
Route::post('employee/{employee}/profile', 'EmployeeProfileController@updateProfile')
    ->middleware('can:employees.update.biographical');

//Contact Information
Route::get('employee/{employee}/contact', 'EmployeeContactController@contact')
    ->middleware('can:employees.show.full_profile');
Route::post('employee/{employee}/profile/store_phone', 'EmployeeContactController@storePhone')
    ->middleware('can:employees.update.contact');
Route::post('employee/{employee}/profile/store_address', 'EmployeeContactController@storeAddress')
    ->middleware('can:employees.update.contact');
Route::patch('employee/{employee}/profile/store_email', 'EmployeeContactController@storeEmail')
    ->middleware('can:employees.update.contact');
Route::patch('employee/{employee}/address/{address}/update_address', 'EmployeeContactController@updateAddress')
    ->middleware('can:employees.update.contact');

//Passports and Visas
Route::get('employee/{employee}/passports_visas', 'EmployeePassportVisaController@passportVisa')
    ->middleware('can:employees.show.full_profile');
Route::get('employee/{employee}/create_passport', 'EmployeePassportVisaController@createPassport')
    ->middleware('can:employees.show.full_profile');
Route::post('employee/{employee}/create_passport', 'EmployeePassportVisaController@storePassport')
    ->middleware('can:employees.update.government_documents');
Route::post('employee/{employee}/passport/{passport}/create_visa', 'EmployeePassportVisaController@storeVisa')
    ->middleware('can:employees.update.government_documents');
Route::patch('employee/{employee}/visa/{visa}/update_visa', 'EmployeePassportVisaController@updateVisa')
    ->middleware('can:employees.update.government_documents');
Route::patch('employee/{employee}/passport/{passport}/update_passport', 'EmployeePassportVisaController@updatePassport')
    ->middleware('can:employees.update.government_documents');
Route::get('employee/{employee}/passport/{passport}/update_passport', 'EmployeePassportVisaController@updatePassportForm')
    ->middleware('can:employees.update.government_documents');

//ID Cards
Route::get('employee/{employee}/id_card', 'EmployeeIdCardController@idCard')
    ->middleware('can:employees.show.full_profile');
Route::get('employee/{employee}/create_id_card', 'EmployeeIdCardController@createForm')
    ->middleware('can:employees.show.full_profile');
Route::post('employee/{employee}/create_id_card', 'EmployeeIdCardController@store')
    ->middleware('can:employees.update.government_documents');
Route::get('employee/{employee}/id_card/{id_card}/update_id_card', 'EmployeeIdCardController@editForm')
    ->middleware('can:employees.update.government_documents');
Route::patch('employee/{employee}/id_card/{id_card}/update_id_card', 'EmployeeIdCardController@update')
    ->middleware('can:employees.update.government_documents');

//Official Documents
Route::get('employee/{employee}/official_documents', 'EmployeeOfficialDocumentsController@officialDocuments')
    ->middleware('can:employees.show.full_profile');
Route::post('employee/{employee}/official_documents', 'EmployeeOfficialDocumentsController@store')
    ->middleware('can:employees.update.official_documents');
Route::post('employee/{employee}/official_documents', 'EmployeeOfficialDocumentsController@store')
    ->middleware('can:employees.update.official_documents');
Route::get('employee/{employee}/official_documents/{document}/delete', 'EmployeeOfficialDocumentsController@delete')
    ->middleware('can:employees.update.official_documents');

//Employment Details
Route::get('employee/{employee}/employment_overview', 'EmployeePositionController@employmentOverview')
    ->middleware('can:employees.show.full_profile');
Route::post('employee/{employee}/employment_overview', 'EmployeePositionController@storeOverview')
    ->middleware('can:employees.update.employment');
Route::get('employee/{employee}/position/{position}/add', 'EmployeePositionController@addPosition')
    ->middleware('can:employees.update.employment');
Route::get('employee/{employee}/position/{position}/remove', 'EmployeePositionController@removePosition')
    ->middleware('can:employees.update.employment');
Route::get('employee/{employee}/position/view_details', 'EmployeePositionController@viewPositions')
    ->middleware('can:employees.show.full_profile');

/*
|--------------------------------------------------------------------------
| STUDENT
|--------------------------------------------------------------------------
*/
//Directory
Route::get('student/index', 'StudentController@index')
    ->middleware('can:employee-only');
Route::post('student/index', 'StudentController@storeNewStudent')
    ->middleware('can:employee-only');
Route::get('api/student/ajaxshowstudent', 'StudentAjaxController@ajaxShow')
    ->middleware('can:employee-only');

//Dashboard
Route::get('student/{student}', 'StudentController@dashboard')
    ->middleware('can:employee-only');

//Overview
Route::get('student/{student}/profile', 'StudentProfileController@profile')
    ->middleware('can:employee-only');
Route::patch('student/{student}/profile', 'StudentProfileController@updateProfile')
    ->middleware('can:employee-only');
Route::post('student/{student}/profile', 'StudentProfileController@updateProfile')
    ->middleware('can:employee-only');

//Contact Information
Route::get('student/{student}/contact', 'StudentContactController@contact')
    ->middleware('can:employee-only');
Route::post('student/{student}/profile/store_phone', 'StudentContactController@storePhone')
    ->middleware('can:employee-only');
Route::post('student/{student}/profile/store_address', 'StudentContactController@storeAddress')
    ->middleware('can:employee-only');
Route::patch('student/{student}/profile/store_email', 'StudentContactController@storeEmail')
    ->middleware('can:employee-only');
Route::patch('student/{student}/address/{address}/update_address', 'StudentContactController@updateAddress')
    ->middleware('can:employee-only');

//Passports and Visas
Route::get('student/{student}/passports_visas', 'StudentPassportVisaController@passportVisa')
    ->middleware('can:employee-only');
Route::get('student/{student}/create_passport', 'StudentPassportVisaController@createPassport')
    ->middleware('can:employee-only');
Route::post('student/{student}/create_passport', 'StudentPassportVisaController@storePassport')
    ->middleware('can:employee-only');
Route::post('student/{student}/passport/{passport}/create_visa', 'StudentPassportVisaController@storeVisa')
    ->middleware('can:employee-only');
Route::patch('student/{student}/visa/{visa}/update_visa', 'StudentPassportVisaController@updateVisa')
    ->middleware('can:employee-only');
Route::patch('student/{student}/passport/{passport}/update_passport', 'StudentPassportVisaController@updatePassport')
    ->middleware('can:employee-only');
Route::get('student/{student}/passport/{passport}/update_passport', 'StudentPassportVisaController@updatePassportForm')
    ->middleware('can:employee-only');

//ID Cards
Route::get('student/{student}/id_card', 'StudentIdCardController@idCard')
    ->middleware('can:employee-only');
Route::get('student/{student}/create_id_card', 'StudentIdCardController@createForm')
    ->middleware('can:employee-only');
Route::post('student/{student}/create_id_card', 'StudentIdCardController@store')
    ->middleware('can:employee-only');
Route::get('student/{student}/id_card/{id_card}/update_id_card', 'StudentIdCardController@editForm')
    ->middleware('can:employee-only');
Route::patch('student/{student}/id_card/{id_card}/update_id_card', 'StudentIdCardController@update')
    ->middleware('can:employee-only');

//Official Documents
Route::get('student/{student}/official_documents', 'StudentOfficialDocumentsController@officialDocuments')
    ->middleware('can:employee-only');
Route::post('student/{student}/official_documents', 'StudentOfficialDocumentsController@store')
    ->middleware('can:employee-only');
Route::post('student/{student}/official_documents', 'StudentOfficialDocumentsController@store')
    ->middleware('can:employee-only');
Route::get('student/{student}/official_documents/{document}/delete', 'StudentOfficialDocumentsController@delete')
    ->middleware('can:employee-only');

//Academics
Route::get('student/{student}/academics/overview', 'StudentAcademicController@overview')
    ->middleware('can:employee-only');
Route::patch('student/{student}/academics/overview', 'StudentAcademicController@storeOverview')
    ->middleware('can:employee-only');

//Logins
Route::get('student/{student}/logins', 'StudentLoginController@viewStudent')
    ->middleware('can:employee-only');
Route::patch('student/{student}/logins', 'StudentLoginController@updateStudent')
    ->middleware('can:employee-only');

//Family
Route::get('student/{student}/new_family', 'StudentFamilyController@newFamily')
    ->middleware('can:employee-only');
Route::get('student/{student}/view_family', 'StudentFamilyController@viewFamily')
    ->middleware('can:employee-only');
Route::get('student/{student}/add_to_existing_family/{family}', 'StudentFamilyController@addToExistingFamily')
    ->middleware('can:employee-only');
Route::get('student/{student}/create_new_family', 'StudentFamilyController@createNewFamily')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| GUARDIAN
|--------------------------------------------------------------------------
*/
//Directory
Route::get('guardian/index', 'GuardianController@index')
    ->middleware('can:employee-only');
Route::post('guardian/index', 'GuardianController@storeNewGuardian')
    ->middleware('can:employee-only');
Route::get('api/guardian/ajaxshowguardian', 'GuardianAjaxController@ajaxShow')
    ->middleware('can:employee-only');

//Dashboard
Route::get('guardian/{guardian}', 'GuardianController@dashboard')
    ->middleware('can:employee-only');

//Overview
Route::get('guardian/{guardian}/profile', 'GuardianProfileController@profile')
    ->middleware('can:employee-only');
Route::patch('guardian/{guardian}/profile', 'GuardianProfileController@updateProfile')
    ->middleware('can:employee-only');
Route::post('guardian/{guardian}/profile', 'GuardianProfileController@updateProfile')
    ->middleware('can:employee-only');

//Contact Information
Route::get('guardian/{guardian}/contact', 'GuardianContactController@contact')
    ->middleware('can:employee-only');
Route::post('guardian/{guardian}/profile/store_phone', 'GuardianContactController@storePhone')
    ->middleware('can:employee-only');
Route::post('guardian/{guardian}/profile/store_address', 'GuardianContactController@storeAddress')
    ->middleware('can:employee-only');
Route::patch('guardian/{guardian}/profile/store_email', 'GuardianContactController@storeEmail')
    ->middleware('can:employee-only');
Route::patch('guardian/{guardian}/address/{address}/update_address', 'GuardianContactController@updateAddress')
    ->middleware('can:employee-only');

//Passports and Visas
Route::get('guardian/{guardian}/passports_visas', 'GuardianPassportVisaController@passportVisa')
    ->middleware('can:employee-only');
Route::get('guardian/{guardian}/create_passport', 'GuardianPassportVisaController@createPassport')
    ->middleware('can:employee-only');
Route::post('guardian/{guardian}/create_passport', 'GuardianPassportVisaController@storePassport')
    ->middleware('can:employee-only');
Route::post('guardian/{guardian}/passport/{passport}/create_visa', 'GuardianPassportVisaController@storeVisa')
    ->middleware('can:employee-only');
Route::patch('guardian/{guardian}/visa/{visa}/update_visa', 'GuardianPassportVisaController@updateVisa')
    ->middleware('can:employee-only');
Route::patch('guardian/{guardian}/passport/{passport}/update_passport', 'GuardianPassportVisaController@updatePassport')
    ->middleware('can:employee-only');
Route::get('guardian/{guardian}/passport/{passport}/update_passport', 'GuardianPassportVisaController@updatePassportForm')
    ->middleware('can:employee-only');

//ID Cards
Route::get('guardian/{guardian}/id_card', 'GuardianIdCardController@idCard')
    ->middleware('can:employee-only');
Route::get('guardian/{guardian}/create_id_card', 'GuardianIdCardController@createForm')
    ->middleware('can:employee-only');
Route::post('guardian/{guardian}/create_id_card', 'GuardianIdCardController@store')
    ->middleware('can:employee-only');
Route::get('guardian/{guardian}/id_card/{id_card}/update_id_card', 'GuardianIdCardController@editForm')
    ->middleware('can:employee-only');
Route::patch('guardian/{guardian}/id_card/{id_card}/update_id_card', 'GuardianIdCardController@update')
    ->middleware('can:employee-only');

//Official Documents
Route::get('guardian/{guardian}/official_documents', 'GuardianOfficialDocumentsController@officialDocuments')
    ->middleware('can:employee-only');
Route::post('guardian/{guardian}/official_documents', 'GuardianOfficialDocumentsController@store')
    ->middleware('can:employee-only');
Route::post('guardian/{guardian}/official_documents', 'GuardianOfficialDocumentsController@store')
    ->middleware('can:employee-only');
Route::get('guardian/{guardian}/official_documents/{document}/delete', 'GuardianOfficialDocumentsController@delete')
    ->middleware('can:employee-only');

//Family
Route::get('guardian/{guardian}/new_family', 'GuardianFamilyController@newFamily')
    ->middleware('can:employee-only');
Route::get('guardian/{guardian}/view_family', 'GuardianFamilyController@viewFamily')
    ->middleware('can:employee-only');
Route::get('guardian/{guardian}/add_to_existing_family/{family}', 'GuardianFamilyController@addToExistingFamily')
    ->middleware('can:employee-only');
Route::get('guardian/{guardian}/create_new_family', 'GuardianFamilyController@createNewFamily')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| FAMILY
|--------------------------------------------------------------------------
*/
//API
Route::get('api/family/ajaxshowfamilies', 'FamilyAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::get('family/{family}', 'FamilyController@show')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| PERSON
|--------------------------------------------------------------------------
*/
//Create
Route::get('person/create', 'PersonController@create')
    ->middleware('can:employee-only');
Route::post('person/create', 'PersonController@store')
    ->middleware('can:employee-only');
//Edit
Route::get('person/{file}/edit', 'PersonController@edit')
    ->middleware('can:employee-only');
Route::patch('person/{file}', 'PersonController@update')
    ->middleware('can:employee-only');
//Delete
Route::get('person/{file}/delete', 'PersonController@destroy')
    ->middleware('can:employee-only');
//View
Route::get('person/{file}', 'PersonController@show')
    ->middleware('can:employee-only');
//Index
Route::get('person', 'PersonController@index')
    ->middleware('can:employee-only');
//Search
Route::post('person/search', 'PersonController@search')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| EMPLOYEE POSITIONS
|--------------------------------------------------------------------------
*/
//API
Route::get('api/position/ajaxshowposition', 'PositionAjaxController@ajaxShow')
    ->middleware('can:positions.show.positions');
//Overview
Route::get('position/summary', 'PositionController@summary')
    ->middleware('can:positions.show.positions');
Route::get('position/index', 'PositionController@index')
    ->middleware('can:positions.show.positions');
Route::get('position/archived', 'PositionController@archived')
    ->middleware('can:positions.show.positions');
//New
Route::get('position/create', 'PositionController@create')
    ->middleware('can:employee-only');
Route::post('position/create', 'PositionController@store')
    ->middleware('can:employee-only');
//View
Route::get('position/{position}', 'PositionController@view')
    ->middleware('can:positions.show.positions');
//Update
Route::patch('position/{position}/edit', 'PositionController@update')
    ->middleware('can:employee-only');
Route::get('position/{position}/edit', 'PositionController@updateForm')
    ->middleware('can:employee-only');
Route::get('position/{position}/archive', 'PositionController@archive')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| SCHOOL YEAR
|--------------------------------------------------------------------------
*/
//Year
Route::get('year/index', 'YearController@index')
    ->middleware('can:employee-only');
Route::get('api/year/ajaxshowyear', 'YearAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/year/ajaxstoreyear', 'YearAjaxController@ajaxStore')
    ->middleware('can:employee-only');
//Quarter
Route::get('quarter/index', 'QuarterController@index')
    ->middleware('can:employee-only');
Route::get('api/quarter/ajaxshowquarter', 'QuarterAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/quarter/ajaxstorequarter', 'QuarterAjaxController@ajaxStore')
    ->middleware('can:employee-only');
//Day
Route::get('day/{year}/index', 'DayController@index')
    ->middleware('can:employee-only');
//Holiday
Route::get('holiday/{year}/index', 'HolidayController@index')
    ->middleware('can:employee-only');
Route::get('api/holiday/ajaxshowholiday', 'HolidayAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/holiday/ajaxstoreholiday', 'HolidayAjaxController@ajaxStore')
    ->middleware('can:employee-only');


/*
|--------------------------------------------------------------------------
| GRADE LEVELS
|--------------------------------------------------------------------------
*/
Route::get('grade_level/index', 'GradeLevelController@index')
    ->middleware('can:employee-only');
Route::get('api/grade_level/ajaxshowgrade_level', 'GradeLevelAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/grade_level/ajaxstoregrade_level', 'GradeLevelAjaxController@ajaxStore')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| DEPARTMENTS
|--------------------------------------------------------------------------
*/
Route::get('department/index', 'DepartmentController@index')
    ->middleware('can:employee-only');
Route::get('api/department/ajaxshowdepartment', 'DepartmentAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/department/ajaxstoredepartment', 'DepartmentAjaxController@ajaxStore')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| ROOMS
|--------------------------------------------------------------------------
*/
Route::get('room/index', 'RoomController@index')
    ->middleware('can:employee-only');
Route::get('api/room/ajaxshowroom', 'RoomAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/room/ajaxstoreroom', 'RoomAjaxController@ajaxStore')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| BUILDINGS
|--------------------------------------------------------------------------
*/
Route::get('building/index', 'BuildingController@index')
    ->middleware('can:employee-only');
Route::get('api/building/ajaxshowbuilding', 'BuildingAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/building/ajaxstorebuilding', 'BuildingAjaxController@ajaxStore')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| ROOM TYPES
|--------------------------------------------------------------------------
*/
Route::get('room_type/index', 'RoomTypeController@index')
    ->middleware('can:employee-only');
Route::get('api/room_type/ajaxshowroom_type', 'RoomTypeAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/room_type/ajaxstoreroom_type', 'RoomTypeAjaxController@ajaxStore')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| GRADE SCALES
|--------------------------------------------------------------------------
*/
Route::get('api/grade_scale/ajaxshowgrade_scale', 'GradeScaleAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::get('grade_scale/index', 'GradeScaleController@index')
    ->middleware('can:employee-only');
Route::post('grade_scale/index', 'GradeScaleController@store')
    ->middleware('can:employee-only');
Route::get('grade_scale/{grade_scale}', 'GradeScaleController@show')
    ->middleware('can:employee-only');
Route::patch('grade_scale/{grade_scale}', 'GradeScaleController@update')
    ->middleware('can:employee-only');
Route::get('grade_scale/{grade_scale}/delete', 'GradeScaleController@delete')
    ->middleware('can:employee-only');
Route::get('api/grade_scale/{grade_scale}/percentage/ajaxshowitem', 'GradeScalePercentageAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::get('api/grade_scale/{grade_scale}/standards/ajaxshowitem', 'GradeScaleStandardsAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/grade_scale/{grade_scale}/percentage/ajaxstoreitem', 'GradeScalePercentageAjaxController@ajaxStore')
    ->middleware('can:employee-only');
Route::post('api/grade_scale/{grade_scale}/standards/ajaxstoreitem', 'GradeScaleStandardsAjaxController@ajaxStore')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| ATTENDANCE
|--------------------------------------------------------------------------
*/
Route::get('attendance/daily_report', 'AttendanceClassController@dailyReport')
    ->middleware('can:employee-only');
Route::post('attendance/daily_report', 'AttendanceClassController@dailyReport')
    ->middleware('can:employee-only');
Route::get('attendance/update', 'AttendanceClassController@attendanceUpdate')
    ->middleware('can:employee-only');
Route::post('attendance/update', 'AttendanceClassController@attendanceUpdate')
    ->middleware('can:employee-only');
Route::get('api/attendance/update/{date}/ajaxshowattendance', 'AttendanceUpdateAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/attendance/update/{date}/ajaxstoreattendance', 'AttendanceUpdateAjaxController@ajaxStore')
    ->middleware('can:employee-only');
Route::get('attendance/quarterly_report_form', 'AttendanceQuarterlyReportController@reportForm')
    ->middleware('can:employee-only');
Route::post('attendance/quarterly_report_form', 'AttendanceQuarterlyReportController@processForm')
    ->middleware('can:employee-only');
Route::get('attendance/quarterly_report/{quarter}/{class}', 'AttendanceQuarterlyReportController@report')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| CLASSES
|--------------------------------------------------------------------------
*/
Route::get('class/index', 'ClassController@index')
    ->middleware('can:employee-only');
Route::post('class/index', 'ClassController@store')
    ->middleware('can:employee-only');
Route::get('class/{class}', 'ClassController@show')
    ->middleware('can:employee-only');
Route::patch('class/{class}', 'ClassController@storeUpdateShow')
    ->middleware('can:employee-only');
Route::post('class/{class}/store_attendance', 'AttendanceClassController@store')
    ->middleware('can:employee-only');
Route::post('class/{class}/update_attendance', 'AttendanceClassController@update')
    ->middleware('can:employee-only');
Route::get('class/{class}/audits', 'ClassController@showAudits')
    ->middleware('can:employee-only');
//Edit Overview
Route::get('class/{class}/edit_overview', 'ClassController@update')
    ->middleware('can:employee-only');
Route::patch('class/{class}/edit_overview', 'ClassController@storeUpdate')
    ->middleware('can:employee-only');
//Edit Enrollment
Route::get('class/{class}/edit_enrollment/{filter}', 'ClassEnrollmentController@enrollment')
    ->middleware('can:employee-only');
Route::patch('class/{class}/edit_enrollment/{filter}', 'ClassEnrollmentController@storeEnrollment')
    ->middleware('can:employee-only');
Route::patch('class/{class}/edit_enrollment/{filter}/{quarter}', 'ClassEnrollmentController@updateEnrollment')
    ->middleware('can:employee-only');
//AJAX
Route::post('api/class/ajaxstoreclass', 'ClassAjaxController@ajaxStore')
    ->middleware('can:employee-only');
Route::get('api/class/ajaxshowclass', 'ClassAjaxController@ajaxShow')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| COURSES
|--------------------------------------------------------------------------
*/
Route::get('course/index', 'CourseController@index')
    ->middleware('can:employee-only');
Route::post('course/index', 'CourseController@store')
    ->middleware('can:employee-only');
Route::get('course/{course}', 'CourseController@show')
    ->middleware('can:employee-only');
Route::patch('course/{course}', 'CourseController@storeUpdateShow')
    ->middleware('can:employee-only');
Route::get('course/{course}/audits', 'CourseController@showAudits')
    ->middleware('can:employee-only');
Route::get('course/{course}/edit', 'CourseController@update')
    ->middleware('can:employee-only');
Route::patch('course/{course}/edit', 'CourseController@storeUpdate')
    ->middleware('can:employee-only');

Route::post('course/{course}/report_card_options', 'CourseController@storeCourseDisplayOptions')
    ->middleware('can:employee-only');
Route::patch('course/{course}/transcript_options', 'CourseController@storeTranscriptOptions')
    ->middleware('can:employee-only');
Route::patch('course/{course}/scheduling_options', 'CourseController@storeSchedulingOptions')
    ->middleware('can:employee-only');
Route::patch('course/{course}/required_materials', 'CourseController@storeRequiredMaterials')
    ->middleware('can:employee-only');

Route::post('api/course/ajaxstorecourse', 'CourseAjaxController@ajaxStore')
    ->middleware('can:employee-only');
Route::get('api/course/ajaxshowcourse', 'CourseAjaxController@ajaxShow')
    ->middleware('can:employee-only');

Route::post('api/course/{course}/ajaxstoreprerequisite', 'CoursePrerequisiteAjaxController@ajaxStore')
    ->middleware('can:employee-only');
Route::get('api/course/{course}/ajaxshowprerequisite', 'CoursePrerequisiteAjaxController@ajaxShow')
    ->middleware('can:employee-only');

Route::post('api/course/{course}/ajaxstorecorequisite', 'CourseCorequisiteAjaxController@ajaxStore')
    ->middleware('can:employee-only');
Route::get('api/course/{course}/ajaxshowcorequisite', 'CourseCorequisiteAjaxController@ajaxShow')
    ->middleware('can:employee-only');

Route::post('api/course/{course}/ajaxstoreequivalent', 'CourseEquivalentAjaxController@ajaxStore')
    ->middleware('can:employee-only');
Route::get('api/course/{course}/ajaxshowequivalent', 'CourseEquivalentAjaxController@ajaxShow')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| GRADEBOOK
|--------------------------------------------------------------------------
*/
Route::get('class/{class}/{quarter}/gradebook', 'GradebookController@show')
    ->middleware('can:employee-only');
Route::get('class/{class}/{quarter}/gradebook/assignments', 'AssignmentController@index')
    ->middleware('can:employee-only');
Route::get('class/{class}/{quarter}/gradebook/assignment_type', 'AssignmentTypeController@index')
    ->middleware('can:employee-only');

Route::get('api/class/{class}/{quarter}/gradebook/assignment/ajaxshowassignment', 'AssignmentAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/class/{class}/{quarter}/gradebook/assignment/ajaxstoreassignment', 'AssignmentAjaxController@ajaxStore')
    ->middleware('can:employee-only');

Route::get('class/{class}/{quarter}/gradebook/assignment/{assignment}', 'AssignmentController@grade')
    ->middleware('can:employee-only');
Route::get('api/class/{class}/{quarter}/gradebook/assignment/{assignment}/ajaxshowassessment', 'AssignmentGradeAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/class/{class}/{quarter}/gradebook/assignment/{assignment}/ajaxstoreassessment', 'AssignmentGradeAjaxController@ajaxStore')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| GRADE ASSIGNMENT TYPES
|--------------------------------------------------------------------------
*/
Route::get('class/{class}/{quarter}/gradebook/assignment_type', 'AssignmentTypeController@index')
    ->middleware('can:employee-only');
Route::get('api/class/{class}/gradebook/assignment_type/ajaxshowassignment_type', 'AssignmentTypeAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/class/{class}/gradebook/assignment_type/ajaxstoreassignment_type', 'AssignmentTypeAjaxController@ajaxStore')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| MAP ROSTER EXPORT
|--------------------------------------------------------------------------
*/
Route::get('map/export', 'MapRosterController@index')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| HOW TO VIDEOS HOSTED BY MICROSOFT STEAM
|--------------------------------------------------------------------------
*/
Route::get('videos/channel/how-to', 'HowToVideosController@channel')
    ->middleware('can:employee-only');

/*
|--------------------------------------------------------------------------
| REPORTS
|--------------------------------------------------------------------------
*/
// Class Reports
Route::get('report/grades/{class}/{quarter}/{student}', 'GradebookController@studentDetails')
    ->middleware('can:employee-only');
Route::get('report/grades/{class}/{quarter}/{student}/print', 'GradebookController@printStudentDetails')
    ->middleware('can:employee-only');

// Behavior Reports
Route::get('report/behavior/approve/{quarter}', 'GradeBehaviorQuarterController@approvalForm')
    ->middleware('can:employee-only');
Route::post('report/behavior/approve/{quarter}', 'GradeBehaviorQuarterController@processChangeQuarter')
    ->middleware('can:employee-only');
Route::get('report/behavior/{class}/{quarter}', 'GradeBehaviorQuarterController@grade')
    ->middleware('can:employee-only');
Route::post('report/behavior/{class}/{quarter}', 'GradeBehaviorQuarterController@processGrades')
    ->middleware('can:employee-only');
Route::get('api/report/behavior/approve/{quarter}/ajaxshowreports', 'GradeBehaviorQuarterAjaxController@ajaxShow')
    ->middleware('can:employee-only');
Route::post('api/report/behavior/approve/{quarter}/ajaxstorereports', 'GradeBehaviorQuarterAjaxController@ajaxStore')
    ->middleware('can:employee-only');

// Print Report Cards
Route::get('report/report_cards/{year}/print_form', 'ReportCardPrintController@reportForm')
    ->middleware('can:employee-only');
Route::post('report/report_cards/{year}/print_form', 'ReportCardPrintController@changeYear')
    ->middleware('can:employee-only');
Route::post('report/report_cards/{year}/print', 'ReportCardPrintController@generateReports')
    ->middleware('can:employee-only');

