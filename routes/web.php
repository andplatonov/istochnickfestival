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

// они зашли в бота
Route::get('/stat', 'StatController@firstUsers');
// вопросы
Route::get('/questionStat', 'StatController@questionStat');
// Сказали Да
Route::get('/yes', 'StatController@yesStat');
// рейтинг
Route::get('/star', 'StatController@starStat');
// Пожелания

// рассылка
//Route::get('/q', 'StatController@setFixPhone');



Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');
