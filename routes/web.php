<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/{any?}', function () {
    return view('home');
});

//Reset Password
Route::post('/password/create', 'Api\PasswordResetController@create');
Route::post('/password/find', 'Api\PasswordResetController@find');
Route::post('/password/reset', 'Api\PasswordResetController@reset');
Route::get('/reset_password/{token}', function () {
    return view('home');
});


//Email verification
Route::post('/activation', 'Api\VerificationController@signupActivate');
Route::post('/re-activation', 'Api\VerificationController@activate');
Route::get('/activation/{token}', function () {
    return view('home');
});

//Get Theme
Route::get('web/getGeneral', 'Api\GeneralController@index');
Route::get('web/getTheme', 'Api\ThemeController@index');



Route::group(['middleware' => 'auth'], function () {

    //auth
    Route::get('/web/auth', 'Api\UserController@auth')->name('auth');
    //User
    Route::get('/web/getUsers', 'Api\UserController@index');
    Route::get('/web/employeeUser', 'Api\UserController@employee')->name('users');
    Route::get('/web/getUserEmployees', 'Api\UserController@getemployee'); // no relationship
    Route::get('/web/studentUser', 'Api\UserController@student')->name('users');
    Route::get('/web/parentUser', 'Api\UserController@parent')->name('users');
    Route::get('/web/getUser/{id}', 'Api\UserController@show');
    Route::post('/web/createUser', 'Api\UserController@store')->name('create_user');
    Route::post('/web/updateUser', 'Api\UserController@update')->name('update_user');
    Route::delete('/web/deleteUser/{id}', 'Api\UserController@destroy')->name('delete_user');
    Route::post('/web/userDetail', 'Api\UserController@detail'); //for creating user
    Route::post('/web/updateUserProfile', 'Api\UserController@profile');
    Route::post('/web/updateUserPermission', 'Api\UserController@permission');
    Route::post('/web/updateAuthGeneral', 'Api\UserController@AuthGeneral');
    Route::post('/web/updateAuthPassword', 'Api\UserController@Password');

    //Events
    Route::post('/web/createEvent', 'Api\EventController@store');
    Route::post('/web/updateMainEvent', 'Api\EventController@update');
    Route::get('/web/getEvents', 'Api\EventController@index');
    Route::delete('/web/deleteEvent/{id}', 'Api\EventController@destroy');




    Route::get('/employee/{id}', function () {
        return view('home');
    });
    Route::get('/user/{id}', function () {
        return view('home');
    });
    Route::get('/product/{id}', function () {
        return view('home');
    });
    Route::get('/edit_product/{id}', function () {
        return view('home');
    });
    Route::get('/shipping/{id}', function () {
        return view('home');
    });
    Route::get('/payment/{id}', function () {
        return view('home');
    });
    Route::get('/order/{id}', function () {
        return view('home');
    });


    //Delete
    Route::post('/web/delete', 'Api\DeleteController@index');
    Route::get('/web/restore', 'Api\DeleteController@restore');


    //Invoice
    Route::get('/web/invoices', 'Api\InvoiceController@index');
    Route::post('web/createInvoice', 'Api\InvoiceController@store');
    Route::post('web/SetInvoice', 'Api\InvoiceController@defaultDetail');
    Route::post('web/sendInvoice', 'Api\InvoiceController@SendInvoice');
    Route::get('web/defaultInvoice', 'Api\InvoiceController@Getdefault');
    Route::post('web/SetInvoiceItems', 'Api\InvoiceController@SetInvoiceItems');
    Route::post('web/DownloadInvoice/{id}', 'Api\PdfController@Invoice');
    Route::get('web/GetInvoiceItems', 'Api\InvoiceController@GetInvoiceItems');
    Route::post('web/updateInvoiceStatus/', 'Api\InvoiceController@updateStatus');

    //Orders
    Route::get('web/getOrders', 'Api\OrderController@all');
    Route::get('web/getNoti', 'Api\OrderController@noti');
    Route::get('web/getOrder/{id}', 'Api\OrderController@show');
    Route::post('web/updateOrder', 'Api\OrderController@update');
    Route::delete('/web/order/{id}', 'Api\OrderController@destroy');





    //Mail
    Route::post('web/sendEmail', 'Api\MailController@send');
    Route::get('web/getParentsMail', 'Api\MailController@parents');
    Route::get('web/getStudentsMail', 'Api\MailController@students');
    Route::get('web/getMailCategories', 'Api\MailController@categories');
    Route::delete('/web/MailCategory/{id}', 'Api\MailController@removeCat');
    Route::get('/web/mails', 'Api\MailController@index');
    Route::post('web/starredMail', 'Api\MailController@starred');
    Route::get('/web/mail/{id}', 'Api\MailController@restore');
    Route::delete('/web/mail/{id}', 'Api\MailController@destroy');
    Route::delete('/web/removeMailCat/{id}', 'Api\MailController@removeMailCat');
    Route::post('web/addMailCat', 'Api\MailController@addCategory');

    //Theme
    Route::post('web/updateTheme', 'Api\ThemeController@update');

    //General
    Route::post('web/setLogo', 'Api\GeneralController@logo');
    Route::post('web/setDetail', 'Api\GeneralController@detail');
    Route::post('web/setColor', 'Api\GeneralController@color');

    //Todo
    Route::post('web/addTodo', 'Api\TodoController@store');
    Route::post('web/updateTodo', 'Api\TodoController@update');
    Route::get('/web/todo', 'Api\TodoController@index')->name('todo');
    Route::get('/web/getTodoCategories', 'Api\TodoController@categories');
    Route::get('/web/todo/{id}', 'Api\TodoController@restore');
    Route::get('/web/todoNoti', 'Api\TodoController@noti');
    Route::delete('/web/todo/{id}', 'Api\TodoController@destroy');
    Route::delete('/web/TodoCategory/{id}', 'Api\TodoController@removeCat');

    //Calendar Event
    Route::post('web/addEvent', 'Api\CalendarController@store');
    Route::post('web/updateEvent', 'Api\CalendarController@update');
    Route::get('/web/events', 'Api\CalendarController@index');
    Route::get('/web/getCalendarCategories', 'Api\CalendarController@categories');
    Route::delete('/web/event/{id}', 'Api\CalendarController@destroy');
    Route::delete('/web/removeCalendarCat/{id}', 'Api\CalendarController@removeCat');

    //Status
    Route::post('web/online', 'Api\StatusController@online');
    Route::post('web/offline', 'Api\StatusController@offline');

    //Role
    Route::get('/web/roles', 'Api\RoleController@index')->name('roles');
    Route::post('/web/createRole', 'Api\RoleController@store')->name('Create_Role');
    Route::delete('/web/deleteRole/{id}', 'Api\RoleController@destroy');

    //Default Permissions   
    Route::get('/web/getPermissions', 'Api\DefaultPermissionController@index');
    Route::post('/web/createPermission', 'Api\DefaultPermissionController@store');

    //Products
    Route::post('web/addProduct', 'Api\ProductController@store');
    Route::post('web/updateProduct', 'Api\ProductController@update');
    Route::post('web/addAttribute', 'Api\ProductController@addAttribute');
    Route::get('web/getAttribute/{id}', 'Api\ProductController@getAttri');
    Route::get('web/getProductCategories', 'Api\ProductController@categories');
    Route::get('web/getTags', 'Api\ProductController@tags');
    Route::get('web/getVariation/{no}', 'Api\ProductController@variations');
    Route::get('web/getProducts/', 'Api\ProductController@index');
    Route::get('web/getProductDetail/{id}', 'Api\ProductController@show');
    Route::post('web/setRating', 'Api\RatingController@setRating');
    Route::get('web/getRating/{id}', 'Api\RatingController@getRating');


    //Brand
    Route::post('web/addBrand', 'Api\BrandController@store');
    Route::get('web/getBrands', 'Api\BrandController@index');
    Route::post('web/editBrand', 'Api\BrandController@update');
    Route::delete('web/deleteBrand/{id}', 'Api\BrandController@destroy');

    //Shipping
    Route::post('web/createShipping', 'Api\ShippingController@store');
    Route::post('web/updateShipping', 'Api\ShippingController@update');
    Route::get('web/getShippings', 'Api\ShippingController@index');
    Route::get('web/getShipping/{id}', 'Api\ShippingController@show');
    Route::delete('web/deleteShipping/{id}', 'Api\ShippingController@destroy');



    //Payments
    Route::get('web/getPayments', 'Api\PaymentController@index');
    Route::get('web/getPayment/{id}', 'Api\PaymentController@show');
    Route::post('web/updatePayment', 'Api\PaymentController@update');
    Route::post('web/addPayment', 'Api\PaymentController@store');
    Route::delete('web/deletePayment/{id}', 'Api\PaymentController@destroy');


    //Categories
    Route::post('web/addCategory', 'Api\CategoryController@store');
    Route::post('web/deleteCategory', 'Api\CategoryController@destroy');
    Route::post('web/editCategory', 'Api\CategoryController@update');
    Route::get('web/getCategories', 'Api\CategoryController@index');

    //Dashboard
    Route::get('web/invoiceStatus/{year}', 'Api\DashboardController@invoice');
    Route::get('web/orderStatus/{date}', 'Api\DashboardController@order');
    Route::get('web/getCounter/', 'Api\DashboardController@count');
    Route::get('web/calendarDashboard/', 'Api\DashboardController@calendar');
    Route::get('web/sellProduct/', 'Api\DashboardController@sellProduct');
});
