<!-- row modal for add wetlab-->
<div id="wetlab-adding-modal" class="speaker-modal modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="speaker-modal-close" data-dismiss="modal"></button>
            <div class="modal-body">
                <div class="row">
                    <form action="{{ route('add-course-to-cart') }}" method="POST">
                        <div class="form-row">
                            <label for="course-category">Choose Wetlab Category</label>
                            <div class="form-group col-md-12">
                                @foreach ($wetlabs_list as $wetlab)
                                <div class="form-group col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input name="courses[]" type="checkbox" class="custom-control-input" value="{{ $wetlab->id }}">
                                        <label class="custom-control-label" for="customCheck1">{{ $wetlab->name }} <span class="price">SAR {{ $wetlab->price }}</span></label>
                                    </div>
                                    <small id="passwordHelpBlock" class="form-text text-muted text-uppercase">
                                        {{ sprintf('Starts on %s. available seats %d', $wetlab->starts_on->format('F j, Y'), $wetlab->seats) }}
                                    </small>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-row col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        {{ csrf_field() }}
                        <input type="hidden" name="item_type" value="wetlabs">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row modal for add wetlab -->