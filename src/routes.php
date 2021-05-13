<?php

Route::group(['namespace' => 'Outdare\Auth\Controllers'], function () {
	Route::group(['middleware' => ['web']], function () {

		/** Page/Form Routes **/
		Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
		Route::post('login', 'Auth\LoginController@login')->name('login');
		Route::post('logout', 'Auth\LoginController@logout')->name('logout');
		Route::get('logout', 'Auth\LoginController@logout');

		/** Redirect route **/

		if (config()->get("backoffice") == null) {
			Route::get(config()->get("auth::auth.redirect_path"), 'Auth\HomeController@index')->name(strtr(config()->get("auth::auth.redirect_path"), '/', ""));
		}

		/** HTTP Requests Routes **/
		Route::post('user/login', 'Auth\LoginController@userLogin');
		if (config()->get('auth::auth.enable_register_routes')) {
			Route::post('user/register', 'Auth\RegisterController@userRegister');
		}
	});
});