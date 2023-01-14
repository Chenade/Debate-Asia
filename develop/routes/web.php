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

// Route::get('/', function () {
// 	//return ("Hello World");
// 	return view('fixing');
// 	// return view('index');
// });


Route::prefix('admin')->group(function () {
	// Route::get('/login', 		function () { return view('page.login');});
	Route::get('/', 			function () { return view('page.management.users');});
	Route::get('/competition', 	function () { return view('page.management.competition');});
	Route::get('/banner', 		function () { return view('page.management.banner');});
	Route::get('/ads', 			function () { return view('page.management.ads');});
	Route::get('/natural_8', 	function () { return view('page.management.natural_8');});
	Route::get('/course', 		function () { return view('page.management.course');});
	Route::get('/peter', 		function () { return view('page.management.peter');});
	Route::get('/media', 		function () { return view('page.management.media');});
	// Route::get('/faq', 		function () { return view('page.management.faq'); });
	// Route::get('/logout', 	function () { return view('page.management.faq'); });
});

Route::get('/', 				function () { return view('page.index');});
// Route::get('/guideline', 		function () { return view('page.guideline');});
Route::get('/rules', 			function () { return view('page.rules');});