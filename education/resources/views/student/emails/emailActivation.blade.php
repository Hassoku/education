@extends('student.emails.partials.header')
@section('title','Duroos Student Activation')
    <!-- Email Body : BEGIN -->
        <h2>Welcome to the duroos app {{$student['name']}}</h2>
        <br/>
        Your registered email-id is {{$student['email']}} , Please click on the below link to verify your email account
        <br/>
        <a href="{{route('student.email.activation',[$student['activation_code']])}}">Verify Email</a>
    <!-- Email Body : END -->
@include('student.emails.partials.footer')