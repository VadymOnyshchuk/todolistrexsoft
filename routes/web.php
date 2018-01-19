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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/tasks', 'TaskController@index');
Route::get('/myTasks', 'TaskController@indexMyTasks');
Route::post('/task', 'TaskController@store')->name('task');
/*Route::post('/sendmail', function(\Illuminate\Http\Request $request,
    Illuminate\Mail\Mailer $mailer  ){
    $mailer
        ->to($request->input('receiver'))
        ->send(new \App\Mail\notification($request->input('name')));
    return redirect()->back();
})->name('sendmail');*/
Route::post('/sendmail', 'TaskController@mail')->name('sendmail');
Route::delete('/task/{task}', 'TaskController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
