<div id="reservations" class="container-fluid">
    <div class="row mt-5">
        {{--tutor_profile_and_availability_aside--}}
        @include("tutor.layout.tutor_profile_and_availability_aside", ['tutor_availabilities' => $tutor_availabilities])

        {{--Reservations--}}
        <div class="col-md-8 border-right">
            <div class="d-flex justify-content-between">
                <h2 class="mr-auto font-weight-light" {{--data-toggle="modal" data-target="#incoming-call"--}}>Your Reservation</h2>
                <div class="dropdown">Reservation Type:
                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Both
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                    </div>
                </div>
            </div>

            @if($tutor_learning_session_reservations->count() > 0)
                {{--Reservation List--}}
                <ul class="list-group main-appointments mb-3">
                    @foreach($tutor_learning_session_reservations as $learning_session_reservation)
                    {{-- @php print_r($learning_session_reservation['reserv_id']); @endphp --}}
                        <li class="list-group-item d-flex justify-content-between p-4">
                            <div>
                                <h4 class="my-1 font-weight-light">{{$learning_session_reservation['topic']}}</h4>
                                <p class="my-2">{{$learning_session_reservation['student_name']}}</p>
                                <p class="text-muted mt-2 mb-0">{{$learning_session_reservation['session_timing']}}</p>
                            </div>
                            <div class="text-right"><p class="text-danger">{{$learning_session_reservation['remaining_time']}}</p>
                                <a class="btn mt-3 btn-outline-success btn-sm" href="{{route('individual.chat',['student_id' => $learning_session_reservation['student_id'],'device' => 'browser'])}}" role="button">Send Message <i class="fas fa-angle-right"></i></a>
                            </div>
                            <div class="float right">
                            <a href="{{route('tutor.approve', $learning_session_reservation['reserv_id'])}}" class="btn btn-success">Accept</a>
                                <a href="{{route('tutor.decline', $learning_session_reservation['reserv_id'])}}" class="btn btn-danger">Reject</a>
                            </div>
                        </li>
                    @endforeach
                    {{--Sample desing
                                    <li class="list-group-item d-flex justify-content-between p-4">
                                        <div>
                                            <h4 class="my-1 font-weight-light">Basic Mathematics</h4>
                                            <p class="my-2">Juliet Matt</p>
                                            <p class="text-muted mt-2 mb-0">11:00 am - 21 Nov, 2017</p>
                                        </div>
                                        <div class="text-right"><p class="text-danger">5 Minutes Remaining</p>
                                            <a class="btn mt-3 btn-outline-success btn-sm" href="#" role="button">Send Message <i class="fas fa-angle-right"></i></a>
                                        </div>
                                    </li>--}}
                </ul>

                {{--Pagination--}}
                <nav aria-label="Page navigation example" class="mt-5">
                    {{--                {{$tutor_learning_session_reservations->links()}}--}}
                    @if($tutor_learning_session_reservations->lastPage() > 1)
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            @if ($tutor_learning_session_reservations->onFirstPage())
                                <li class="disabled page-item"><a class="page-link" href="#">Previous</a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{$tutor_learning_session_reservations->previousPageUrl()}}" onclick="reservationPagination('{{$tutor_learning_session_reservations->previousPageUrl()}}')" rel="prev">Previous</a></li>
                            @endif

                            @for ($i = 1; $i <= $tutor_learning_session_reservations->lastPage(); $i++)
                                @if($tutor_learning_session_reservations->currentPage() == $i)
                                    <li class="disabled page-item"><a class="page-link" href="#">{{ $i }}</a></li>
                                @else
                                    <li class="page-item"> <a class="page-link" href="{{ $tutor_learning_session_reservations->url($i) }}" onclick="reservationPagination('{{ $tutor_learning_session_reservations->url($i) }}')">{{ $i }}</a></li>
                                @endif
                            @endfor

                        <!-- Next Page Link -->
                            @if ($tutor_learning_session_reservations->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $tutor_learning_session_reservations->nextPageUrl() }}" onclick="reservationPagination('{{ $tutor_learning_session_reservations->nextPageUrl() }}')" rel="next">Next</a></li>
                            @else
                                <li class="disabled page-item"><a class="page-link" href="#">Next</a></li>
                            @endif
                        </ul>
                    @endif
                </nav>
            @else
                <div class="row">
                    <h6 class="col-12 text-center"><u><i>You have no reservations</i></u></h6>
                </div>
            @endif
        </div>

        {{--payment_aside--}}
        @include('tutor.layout.payment_aside',['payments' => $payments])
    </div>
</div>