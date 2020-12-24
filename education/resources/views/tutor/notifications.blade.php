<div id="reservations" class="container-fluid">
    <div class="row mt-5">
        {{--tutor_profile_and_availability_aside--}}
        @include("tutor.layout.tutor_profile_and_availability_aside", ['tutor_availabilities' => $tutor_availabilities])

        <div class="col-md-8 border-right">
            <div class="d-flex justify-content-between">
                <h2 class="mr-auto font-weight-light" data-toggle="modal" data-target="#incoming-call">Notifications</h2>
            </div>
            <ul class="list-group main-appointments mb-3">
                <li class="list-group-item d-flex justify-content-between p-4">
                    <div>
                        <h4 class="my-1 font-weight-light">Notification Title</h4>
                        <p class="text-muted mt-2 mb-0">11:00 am - 21 Nov, 2017</p>
                        <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between p-4">
                    <div>
                        <h4 class="my-1 font-weight-light">Notification Title</h4>
                        <p class="text-muted mt-2 mb-0">11:00 am - 21 Nov, 2017</p>
                        <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between p-4">
                    <div>
                        <h4 class="my-1 font-weight-light">Notification Title</h4>
                        <p class="text-muted mt-2 mb-0">11:00 am - 21 Nov, 2017</p>
                        <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between p-4">
                    <div>
                        <h4 class="my-1 font-weight-light">Notification Title</h4>
                        <p class="text-muted mt-2 mb-0">11:00 am - 21 Nov, 2017</p>
                        <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </li>
            </ul>
            <nav aria-label="Page navigation example" class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

        {{--payment_aside--}}
        @include('tutor.layout.payment_aside',['payments' => $payments])
    </div>
</div>