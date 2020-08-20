<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::post('/password/create', 'Api\PasswordClientController@create');
Route::post('/password/find', 'Api\PasswordClientController@find');
Route::post('/password/reset', 'Api\PasswordClientController@reset');
Route::post('/signUp', 'Api\AuthController@signUp');

Route::get('signup/activate/{token}', 'Api\VerificationController@signupActivate');
Route::get('general/', 'Api\GeneralController@index');
Route::get('theme/', 'Api\ThemeController@index');

Route::get('/slip/{id}', 'Api\OrderController@slip');

//product details
Route::get('getVariation/{no}', 'Api\ProductController@variations');
Route::get('getAllData', 'Api\SendApiController@index');

// //Reset Password
// Route::post('/password/create', 'Api\PasswordResetController@create');
// Route::post('/password/find', 'Api\PasswordResetController@find');
// Route::post('/password/reset', 'Api\PasswordResetController@reset');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/auth', 'Api\UserController@auth')->name('auth');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //Fav
    Route::post('/addFav', 'Api\FavController@store');
    Route::get('/getFav', 'Api\FavController@show');
    Route::post('/removeFav', 'Api\FavController@remove');
    Route::post('/logouts', 'Api\AuthController@logout');

    //Role
    Route::get('/orders', 'Api\OrderController@index');
    Route::post('/startOrder', 'Api\OrderController@store');

    //Address
    Route::get('/address', 'Api\AddressController@index');
    Route::post('/addAddress', 'Api\AddressController@store');
    Route::post('/updateAddress', 'Api\AddressController@update');


    //User
    Route::get('/users', 'Api\UserController@index')->name('users');
    Route::get('/user', 'Api\UserController@auth');
    Route::get('/user/{id}', 'Api\UserController@show')->name('show_User');
    Route::post('/updateUser', 'Api\UserController@general');
    Route::post('/updatePassword', 'Api\UserController@password');
    Route::delete('/deleteUser/{id}', 'Api\UserController@destroy')->name('delete_user');
    Route::post('/updateProfile', 'Api\UserController@profile');
    Route::get('/removeProfile', 'Api\UserController@removeProfile');

    //employee
    Route::get('/showEmployee', 'Api\EmployeeController@index')->name('employees');
    Route::post('/createEmployee', 'Api\EmployeeController@store')->name('Create_Employee');
    Route::post('/editEmployee', 'Api\EmployeeController@edit')->name('Edit_Employee');
    Route::delete('/deleteEmployee/{id}', 'Api\EmployeeController@destroy')->name('Delete_Employee');
    Route::get('/Employee_detail/{id}', 'Api\EmployeeController@show')->name('show_Employee');

    //Role
    Route::get('/roles', 'Api\RoleController@index')->name('roles');
    Route::post('/createRole', 'Api\RoleController@store')->name('Create_Role');


    //Classroom
    Route::get('/startOrder', 'Api\ClassroomController@index')->name('classrooms');
    Route::post('/createClassroom', 'Api\ClassroomController@store')->name('Create_Classroom');
    Route::delete('/deleteClassroom/{id}', 'Api\ClassroomController@destroy')->name('Delete_Classroom');

    //Student
    Route::get('/students', 'Api\StudentController@index')->name('students');
    Route::post('/createStudent', 'Api\StudentController@store')->name('Create_Student');
    Route::delete('/deleteStudent/{id}', 'Api\StudentController@destroy')->name('Delete_Student');
});

// Get_Token For Mobile App
Route::post('/sanctum/token', 'Api\AuthController@login');
