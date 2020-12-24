<?php

//Tutor prefix route group
Route::group(['prefix' => 'tutor', 'middleware' => 'verify.tutor'], function () {
    Route::get('/', 'Web\Tutor\Auth\LoginController@showLoginForm')->name('tutor.home');
    Route::get('/get/auth/form/{type}', 'Web\Tutor\Auth\LoginController@getAuthForm')->name('tutor.get.auth.form');
    
    Route::group(['middleware' => 'guest:tutor'], function () {
        //Login routes
        Route::get('login', 'Web\Tutor\Auth\LoginController@showLoginForm')->name('tutor.login.show');
        Route::post('login', 'Web\Tutor\Auth\LoginController@login')->name('tutor.login.post');
        
        //Password reset routes
        Route::get('password/reset',
            'Web\Tutor\Auth\ForgotPasswordController@showLinkRequestForm')->name('tutor.password.request');
        Route::post('password/email',
            'Web\Tutor\Auth\ForgotPasswordController@sendResetLinkEmail')->name('tutor.password.reset.email');
        Route::get('password/reset/{token?}',
            'Web\Tutor\Auth\ResetPasswordController@showResetForm')->name('tutor.password.reset.token');
        Route::post('password/reset',
            'Web\Tutor\Auth\ResetPasswordController@reset')->name('tutor.password.reset');
        
        //Register routes
        Route::get('register',
            'Web\Tutor\Auth\RegisterController@showRegistrationForm')->name('tutor.register.show');
        Route::post('register',
            'Web\Tutor\Auth\RegisterController@register')->name('tutor.register.post');
        
        // social links
        Route::get('/login/{social}', 'Web\Tutor\Auth\LoginController@socialLogin')
            ->where('social', 'facebook|twitter|google')->name('tutor.social.login');
        Route::get('/login/{social}/callback', 'Web\Tutor\Auth\LoginController@handleProviderCallback')
            ->where('social', 'facebook|twitter|google')->name('tutor.social.callback');
    });
    //Protected routes for authenticated
    Route::group(['middleware' => 'auth:tutor'], function () {
        Route::get('get/topics', 'Web\Tutor\ProfileController@getTopics')->name('get.topics');
        Route::get('get/languages', 'Web\Tutor\ProfileController@getLanguages')->name('get.languages');
        Route::get('get/statecountry', 'Web\Tutor\ProfileController@getStateCountry')->name('get.statecountry');
        Route::get('get/tutoringStyles', 'Web\Tutor\ProfileController@getTutoringStyles')->name('get.tutoring.styles');
        Route::get('get/interests', 'Web\Tutor\ProfileController@getInterests')->name('get.interests');
        
        
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', 'Web\Tutor\ProfileController@index')->name('tutor.profile.show');
            Route::get('add', 'Web\Tutor\ProfileController@addProfile')->name('tutor.profile.add');
            Route::post('pic/change', 'Web\Tutor\ProfileController@changeProfilePicture')->name('tutor.profile.pic.change');
            Route::post('video/change', 'Web\Tutor\ProfileController@changeProfileVideo')->name('tutor.profile.video.change'); // not set then set it , if set then update the video
            Route::delete('video/remove', 'Web\Tutor\ProfileController@removeProfileVideo')->name('tutor.profile.video.remove');
            
            
            Route::post('specialization/add', 'Web\Tutor\ProfileController@addSpecialization')->name('tutor.profile.specialization.add');
            Route::post('language/add', 'Web\Tutor\ProfileController@addLanguage')->name('tutor.profile.language.add');
            
            Route::post('tutoringStyle/add', 'Web\Tutor\ProfileController@addTutoringStyle')->name('tutor.profile.tutoring.style.add');
            Route::post('interest/add', 'Web\Tutor\ProfileController@addInterests')->name('tutor.profile.interest.add');
            Route::post('certificate/add', 'Web\Tutor\ProfileController@addCertificate')->name('tutor.profile.certificate.add');
            Route::post('education/add', 'Web\Tutor\ProfileController@addEducation')->name('tutor.profile.education.add');
            Route::post('state_country/add', 'Web\Tutor\ProfileController@addStateCountry')->name('tutor.profile.state_country.add');
            Route::post('availabilitySchedule/add', 'Web\Tutor\ProfileController@addAvailabilitySchedule')->name('tutor.profile.availability.schedule.add');
            
            Route::delete('specialization/remove', 'Web\Tutor\ProfileController@removeSpecialization')->name('tutor.profile.specialization.remove');
            Route::delete('language/remove', 'Web\Tutor\ProfileController@removeLanguage')->name('tutor.profile.language.remove');
            Route::delete('tutoring_style/remove', 'Web\Tutor\ProfileController@removeTutoringStyle')->name('tutor.profile.tutoring_style.remove');
            Route::delete('interests/remove', 'Web\Tutor\ProfileController@removeInterest')->name('tutor.profile.interest.remove');
            Route::delete('certification/remove', 'Web\Tutor\ProfileController@removeCertification')->name('tutor.profile.certificate.remove');
            Route::delete('availabilitySchedule/remove', 'Web\Tutor\ProfileController@removeAvailabilitySchedule')->name('tutor.profile.availability.schedule.remove');
            
            Route::post('certificate/get', 'Web\Tutor\ProfileController@getCertificate')->name('tutor.profile.certificate.get');
            Route::put('certificate/update', 'Web\Tutor\ProfileController@updateCertificate')->name('tutor.profile.certificate.update');
            Route::put('education/update', 'Web\Tutor\ProfileController@updateEducation')->name('tutor.profile.education.update');
            Route::put('state_country/update', 'Web\Tutor\ProfileController@updateStateCountry')->name('tutor.profile.state_country.update');
        });
        
        Route::post('logout', 'Web\Tutor\Auth\LoginController@logout')->name('tutor.logout');
        Route::get('offline', 'Web\Tutor\Auth\LoginController@offline')->name('tutor.offline');
        Route::get('dashboard', 'Web\Tutor\DashboardController@index')->name('tutor.dashboard');
        Route::get('dashboard/{tab}', 'Web\Tutor\DashboardController@tab')->name('tutor.dashboard.tab');
        Route::get('dashboard/res', 'Web\Tutor\DashboardController@reservation')->name('tutor.dashboard.reservation');
        Route::post('availability', 'Web\Tutor\DashboardController@availabilityCheck')->name('tutor.availability.post');
        Route::post('busy', 'Web\Tutor\DashboardController@busyCheck')->name('tutor.busy.post');
        //Reservations Approval/Disapproval
        Route::post('/approve/{id}', 'Web\Tutor\DashboardController@approve')->name('tutor.approve');
        Route::post('/decline/{id}', 'Web\Tutor\DashboardController@decline')->name('tutor.decline');
        // learning session
        Route::group(['prefix' => 'learningSession'], function () {
            Route::post('/'
                , 'Web\Tutor\LearningSession\LearningSessionController@index')->name('tutor.learning.session');
            //
            Route::post('request/response',
                'Web\Tutor\LearningSession\LearningSessionRequestController@response')->name('tutor.learning.session.request.response');
            Route::get('create/{learning_session_request_id}',
                'Web\Tutor\LearningSession\LearningSessionController@createLearningSession')->name('tutor.learning.session.create');
            Route::post('complete',
                'Web\Tutor\LearningSession\LearningSessionController@completeLearningSession')->name('tutor.learning.session.complete');
            
            // chat token
            Route::post('chat/token',
                'Web\Tutor\LearningSession\LearningSessionController@chatToken')->name('tutor.learning.session.chat.token');
            
            // track
            Route::post('track',
                'Web\Tutor\LearningSession\LearningSessionController@trackSession')->name('tutor.learning.session.track');
            
        });
        
        // individual chat
        Route::group(['prefix' => 'chat'], function () {
            Route::get('individual/student/{student_id}', 'Web\Tutor\Chat\IndividualChatController@chat_with_student')->name('individual.chat');
        });
        
        // Settings
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', 'Web\Tutor\SettingsController@index')->name('tutor.account.settings');
            Route::get('dashboard/{tab}', 'Web\Tutor\SettingsController@tab')->name('tutor.settings.tab');
            Route::post('update/account/details', 'Web\Tutor\SettingsController@updateAccountDetails')->name('tutor.setting.update.account.detail');
            Route::post('add/card/details', 'Web\Tutor\SettingsController@addCardDetails')->name('tutor.setting.add.card.detail');
            Route::post('update/card/details', 'Web\Tutor\SettingsController@updateCardDetails')->name('tutor.setting.update.card.detail');
            Route::post('update/preferences', 'Web\Tutor\SettingsController@updatePreferences')->name('tutor.setting.update.preferences');
        });
    });
});
