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

//GET DATA FOR HOMPEPAGE
Route::get('/', 'getData@getStrikingClass');

//GET DATA FOR SEARCH
Route::post('/getSearchKey', 'getData@getSearchKey');

//GET ALL CLASSES
Route::get('/allclasses', 'getData@getAllClasses');

//GET CLASS ORDER BY SORT
Route::post('/sortClass', 'getData@getSortedClasses');

//GET CLASS DETAIL
Route::post('/classdetail', 'getData@getClassDetail');
