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

Route::get('/', 'Controller@serve')->name('home');
Route::post('/contribution', 'Controller@handleContributionForm')->name('handle-contribution');
Route::post('/mutation', 'Controller@handleMutationForm')->name('handle-mutation');
