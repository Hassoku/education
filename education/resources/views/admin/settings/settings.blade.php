@extends('admin.layout.app')
@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-b-0 _300">Settings</h4>
                </div>
                <div class="col-sm-6 text-sm-right"></div>
            </div>
        </div>
        <div class="row">@include('admin.layout.errors')</div>
        <div class="padding">
            <div class="row">
                <div class="col-sm-3 col-lg-2">
                    <div class="p-y">
                        <div class="nav-active-border left b-primary">
                            <ul class="nav nav-sm">
                                {{--languages--}}
                                <li class="nav-item">
                                    <a class="nav-link block @if($selectedTab == 'subscription_package') active @endif" href data-toggle="tab" data-target="#subscription_package-tab">Subscription packages</a>
                                </li>

                                {{--languages--}}
                                <li class="nav-item">
                                    <a class="nav-link block @if($selectedTab == 'language') active @endif" href data-toggle="tab" data-target="#language-tab">Languages</a>
                                </li>

                                {{--Tutoring styles--}}
                                <li class="nav-item">
                                    <a class="nav-link block @if($selectedTab == 'tutoring_style') active @endif" href data-toggle="tab" data-target="#tutoring-style-tab">Tutoring Styles</a>
                                </li>

                                {{--Interests--}}
                                <li class="nav-item">
                                    <a class="nav-link block @if($selectedTab == 'interest') active @endif" href data-toggle="tab" data-target="#interest-tab">Interests</a>
                                </li>

                                {{--Account Settings--}}
                                <li class="nav-item">
                                    <a class="nav-link block @if($selectedTab == 'account_setting') active @endif" href data-toggle="tab" data-target="#account-settings-tab">Account Settings</a>
                                </li>

                                {{--Security--}}
                                <li class="nav-item">
                                    <a class="nav-link block @if($selectedTab == 'security') active @endif" href data-toggle="tab" data-target="#security-tab">Security</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 col-lg-10 {{--light--}} lt bg-auto">
                    <div class="tab-content pos-rlt">
                        {{--Subscription packages tab--}}
                        <div class="tab-pane @if($selectedTab == 'subscription_package') active @endif" id="subscription_package-tab">
                            <div class="p-a white lt box-shadow">
                                    <h4 class="m-b-0 _300">
                                        Subscription packages
                                        <div class="text-sm-right">
                                            <button id="add-subscription_package-btn" class="btn btn-fw info">Add New &nbsp;<i class="fa fa-plus"></i></button>
                                        </div>
                                    </h4>
                            </div>
                            @include('admin.settings.subscriptionPackages.index',['subscriptionPackagesCollection' => $subscriptionPackagesCollection])
                        </div>

                        {{--Language tab--}}
                        <div class="tab-pane @if($selectedTab == 'language') active @endif" id="language-tab">
                            <div class="p-a white lt box-shadow">
                                    <h4 class="m-b-0 _300">
                                         Languages
                                        <div class="text-sm-right">
                                            <button id="add-new-language-btn" class="btn btn-fw info">Add New &nbsp;<i class="fa fa-plus"></i></button>
                                        </div>
                                    </h4>
                            </div>
                            @include('admin.settings.languages.index',['languagesCollection' => $languagesCollection])
                        </div>

                        {{--Tutoring Style--}}
                        <div class="tab-pane @if($selectedTab == 'tutoring_style') active @endif" id="tutoring-style-tab">
                            <div class="p-a white lt box-shadow">
                                <h4 class="m-b-0 _300">
                                    Tutoring Style
                                    <div class="text-sm-right">
                                        <button id="add-new-tutoring-style-btn" class="btn btn-fw info">Add New &nbsp;<i class="fa fa-plus"></i></button>
                                    </div>
                                </h4>
                            </div>
                            @include('admin.settings.tutoringStyles.index',['tutoringStylesCollection' => $tutoringStylesCollection])
                        </div>

                        {{--Interests Tab--}}
                        <div class="tab-pane @if($selectedTab == 'interest') active @endif" id="interest-tab">
                            <div class="p-a white lt box-shadow">
                                <h4 class="m-b-0 _300">
                                    Interests
                                    <div class="text-sm-right">
                                        <button id="add-new-interest-btn" class="btn btn-fw info">Add New &nbsp;<i class="fa fa-plus"></i></button>
                                    </div>
                                </h4>
                            </div>
                            @include('admin.settings.interests.index',['interestsCollection' => $interestsCollection])
                        </div>

                        {{--Account settings Tab--}}
                        <div class="tab-pane @if($selectedTab == 'account_setting') active @endif" id="account-settings-tab">
                            <div class="p-a white lt box-shadow">
                                <h4 class="m-b-0 _300">
                                    Account settings
                                </h4>
                            </div>
                            <form role="form" class="p-a-md col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="{{Auth::user()->name}}">
                                </div>
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="text" disabled class="form-control" value="{{Auth::user()->email}}">
                                </div>
                                <button type="submit" disabled class="btn btn-info m-t">Update</button>
                            </form>
                        </div>

                        {{--Security tab--}}
                        <div class="tab-pane @if($selectedTab == 'security') active @endif" id="security-tab">
                            <div class="p-a white lt box-shadow">
                                <h4 class="m-b-0 _300">
                                    Security
                                </h4>
                            </div>
                            <div class="p-a-md">
                                <div class="clearfix m-b-lg">
                                    <form role="form" class="col-md-6 p-a-0">
                                        <div class="form-group">
                                            <label>Old Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>New Password Again</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <button type="submit" disabled class="btn btn-info m-t">Update</button>
                                    </form>
                                </div>

                                <p><strong>Delete account?</strong></p>
                                <button type="submit" class="btn btn-danger m-t" data-toggle="modal" disabled>Delete Account</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############ PAGE END-->

        <!-- modals -->
            {{--Subscription packages--}}
            <div id="subscription_package-modal" class="modal" data-backdrop="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Subscription package</h5>
                        </div>
                            <div class="modal-body text-center p-lg">
                                <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">Minutes</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="add-sub-pak-minutes-field" placeholder="Minutes">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">Price</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="add-sub-pak-price-field" placeholder="Price">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">Type</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="add-sub-pak-type-select">
                                            <option value="individual">Individual</option>
                                            <option value="group">Group</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                                <button type="submit" class="btn primary p-x-md"
                                        onclick="addNewSubscription_package(
                                             $('#add-sub-pak-minutes-field').val(),
                                             $('#add-sub-pak-price-field').val(),
                                             $('#add-sub-pak-type-select').val()
                                         );">
                                    Add
                                </button>
                            </div>
                    </div><!-- /.modal-content -->
                </div>
            </div>

            {{--Language--}}
            <div id="language-modal" class="modal" data-backdrop="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Language</h5>
                        </div>
                            <div class="modal-body text-center p-lg">
                                <div class="form-group row">
                                    <label class="col-sm-2 form-control-label">Language</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="add-language-field" placeholder="Language">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                                <button type="submit" class="btn primary p-x-md" onclick="addNewLanguage($('#add-language-field').val());">Add</button>
                            </div>
                    </div><!-- /.modal-content -->
                </div>
            </div>

            {{--Tutoring Styles--}}
            <div id="tutoring-style-modal" class="modal" data-backdrop="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Tutoring Style</h5>
                        </div>
                        <div class="modal-body text-center p-lg">
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Tutoring Style</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="add-tutoring-style-field" placeholder="Tutoring Style">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                            <button type="button" class="btn primary p-x-md" onclick="addNewTutoringStyle($('#add-tutoring-style-field').val());">Add</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div>
            </div>
            <div id="tutoring-style-edit-modal" class="modal" data-backdrop="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Tutoring Style</h5>
                        </div>
                        <div class="modal-body text-center p-lg">
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Tutoring Style</label>
                                <div class="col-sm-9">
                                    <input type="hidden" id="edit-tutoring-style-id">
                                    <input class="form-control" id="edit-tutoring-style-field" placeholder="Tutoring Style">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                            <button type="button" class="btn primary p-x-md" onclick="editTutorStyle($('#edit-tutoring-style-id').val(),$('#edit-tutoring-style-field').val());">Update</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div>
            </div>

            {{--Interests--}}
            <div id="interest-modal" class="modal" data-backdrop="true" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Interest</h5>
                        </div>
                        <div class="modal-body text-center p-lg">
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label">Interest</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="add-interest-field" placeholder="Interest">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                            <button type="button" class="btn primary p-x-md" onclick="addNewInterest($('#add-interest-field').val());">Add</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div>
            </div>
            <div id="interest-edit-modal" class="modal" data-backdrop="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Interest</h5>
                        </div>
                        <div class="modal-body text-center p-lg">
                            <div class="form-group row">
                                <label class="col-sm-3 form-control-label">Interest</label>
                                <div class="col-sm-9">
                                    <input type="hidden" id="edit-interest-id">
                                    <input class="form-control" id="edit-interest-field" placeholder="Interest">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                            <button type="button" class="btn primary p-x-md" onclick="editInterest($('#edit-interest-id').val(),$('#edit-interest-field').val());">Update</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div>
            </div>
        <!-- / modals -->
    </div>
@endsection

@section('styles')
    <link href="{{asset('assets/admin/css/sweetalert/sweetalert.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('assets/admin/js/sweetalert/sweetalert.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers:
                    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
        });

        {{--<Subscription package>--}}
            {{-- <Add> --}}
                $('#add-subscription_package-btn').click(function () {
                    $('#subscription_package-modal').modal('show');
                });
                function addNewSubscription_package($minutes, $price, $type) {
                    $('#subscription_package-modal').modal('hide');
                    $.ajax({
                        url: '{{route('admin.subscriptionPackage.add')}}',
                        type: "POST",
                        data:{
                            'minutes' : $minutes,
                            'price' : $price,
                            'type' : $type,
                        },
                        success: function (response) {
                            console.log("response: " + JSON.stringify(response));

                            var $url = "{{route('admin.settings')}}?tab=subscription_package";
                            window.location.href = $url;
                        },
                        error:function (error) {
                            console.log('Error: ' + JSON.stringify(error));
                            console.log(error.responseText);
                        }
                    });
                }
            {{-- </Add> --}}

            {{-- <Delete> --}}
                function deleteSubscription_package(subscriptionID) {
                    swal({
                        title: "Are you sure to remove Subscription Package & all related data?",
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
                                                    window.location = '';
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
            {{-- </Delete> --}}
        {{--</Subscription package>--}}

         {{--<language>--}}
            {{-- <Add> --}}
                $('#add-new-language-btn').click(function () {
                    $('#language-modal').modal('show');
                });
                function addNewLanguage($lang) {
                    $('#language-modal').modal('hide');
                    $.ajax({
                        url: '{{route('admin.language.add')}}',
                        type: "POST",
                        data:{
                            'language' : $lang
                        },
                        success: function (response) {
                            console.log("response: " + JSON.stringify(response));

                            var $url = "{{route('admin.settings')}}?tab=language";
                            window.location.href = $url;
                        },
                        error:function (error) {
                            console.log('Error: ' + JSON.stringify(error));
                            console.log(error.responseText);
                        }
                    });
                }
            {{-- </Add> --}}

            {{-- <Delete> --}}
                function deleteLanguage(languageID) {
                    swal({
                        title: "Are you sure to remove Language & all related data?",
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
                                                    window.location = '';
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
            {{-- </Delete> --}}
        {{--</language>--}}

        {{--<tutoring style>--}}
            {{-- <Add> --}}
                $('#add-new-tutoring-style-btn').click(function () {
                    $('#tutoring-style-modal').modal('show');
                });
                function addNewTutoringStyle($tutoringStyle) {
                    $('#tutoring-style-modal').modal('hide');
                    $.ajax({
                        url: '{{route('admin.tutoringStyle.add')}}',
                        type: "POST",
                        data:{
                            'tutoring_style' : $tutoringStyle
                        },
                        success: function (response) {
                            console.log("response: " + JSON.stringify(response));

                            var $url = "{{route('admin.settings')}}?tab=tutoring_style";
                            window.location.href = $url;
                        },
                        error:function (error) {
                            console.log('Error: ' + JSON.stringify(error));
                            console.log(error.responseText);
                        }
                    });
                }
            {{-- </Add> --}}

            {{-- <Edit> --}}
                function showEditDialogForTutorStyle($tutoringStyleId, $tutoringStyle) {
                    $('#edit-tutoring-style-id').val($tutoringStyleId)
                    $('#edit-tutoring-style-field').val($tutoringStyle);
                    $('#tutoring-style-edit-modal').modal('show');
                }
                function editTutorStyle($tutoringStyleId, $tutoringStyle) {
                    $('#edit-tutoring-style-id').val("")
                    $('#edit-tutoring-style-field').val("");
                    $('#tutoring-style-edit-modal').modal('hide');

                    $.ajax({
                        url:'{{ route('admin.tutoringStyle.edit') }}',
                        type:"POST",
                        data:{
                            'tutoring_style_id' : $tutoringStyleId,
                            'tutoring_style' : $tutoringStyle,
                        },
                        success:function (response) {
                            console.log("response: " + JSON.stringify(response));
                            // refresh the page
                            window.location.href = '{{route('admin.settings', ['tab' => 'tutoring_style'])}}';
                        },
                        error:function (error) {
                            console.log('Error: ' + JSON.stringify(error));
                            console.log(error.responseText);
                        }
                    });

                }
            {{-- </Edit> --}}


            {{-- <Delete> --}}
                function deleteTutoringStyle(tutoringStyleID) {
                    swal({
                        title: "Are you sure to remove Tutoring Style & all related data?",
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
                                                    window.location = '';
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
            {{-- </Delete> --}}
        {{--</tutoring style>--}}

        {{--<Interest>--}}
            {{-- <Add> --}}
                $('#add-new-interest-btn').click(function () {
                    $('#interest-modal').modal('show');
                });
                function addNewInterest($intr) {
                    $('#interest-modal').modal('hide');
                    $.ajax({
                        url: '{{route('admin.interest.add')}}',
                        type: "POST",
                        data:{
                            'interest' : $intr
                        },
                        success: function (response) {
                            console.log("response: " + JSON.stringify(response));

                            var $url =  "{{route('admin.settings')}}?tab=interest";
                            window.location.href = $url;
                        },
                        error:function (error) {
                            console.log('Error: ' + JSON.stringify(error));
                            console.log(error.responseText);
                        }
                    });
                }
            {{-- </Add> --}}

            {{-- <Edit> --}}
                function showEditDialogForInterest($interestId, $interest) {
                    $('#edit-interest-id').val($interestId)
                    $('#edit-interest-field').val($interest);
                    $('#interest-edit-modal').modal('show');
                }
                function editInterest($interestId, $interest) {
                    $('#edit-interest-id').val("")
                    $('#edit-interest-field').val("");
                    $('#interest-edit-modal').modal('hide');

                    $.ajax({
                        url:'{{ route('admin.interest.edit') }}',
                        type:"POST",
                        data:{
                            'interest_id' : $interestId,
                            'interest' : $interest,
                        },
                        success:function (response) {
                            console.log("response: " + JSON.stringify(response));
                            // refresh the page
                            window.location.href = '{{route('admin.settings', ['tab' => 'interest'])}}';
                        },
                        error:function (error) {
                            console.log('Error: ' + JSON.stringify(error));
                            console.log(error.responseText);
                        }
                     });

                }
            {{-- </Edit> --}}
                    
                    
            {{-- <Delete> --}}
                function deleteInterest(interestID) {
                    swal({
                        title: "Are you sure to remove Interest & all related data?",
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
                                                    window.location = '';
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
            {{-- </Delete> --}}
        {{--</Interest>--}}
    </script>
@endsection