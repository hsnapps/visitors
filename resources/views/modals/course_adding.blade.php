<!-- row modal for add course-->
<div id="course-adding-modal" class="speaker-modal modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="speaker-modal-close" data-dismiss="modal"></button>
            <div class="modal-body">
                <div class="row">
                    <form action="{{ route('add-course-to-cart') }}" method="POST">
                        <label for="course-category">Choose Course Category</label>
                        <div class="form-row">
                            @foreach ($courses_list as $course)
                            <div class="form-group col-md-6">
                                <div class="custom-control custom-checkbox">
                                    <input name="courses[]" type="checkbox" class="custom-control-input" value="{{ $course->id }}">
                                    <label class="custom-control-label" for="customCheck1">{{ $course->name }}</label>
                                </div>
                                <small id="passwordHelpBlock" class="form-text text-muted text-uppercase">
                                    {{ sprintf('Starts on %s. available seats %d', $course->starts_on->format('F j, Y'), $course->seats) }}
                                </small>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-row col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        {{ csrf_field() }}
                        <input type="hidden" name="item_type" value="courses">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row modal for add course -->