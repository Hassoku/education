@extends('student.layout.app')
@section('pageTitle', 'Payment History')
@section('body_class_atr')class="main"@endsection
@section('student_layout_topnavbar')
    @include('student.layout.topnavbar')
@endsection
@section('content')
    <main role="main">
        <div class="row mt-5">
            <div class="col-md-2 left-area pl-3"></div>
            <div class="col-md-8 border-right border-left">
                @if($student_payments->count() < 2)
                    <div class="table-responsive text-center">No record found.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped b-t">
                            <thead>
                            <tr>
                                <th style="width:20px;">
                                    ID
                                </th>
                                <th>Purchased Minutes</th>
                                <th>Amount</th>
                                <th>Total Minutes</th>
                                <th>Total Amount</th>
                                <th>Time</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $serialNumberCounter = ($student_payments->currentPage()-1) * $student_payments->perPage()+1;
                            @endphp
                            @foreach($student_payments as $student_balance)
                                @if($student_balance->purchased_slots > 0)
                                    <tr>
                                        <td>
                                            {{$serialNumberCounter++ }}
                                        </td>
                                        <td>{{($student_balance->purchased_slots) / 4}}</td>
                                        <td>{{$student_balance->purchased_amount}}</td>
                                        <td>{{($student_balance->remaining_slots) / 4}}</td>
                                        <td>{{$student_balance->remaining_amount}}</td>
                                        {{--<td>{{$learning_session->created_at->format('F j, Y')}}</td>--}}
                                        <td>{{$student_balance->updated_at->format('g:i A')}}</td>
                                        <td>{{$student_balance->updated_at->format('F j, Y')}}</td>
                                        <td>
                                            <a href class="btn btn-success">View</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                    {{--Pagination--}}
                    <nav aria-label="Page navigation example" class="mt-5">
                        {{--                {{$student_payments->links()}}--}}
                        @if($student_payments->lastPage() > 1)
                            <ul class="pagination justify-content-center">
                                <!-- Previous Page Link -->
                                @if ($student_payments->onFirstPage())
                                    <li class="disabled page-item"><a class="page-link" href="#">Previous</a></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{$student_payments->previousPageUrl()}}" onclick="reservationPagination('{{$student_payments->previousPageUrl()}}')" rel="prev">Previous</a></li>
                                @endif

                                @for ($i = 1; $i <= $student_payments->lastPage(); $i++)
                                    @if($student_payments->currentPage() == $i)
                                        <li class="disabled page-item"><a class="page-link" href="#">{{ $i }}</a></li>
                                    @else
                                        <li class="page-item"> <a class="page-link" href="{{ $student_payments->url($i) }}" onclick="reservationPagination('{{ $student_payments->url($i) }}')">{{ $i }}</a></li>
                                    @endif
                                @endfor

                            <!-- Next Page Link -->
                                @if ($student_payments->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $student_payments->nextPageUrl() }}" onclick="reservationPagination('{{ $student_payments->nextPageUrl() }}')" rel="next">Next</a></li>
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
