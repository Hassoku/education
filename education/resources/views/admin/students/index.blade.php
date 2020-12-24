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
                <div class="col-sm-6 text-sm-right">
                    <form method="GET" action="{{route('admin.student.create')}}">
                        <button class="btn btn-fw info" type="submit">Add New &nbsp;<i class="fa fa-plus"></i></button>
                    </form>
                </div>
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
                            <strong>{{$studentsCollection->count()}}</strong> Result(s) found for: <strong>{{$searchKeyword}}</strong><br><a href="{{route('admin.students')}}" class="text-info"><i class="fa fa-remove"></i>&nbsp;Clear Search</a>
                        @else
                            Total Records: {{$studentsCollection->total()}}
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
                        <form method="GET" action="{{route('admin.students')}}">
                        <div class="input-group input-group-sm">

                                <input type="text" class="form-control" placeholder="Search" value="@if(isset($searchKeyword)){{$searchKeyword}}@endif" name="keyword">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn b-a white" type="button">Go!</button>
                                </span>

                        </div>
                        </form>
                    </div>
                </div>
                @if($studentsCollection->count() < 1)
                    <div class="table-responsive text-center">No record found.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped b-t">
                            <thead>
                            <tr>
                                <th style="width:20px;">
                                    <!--<label class="ui-check m-a-0"><input type="checkbox" class="has-value"><i></i> </label>-->
                                    ID
                                </th>
                                <th></th> {{--profile image--}}
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Active State</th>
                                <th>Change Status</th>
                                <th>Created Date</th>
                                <th style="width:50px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $serialNumberCounter = ($studentsCollection->currentPage()-1) * $studentsCollection->perPage()+1;
                            @endphp
                            @foreach($studentsCollection as $student)
                                <tr class="row{{$student->id}}">
                                    <td>
                                        <!--<label class="ui-check m-a-0"><input type="checkbox" name="post[]" class="has-value"><i class="dark-white"></i></label>-->
                                        {{$serialNumberCounter++ }}
                                    </td>
                                    <td>
                                        <span class="w-40 avatar">
                                            @if(isset($student->profile->picture))
                                                <img src="{{asset($student->profile->picture)}}" alt="...">
                                            @endif
                                      <i class="{{($student->online_status) ? 'on' : 'off'}} b-white bottom {{'online-'.$student->email}}"></i>
                                    </span>
                                    </td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->last_name}}</td>
                                    <td>{{$student->email}}</td>
                                    <td>{{$student->mobile}}</td>
                                    <td id="status{{ $student->id }}">
                                        @if($student->status == 'under_review')
                                            <span class="label  yellow pos-rlt m-r-xs">Under Review</span>
                                        @elseif($student->status == 'active')
                                            <span class="label success pos-rlt m-r-xs">Activated</span>
                                        @elseif($student->status == 'suspended')
                                            <span class="label red pos-rlt m-r-xs">Suspended</span>
                                        @elseif($student->status == 'block')
                                            <span class="label dark pos-rlt m-r-xs">Blocked</span>
                                        @endif
                                    </td>
                                    <td>
                                        <select class="form-control" onchange="updateStatus(this, {{ $student->id }})" name="status">
                                            <option value="under_review" {{ ($student->status == 'under_review') ? 'selected' : null }}>Under Review</option>
                                            <option value="active" {{ ($student->status == 'active') ? 'selected' : null }}>Active</option>
                                            <option value="suspended" {{ ($student->status == 'suspended') ? 'selected' : null }}>Suspended</option>
                                            <option value="block" {{ ($student->status == 'block') ? 'selected' : null }}>Block</option>
                                        </select>
                                        <input type="hidden" id="status_url{{ $student->id }}" value="{{ route('admin.student.update.status', $student->id) }}">
                                    </td>
                                    <td>{{$student->created_at->format('F j, Y')}}</td>
                                    <td style="width:18%;">
                                        <a class="btn btn-sm success" href="{{route('admin.student.show',['id'=>$student->id])}}"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                        <a class="btn btn-sm info" href="{{route('admin.student.edit',['id'=>$student->id])}}"><i class="glyphicon glyphicon-edit"></i> edit</a>
                                        <a class="btn btn-sm danger" onclick="showWarningDialog({{$student->id}})" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>
                                        <input type="hidden" id="delete_url{{$student->id}}" value="{{route('admin.student.delete',['id'=>$student->id])}}">
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
                        <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($studentsCollection->currentpage()-1)*$studentsCollection->perpage()+1}} to {{(($studentsCollection->currentpage()-1)*$studentsCollection->perpage())+$studentsCollection->count()}} of {{ $studentsCollection->total() }} items</small> </div>
                        <div class="col-sm-4 text-right text-center-xs ">
                            {{ $studentsCollection->links() }}
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
        	let delete_url = $("#delete_url"+id).val();
	        /*swal(
	        	{   title: 'Are you sure?', text: 'Your will not be able to recover this thing!',
			        type: 'warning',
			        showCancelButton: true, confirmButtonColor: '#DD6B55',
			        confirmButtonText: 'Yes, delete it!', closeOnConfirm: false }
			        ,
		        function () {
			        // Code to delete something
			        swal('Deleted!', 'It was deleted.', 'success');
			        // The success alert only shows for a split second and is gone
		        }
                );*/

            swal({
                title: "Are you sure to remove Student & all related data?",
                text: "You will not be able to recover this info!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true
            }, function () {
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: delete_url,
                    data: {},
                    success: function (returnedData) {
                        if (returnedData) {
                            swal("Deleted!", "Record has been deleted.", "success");
	                        $(".row" + id).remove();
                        } else {
                            swal("Problem", "Unable to delete record.", "error");
                        }
                    },
                    error: function (returnedData) {
                        swal("Error", "There some problem with the request.", "error");
                    }
                });
            });

        }

        function updateStatus(me, id){
            let status = $(me).val();
            console.log(status);
            let updateStatusUrl = $("#status_url"+id).val();
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: updateStatusUrl,
                data: {'status': status},
                success: function (returnedData) {
                    if (returnedData) {
                        let html = "";
                        if (status === "under_review"){
                            html = '<span class="label  yellow pos-rlt m-r-xs">Under Review</span>';
                        }
                        if  (status === "active"){
                            html = '<span class="label success pos-rlt m-r-xs">Activated</span>';
                        }
                        if (status === "suspended"){
                            html = '<span class="label red pos-rlt m-r-xs">Suspended</span>';
                        }
                        if (status === "block"){
                            html = '<span class="label dark pos-rlt m-r-xs">Blocked</span>';
                        }
                        $("#status"+id).html(html);
                        swal("Status Updated!", "Status Update Successfully.", "success");
                    } else {
                        swal("Problem", "Unable to update status", "error");
                    }
                },
                error: function (returnedData) {
                    swal("Error", "There some problem with the request.", "error");
                }
            });
        }
    </script>

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
