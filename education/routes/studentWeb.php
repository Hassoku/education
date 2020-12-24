<?php

//Student prefix route group
Route::group(['prefix' => 'student', 'middleware' => 'verify.student'], function () {
    Route::get('/', 'Web\Student\Auth\LoginController@showLoginForm')->name('student.home');
    Route::get('/get/auth/form/{type}', 'Web\Student\Auth\LoginController@getAuthForm')->name('student.get.auth.form');
    
    Route::group(['middleware' => 'guest:student'], function() {
        //Login routes
        Route::get('login', 'Web\Student\Auth\LoginController@showLoginForm')->name('student.login.show');
        Route::post('login', 'Web\Student\Auth\LoginController@login')->name('student.login.post');
       
        //Second-Page Student Details
        Route::get('details', 'Web\Student\StudenDetailController@index')->name('student.details');
        Route::post('details', 'Web\Student\StudenDetailController@store')->name('student.detail.post');
        
       
        
        //Password reset routes
        Route::get('password/reset',
            'Web\Student\Auth\ForgotPasswordController@showLinkRequestForm')->name('student.password.request');
        Route::post('password/email',
            'Web\Student\Auth\ForgotPasswordController@sendResetLinkEmail')->name('student.password.reset.email');
        Route::get('password/reset/{token?}',
            'Web\Student\Auth\ResetPasswordController@showResetForm')->name('student.password.reset.token');
        Route::post('password/reset',
            'Web\Student\Auth\ResetPasswordController@reset')->name('student.password.reset');
        
        //Register routes
        Route::get('register',
            'Web\Student\Auth\RegisterController@showRegistrationForm')->name('student.register.show');
        Route::post('register',
            'Web\Student\Auth\RegisterController@register')->name('student.register.post');
        // Route::get('register', 'Web\Student\Auth\RegisterController@showRegistrationForm')->name('student.register.show');
        // Route::post('register', 'Web\Student\Auth\RegisterController@register')->name('student.register.post');
        
        // Route::get('/register/create-step2', 'Web\Student\Auth\RegisterController@showRegistrationForm2');
        // Route::post('/register/create-step2','Web\Student\Auth\RegisterController@register2');
        
        //Email Activation
        Route::get('activation/{activation_code}',
            'Web\Student\Auth\ActivationController@index')->name('student.email.activation');
        
        // invite
        Route::get('invite/{ref_code}',
            'Web\Student\Auth\InvitationController@showRegistrationForm')->name('student.invite.register.show');
        Route::post('invite/register',
            'Web\Student\Auth\InvitationController@register')->name('student.invite.register.post');
        
        // social links
        Route::get('/login/{social}','Web\Student\Auth\LoginController@socialLogin')
            ->where('social','facebook|twitter|google')->name('student.social.login');
        Route::get('/login/{social}/callback','Web\Student\Auth\LoginController@handleProviderCallback')
            ->where('social','facebook|twitter|google')->name('student.social.callback');
        
        
    });
    //Protected routes for authenticated
    Route::group(['middleware' => 'auth:student'], function () {
        Route::post('logout', 'Web\Student\Auth\LoginController@logout')->name('student.logout');
        Route::get('offline', 'Web\Student\Auth\LoginController@offline')->name('student.offline');
        Route::get('dashboard', 'Web\Student\DashboardController@index')->name('student.dashboard');
        Route::get('dashboard/p/', 'Web\Student\DashboardController@page')->name('student.dashboard.page');
        //dynamic dropdown country and states
        Route::post('dashboard/get-states-by-country','Web\Student\DashboardController@getState')->name('student.dashboard.getState');
        //reservation
        Route::get('dashboard/tutor/reservation/{tutor_id}','Web\Student\DashboardController@reservation')->name('student.dashboard.reservation');
        Route::post('dashboard/tutor/reservation/placed','Web\Student\DashboardController@reservationStore')->name('student.dashboard.reservation.store');

        Route::get('tutor', 'Web\Student\DashboardController@tutorall')->name('student.tutors');
        Route::post('availability', 'Web\Student\DashboardController@availabilityCheck')->name('student.availability.post');
        Route::post('', 'Web\Student\DashboardController@update')->name('student.profile.update');
        //Search
        Route::get('/search', 'Web\Student\DashboardController@search')->name('search');
        Route::get('/serach/tutor', 'Web\Student\DashboardController@searchTutor')->name('search.tutor');


        Route::post('/autocomplete','Web\Student\DashboardController@autocomplete')->name('autocomplete');
        // profile
        Route::group(['prefix' => 'profile'], function () {
            
            Route::get('/','Web\Student\ProfileController@index')->name('student.profile.show');
            Route::post('/create','Web\Student\ProfileController@store')->name('student.profile.store');
            //Route::get('add','Web\Student\ProfileController@addProfile')->name('student.profile.add');
            Route::post('pic/change','Web\Student\ProfileController@changeProfilePicture')->name('student.profile.pic.change');
            
        });
       
        // tutor
        Route::group(['prefix' => 'tutor'], function () {
            // all tutors ajax
            Route::get('ajax/all', 'Web\Student\TutorController@listAllTutors')->name('student.ajax.tutors.all');
            Route::post('ajax/reservation/availability', 'Web\Student\TutorController@get_availabilities_available_slots')->name('student.ajax.tutor.reservation.availability');
            Route::post('ajax/reservation', 'Web\Student\TutorController@reserve_for_learning_session')->name('student.ajax.tutor.reservation');
            Route::delete('ajax/reservation/delete', 'Web\Student\TutorController@delete_learning_session_reservation')->name('student.ajax.tutor.reservation.delete');
            Route::post('ajax/report', 'Web\Student\TutorController@reportTutor')->name('student.ajax.tutor.reportTutor');
            Route::post('ajax/NotifyStudentTA/add', 'Web\Student\TutorController@addNotifyStudentTA')->name('student.ajax.tutor.NotifyStudentTA.add');
            Route::delete('ajax/NotifyStudentTA/delete', 'Web\Student\TutorController@deleteNotifyStudentTA')->name('student.ajax.tutor.NotifyStudentTA.delete');
            
            // tutor profile
            Route::get('p/{tutor_id}', 'Web\Student\TutorController@showTutorProfile')->name('student.tutorProfile.show');
        });
        
        // learning session
        Route::group(['prefix' => 'learningSession'], function () {
            Route::get('request/{tutor_id}', 'Web\Student\TutorController@learningSessionRequest')->name('student.learningSession.request.tutor');
            Route::post('request', 'Web\Student\LearningSession\LearningSessionRequestController@generate')->name('student.learningSession.request.generate');
            Route::get('request/{learning_session_request_id}/withdraw', 'Web\Student\LearningSession\LearningSessionRequestController@withdraw')->name('student.learningSession.request.withdraw');
            
            Route::get('/','Web\Student\LearningSession\LearningSessionController@joinLearningSession')->name('student.join.learning.session');
            Route::post('complete', 'Web\Student\LearningSession\LearningSessionController@complete')->name('student.learning.session.complete');
            Route::post('chat/token', 'Web\Student\LearningSession\LearningSessionController@chatToken')->name('student.learning.session.chat.token');
            
            // session archives
            Route::get('archives', 'Web\Student\LearningSession\LearningSessionController@sessionArchives')->name('student.learning.session.archives');
            Route::get('{id}/archive', 'Web\Student\LearningSession\LearningSessionController@sessionArchive')->name('student.learning.session.archive');
        });
        
        // individual chat
        Route::group(['prefix' => 'chat'], function (){
            Route::get('individual/tutor/{tutor_id}', 'Web\Student\Chat\IndividualChatController@chat_with_tutor')->name('student.individual.chat');
        });

//        Setting
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', 'Web\Student\SettingController@index')->name('student.setting');
            Route::get('/{tab}', 'Web\Student\SettingController@tab')->name('student.setting.tab');
            Route::post('update/preferences', 'Web\Student\SettingController@updatePreferences')->name('student.setting.update.preferences');
        });
        
        // subscription
        Route::group(['prefix' => 'subscription'], function () {
            Route::get('/','Web\Student\SubscriptionController@index')->name('student.subscription');
            
            //////////////////////////////////////////////////////// AJAX //////////////////////////////////
            // packages
            Route::get('ajax/packages','Web\Student\SubscriptionController@packages')->name('student.ajax.subscription.packages');
            // buy packages
//            Route::post('ajax/buy/package','Web\Student\SubscriptionController@buy_package')->name('student.ajax.buy.subscription.package');
            Route::get('ajax/buy/package/{subscription_package_id}','Web\Student\SubscriptionController@buy_package')->name('student.ajax.buy.subscription.package');
            // Student remaining minutes
            Route::get('ajax/remaining/minutes','Web\Student\SubscriptionController@remaining_minutes')->name('student.ajax.subscription.remaining.minutes');
        });
        
        // free minutes
        Route::get('/freeMinutes','Web\Student\FreeMinutesController@index')->name('student.freeMinutes');
        
        // payment
        Route::group(['prefix' => 'payment'], function () {
            Route::get('/subscriptionPackage/{subscription_package_id}','Web\Student\PaymentController@index')->name('student.payment');
            Route::get('/checkout/{checkoutId}/subscriptionPackage/{subscription_package_id}','Web\Student\PaymentController@checkOut')->name('student.checkout');
            Route::get('/details/subscriptionPackage/{subscription_package_id}','Web\Student\PaymentController@details')->name('student.payment.details');
            Route::get('/history','Web\Student\PaymentController@history')->name('student.paymentHistory');
        });
    });
});
