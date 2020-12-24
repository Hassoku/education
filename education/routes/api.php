<?php

use App\Helpers\CommonHelper;
use Dingo\Api\Routing\Router;
use Illuminate\Http\Request;

$api = app(Router::class);
$api->version(
    'v1',
    ['namespace' => 'App\Http\Controllers\Api\V1', 'prefix' => 'api'],
    function (Router $api) {
        // greetings
        $api->get('/', function () {
            return response()->json(['greetings' => 'api welcomes you'])->setStatusCode(200);
        });
        // help
        $api->get('/help', function () {
            return view('help');
        });
        // about
        $api->get('/about', function () {
            return view('about');
        });

        // login
        $api->post('login', ['as' => 'api.student.login', 'uses' => 'Auth\LoginController@login',]);
    
        // Check Facebook Social Id Exists- login
        $api->post('check/social/', ['as' => 'api.student.check.social', 'uses' => 'Auth\LoginController@checkSocialId',]);

        // social - login
        $api->post('login/social', ['as' => 'api.student.login.social', 'uses' => 'Auth\LoginController@socialLogin',]);

        // register
        $api->post('register', ['as' => 'api.student.register', 'uses' => 'Auth\RegisterController@register',]);

        // password reset link
        $api->get('password/reset', ['as' => 'api.password.reset', 'uses' => 'Auth\ForgotPasswordController@restPassword']);

        // register the student device
        $api->post('device',['as' => 'api.student.store.device', 'uses' => 'StudentDeviceController@store']);

        // test pusher
        $api->post('pusher', function (Request $request){
            $id = $request->get('id');
            $student_name = $request->get('student_name');
            $channel = $request->get('channel').'.'.$id;
            $event = $request->get('event');

            $data['student_name'] = $student_name;
            CommonHelper::puhser()->trigger('' . $channel,''.$event, $data);

            return "pusher sent";
        });

        // testing
        $api->get('learningSession/complete/all', function (){
           return \App\Helpers\LearningSessionCommonHelper::completeAllSessions();
        });
        $api->get('/fcm/{tutor_id}', function ($tutor_id) {
           return \App\Helpers\TutorCommonHelper::sendFCMNotifications($tutor_id);
           });


        /*
         * An open url to get notification for payment callbacks like(bad Internet connection or crashes)
         * GET {notificationUrl}?id={id}&resourcePath={resourcePath}
         * */
        $api->get('payment/notify', 'PaymentController@notify');


        /*
         * Need Authentication
         * jwt Brear token is needed
         * */
        $api->group(['middleware' => 'auth:api'], function (Router $api) {
            // logout
            $api->delete('logout', ['as' => 'api.student.logout', 'uses' => 'Auth\loginController@logout',]);

            // get user
            $api->get('student/{id}',['as' => 'api.student.show', 'uses' => 'StudentController@show']);

            // get authenticated user
            $api->get('me',['as' => 'me', 'uses' => 'StudentController@me']);

            // update authenticated user password
            $api->put('me/password', ['as' => 'me.update.password', 'uses' => 'StudentController@updatePassword']);

            // update me
            $api->post('me', ['as' => 'me.update', 'uses' => 'StudentController@updateMe']);

            // tutor
            $api->group(['prefix' => 'tutor'], function (Router $api){
                $api->get('/all',['as' => 'api.tutor.list', 'uses' => 'TutorController@index']);

                // tutor availabilities
                $api->post('reservation/availability',['as' => 'api.tutor.reservation.availability', 'uses' => 'TutorController@get_availabilities_available_slots']);

                // tutor reservation
                $api->post('reservation',['as' => 'api.tutor.reservation', 'uses' => 'TutorController@reserve_for_learning_session']);

                // delete reservation
                $api->delete('reservation', 'TutorController@delete_learning_session_reservation')->name('api.tutor.reservation.delete');

                // for rate the tutor
                $api->post('rating',['as' => 'api.tutor.rating', 'uses' => 'TutorController@rating']);

                // adding to favorite
                $api->post('/add/fav', ['as' => 'api.tutor.add.to.fav', 'uses' => 'TutorController@addToFav']);

                // removing from favorite
                $api->post('/remove/fav', ['as' => 'api.tutor.remove.from.fav', 'uses' => 'TutorController@removeToFav']);

                // fav tutors list
                $api->get('/fav', ['as' => 'api.fav.tutors', 'uses' => 'TutorController@favTutors']);

                // report
                $api->post('/report', ['as' => 'api.tutor.report', 'uses' => 'TutorController@reportTutor']);

                // notify: tutor availability
                $api->post('/add/notifyTA', ['as' => 'api.tutor.add.notifyTA', 'uses' => 'TutorController@addNotifyStudentTA']);
                $api->delete('/delete/notifyTA', ['as' => 'api.tutor.delete.notifyTA', 'uses' => 'TutorController@deleteNotifyStudentTA']);

                // chat
                $api->group(['prefix' => 'chat'], function (Router $api) {
                    $api->get('/individual/{tutor_id}', ['as' => 'api.tutor.individual.chat',
                        'uses' => 'Chat\IndividualChatController@chat_with_tutor']);
                });
            });

            // Learning Session
            $api->group(['prefix' => 'learningSession'], function (Router $api) {
                // request generate
                $api->post('request', 'LearningSession\LearningSessionRequestController@generate')->name('api.learning.session.request.generate');

                // request send
                $api->post('request/send', 'LearningSession\LearningSessionRequestController@send')->name('api.learning.session.request.send');

                // withdraw the session request
                $api->get('request/{learning_session_request_id}/withdraw', 'LearningSession\LearningSessionRequestController@withdraw')->name('api.learning.session.request.withdraw');

                // complete the session
                $api->post('/complete', 'LearningSession\LearningSessionController@complete')->name('api.learning.session.complete');

                // chat token
                $api->post('chat/token', 'LearningSession\LearningSessionController@chatToken')->name('api.learning.session.chat.token');

                // reservations
                $api->get('reservations', 'LearningSession\LearningSessionController@get_student_reserved_session_list')->name('api.learning.session.student.reservations');

                // history
                $api->get('history', 'LearningSession\LearningSessionController@sessionArchives')->name('api.learning.session.history');
            });

            // subscription
            $api->group(['prefix' => 'subscription'], function (Router $api) {
                // packages
                $api->get('packages','SubscriptionController@packages')->name('api.subscription.packages');

                // buy packages
                // Student Subscription Packages
                $api->post('buy/package','SubscriptionController@buy_package')->name('api.buy.subscription.package');

                // Student remaining minutes
                $api->get('remaining/minutes','SubscriptionController@remaining_minutes')->name('api.subscription.remaining.minutes');
            });

            // topics
            $api->group(['prefix' => 'topic'], function (Router $api) {
                // all topics and subjects
                $api->get('all','TopicController@index')->name('api.topics.all');

                // tutor of topic
                $api->get('{topic_id}/tutors','TopicController@topic_tutors')->name('api.topic.all.tutors');
            });

            // payment: history
            $api->group(['prefix' => 'payment'], function (Router $api) {
                $api->get('/history','PaymentController@paymentHistory')->name('api.payment.history');
            });

        });
    });