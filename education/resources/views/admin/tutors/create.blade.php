@extends('admin.layout.app')
@section('content')

    <div ui-view class="app-body" id="view">

        <!-- ############ PAGE START-->
        <div class="p-a white lt box-shadow">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.tutors')}}">Tutors</a></li>
                    <li class="breadcrumb-item active">Add New Tutor</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="m-b-0 _300">Add New Tutor</h4>
                </div>
                <div class="col-sm-6 text-sm-right"></div>
            </div>
        </div>
        <div class="row">@include('admin.layout.errors')</div>
        <div class="padding">
            <div class="box padding">
                <h3>New Tutor</h3>
                <div class="box-header">
                    <img id="profile-img" src="{{asset('assets/tutor/images/users/default_tutor_image.jpg')}}" class="circle " width="150" height="150" alt="...">
                    {{-- <div>
                         <a id="change-profile-image" class="btn btn-link" href>
                             <i class="fa fa-edit"></i>
                             <input type="file" id="select-profile-image" accept="image/png, image/jpeg, image/gif"  style="display:none">
                             Change Image
                         </a>
                     </div>--}}
                </div>
                <div>
                    <form role="form" method="POST" action="{{route('admin.tutor.store')}}" enctype="multipart/form-data">
                        <div class="row form-group">
                            <label class="col-sm-2">First Name*</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="name" placeholder="Enter First Name" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2">Middle Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="middle_name" placeholder="Enter Middle Name">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2">Last Name*</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="" name="last_name" placeholder="Enter Last Name" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2">Mobile*</label>
                            <div class="col-sm-10">
                                <input type="tel" id="mobile" class="form-control" {{--placeholder="Mobile"--}} name="mobile" value="{{ old('mobile') }}" required>
                                <span id="valid-mob-num-msg" class="hide">✓ Valid</span>
                                <span id="error-mob-num-msg" class="hide">Invalid number</span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2">Email*</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="" name="email" placeholder="Enter Email" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2" for="title_arabic">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="status">
                                    <option value="under_review">Under Review</option>
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="block">Block</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2" >Password*</label>
                            <div class="col-sm-10">
                                <input type="password" id="newpassword" class="form-control" placeholder="Password" name="password" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2" for="title_arabic">Confirm Password*</label>
                            <div class="col-sm-10">
                                <input type="password" id="conformpassword" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2" for="is_percentage">Is Percentage?</label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="is_percentage" id="is_percentage" onclick="changeTextPercentageInput(this)">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2" for="charge" id="inputTitle">Fixed</label>
                            <div class="col-sm-10">
                                <input type="text" id="charge" class="form-control" placeholder="10" name="charge" required>
                            </div>
                        </div>
                        <div class="form-group m-t-lg text-sm-right">
                            <div class="col-sm-12">
                                <button class="btn btn-fw primary" name="publish"><i class="fa fa-user-plus"> Create Tutor</i></button>
                            </div>
                        </div>
                        {{csrf_field()}}
                    </form>
                </div>
            </div>
        </div>
        <!-- ############ PAGE END-->

    </div>
@endsection


{{--Own styles and scripts--}}
@section('styles')
    <!-- Mobile Number Field CSS -->
    <link rel="stylesheet" href="{{asset('assets/admin/mobile_number_field/css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/mobile_number_field/css/demo.css')}}">
@endsection
@section('scripts')
    {{--Mobile Number Field JS--}}
    <script src="{{asset('assets/admin/mobile_number_field/js//intlTelInput.js')}}"></script>
    <script>
        function changeTextPercentageInput(me) {
            let val = $(me).is(":checked");
            let selector = $("#inputTitle");
            selector.html("Fixed");
            if (val){
                selector.html("Percentage");
            }
        }
        // registration - from - mobile - field js
        function forMobileField() {
            // for mobile number field
            var telInput = $("#mobile"),
                errorMsg = $("#error-mob-num-msg"),
                validMsg = $("#valid-mob-num-msg");

            // initialise plugin
            telInput.intlTelInput({
                utilsScript: "{{asset('assets/student/mobile_number_field/js/utils.js')}}"
            });

            var reset = function() {
                telInput.removeClass("error-mob-num");
                errorMsg.addClass("hide");
                validMsg.addClass("hide");
            };

            // on blur: validate
            telInput.blur(function() {
                reset();
                if ($.trim(telInput.val())) {
                    if (telInput.intlTelInput("isValidNumber")) {
                        validMsg.removeClass("hide");
                    } else {
                        telInput.addClass("error-mob-num");
                        errorMsg.removeClass("hide");
                    }
                }
            });

            // on keyup / change flag: reset
            telInput.on("keyup change", reset);
        }
        $(document).ready(function () {
            forMobileField();
        });
    </script>
@endsection
