<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', 'PageController@home')->name('home');
Route::get('/login', 'Auth\LoginController@show')->name('login');
Route::get('/register', 'Auth\RegisterController@show')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('do-login');
Route::post('/register', 'Auth\RegisterController@register')->name('do-register');
Route::get('/password/reset', 'Auth\ForgotPasswordController@show')->name('show-reset-password');
Route::post('/password/reset', 'Auth\ForgotPasswordController@reset')->name('reset-password');


// // Maintenance Comment out other route when this is in motion
// Route::fallback(function(){
//     return view("migration");
// });


Route::group(['middleware' => 'auth'], function () {
    // BOTH
    Route::get('/dashboard', 'UserController@showDashboard')->name('dashboard');
    Route::get('/investments/active', 'InvestmentController@showActiveInvestments')->name('active-investments');
    Route::get('/investments/completed', 'InvestmentController@showCompletedInvestments')->name('completed-investments');
    Route::post('/investments/archive', 'InvestmentController@archive')->name('archive-investment');
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/partnership', 'PlanController@showPartnership')->name('partnership');

    // USER ONLY
    Route::group(['middleware' => 'checkRole:user'], function () {
        Route::get('/profile', 'UserController@showProfile')->name('profile');
        Route::post('/profile', 'UserController@updateProfile')->name('update-profile');
        Route::post('/profile/update-password', 'Auth\ChangePasswordController@change')->name('update-password');
        Route::post('/investment/create', 'InvestmentController@create')->name('create-investment');
        Route::get('/plans', 'PlanController@list')->name('show-plans');
        Route::get('/investment-pay-information/{investment_id}', 'InvestmentController@payInformation')->name('investment-pay-information');
        Route::get('/referrals', 'ReferralController@show')->name('referrals');
    });

    //ADMIN ONLY
    Route::group(['middleware' => 'checkRole:admin'], function () {
        Route::get('/investments/pending', 'InvestmentController@showPendingInvestments')->name('pending-investments');
        Route::post('/plan/create', 'PlanController@create')->name('create-plan');
        Route::get('/plan/add', 'PlanController@add')->name('add-plan');
        Route::get('/plan/edit/{plan_id}', 'PlanController@edit')->name('edit-plan');
        Route::post('/plan/update', 'PlanController@update')->name('update-plan');
        Route::post('/plan/delete', 'PlanController@delete')->name('delete-plan');
        Route::get('/users', 'UserController@showUsers')->name('show-users');
        Route::post('/user/delete', 'UserController@deleteUser')->name('delete-user');
        Route::post('/investment/activate', 'InvestmentController@activate')->name('activate-investment');
        Route::post('/investment/withdraw', 'InvestmentController@withdraw')->name('withdraw-investment');
        Route::post('/login-as-user', 'UserController@loginUserSession')->name('login-as-user');
        Route::get('/referrals/manage', 'ReferralController@manage')->name('manage-referrals');
        Route::post('/referral/pay', 'ReferralController@pay')->name('pay-referral');
        Route::get('/users/download', 'UserController@export')->name('download-user-csv');
        Route::get('/investment/active/download/{type}', 'InvestmentController@exportActive')->name('download-active-investment-csv');
        Route::get('/investment/pending/download/{type}', 'InvestmentController@exportPending')->name('download-pending-investment-csv');
        Route::get('/investment/completed/download/{type}', 'InvestmentController@exportCompleted')->name('download-completed-investment-csv');
    });
});


Route::fallback(function () {
    return redirect()->route('login');
});
