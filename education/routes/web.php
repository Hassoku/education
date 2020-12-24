<?php
use Illuminate\Support\Facades\Route;

// error
Route::group(['prefix' => 'error'],function (){
    Route::get('404', function () {
        return view('errors.404');
    })->name('error.404');

    Route::get('419', function () {
        return view('errors.419');
    })->name('error.419');

    Route::get('500', function () {
        return view('errors.500');
    })->name('error.500');

    Route::get('503', function () {
        return view('errors.503');
    })->name('error.503');

    Route::get('505', function () {
        return view('errors.505');
    })->name('error.505');
});


// for local
Route::get('/', function () {return view('welcome');});

//for live
// Route::get('/', 'HomeController@index');
// Route::get('/remove_notification', 'HomeController@removeNotification')->name('remove-notification');

Route::get('/help', function () {
    return view('help');
})->name('help');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

