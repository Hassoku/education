{{--Payments--}}
<div class="right-area col-md-2 ">
    <h3 class="h4 font-weight-light">Payments</h3>
    <ul class="list-group mb-3 mr-3">
        <li class="list-group-item ">
            <h6 class="m-0">{{$payments['received_amount']}} SAR Received</h6>
        </li> <li class="list-group-item ">
            <h6 class="m-0">{{$payments['pending_amount']}} SAR Pending</h6>
        </li>
    </ul>
    <p><a class="btn btn-success" href="#" role="button">Withdraw Payments <i class="fas fa-angle-right"></i></a></p>
</div>