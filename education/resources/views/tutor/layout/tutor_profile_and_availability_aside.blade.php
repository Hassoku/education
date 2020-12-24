<div class="col-md-2 ">
    <div class="left-area pl-3">
        <div class="d-flex flex-row left-profile align-middle">
            <img src="{{asset('' . Auth::user()->profile->picture)}}" class="circle " width="50" height="50" alt="...">
            <a href="{{route('tutor.profile.show')}}" class="my-3 ml-3">
                View Profile <i class="fas fa-angle-right"></i>
            </a>
        </div>
        <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small class="text-muted mb-3">Your Profile is 25% completed</small>


        <h3 class="h6 mt-3">Your Available Times</h3>

            <ul class="list-group mb-3">
                @foreach($tutor_availabilities as $day => $values)
                    <li class="list-group-item ">
                        <div>
                            <h6 class="m-0">{{$day}}</h6>
                            @foreach($values as $value)
                                <small class="text-muted">{{$value}}</small><br>
                            @endforeach
                        </div>
                    </li>
                @endforeach
                <li class="list-group-item text-right">
                    <a href="{{route('tutor.profile.show')}}#tutor_pf_availability">
                        <i class="far fa-edit"></i>
                        Edit Availability
                    </a>
                </li>
            </ul>
    </div>

</div>