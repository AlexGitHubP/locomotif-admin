<?php

Route::group(['middleware' => ['web']], function () {
	Route::get('admin', 'Locomotif\Admin\Controller\AdminController@index');
	Route::get('admin/login', 'Locomotif\Admin\Controller\LoginController@showLoginForm')->name('admin/login');
	Route::post('admin/login', 'Locomotif\Admin\Controller\LoginController@login');
	Route::get('admin/logout', 'Locomotif\Admin\Controller\LoginController@logout')->name('admin/logout');
    Route::post('admin/logout', 'Locomotif\Admin\Controller\LoginController@logout');

	// Route::post('admin', 'Locomotif\Admin\Controller\AdminController@store');
	// Route::get('admin/create', 'Locomotif\Admin\Controller\AdminController@create');
	// Route::get('admin/{testimonial}', 'Locomotif\Admin\Controller\AdminController@show');
	// Route::get('admin/{testimonial}/edit', 'Locomotif\Admin\Controller\AdminController@edit');
	// Route::put('admin/{testimonial}', 'Locomotif\Admin\Controller\AdminController@update');
	// Route::delete('admin/{testimonial}', 'Locomotif\Admin\Controller\AdminController@destroy');
});
?>