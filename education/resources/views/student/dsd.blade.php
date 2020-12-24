@extends('student.layout.app')
@section('pageTitle', 'Search Result')
@section('body_class_atr')class="main"@endsection
@section('student_layout_topnavbar')
    @include('student.layout.topnavbar')
@endsection
@section('content')
    <main role="main">
        <div id="dash-content">
           
            <div class="row mt-5">
                <div class="col-md-2 left-area pl-3">
                    <div class="w3-sidebar w3-light-grey w3-bar-block" style="width:108%;margin-top: -45px;height: 135%;margin-left: -4px;">
                        <a style="text-decoration: none;color: #cecece;font-size: 21px;;margin-top: 15px;" class="w3-bar-item w3-button" href="{{route('student.dashboard')}}" > <span>Dashboard</span>&nbsp;<i class="fas fa-tachometer-alt"></i></a>
                        <h3 class="w3-bar-item" style="color: #cecece;">Menu</h3>
                        <a style="text-decoration: none;color: #cecece;" class="w3-bar-item w3-button" href="{{route('student.dashboard.page',['p_code' => 'ttr'])}}"><span>All Tutors</span>&nbsp;&nbsp;<i class='fas fa-graduation-cap' style='font-size:20px;color: #cecece;'></i></a>
                        <h3 class="w3-bar-item"style="color: #cecece;" >Sessions</h3>
                        <a style="text-decoration: none;color: #cecece;"  href="{{route('student.dashboard.page',['p_code' => 'rsrv'])}}" class="w3-bar-item w3-button"><span>Reservations</span>&nbsp;&nbsp;<i class="fas fa-ticket-alt"></i></a></p>
                        <h3 class="w3-bar-item">Pay For Services</h3>
                        <a style="text-decoration: none;color: #cecece;"  href="#" class="w3-bar-item w3-button">Proofreading</a>
                        <a style="text-decoration: nonecolor: #cecece;"  href="#" class="w3-bar-item w3-button">Translations</a>
                     </div>
                </div>
                <div class="col-md-8 border-right ">
                    @if (isset($topic))
                           
                     @forelse ($topic as $item)
                     
                         <div class="container">
                               <div class="col-md-4">
                                   <h5>Search Query: {{request()->query('topic')}} </h5>
                                <div class="card" style="width: 18rem;">
                                    {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
                                    <div class="card-body">
                                      <h5 class="card-title"> {{$item->topic}}</h5>
                                      <p class="card-text">{{$item->description}}</p>
                                      <a href="#" class="btn btn-primary">{{$item->status}}</a>
                                    </div>
                                  </div>
                               </div>
                         </div>
                       
                         @empty
                         <h3>no record found</h3>
                     @endforelse
                    @endif
                  
                   
                </div>
                      {{--Remaining Minutes Aside--}}
                @include('student.layout.remainingMinutesAsideBar')
            </div>
        </div>
        @include('student.layout.footer') 
    </main>
@endsection
@section('ownCSS')
   
        
@endsection