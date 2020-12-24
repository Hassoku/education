@extends('admin.layout.app')
{{--Setting values--}}
@php
    $student_profile = $student->profile;
@endphp
@section('content')
    <div ui-view class="app-body" id="view">
            <!-- ############ PAGE START-->
                <div class="p-a white lt box-shadow">
                    <div class="row">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.reports')}}">Reports</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.reports',['tab' => 'studentBalances'])}}">Students</a></li>
                            <li class="breadcrumb-item active">{{$student->name}} {{$student->last_name}}</li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="m-b-0 _300">{{$student->name}} {{$student->last_name}}</h4>
                        </div>
                        <div class="col-sm-6 text-sm-right"></div>
                    </div>
                </div>
                <div class="row">@include('admin.layout.errors')</div>
                <div class="padding">
                    <div class="box padding">
                        <div class="box-header">
                            <img id="profile-img" src="{{asset($student_profile->picture)}}" class="circle " width="150" height="150" alt="...">
                            <div style="padding: 15px">
                                <h2>{{$student->name}} {{$student->middle_name}} {{$student->last_name}}</h2>
                            </div>
                            <div>
                                <span class="label {{($student->online_status == true)? 'success': 'red'}} pos-rlt m-r-xs {{'online-'.$student->email}} ">
                                    {{($student->online_status)? 'Online': 'Offline'}}
                                </span>
                            </div>
                        </div>
                        {{--table--}}
                        <div class="padding">
                            <div class="row">
                                <div class="col-sm-5">
                                    <a href="{{route('admin.reports.export',['tab'=>'indvStdBlncRep','id'=>$student->id])}}" class="btn btn-success">Export</a>
                                </div>
                            </div>
                            @if($studentBalanceCollection->count() < 1)
                                <div class="table-responsive text-center">No record found.</div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped b-t">
                                        <thead>
                                        <tr>
                                            <th style="width:20px;">
                                                Sno
                                            </th>
                                            <th>Type</th>
                                            <th>Minutes</th>
                                            <th>Amount</th>
                                            <th>Date</th>
{{--                                            <th style="width:50px;">Action</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $serialNumberCounter = ($studentBalanceCollection->currentPage()-1) * $studentBalanceCollection->perPage()+1;
                                        @endphp
                                        @foreach($studentBalanceCollection as $studentBalance)
                                            <tr>
                                                <td>
                                                    {{$serialNumberCounter++ }}
                                                </td>
                                                <td>{{strtoupper($studentBalance->type)}}</td>
                                                <td>{{$studentBalance->purchased_slots / 4}}</td>
                                                <td>{{$studentBalance->purchased_amount}}</td>
                                                <td>{{($studentBalance->created_at) ? $studentBalance->created_at->format('F j, Y'): ''}}</td>
                                                {{--<td style="width:18%;">
                                                    <a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                                </td>--}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            <div class="dker p-a">
                                <div class="row">
                                    <div class="col-sm-4 hidden-xs"></div>
                                    <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($studentBalanceCollection->currentpage()-1)*$studentBalanceCollection->perpage()+1}} to {{(($studentBalanceCollection->currentpage()-1)*$studentBalanceCollection->perpage())+$studentBalanceCollection->count()}} of {{ $studentBalanceCollection->total() }} items</small> </div>
                                    <div class="col-sm-4 text-right text-center-xs ">
                                        {{ $studentBalanceCollection->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- ############ PAGE END-->
        </div>
@endsection


{{--Own styles and scripts--}}
@section('styles')

@endsection
@section('scripts')
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('6a46b90592aa1656faab', {
            cluster: 'ap2',
            encrypted: true
        });

        // student
        var channel = pusher.subscribe('student.status');
        channel.bind('student.status.event', function (data) {
            var student = data.student;
            // console.log(student);
            var elements = document.getElementsByClassName('online-'+student.email);
            $.each(elements, function (i, element) {
                if(student.online_status){
                    console.log("true");
                    element.classList.remove('red');
                    element.classList.add('success');
                    element.innerHTML = "Online";
                }else {
                    if(!student.online_status){
                        console.log("false");
                        element.classList.remove('success');
                        element.classList.add('red');
                        element.innerHTML = "Offline";
                    }
                }
            });
        });

    </script>
@endsection