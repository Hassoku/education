@extends('student.layout.app')
@section('pageTitle', 'Subscription')
@section('body_class_atr')class="main"@endsection
@section('student_layout_topnavbar')
    @include('student.layout.topnavbar')
@endsection
@section('content')
    <main role="main">
        <div class="row mt-5">
            <div class="col-md-2 left-area pl-3"></div>
            <div class="col-md-8 border-right border-left">
                <div>
                    <h2>
                        Buy Minutes
                    </h2>
                </div>
                <div >
                    <ul class="nav nav-tabs"  role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#individual-minutes-div" role="tab" data-toggle="tab">Individual</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#group-minutes-div" role="tab" data-toggle="tab">Group</a>
                        </li>
                    </ul>
                    <div class="tab-content border-bottom border-left border-right p-2">
                        <div  role="tabpanel"  class="login-form tab-pane active">
                            @foreach($individualPackages as $package)
                                <div class="d-flex justify-content-between row p-1">
                                    <div class="col-md-4" style="text-align: center; vertical-align: center">{{$package->minutes}} Minutes</div>
                                    <div class="col-md-4" style="text-align: center; vertical-align: center">${{$package->price}}</div>
                                    <a href="{{route('student.ajax.buy.subscription.package',['subscription_package_id' => $package->id])}}" class="col-md-4 btn btn-outline-primary" role="button">Buy</a>
                                </div>
                            @endforeach
                        </div>
                        <div role="tabpanel"  class="login-form tab-pane">
                            @foreach($groupedPackages as $package)
                                <div class="d-flex justify-content-between row p-1">
                                    <div class="col-md-4" style="text-align: center; vertical-align: center">{{$package->minutes}} Minutes</div>
                                    <div class="col-md-4" style="text-align: center; vertical-align: center">${{$package->price}}</div>
                                    <a href="{{route('student.ajax.buy.subscription.package',['subscription_package_id' => $package->id])}}" class="col-md-4 btn btn-outline-primary" role="button">Buy</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{--Remaining Minutes Aside--}}
            @include('student.layout.remainingMinutesAsideBar');
        </div>
        {{--including footer--}}
        @include('student.layout.footer')
    </main>
@endsection
