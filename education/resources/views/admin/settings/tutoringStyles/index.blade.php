<div class="padding">
    <div class="box">
        <div class="box-header">
            <h3>TutoringStyles</h3>
        </div>
        @if($tutoringStylesCollection->count() < 1)
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
                        <th>Tutoring Style</th>
                        <th>Created Date</th>
                        <th style="width:50px;">Action</th>
                    </tr>
                    </thead>
                    <tbody id = "tutoring-style-table-body">
                    @php
                        $serialNumberCounter = 1;
                    @endphp
                    @foreach($tutoringStylesCollection as $tutoringStyle)
                        <tr>
                            <td>
                                <!--<label class="ui-check m-a-0"><input type="checkbox" name="post[]" class="has-value"><i class="dark-white"></i></label>-->
                                {{$serialNumberCounter++ }}
                            </td>
                            <td style="width:25%;">{{$tutoringStyle->tutoring_style}}</td>
                            <td>{{($tutoringStyle->created_at) ? $tutoringStyle->created_at->format('F j, Y'):''}}</td>
                            <td style="width:25%;">
                                {{--<a class="btn btn-sm success" href="#"><i class="glyphicon glyphicon-eye-open"></i> view</a>--}}
                                <a style="color: white" class="btn btn-sm info" onclick="showEditDialogForTutorStyle('{{$tutoringStyle->id}}','{{$tutoringStyle->tutoring_style}}')"><i class="glyphicon glyphicon-edit"></i> edit</a>
                                <a class="btn btn-sm danger" onclick="deleteTutoringStyle({{$tutoringStyle->id}})" style="color: #fff;"><i class="glyphicon glyphicon-remove"></i> delete</a>
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
