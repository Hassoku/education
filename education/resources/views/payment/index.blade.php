<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('assets/admin/images/favicon.png')}}">
    <title>Payment</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            /*background-color: #fff;*/
            background-color: #8AD3FF;

            /*color: #636b6f;*/
            color: #000000;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 42px;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .m-b-md {
            margin-top: 50px;
        }

        .welcome-logo{
            width: 200px;
        }

        .des{
            font-size: 20px;
        }

    </style>

    {{--adding hyper pay widget--}}
    <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$checkoutId}}"></script>
    <script>var wpwlOptions = {style:"card"}</script>
</head>
<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <img class="welcome-logo" src="{{asset('assets/admin/images/logo/durooos-logo.png')}}">
            <div class="title">
                <span class="">Pay Here</span>
            </div>

            {{--<form action="@if(Auth::guard('student')->check()){{route('student.payment.details',['subscription_package_id' => $subscription_package_id])}}@elseif(Auth::guard('api')->check()){{route('api.payment.details',['subscription_package_id' => $subscription_package_id])}}@endif"--}}
            <form action="{{route('student.payment.details',['subscription_package_id' => $subscription_package_id])}}" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
        </div>
    </div>
</body>
</html>
