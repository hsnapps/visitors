<!-- row modal for add booking -->
<div id="booking-adding-modal" class="speaker-modal modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="speaker-modal-close" data-dismiss="modal"></button>
                <div class="modal-body">
                    <div class="row">
                        <form action="{{ route('add-course-to-cart') }}" method="POST">
                            <label for="course-category">Choose Booking Package</label>
                            <div class="form-row">
                                @foreach ($bookings_list as $booking)
                                <div class="form-group col-md-3">
                                    <div class="custom-control custom-checkbox">
                                        <input name="bookings[]" type="radio" class="custom-control-input" value="{{ $booking->id }}">
                                        <label class="custom-control-label" for="customCheck1">{{ sprintf('%d Days', $booking->days) }} <span class="price">{{ sprintf('%s %.2f', env('CURRENCY'), $booking->price / env('CURRENCY_RATE')) }}</span></label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-row col-md-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            {{ csrf_field() }}
                            <input type="hidden" name="item_type" value="booking">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row modal for add booking -->