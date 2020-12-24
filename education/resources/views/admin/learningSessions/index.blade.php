@extends('admin.layout.app')
@section('content')
    <div ui-view class="app-body" id="view">

            <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Students</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-b-0 _300">Manage Students</h4>
                </div>
                <div class="col-sm-6 text-sm-right"></div>
            </div>
        </div>
        <div class="row">@include('admin.layout.errors')</div>
        <div class="padding">
            <div class="box">
                <div class="box-header">
                    <h3>Students</h3>
                </div>
                <div class="row p-a">
                    <div class="col-sm-5">

                        @if(isset($searchKeyword) && !empty($searchKeyword))
                            <strong>{{$learningSessionsCollection->count()}}</strong> Result(s) found for: <strong>{{$searchKeyword}}</strong><br><a href="{{route('admin.sessions')}}" class="text-info"><i class="fa fa-remove"></i>&nbsp;Clear Search</a>
                        @else
                            Total Records: {{$learningSessionsCollection->total()}}
                        @endif
                        <!--<select class="input-sm form-control w-sm inline v-middle">
                            <option value="0">Bulk action</option>
                            <option value="1">Delete selected</option>
                            <option value="2">Bulk edit</option>
                            <option value="3">Export</option>
                        </select>
                        <button class="btn btn-sm white">Apply</button>-->
                    </div>
                    <div class="col-sm-4"> </div>
                    <div class="col-sm-3">
                        <form method="GET" action="{{route('admin.sessions')}}">
                        <div class="input-group input-group-sm">

                                <input type="text" class="form-control" placeholder="Search" value="@if(isset($searchKeyword)){{$searchKeyword}}@endif" name="keyword">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn b-a white" type="button">Go!</button>
                                </span>

                        </div>
                        </form>
                    </div>
                </div>
                @if($learningSessionsCollection->count() < 1)
                    <div class="table-responsive text-center">No record found.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped b-t">
                            <thead>
                            <tr>
                                <th style="width:20px;">
                                    <!--<label class="ui-check m-a-0"><input type="checkbox" class="has-value"><i></i> </label>-->
                                    S.No.
                                </th>
                                <th>Tutor</th>
                                <th>Student</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th style="width:50px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $serialNumberCounter = ($learningSessionsCollection->currentPage()-1) * $learningSessionsCollection->perPage()+1;
                            @endphp
                            @foreach($learningSessionsCollection as $learningSession)
                                <tr>
                                    <td>
                                        <!--<label class="ui-check m-a-0"><input type="checkbox" name="post[]" class="has-value"><i class="dark-white"></i></label>-->
                                        {{$serialNumberCounter++ }}
                                    </td>
                                    <td>
                                         <span class="w-40 avatar">
                                          <img src="{{asset($learningSession->tutor->profile->picture)}}" alt="...">
                                          <i class="{{($learningSession->tutor->online_status) ? 'on' : 'off'}} b-white bottom {{'online-tut-'.$learningSession->tutor->email}}"></i>
                                        </span>
                                        <br>
                                        <h6 style="margin-top: 10px; margin-bottom: 0">{{$learningSession->tutor->name}} {{$learningSession->tutor->last_name}}</h6>
                                    </td>
                                    <td>
                                        <span class="w-40 avatar">
                                          <img src="{{asset($learningSession->student->profile->picture)}}" alt="...">
                                          <i class="{{($learningSession->student->online_status) ? 'on' : 'off'}} b-white bottom {{'online-std-'.$learningSession->student->email}}"></i>
                                        </span>
                                        <br>
                                        <h6 style="margin-top: 10px; margin-bottom: 0">{{$learningSession->student->name}} {{$learningSession->student->last_name}}</h6>
                                    </td>
                                    <td>
                                        @if($learningSession->status == 0)
                                            <span class="label success pos-rlt m-r-xs"> Complete</span>
                                        @else
                                            <span class="label red pos-rlt m-r-xs"> Running</span>
                                        @endif
                                    </td>
                                    <td>{{$learningSession->created_at->format('F j, Y')}}</td>
                                    <td style="width:18%;">
                                        <a class="btn btn-sm success" href="{{route('admin.session.show',['id'=>$learningSession->id])}}"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                        <a class="btn btn-sm info" href="{{route('admin.session.edit',['id'=>$learningSession->id])}}"><i class="glyphicon glyphicon-edit"></i> edit</a>
                                        <a class="btn btn-sm danger" onclick="showWarningDialog({{$learningSession->id}})" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>
                                        <!--<a href="" class="active" ui-toggle-class=""><i class="fa fa-check text-success none"></i><i class="fa fa-times text-danger inline"></i>Delete</a>-->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <footer class="dker p-a">
                    <div class="row">
                        <div class="col-sm-4 hidden-xs">
                            <!--<select class="input-sm form-control w-sm inline v-middle">
                                <option value="0">Bulk action</option>
                                <option value="1">Delete selected</option>
                                <option value="2">Bulk edit</option>
                                <option value="3">Export</option>
                            </select>
                            <button class="btn btn-sm white">Apply</button>-->
                        </div>
                        <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($learningSessionsCollection->currentpage()-1)*$learningSessionsCollection->perpage()+1}} to {{(($learningSessionsCollection->currentpage()-1)*$learningSessionsCollection->perpage())+$learningSessionsCollection->count()}} of {{ $learningSessionsCollection->total() }} items</small> </div>
                        <div class="col-sm-4 text-right text-center-xs ">
                            {{ $learningSessionsCollection->links() }}
                            <!--<ul class="pagination pagination-sm m-a-0">
                                <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                                <li class="active"><a href="">1</a></li>
                                <li><a href="">2</a></li>
                                <li><a href="">3</a></li>
                                <li><a href="">4</a></li>
                                <li><a href="">5</a></li>
                                <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                            </ul>-->
                        </div>
                    </div>
                </footer>
            </div>
        </div>

            <!-- ############ PAGE END-->

        </div>
@endsection
@section('styles')
    <link href="{{asset('assets/admin/css/sweetalert/sweetalert.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('assets/admin/js/sweetalert/sweetalert.min.js')}}"></script>
    <script>
        function showWarningDialog(id) {
            swal({
                title: "Are you sure to remove Session & all related data?",
                text: "You will not be able to recover this info!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true
            }, function () {
/*                $.ajax({
                    type: "DELETE",
                    dataType: 'json',
                    url: 'schools/'+id,
                    data: {},
                    success: function (returnedData) {
                        if (returnedData.success) {
                            //swal("Deleted!", "Record has been deleted.", "success");
                            window.location = '{{route('admin.sessions')}}';
                        } else {
                            swal("Problem", "Unable to delete record.", "error");
                        }
                    },
                    error: function (returnedData) {
                        swal("Error", "There some problem with the request.", "error");
                    }
                });*/
            });
        }
    </script>

    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('6a46b90592aa1656faab', {
            cluster: 'ap2',
            encrypted: true
        });

        // tutor
        var channel = pusher.subscribe('tutor.status');
        channel.bind('tutor.status.event', function (data) {
            var tutor = data.tutor;
            // console.log(tutor);
            var elements = document.getElementsByClassName('online-tut-'+tutor.email);
            $.each(elements, function (i, element) {
                if(tutor.online_status){
                    console.log("true");
                    element.classList.remove('off');
                    element.classList.add('on');
                }else {
                    if(!tutor.online_status){
                        console.log("false");
                        element.classList.remove('on');
                        element.classList.add('off');
                    }
                }
            });
        });

        // student
        var channel = pusher.subscribe('student.status');
        channel.bind('student.status.event', function (data) {
            var student = data.student;
            // console.log(student);
            var elements = document.getElementsByClassName('online-std-'+student.email);
            $.each(elements, function (i, element) {
                if(student.online_status){
                    console.log("true");
                    element.classList.remove('off');
                    element.classList.add('on');
                }else {
                    if(!student.online_status){
                        console.log("false");
                        element.classList.remove('on');
                        element.classList.add('off');
                    }
                }
            });
        });
    </script>
@endsection