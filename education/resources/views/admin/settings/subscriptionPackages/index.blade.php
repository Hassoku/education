<div class="padding">
    <div class="box">
        <div class="box-header">
            <h3>Subscription Packages</h3>
        </div>
        @if($subscriptionPackagesCollection->count() < 1)
            <div class="table-responsive text-center">No record found.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped b-t">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            ID
                        </th>
                        <th>Minutes</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Created Date</th>
                        <th style="width:50px;">Action</th>
                    </tr>
                    </thead>
                    <tbody id = "tutoring-style-table-body">
                    @php
                        $serialNumberCounter = 1;
                    @endphp
                    @foreach($subscriptionPackagesCollection as $subscriptionPackage)
                        <tr>
                            <td>
                                {{$serialNumberCounter++ }}
                            </td>
                            <td>{{$subscriptionPackage->minutes}}</td>
                            <td>{{$subscriptionPackage->price}}</td>
                            <td>{{$subscriptionPackage->type}}</td>
                            <td>{{($subscriptionPackage->created_at) ? $subscriptionPackage->created_at->format('F j, Y'):''}}</td>
                            <td style="width:25%;">
                                {{--<a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>--}}
                                <a class="btn btn-sm info" href="{{route('admin.subscriptionPackage.edit',['id' => $subscriptionPackage->id])}}"><i class="glyphicon glyphicon-edit"></i> edit</a>
                                <a class="btn btn-sm danger" onclick="deleteSubscription_package({{$subscriptionPackage->id}})" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>
                                <!--<a href="" class="active" ui-toggle-class=""><i class="fa fa-check text-success none"></i><i class="fa fa-times text-danger inline"></i>Delete</a>-->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
