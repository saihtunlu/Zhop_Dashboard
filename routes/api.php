<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::post('/password/create', 'Api\PasswordResetController@create');
Route::get('/password/find/{token}', 'Api\PasswordResetController@find');
Route::post('/password/reset', 'Api\PasswordResetController@reset');

Route::get('signup/activate/{token}', 'Api\VerificationController@signupActivate');
Route::get('general/', 'Api\GeneralController@index');
Route::get('theme/', 'Api\ThemeController@index');

//product details
Route::get('getVariation/{no}', 'Api\ProductController@variations');
Route::get('getAllData', 'Api\SendApiController@index');

//Reset Password
Route::post('/password/create', 'Api\PasswordResetController@create');
Route::post('/password/find', 'Api\PasswordResetController@find');
Route::post('/password/reset', 'Api\PasswordResetController@reset');

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
    Route::post('/signUp', 'Api\AuthController@signUp');

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

// Route::post('/sanctum/token', function (Request $request) {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//         'device_name' => 'required'
//     ]);
//     $user = User::where('email', $request->email)->first();
//     if (!$user || !Hash::check($request->password, $user->password)) {
//         throw ValidationException::withMessages([
//             'email' => ['The provided credentials are incorrect.'],
//         ]);
//     }
//     $orders = Order::where('user_id', $user->id)->with('detail.product.images', 'detail.product.brand', 'detail.product.categories', 'detail.product.tags.tag', 'detail.variation.product.images', 'detail.variation.product.variations.Attri2.attribute', 'detail.variation.Attri2.attribute', 'detail.variation.Attri1.attribute', 'detail.variation.product.variations.Attri1.attribute', 'detail.variation.product.brand', 'detail.variation.product.categories', 'detail.variation.product.tags.tag', 'billAddress', 'payment.banks', 'payment.restrictions')->get();
//     $token = $user->createToken($request->device_name)->plainTextToken;
//     $response = [
//         'user' => $user,
//         'token' => $token,
//         'orders' => $orders
//     ];
//     return response($response, 201);
// });
