<?php

use App\Models\LearningSessions\LearningSessionRequest;
use App\Models\Users\Students\Student;
use App\Models\Users\Tutors\Tutor;
use Illuminate\Support\Facades\Broadcast;

/*Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});*/

/*
 * Learning Session Request channel for active and authenticated tutor
 * */

/*Broadcast::channel('Learning_session.request.tutor.{id}', function ($learning_session_request, $id) {
    // verifying that the tutor is the same tutor which is in LearningSessionRequest
    return $learning_session_request->tutor_id === Tutor::find($id)->id;
});

/*
 * Tutor status
 * */
/*Broadcast::channel('tutor.status.{student_id}', function ($student, $student_id) {
    // checking whether student is authorized
    return $student->id === Student::find($student_id)->id;
});*/