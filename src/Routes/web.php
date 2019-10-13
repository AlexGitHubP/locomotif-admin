<?php

Route::group(['middleware' => ['web']], function () {
	Route::get('admin', 'Locomotif\Admin\Controller\AdminController@index');
	Route::get('admin/login', 'Locomotif\Admin\Controller\LoginController@showLoginForm')->name('admin/login');
	Route::post('admin/login', 'Locomotif\Admin\Controller\LoginController@login');
	Route::get('admin/logout', 'Locomotif\Admin\Controller\LoginController@logout')->name('admin/logout');
	Route::post('admin/logout', 'Locomotif\Admin\Controller\LoginController@logout');

	Route::get('admin/users', 'Locomotif\Admin\Controller\UsersController@index')->name('admin/users');
	Route::get('admin/users/create', 'Locomotif\Admin\Controller\UsersController@create');
	Route::get('admin/users/{user}/edit', 'Locomotif\Admin\Controller\UsersController@edit');
	Route::put('admin/users/{user}', 'Locomotif\Admin\Controller\UsersController@update');
	Route::post('admin/users', 'Locomotif\Admin\Controller\UsersController@store');
	Route::get('admin/users/{user}', 'Locomotif\Admin\Controller\UsersController@show');
	Route::delete('admin/users/{user}', 'Locomotif\Admin\Controller\UsersController@destroy');
});
?>
