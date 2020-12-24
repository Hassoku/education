@extends('admin.layout.app')
@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
            <div class="p-a white lt box-shadow">
                <div class="row">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Subjects</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="m-b-0 _300">Manage Subjects</h4>
                    </div>
                    <div class="col-sm-6 text-sm-right">
                        <form method="GET" action="{{route('admin.subject.create')}}">
                            <button class="btn btn-fw info" type="submit">Add New &nbsp;<i class="fa fa-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">@include('admin.layout.errors')</div>
            <div class="padding">
                <div class="box">
                    <div class="box-header">
                        <h3>Subjects</h3>
                    </div>
                    <div class="row p-a">
                        <div class="col-sm-5">
                            @if(isset($searchKeyword) && !empty($searchKeyword))
                                <strong>{{$subjectsCollection->count()}}</strong> Result(s) found for: <strong>{{$searchKeyword}}</strong><br><a href="{{route('admin.subjects')}}" class="text-info"><i class="fa fa-remove"></i>&nbsp;Clear Search</a>
                            @else
                                Total Records: {{$subjectsCollection->total()}}
                        @endif
                        </div>
                        <div class="col-sm-4"> </div>
                        <div class="col-sm-3">
                            <form method="GET" action="{{route('admin.subjects')}}">
                                <div class="input-group input-group-sm">

                                    <input type="text" class="form-control" placeholder="Search" value="@if(isset($searchKeyword)){{$searchKeyword}}@endif" name="keyword">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn b-a white">Go!</button>
                                    </span>

                                </div>
                            </form>
                        </div>
                    </div>
                    @if($subjectsCollection->count() < 1)
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
                                    <th>subject</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th style="width:50px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $serialNumberCounter = ($subjectsCollection->currentPage()-1) * $subjectsCollection->perPage()+1;
                                @endphp
                                @foreach($subjectsCollection as $subject)
                                    <tr class="row{{$subject->id}}">
                                        <td>
                                            <!--<label class="ui-check m-a-0"><input type="checkbox" name="post[]" class="has-value"><i class="dark-white"></i></label>-->
                                            {{$serialNumberCounter++ }}
                                        </td>
                                        <td>{{$subject->topic}}</td>
                                        <td>{{$subject->description}}</td>
                                        <td>
                                            @if($subject->status == 'activate')
                                                <span class="label  success pos-rlt m-r-xs">Activated</span>
                                            @elseif($subject->status == 'deactivate')
                                                <span class="label red pos-rlt m-r-xs">Deactivated</span>
                                            @endif
                                        </td>
                                        <td>{{($subject->created_at) ? $subject->created_at->format('F j, Y') : ''}}</td>
                                        <td style="width:18%;">
                                            <a class="btn btn-sm success" href="{{route('admin.subject.show',['id'=>$subject->id])}}"><i class="glyphicon glyphicon-eye-open"></i> view</a>
                                            <a class="btn btn-sm info" href="{{route('admin.subject.edit',['id'=>$subject->id])}}"><i class="glyphicon glyphicon-edit"></i> edit</a>
                                            <a class="btn btn-sm danger" onclick="showWarningDialog({{$subject->id}})" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>
                                            <input type="hidden" id="delete_url{{$subject->id}}" value="{{route('admin.subject.delete',['id'=>$subject->id])}}">
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
                            <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing {{($subjectsCollection->currentpage()-1)*$subjectsCollection->perpage()+1}} to {{(($subjectsCollection->currentpage()-1)*$subjectsCollection->perpage())+$subjectsCollection->count()}} of {{ $subjectsCollection->total() }} items</small> </div>
                            <div class="col-sm-4 text-right text-center-xs ">
                            {{ $subjectsCollection->links() }}
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
            swal({
                title: "Are you sure to remove subject & all related data?",
                text: "You will not be able to recover this info!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "DELETE",
                        dataType: 'json',
                        url: delete_url,
                        data: {},
                        success: function (returnedData) {
                            if (returnedData.success) {
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
                }
            });
        }

    </script>
@endsection
