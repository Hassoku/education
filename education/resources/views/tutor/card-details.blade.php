
    @if($isCardSet)
        <div class="d-flex justify-content-between">
            <h2 class="mr-auto font-weight-light">Card Details</h2>
        </div>
        <form class="white-container center-form p-4 mt-1" method="POST" action="#">
            {{--Number --}}
            <div class="form-group row">
                <label for="name" class="col-md-2 col-form-label">Number</label>
                <div class="col-md-10">
                    {{--<input type="text"  class="form-control" id="number-field" name = "number" value="{{$number}}">--}}
                    {{$number}}
                </div>
            </div>

            {{--Expiry Date --}}
            <div class="form-group row">
                <label for="name" class="col-md-2 col-form-label">Expiry Date</label>
                <div class="col-md-10">
                    {{--<input type="text"  class="form-control" id="expiry-date-field" name = "expiry_date" value="{{$expiryDate}}">--}}
                    {{$expiryDate}}
                </div>
            </div>

            {{--Holder --}}
            <div class="form-group row">
                <label for="name" class="col-md-2 col-form-label">Holder</label>
                <div class="col-md-10">
                    {{--<input type="text"  class="form-control" id="holder-field" name = "holder" value="{{$holder}}">--}}
                    {{$holder}}
                </div>
            </div>

            {{--CVV --}}
            <div class="form-group row">
                <label for="name" class="col-md-2 col-form-label">CVV</label>
                <div class="col-md-10">
                    {{--<input type="text"  class="form-control" id="cvv-field" name = "cvv" value="{{$cvv}}">--}}
                    {{$cvv}}
                </div>
            </div>


            <div class="form-group row mb-0">
                <div class="col-md-2 col-form-label">
                    <div class="btn  btn-primary" id="change-card-details-btn" role="button" data-toggle="modal" data-target="#update-card-detail-modal">Change Details</div>
                </div>
                <div class="col-md-10 "></div>
            </div>

        </form>

        {{--model to update card details--}}
        <div id="update-card-detail-modal" class="modal" data-backdrop="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Card Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center p-lg">
                        <form class="white-container center-form p-4 mt-1" method="POST" action="{{route('tutor.setting.update.card.detail')}}">
                            {{csrf_field()}}
                            {{--Number --}}
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label">Number</label>
                                <div class="col-md-10">
                                    <input type="text"  class="form-control" placeholder="Card number" id="number-field" name = "number" value="" required>
                                </div>
                            </div>

                            {{--Expiry Date --}}
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label">Expiry Date</label>
                                <div class="col-md-10">
                                    <input type="date"  class="form-control" placeholder="Expiry Date" id="expiry-date-field" name = "expiry_date" value="" required>
                                </div>
                            </div>

                            {{--Holder --}}
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label">Holder</label>
                                <div class="col-md-10">
                                    <input type="text"  class="form-control" placeholder="Holder" id="holder-field" name = "holder" value="" required>
                                </div>
                            </div>

                            {{--CVV --}}
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label">CVV</label>
                                <div class="col-md-10">
                                    <input type="text"  class="form-control" placeholder="CVV" id="cvv-field" name = "cvv" value="" required>
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <label for="update-btn" class="col-md-2 col-form-label"></label>
                                <div class="col-md-10 ">
                                    <button class="btn  btn-success" id="update-btn" type="submit">Update</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer"></div>
                </div><!-- /.modal-content -->
            </div>
        </div>
    @else
        <div class="d-flex justify-content-between">
            <h2 class="mr-auto font-weight-light">Add Card Details</h2>
        </div>
        <form class="white-container center-form p-4 mt-1" method="POST" action="{{route('tutor.setting.add.card.detail')}}">
            {{csrf_field()}}
            {{--Number --}}
            <div class="form-group row">
                <label for="name" class="col-md-2 col-form-label">Number</label>
                <div class="col-md-10">
                    <input type="text"  class="form-control" placeholder="Card number" id="number-field" name = "number" value="" required>
                </div>
            </div>

            {{--Expiry Date --}}
            <div class="form-group row">
                <label for="name" class="col-md-2 col-form-label">Expiry Date</label>
                <div class="col-md-10">
                    <input type="date"  class="form-control" placeholder="Expiry Date" id="expiry-date-field" name = "expiry_date" value="" required>
                </div>
            </div>

            {{--Holder --}}
            <div class="form-group row">
                <label for="name" class="col-md-2 col-form-label">Holder</label>
                <div class="col-md-10">
                    <input type="text"  class="form-control" placeholder="Holder" id="holder-field" name = "holder" value="" required>
                </div>
            </div>

            {{--CVV --}}
            <div class="form-group row">
                <label for="name" class="col-md-2 col-form-label">CVV</label>
                <div class="col-md-10">
                    <input type="text"  class="form-control" placeholder="CVV" id="cvv-field" name = "cvv" value="" required>
                </div>
            </div>


            <div class="form-group row mb-0">
                <label for="update-btn" class="col-md-2 col-form-label"></label>
                <div class="col-md-10 ">
                    <button class="btn  btn-success" id="update-btn" type="submit">Add Card</button>
                </div>
            </div>

        </form>
    @endif