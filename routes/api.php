<?php

use Illuminate\Support\Facades\Route;

Route::get('/apartments/all', 'ApartmentsController@all');

Route::get('/apartments', 'ApartmentsController@ApartmentsOnUserPage')->middleware('verifyToken');

Route::post('/apartments', 'ApartmentsController@apartments')->middleware('verifyTokenCreateApartments');

Route::delete('/apartments/{id}', 'ApartmentsController@delete');

Route::get('apartments/{id}', 'ApartmentsController@get');

Route::patch('apartments/{id}', 'ApartmentsController@patch');

Route::post('/apartments/{id}/image', 'ImagesController@images');
