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

//Route::get('/', function () {
//    return view('welcome');
//});

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

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});


Route::group(['middleware' => ['web'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::auth();

    Route::get('/home', ['as' => 'admin.home', 'uses' => 'HomeController@index']);
    Route::resource('admin_user', 'AdminUserController');
    Route::post('admin_user/destroyall',['as'=>'admin.admin_user.destroy.all','uses'=>'AdminUserController@destroyAll']);
    Route::resource('role', 'RoleController');
    Route::post('role/destroyall',['as'=>'admin.role.destroy.all','uses'=>'RoleController@destroyAll']);
    Route::get('role/{id}/permissions',['as'=>'admin.role.permissions','uses'=>'RoleController@permissions']);
    Route::post('role/{id}/permissions',['as'=>'admin.role.permissions','uses'=>'RoleController@storePermissions']);
    Route::resource('permission', 'PermissionController');
    Route::post('permission/destroyall',['as'=>'admin.permission.destroy.all','uses'=>'PermissionController@destroyAll']);
    Route::resource('blog', 'BlogController');
});


Route::get('/admin', function () {
    return view('admin.welcome');
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
});

//Route::get('/', function () {
//    return view('welcome');
//});
// 不需要登录验证的接口
Route::get('/', function () {
    return view('welcome');
//    return view('auth.casLogin');
});
Route::get('/addGRs','GRController@addGRs');
Route::get('/dologin', 'CasAuthController@login');

Route::get('/index', 'indexController@index');
Route::post('/editGRs/{gr_code}','GRController@updateGRs');
Route::get('/editGRs/','GRController@editGRs');
Route::get('/GRs', 'GRController@getGRs');
Route::post('/GRs', 'GRController@getGRs');
Route::post('/GR/update/{gr_code}', 'COController@update');
Route::get('/editGRs', 'GRController@editGRs');
Route::post('/editGRs', 'GRController@editGRs');
Route::post('/addGR','GRController@add');
Route::get('/addGR','GRController@add');
Route::delete('/deleteGR/{gr_code}',"GRController@deleteGR");
Route::post('/deleteGR/{gr_code}',"GRController@deleteGR");
Route::get('/addGRCourses','GRController@addGRCourses');
Route::post('/addGRCourse','GRController@addGRCourse');
Route::get('/addGRCourse','GRController@addGRCourse');
Route::post('/deleteGRCourse/{gr_code}','GRController@deleteGRCourse');
Route::get('/GR/{GRCode}', 'GRController@editGRsCourses');
Route::post('/GR/update/{gr_code}/course/{course_code}', 'GRController@updateGRsCourse');
Route::get('/getGRsAndCCPs/{course_code}', 'GRController@getGRsAndCCPs');
Route::get('/editGRAndCCPs/{gr_code}/course/{course_code}', 'GRController@editGRAndCCPs');
Route::post('/GRs/bind/{gr_code}/course/{course_code}', 'GRController@addGRAndCCPS');

Route::get('/CMs/{course_code}','CMController@show');
Route::post('/CMs/{course_code}','CMController@addCM');
Route::post('/deleteCM/{cm_code}','CMController@deleteCM');
Route::get('/COs/{course_code}', 'COController@getCOs');
Route::get('/editCOs/{course_code}', 'COController@editCOs');
Route::post('/COs/{course_code}', 'COController@create');
Route::delete('/COs/{co_id}', 'COController@destroy');
Route::post('/COs/update/{co_id}', 'COController@update');
Route::post('/COs/bind/{co_id}', 'COController@addCOAndCCPS');
Route::get('/getCOsAndCCPs/{course_code}', 'COController@getCOsAndCCPs');
Route::get('/editCOAndCCPs/{co_id}', 'COController@editCOAndCCPs');
Route::get('/validateCOWeightSum/{course_code}', 'COController@validateCOWeightSum');
Route::get('/show','CourseController@show');
Route::post('/addCourse','CourseController@add');
Route::get('/getStudentsCOGR/{course_code}', 'COController@getStudentsCOGR');





Route::get('/CCPs/{course_code}', 'CCPController@getCCPs');
Route::post('/CCPs/{course_code}', 'CCPController@getCCPs');
Route::get('/addCCP/{parent_ccp_id}', 'CCPController@addCCP');
Route::get('/editCCP/{id}', 'CCPController@editCCP');
Route::post('/CCP/{ccp_code}', 'CCPController@create');
Route::get('/CCP/{ccp_code}', 'CCPController@create');
Route::post('/CCP/update/{id}', 'CCPController@update');
Route::delete('/CCP/{id}', 'CCPController@destroyCCP');
Route::get('/addRootCCP/{course_code}', 'CCPController@addRootCCP');
Route::get('/getStudentsCCPs/{course_code}', 'CCPController@getStudentsCCPs');
Route::post('/RootCCP/{ccp_code}', 'CCPController@createRootCCP');
Route::get('/upLoadCCP/{course_code}', 'CCPController@getUpLoadCCPTemplate');
Route::get('/editCCP', 'CCPController@editCCP');


Route::get('/download/{course_code}/ccps', 'DownloadController@downloadCCPs');
Route::get('/download/{course_code}/grs', 'DownloadController@downloadGRs');
Route::get('/download/{course_code}/cos', 'DownloadController@downloadCOs');
Route::get('/download/{course_code}/pos', 'DownloadController@downloadPOs');
Route::get('/download/{course_code}/students_ccps', 'DownloadController@downloadStudentsCCPs');

Route::post('/upload/{course_code}/ccps', 'UploadController@uploadCCPs');
Route::post('/upload/{course_code}/grs', 'UploadController@uploadGRs');
Route::post('/upload/{course_code}/cos', 'UploadController@uploadCOs');
Route::post('/upload/{course_code}/pos', 'UploadController@uploadPOs');
Route::post('/upload/{course_code}/students_ccps', 'UploadController@uploadStudentsCCPs');
Route::post('/upload/{course_code}/ccpTemp', 'UploadController@upLoadCCPTemp');