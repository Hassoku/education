@extends('student.layout.app')
@section('pageTitle', 'Session Archives')
@section('body_class_atr')class="main"@endsection
@section('student_layout_topnavbar')
    @include('student.layout.topnavbar')
@endsection
@section('content')
    <main role="main">
        <div class="row mt-5">
            <div class="col-md-2 left-area pl-3"></div>
            <div class="col-md-8 border-right border-left">
                    @if($completed_learning_sessions->count() < 1)
                        <div class="table-responsive text-center">No record found.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped b-t">
                                <thead>
                                <tr>
                                    <th style="width:20px;">
                                        ID
                                    </th>
                                    <th>Tutor</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th style="width:50px;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $serialNumberCounter = ($completed_learning_sessions->currentPage()-1) * $completed_learning_sessions->perPage()+1;
                                @endphp
                                @foreach($completed_learning_sessions as $learning_session)
                                    <tr>
                                        <td>
                                            {{$serialNumberCounter++ }}
                                        </td>
                                        <td>
                                            <div style="position: relative" class="">
                                                <i style="position: absolute; bottom: 4px; left: 1px; color: #eeeeee; " class="fas fa-circle"></i>
                                                <small style="position: absolute; bottom: 0px; left: 2px;" class=" {{'online-tut-'.$learning_session->tutor->email}} {{ ($learning_session->tutor->online_status == 0) ? 'text-muted ' : 'text-success ' }}">
                                                    <i class="fas fa-circle"></i>
                                                </small>
                                                <img style="border-radius: 100px; width: 55px" src="{{asset($learning_session->tutor->profile->picture)}}" class="circle" alt="{{$learning_session->tutor->name}} {{$learning_session->tutor->last_name}}" style="width:50%; padding: 5%">
                                            </div>
                                            <br>
                                            <h6>{{$learning_session->tutor->name}} {{$learning_session->tutor->last_name}}</h6>
                                        </td>
                                        <td>{{Carbon::parse($learning_session->learning_session->start_time)->format('g:i A')}}</td>
                                        <td>{{Carbon::parse($learning_session->learning_session->end_time)->format('g:i A')}}</td>
                                        <td>
                                            <span class="{{($learning_session->learning_session->status == true)? '  text-success': ' text-danger'}}">
                                                {{($learning_session->learning_session->status == true) ? 'Running': 'Completed'}}
                                            </span>
                                        </td>
                                        <td>{{$learning_session->created_at->format('F j, Y')}}</td>
                                        <td style="width:18%;">
                                            <a class="btn btn-success" href="{{route('student.learning.session.archive',['id' => $learning_session->learning_session->id])}}"><i class=""></i> view</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                        {{--Pagination--}}
                        <nav aria-label="Page navigation example" class="mt-5">
                            {{--                {{$completed_learning_sessions->links()}}--}}
                            @if($completed_learning_sessions->lastPage() > 1)
                                <ul class="pagination justify-content-center">
                                    <!-- Previous Page Link -->
                                    @if ($completed_learning_sessions->onFirstPage())
                                        <li class="disabled page-item"><a class="page-link" href="#">Previous</a></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{$completed_learning_sessions->previousPageUrl()}}" onclick="reservationPagination('{{$completed_learning_sessions->previousPageUrl()}}')" rel="prev">Previous</a></li>
                                    @endif

                                    @for ($i = 1; $i <= $completed_learning_sessions->lastPage(); $i++)
                                        @if($completed_learning_sessions->currentPage() == $i)
                                            <li class="disabled page-item"><a class="page-link" href="#">{{ $i }}</a></li>
                                        @else
                                            <li class="page-item"> <a class="page-link" href="{{ $completed_learning_sessions->url($i) }}" onclick="reservationPagination('{{ $completed_learning_sessions->url($i) }}')">{{ $i }}</a></li>
                                        @endif
                                    @endfor

                                <!-- Next Page Link -->
                                    @if ($completed_learning_sessions->hasMorePages())
                                        <li class="page-item"><a class="page-link" href="{{ $completed_learning_sessions->nextPageUrl() }}" onclick="reservationPagination('{{ $completed_learning_sessions->nextPageUrl() }}')" rel="next">Next</a></li>
                                    @else
                                        <li class="disabled page-item"><a class="page-link" href="#">Next</a></li>
                                    @endif
                                </ul>
                            @endif
                        </nav>
            </div>
            {{--Remaining Minutes Aside--}}
            @include('student.layout.remainingMinutesAsideBar');
        </div>
        {{--including footer--}}
        @include('student.layout.footer')
    </main>
@endsection
@section('own_js')
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('6a46b90592aa1656faab', {
            cluster: 'ap2',
            encrypted: true
        });

        var channel = pusher.subscribe('tutor.status');
        // rejected
        channel.bind('tutor.status.event', function (data) {
            var tutor = data.tutor;
            // console.log(tutor);
            var elements = document.getElementsByClassName('online-tut-'+tutor.email);
            $.each(elements, function (i, element) {
                if(tutor.online_status){
                    console.log("true");
                    element.classList.remove('text-muted');
                    element.classList.add('text-success');
                }else {
                    if(!tutor.online_status){
                        console.log("false");
                        element.classList.remove('text-success');
                        element.classList.add('text-muted');
                    }
                }
            });

        });

    </script>
@endsection
