<div id="payments" class="container-fluid">
    <div class="row mt-5">
        {{--tutor_profile_and_availability_aside--}}
        @include("tutor.layout.tutor_profile_and_availability_aside", ['tutor_availabilities' => $tutor_availabilities])

        {{--Youu Payments--}}
        <div class="col-md-8 border-right">
            <div class="d-flex justify-content-between">
                <h2 class="mr-auto font-weight-light" data-toggle="modal" data-target="#incoming-call">Your Payments</h2>
            </div>
            <ul class="nav nav-tabs mt-3 ">
                <li class="nav-item">
                    <a class="nav-link @if($selectedTab == 'pending') active @endif" data-toggle="tab" href="#pending">Earnings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($selectedTab == 'received') active @endif" data-toggle="tab" href="#received">Received</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                {{--pending tab--}}
                <div class="tab-pane @if($selectedTab == 'pending') active @endif" id="pending">
                    {{--pendings--}}
                    <ul class="list-group main-appointments mb-3">
                        {{--<li class="list-group-item d-flex justify-content-between p-4">
                            <div>
                                <h4 class="my-1 font-weight-light">Basic Mathematics - Juliet</h4>
                                <p class="text-muted mt-2 mb-0">11:00 am - 21 Nov, 2017</p>
                            </div>
                            <div class="font-weight-bold">$15</div>
                        </li>--}}

                        @php
                            $totalEarnings = 0;
                        @endphp
                        @foreach($earningCollection as $earnings)
                            @php
                                $totalEarnings += $earnings->earning_amount;
                            @endphp
                            <li class="list-group-item d-flex justify-content-between p-4">
                                <div>
                                    {{--<h4 class="my-1 font-weight-light">Basic Mathematics - Juliet</h4>--}}
                                    <p class="text-muted mt-2 mb-0"> {{date('g:i A - d M, Y', strtotime($earnings->created_at))}}</p>
                                </div>
                                <div class="font-weight-bold">{{$earnings->earning_amount}} SAR</div>
                            </li>
                        @endforeach
                    </ul>

                    {{--total--}}
                    <div class="text-right font-weight-bold px-4">Total: {{$totalEarnings}} SAR</div>

                    {{--Pagination--}}
                    <nav aria-label="Page navigation example" class="mt-5">
                        {{--                {{$earningCollection->links()}}--}}
                        @if($earningCollection->lastPage() > 1)
                            <ul class="pagination justify-content-center">
                                <!-- Previous Page Link -->
                                @if ($earningCollection->onFirstPage())
                                    <li class="disabled page-item"><a class="page-link" href="#">Previous</a></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{$earningCollection->previousPageUrl()}}" onclick="reservationPagination('{{$earningCollection->previousPageUrl()}}')" rel="prev">Previous</a></li>
                                @endif

                                @for ($i = 1; $i <= $earningCollection->lastPage(); $i++)
                                    @if($earningCollection->currentPage() == $i)
                                        <li class="disabled page-item"><a class="page-link" href="#">{{ $i }}</a></li>
                                    @else
                                        <li class="page-item"> <a class="page-link" href="{{ $earningCollection->url($i) }}" onclick="reservationPagination('{{ $earningCollection->url($i) }}')">{{ $i }}</a></li>
                                    @endif
                                @endfor

                            <!-- Next Page Link -->
                                @if ($earningCollection->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $earningCollection->nextPageUrl() }}" onclick="reservationPagination('{{ $earningCollection->nextPageUrl() }}')" rel="next">Next</a></li>
                                @else
                                    <li class="disabled page-item"><a class="page-link" href="#">Next</a></li>
                                @endif
                            </ul>
                        @endif
                    </nav>
                </div>

                {{--received tab--}}
                <div class="tab-pane @if($selectedTab == 'received') active @endif" id="received">

                    {{--received list--}}
                    <ul class="list-group main-appointments mb-3">
                        {{--<li class="list-group-item d-flex justify-content-between p-4">
                            <div>
                                <h4 class="my-1 font-weight-light">Basic Mathematics - Juliet Max</h4>
                                <p class="text-muted mt-2 mb-0">11:00 am - 21 Nov, 2017</p>
                            </div>
                            <div class="font-weight-bold">$15</div>
                        </li>--}}
                        @php
                            $totalReceived = 0;
                        @endphp
                        @foreach($withdrawCollection as $withdraw)
                            @php
                                $totalReceived += $withdraw->withdraw_amount;
                            @endphp
                            <li class="list-group-item d-flex justify-content-between p-4">
                                <div>
                                    {{--<h4 class="my-1 font-weight-light">Basic Mathematics - Juliet Max</h4>--}}
                                    <p class="text-muted mt-2 mb-0"> {{date('g:i A - d M, Y', strtotime($withdraw->created_at))}}</p>
                                </div>
                                <div class="font-weight-bold">{{$withdraw->withdraw_amount}} SAR</div>
                            </li>
                        @endforeach
                    </ul>

                    {{--total--}}
                    <div class="text-right font-weight-bold px-4">Total: {{$totalReceived}} SAR</div>

                    {{--pagination--}}
                    <nav aria-label="Page navigation example" class="mt-5">
                        {{--                {{$withdrawCollection->links()}}--}}
                        @if($withdrawCollection->lastPage() > 1)
                            <ul class="pagination justify-content-center">
                                <!-- Previous Page Link -->
                                @if ($withdrawCollection->onFirstPage())
                                    <li class="disabled page-item"><a class="page-link" href="#">Previous</a></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{$withdrawCollection->previousPageUrl()}}" onclick="reservationPagination('{{$withdrawCollection->previousPageUrl()}}')" rel="prev">Previous</a></li>
                                @endif

                                @for ($i = 1; $i <= $withdrawCollection->lastPage(); $i++)
                                    @if($withdrawCollection->currentPage() == $i)
                                        <li class="disabled page-item"><a class="page-link" href="#">{{ $i }}</a></li>
                                    @else
                                        <li class="page-item"> <a class="page-link" href="{{ $withdrawCollection->url($i) }}" onclick="reservationPagination('{{ $withdrawCollection->url($i) }}')">{{ $i }}</a></li>
                                    @endif
                                @endfor

                            <!-- Next Page Link -->
                                @if ($withdrawCollection->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $withdrawCollection->nextPageUrl() }}" onclick="reservationPagination('{{ $withdrawCollection->nextPageUrl() }}')" rel="next">Next</a></li>
                                @else
                                    <li class="disabled page-item"><a class="page-link" href="#">Next</a></li>
                                @endif
                            </ul>
                        @endif
                    </nav>
                </div>
            </div>
        </div>

        {{--payment_aside--}}
        @include('tutor.layout.payment_aside',['payments' => $payments])
    </div>
</div>