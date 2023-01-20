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
	Route::get('/session', 		function () { return view('page.management.session');});
});

Route::get('/', 				function () { return view('page.index');});
// Route::get('/guideline', 		function () { return view('page.guideline');});
Route::get('/rules', 			function () { return view('page.rules');});


Route::prefix('candidate')->group(function () {
	// Route::get('/login', 		function () { return view('page.login');});
	Route::get('/{mid}', 				function () { return view('page.candidate');});
	Route::get('/{mid}/session/{sid}', 	function () { return view('page.session');});
	Route::get('/session', 				function () { return view('page.management.session');});
});