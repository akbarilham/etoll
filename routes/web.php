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

Route::get('/', function () {
	return redirect('login');
});

Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@doLogin');

Route::get('/logout', 'LoginController@logout');
Route::get('/page/dashboard', 'DashboardController@index');
Route::post('/page/dashboard/proses', 'DashboardController@postIndex');
Route::get('/page/dashboard/customer', 'DashboardCustomerController@index');
Route::post('/page/dashboard/customer', 'DashboardCustomerController@postIndex');


Route::group(['middleware' => 'auth.login'], function () {

	Route::get('/dashboard', 'Pages\DashboardController@index');

	Route::get('/welcome', 'Pages\WelcomeController@index');

	/* Customer Care Dashboard */
	Route::get('/page/dashboard/customercare', 'DashboardCustCareController@index');
	Route::post('/page/dashboard/customercare/getdata', 'DashboardCustCareController@getdata');

	/* User Change Password */
	Route::group(['prefix' => 'changepassword', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Security\UserController@changePassword');
		Route::post('submitchangepassword', 'Pages\Security\UserController@submitChangePassword');
	});
	
	Route::group(['prefix' => 'transaction', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Master\TransactionController@index');
		
	});
	Route::group(['prefix' => 'settlement', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Transaction\SettlementController@index');
		
	});
	Route::group(['prefix' => 'balance_history', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Transaction\BalanceHistoryController@index');
		
	});
	Route::group(['prefix' => 'subscriber', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Master\SubscriberMenuController@index');
		
	});
	Route::group(['prefix' => 'user', 'middleware' => 'admin.role'], function () {

		Route::get('', 'Pages\Security\UserController@index');
		Route::post('save', 'Pages\Security\UserController@save');
		Route::post('update', 'Pages\Security\UserController@update');
		Route::post('delete', 'Pages\Security\UserController@delete');
	});

	Route::group(['prefix' => 'userprivilege', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Security\UserPrivilegeController@index');
		Route::post('save', 'Pages\Security\UserPrivilegeController@save');
	});

	Route::group(['prefix' => 'userrole', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Security\UserRoleController@index');
		Route::post('save', 'Pages\Security\UserRoleController@save');
		Route::post('update', 'Pages\Security\UserRoleController@update');
		Route::post('delete', 'Pages\Security\UserRoleController@delete');

	});

	Route::group(['prefix' => 'role', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\RoleController@index');
		Route::post('save', 'Pages\RoleController@save');
		Route::post('update', 'Pages\RoleController@update');
		Route::post('delete', 'Pages\RoleController@delete');
	});

	/* Security User Menu*/
	Route::group(['prefix' => 'user_menu', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Security\UserMenuController@index');
		Route::post('save', 'Pages\Security\UserMenuController@save');
		Route::post('update', 'Pages\Security\UserMenuController@update');
		Route::post('delete', 'Pages\Security\UserMenuController@delete');
	});

	Route::group(['prefix' => 'tollplaza', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Master\TollPlazaController@index');
		Route::get('viewtotal', 'Pages\Master\TollPlazaController@getViewTotalData');
		Route::get('viewdetail', 'Pages\Master\TollPlazaController@getViewDetailData');
		Route::get('newplaza', 'Pages\Master\TollPlazaController@getNewPlazaData');
		Route::get('gateindex', 'Pages\Master\TollPlazaController@nextGateIndex');
		Route::post('save', 'Pages\Master\TollPlazaController@save');
		Route::post('update', 'Pages\Master\TollPlazaController@update');
		Route::post('delete', 'Pages\Master\TollPlazaController@delete');
		Route::post('mydelete', 'Pages\Master\TollPlazaController@myDelete');
	});

	Route::group(['prefix' => 'lane', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Master\LaneController@index');
		Route::post('save', 'Pages\Master\LaneController@save');
		Route::post('update', 'Pages\Master\LaneController@update');
		Route::post('delete', 'Pages\Master\LaneController@delete');
	});

	Route::group(['prefix' => 'fare', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Master\FareController@index');
		Route::post('save', 'Pages\Master\FareController@save');
		Route::post('update', 'Pages\Master\FareController@update');
		Route::post('delete', 'Pages\Master\FareController@delete');
	});

	Route::group(['prefix' => 'bank', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Master\BankController@index');
		Route::post('save', 'Pages\Master\BankController@save');
		Route::post('update', 'Pages\Master\BankController@update');
		Route::post('delete', 'Pages\Master\BankController@delete');
	});

	Route::group(['prefix' => 'operator', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Master\OperatorController@index');
		Route::post('save', 'Pages\Master\OperatorController@save');
		Route::post('update', 'Pages\Master\OperatorController@update');
		Route::post('delete', 'Pages\Master\OperatorController@delete');
	});

	Route::group(['prefix' => 'reportoperasional', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Reporting\ReportOperationalController@index');
		Route::post('showreport', 'Pages\Reporting\ReportOperationalController@showreport');
		Route::get('getlane', 'Pages\Reporting\ReportOperationalController@getLane');
	});

	Route::group(['prefix' => 'reportoperasionalv2', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Reporting\ReportOperationalV2Controller@index');
		Route::post('showreport', 'Pages\Reporting\ReportOperationalV2Controller@showreport');
		Route::get('getlane', 'Pages\Reporting\ReportOperationalV2Controller@getLane');
	});

	Route::group(['prefix' => 'customercare', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\CustomerCare\CustomerCareController@index');

		Route::get('view', 'Pages\CustomerCare\CustomerCareController@view');
		Route::post('saveissue', 'Pages\CustomerCare\CustomerCareController@viewSaveIssue');

		Route::get('setemail', 'Pages\CustomerCare\CustomerCareController@setEmail');
		Route::post('sendemail', 'Pages\CustomerCare\CustomerCareController@sendEmail');

		/* Customer Care Dashboard */
		Route::get('dashboard', 'Pages\CustomerCare\CustomerCareDashboardController@index');
		Route::post('dashboard/process', 'Pages\CustomerCare\CustomerCareDashboardController@postIndex');
	});

	Route::group(['prefix' => 'customercarecheck', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\CustomerCare\CustomerCareCheckController@index');
		Route::get('view', 'Pages\CustomerCare\CustomerCareCheckController@view');

	});

	Route::group(['prefix' => 'rerate', 'middleware' => 'admin.role'], function () {
		Route::get('', 'Pages\Transaction\RerateController@index');
		Route::post('save', 'Pages\Transaction\RerateController@save');
	});

    
});
