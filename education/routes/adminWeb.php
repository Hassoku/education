<?php

// Admin
Route::group(['prefix' => 'admin', 'middleware' => 'verify.admin'], function () {
    Route::get('/', 'Web\Admin\Auth\LoginController@showLoginForm')->name('admin.home');
    Route::group(['middleware' => 'guest:admin'], function() {
        //Login routes
        Route::get('login', 'Web\Admin\Auth\LoginController@showLoginForm')->name('admin.login.show');
        Route::post('login', 'Web\Admin\Auth\LoginController@login')->name('admin.login.post');
        
        //Password reset routes
        Route::get('password/reset',
            'Web\Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        Route::post('password/email',
            'Web\Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.reset.email');
        Route::get('password/reset/{token?}',
            'Web\Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset.token');
        Route::post('password/reset',
            'Web\Admin\Auth\ResetPasswordController@reset')->name('admin.password.reset');
        
        //Register routes
        Route::get('register',
            'Web\Admin\Auth\RegisterController@showRegistrationForm')->name('admin.register.show');
        Route::post('register',
            'Web\Admin\Auth\RegisterController@register')->name('admin.register.post');
    });
    
    //Protected routes for authenticated
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::post('logout', 'Web\Admin\Auth\LoginController@logout')->name('admin.logout');
        Route::get('dashboard', 'Web\Admin\DashboardController@index')->name('admin.dashboard');
        
        // student
        Route::group(['prefix' => 'students'],function (){
            Route::get('/', 'Web\Admin\StudentController@index')->name('admin.students');
            Route::get('/create', 'Web\Admin\StudentController@create')->name('admin.student.create');
            Route::post('/store', 'Web\Admin\StudentController@store')->name('admin.student.store');
            Route::get('/{id}', 'Web\Admin\StudentController@show')->name('admin.student.show');
            Route::get('/edit/{id}', 'Web\Admin\StudentController@edit')->name('admin.student.edit');
            Route::get('/delete/{id}', 'Web\Admin\StudentController@destroy')->name('admin.student.delete');
            Route::post('/update/{id}/info', 'Web\Admin\StudentController@updateInfo')->name('admin.student.update.info');
            Route::post('/update/{id}/status', 'Web\Admin\StudentController@updateStatus')->name('admin.student.update.status');
            Route::get('/free/minutes/{id}', 'Web\Admin\StudentController@assignFreeMinutes')->name('admin.student.assign.free.minutes');
        });
        // tutor
        Route::group(['prefix' => 'tutors'],function (){
            Route::get('/', 'Web\Admin\TutorController@index')->name('admin.tutors');
            Route::get('/create', 'Web\Admin\TutorController@create')->name('admin.tutor.create');
            Route::post('/store', 'Web\Admin\TutorController@store')->name('admin.tutor.store');
            Route::get('/{id}', 'Web\Admin\TutorController@show')->name('admin.tutor.show');
            Route::get('/edit/{id}', 'Web\Admin\TutorController@edit')->name('admin.tutor.edit');
            Route::delete('/delete/{id}', 'Web\Admin\TutorController@destroy')->name('admin.tutor.delete');
            Route::post('/update/{id}/info', 'Web\Admin\TutorController@updateInfo')->name('admin.tutor.update.info');
            Route::post('/update/{id}/status', 'Web\Admin\TutorController@updateStatus')->name('admin.tutor.update.status');
            
            Route::group(['prefix' => 'ajax'],function (){
                Route::group(['prefix' => 'profile'],function (){
                    Route::post('/{id}/pic/change','Web\Admin\TutorController@changeProfilePicture')->name('admin.ajax.tutor.profile.pic.change');
                    Route::delete('/{id}/pic/remove','Web\Admin\TutorController@removeProfilePicture')->name('admin.ajax.tutor.profile.pic.remove');
                    Route::post('/{id}/video/change','Web\Admin\TutorController@changeProfileVideo')->name('admin.ajax.tutor.profile.video.change');
                    Route::delete('/{id}/video/remove','Web\Admin\TutorController@removeProfileVideo')->name('admin.ajax.tutor.profile.video.remove');
                    
                    // specialization
                    Route::get('/{id}/get/topics', 'Web\admin\TutorController@getTopics')->name('admin.ajax.tutor.get.topics');
                    Route::post('/{id}/specialization/add','Web\Admin\TutorController@addSpecialization')->name('admin.ajax.tutor.profile.specialization.add');
                    Route::delete('/{id}/specialization/remove','Web\Admin\TutorController@removeSpecialization')->name('admin.ajax.tutor.profile.specialization.remove');
                    
                    // language
                    Route::get('/{id}/get/languages', 'Web\Admin\TutorController@getLanguages')->name('admin.ajax.tutor.get.languages');
                    Route::post('/{id}/language/add','Web\Admin\TutorController@addLanguage')->name('admin.ajax.tutor.profile.language.add');
                    Route::delete('/{id}/language/remove','Web\Admin\TutorController@removeLanguage')->name('admin.ajax.tutor.profile.language.remove');
                    
                    // tutoring style
                    Route::get('/{id}/get/tutoringStyles', 'Web\Admin\TutorController@getTutoringStyles')->name('admin.ajax.tutor.get.tutoring.styles');
                    Route::post('/{id}/tutoringStyle/add','Web\Admin\TutorController@addTutoringStyle')->name('admin.ajax.tutor.profile.tutoring.style.add');
                    Route::delete('/{id}/tutoring_style/remove','Web\Admin\TutorController@removeTutoringStyle')->name('admin.ajax.tutor.profile.tutoring_style.remove');
                    
                    // interest
                    Route::get('/{id}/get/interests', 'Web\Admin\TutorController@getInterests')->name('admin.ajax.tutor.get.interests');
                    Route::post('/{id}/interest/add','Web\Admin\TutorController@addInterests')->name('admin.ajax.tutor.profile.interest.add');
                    Route::delete('/{id}/interests/remove','Web\Admin\TutorController@removeInterest')->name('admin.ajax.tutor.profile.interest.remove');
                    
                    // certification
                    Route::post('/{id}/certificate/add','Web\Admin\TutorController@addCertificate')->name('admin.ajax.tutor.profile.certificate.add');
                    Route::delete('/{id}/certification/remove','Web\Admin\TutorController@removeCertification')->name('admin.ajax.tutor.profile.certificate.remove');
                    Route::post('/{id}/certificate/get','Web\Admin\TutorController@getCertificate')->name('admin.ajax.tutor.profile.certificate.get');
                    Route::put('/{id}/certificate/update','Web\Admin\TutorController@updateCertificate')->name('admin.ajax.tutor.profile.certificate.update');
                    
                    // education
                    Route::post('/{id}/education/add','Web\Admin\TutorController@addEducation')->name('admin.ajax.tutor.profile.education.add');
                    Route::put('/{id}/education/update','Web\Admin\TutorController@updateEducation')->name('admin.ajax.tutor.profile.education.update');
                    
                    // Availability
                    Route::post('/{id}/availabilitySchedule/add','Web\Admin\TutorController@addAvailabilitySchedule')->name('admin.ajax.tutor.profile.availability.schedule.add');
                    Route::delete('/{id}/availabilitySchedule/remove','Web\Admin\TutorController@removeAvailabilitySchedule')->name('admin.ajax.tutor.profile.availability.schedule.remove');
                    
                });
            });
        });
        // session
        /*Route::group(['prefix' => 'sessions'],function (){
            Route::get('/', 'Web\Admin\SessionController@index')->name('admin.sessions');
            Route::get('/{id}', 'Web\Admin\SessionController@show')->name('admin.session.show');
            Route::get('/edit/{id}', 'Web\Admin\SessionController@edit')->name('admin.session.edit');
        });*/
        // topic
        Route::group(['prefix' => 'subjects'],function (){
            Route::get('/', 'Web\Admin\SubjectController@index')->name('admin.subjects');
            Route::post('/store', 'Web\Admin\SubjectController@store')->name('admin.subject.store');
            Route::get('/create', 'Web\Admin\SubjectController@create')->name('admin.subject.create');
            Route::get('/{id}', 'Web\Admin\SubjectController@show')->name('admin.subject.show');
            Route::get('/edit/{id}', 'Web\Admin\SubjectController@edit')->name('admin.subject.edit');
            Route::delete('/delete/{id}', 'Web\Admin\SubjectController@destroy')->name('admin.subject.delete');
            Route::post('/update/{id}/info', 'Web\Admin\SubjectController@updateInfo')->name('admin.subject.update.info');
        });
        Route::group(['prefix' => 'topics'],function (){
            Route::get('/', 'Web\Admin\TopicController@index')->name('admin.topics');
            Route::get('/create', 'Web\Admin\TopicController@create')->name('admin.topic.create');
            Route::post('/store', 'Web\Admin\TopicController@store')->name('admin.topic.store');
            Route::get('/{id}', 'Web\Admin\TopicController@show')->name('admin.topic.show');
            Route::get('/edit/{id}', 'Web\Admin\TopicController@edit')->name('admin.topic.edit');
            Route::delete('/delete/{id}', 'Web\Admin\SubjectController@destroy')->name('admin.topic.delete');
            Route::post('/update/{id}/info', 'Web\Admin\TopicController@updateInfo')->name('admin.topic.update.info');
        });
        
        // reports
        Route::group(['prefix' => 'reports'],function (){
            Route::get('/', 'Web\Admin\ReportController@index')->name('admin.reports');
            Route::get('/tutor/{id}', 'Web\Admin\ReportController@showTutor')->name('admin.reports.tutor.show');
            Route::get('/student/{id}', 'Web\Admin\ReportController@showStudent')->name('admin.reports.student.show');
            Route::get('/export/{tab}', 'Web\Admin\ReportController@exportReport')->name('admin.reports.export');
        });
        
        // Tut/Std Reporting
        Route::group(['prefix' => 'reporting'],function (){
            Route::get('/', 'Web\Admin\ReportingController@index')->name('admin.tut_std.reporting');
            
            Route::get('/t', 'Web\Admin\ReportingController@tutorReports')->name('admin.tut_std.reporting.tutor');
            Route::get('/t/{id}', 'Web\Admin\ReportingController@tutorReportShow')->name('admin.tut_std.reporting.tutor.show');
            Route::get('/t/edit/{id}', 'Web\Admin\ReportingController@tutorReportEdit')->name('admin.tut_std.reporting.tutor.edit');
            Route::post('/t/update/{id}', 'Web\Admin\ReportingController@tutorReportUpdate')->name('admin.tut_std.reporting.tutor.update');
            
            Route::get('/s', 'Web\Admin\ReportingController@studentReports')->name('admin.tut_std.reporting.student');
            Route::get('/s/{id}', 'Web\Admin\ReportingController@studentReportShow')->name('admin.tut_std.reporting.student.show');
            Route::get('/s/edit/{id}', 'Web\Admin\ReportingController@studentReportEdit')->name('admin.tut_std.reporting.student.edit');
            Route::post('/s/update/{id}', 'Web\Admin\ReportingController@studentReportUpdate')->name('admin.tut_std.reporting.student.update');
        });
        
        // settings
        Route::group(['prefix' => 'settings'],function (){
            Route::get('/', 'Web\Admin\SettingController@index')->name('admin.settings');
            
            // language
            Route::group(['prefix' => 'subscriptionPackage'], function (){
                Route::post('/add', 'Web\Admin\SettingController@addSubscriptionPackage')->name('admin.subscriptionPackage.add');
                Route::get('{id}/edit', 'Web\Admin\SettingController@addSubscriptionPackageEdit')->name('admin.subscriptionPackage.edit');
                Route::post('{id}/update', 'Web\Admin\SettingController@addSubscriptionPackageUpdate')->name('admin.subscriptionPackage.update');
            });
            // language
            Route::group(['prefix' => 'language'], function (){
                Route::post('/add', 'Web\Admin\SettingController@addLanguage')->name('admin.language.add');
            });
            // Tutoring Style
            Route::group(['prefix' => 'tutoringStyle'], function (){
                Route::post('/add', 'Web\Admin\SettingController@addTutoringStyle')->name('admin.tutoringStyle.add');
                Route::post('/edit', 'Web\Admin\SettingController@editTutoringStyle')->name('admin.tutoringStyle.edit');
            });
            // Interest
            Route::group(['prefix' => 'interest'], function (){
                Route::post('/add', 'Web\Admin\SettingController@addInterest')->name('admin.interest.add');
                Route::post('/edit', 'Web\Admin\SettingController@editInterest')->name('admin.interest.edit');
            });
        });
    });
});
