@php
    $preferences = \App\Helpers\StudentCommonHelper::preferences();
    $studentPreferences = $preferences['preferences'];
    $timeZoneSelect = $preferences['timeZoneSelect'];
@endphp



<div class="d-flex justify-content-between">
    <h2 class="mr-auto font-weight-light">Preferences</h2>
</div>

<form class="white-container center-form p-4 mt-1" method="POST" action="{{route('student.setting.update.preferences')}}">
    {{csrf_field()}}
    {{--Language--}}
    <div class="form-group row">
        <label class="col-md-2 col-form-label">Language</label>
        <div class="col-md-10">
            <select name="language" class="form-control">
                <option>Select a language</option>
                <option value="English" @if($studentPreferences->language == 'English') selected @endif>English</option>
                <option value="Arabic" @if($studentPreferences->language == 'Arabic') selected @endif>Arabic</option>
            </select>
        </div>
    </div>
    {{--Time zone--}}
    <div class="form-group row">
        <label for="staticEmail" class="col-md-2 col-form-label">Time Zone</label>
        <div class="col-md-10">
            @php
                echo $timeZoneSelect;
            @endphp
        </div>
    </div>
    {{--email notification--}}
    <div class="form-group row">
        <label for="inputPassword" class="col-md-2 col-form-label"></label>
        <div class="form-check pl-5 col-md-10">
            <input class="form-check-input" type="checkbox" name="emailNotification" @if($studentPreferences->emailNotification == 1) checked @endif>
            <label class="form-check-label">
                Receive Email Notifications
            </label>
        </div>
    </div>
    {{--desktop notification--}}
    <div class="form-group row">
        <label for="inputPassword" class="col-md-2 col-form-label"></label>
        <div class="form-check pl-5 col-md-10">
            <input class="form-check-input" type="checkbox" name="desktopNotification" @if($studentPreferences->desktopNotification == 1) checked @endif>
            <label class="form-check-label">
                Receive Desktop Notifications
            </label>
        </div>
    </div>
    {{--update button--}}
    <div class="form-group row mb-0">
        <label for="inputPassword" class="col-md-2 col-form-label"></label>
        <div class="col-md-10 ">
            <button class="btn  btn-primary" type="submit">Update</button>
        </div>
    </div>
</form>
