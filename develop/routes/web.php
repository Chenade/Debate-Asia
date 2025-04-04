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

Route::get('/language/{lang}', function ($lang) {
    $pathname = request()->query('pathname');
    App::setlocale($lang);
    session(['setLocale' => $lang]);
    return redirect($pathname ?: '/');
});

Route::prefix('admin')->group(function () {
	Route::get('/', 				function () { return view('page.management.users');});
	Route::get('/competition', 		function () { return view('page.management.competition');});
	Route::get('/session', 			function () { return view('page.management.session');});
	Route::get('/ranking', 			function () { return view('page.management.ranking');});
});

Route::get('/', 					function () { return view('page.index');});
// Route::get('/guideline', 		function () { return view('page.guideline');});
Route::get('/rules', 				function () { return view('page.rules');});
Route::get('/signup', 				function () { return view('page.signup');});

Route::prefix('candidate')->group(function () {
	Route::get('/', 					function () { return view('page.candidate');});
	Route::get('/session/{sid}', 		function () { return view('page.session');});
	// Route::get('/session', 			function () { return view('page.management.session');});
});

Route::prefix('judge')->group(function () {
	Route::get('/', 					function () { return view('page.judge');});
	Route::get('{sid}/room/{rid}', 		function () { return view('page.grading');});
	// Route::get('/session', 			function () { return view('page.management.session');});
});


use App\Mail\signupConfirmation;
Route::get('send-mail', function () {
   
    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    Mail::to('chenade0312@gmail.com')->send(new signupConfirmation($details));
   
    dd("Email is Sent.");
});