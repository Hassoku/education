@extends('student.layout.app')
@section('pageTitle', 'Reservations')
@section('body_class_atr')class="main"@endsection
@section('student_layout_topnavbar')
    @include('student.layout.topnavbar',['reservations' => true])
@endsection
@section('content')
<div id="main">
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="col s12">
            <div class="p-1 m-2 border-bottom">
                <button data-target="newReservation" class="btn modal-trigger">Modal</button>
            </div>
                 {{--Model--}}

<div id="newReservation" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Modal Header</h4>
      <p>A bunch of text</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Degree</a>
    </div>
  </div>

</div>		
            <div class="container">
                <div class="section">     
                    <div class="row vertical-modern-dashboard"> 
                            <div class="col s12 m6 xl4">
                                <div id="data-tutors" data-tutors="0"></div>
                                <div id="profile-card" class="card accent-2 z-depth-3" style="height: 565px;">
                                    <div class="card-content">
                                        
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
					

@endsection
@section('own_js')
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems, options);
  });
     </script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('6a46b90592aa1656faab', {
            cluster: 'ap2',
            encrypted: true
        });
        
    </script>
@endsection
