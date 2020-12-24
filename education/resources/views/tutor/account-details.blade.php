    <div class="d-flex justify-content-between">
        <h2 class="mr-auto font-weight-light" data-toggle="modal" data-target="#incoming-call">Account Details</h2>
    </div>
    <form class="white-container center-form p-4 mt-1" method="POST" action="{{route('tutor.setting.update.account.detail')}}">
        {{csrf_field()}}
        <div class="form-group row">
            <label for="name" class="col-md-2 col-form-label">First Name</label>
            <div class="col-md-10">
                <input type="text"  class="form-control" id="first-name-field" name = "first_name" value="{{$name['first_name']}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-2 col-form-label">Middle Name</label>
            <div class="col-md-10">
                <input type="text"  class="form-control" id="middle-name-field" name = "middle_name" value="{{$name['middle_name']}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-2 col-form-label">Last Name</label>
            <div class="col-md-10">
                <input type="text"  class="form-control" id="last-name-field" name = "last_name" value="{{$name['last_name']}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="mobile" class="col-md-2 col-form-label">Mobile</label>
            <div class="col-md-10">
                <input type="text" class="form-control" id="mobile-field" name = "mobile" value="{{$mobile}}">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-2 col-form-label">Email</label>
            <div class="col-md-10">
                <input type="text"  class="form-control" id="email-field" name = "email" value="{{$email}}" disabled="true">
            </div>
        </div>

        <div class="form-group row">
            <label for="inputPassword" class="col-md-2 col-form-label">Password</label>
            <div class="col-md-10">
                <input type="password" class="form-control" id="password-field" name = "password" placeholder="Password" disabled="true">
            </div>
        </div>

        <div class="form-group row mb-0">
            <label for="update-btn" class="col-md-2 col-form-label"></label>
            <div class="col-md-10 ">
                <button class="btn  btn-primary" id="update-btn" type="submit">Update</button>
            </div>
        </div>

    </form>