<!-- row modal for add wetlab-->
<div id="course-adding-modal" class="speaker-modal modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="speaker-modal-close" data-dismiss="modal"></button>
            <div class="modal-body">
                <div class="row">
                    <form action="{{ route('add-course-to-cart') }}" method="POST">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            @foreach ($grouped_courses as $key => $courses)
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                  <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#date-{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                      <label class="custom-control-label">COURSES ON {{ $key }}</label>
                                    </a>
                                  </h4>
                                </div>
                                <div id="date-{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                  <div class="panel-body">
                                    <ul class="wetlab-session">
                                        @foreach ($courses as $course)
                                        <div class="custom-control custom-radio">
                                            <input {{ $course->seats == 0 ? 'disabled' : '' }} name="course[]" type="checkbox" class="custom-control-input" value="{{ $course->id }}">
                                            <span class="price">{{ sprintf('%s - Starts at %s - Available Seats %d', $course->name, $course->starts_on->format('H:i'), $course->seats) }}</span>
                                        </div>
                                        @endforeach
                                    </ul>                                    
                                  </div>
                                </div>
                              </div>
                            @endforeach
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