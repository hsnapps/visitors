<!-- row modal for add wetlab-->
<div id="wetlab-adding-modal" class="speaker-modal modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="speaker-modal-close" data-dismiss="modal"></button>
            <div class="modal-body">
                <div class="row">
                    <form action="{{ route('add-course-to-cart') }}" method="POST">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            @foreach ($wetlabs_list as $wetlab)
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                  <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#wetlab-{{ $wetlab->id }}" aria-expanded="true" aria-controls="collapseOne">
                                      <label class="custom-control-label" for="customCheck1">{{ $wetlab->name }} <span class="price">{{ sprintf('Starts on %s', $wetlab->starts_on->format('F j, Y')) }}</span></label>
                                    </a>
                                  </h4>
                                </div>
                                <div id="wetlab-{{ $wetlab->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                  <div class="panel-body">
                                    <ul class="wetlab-session">
                                        @foreach ($wetlab->sessions as $s)
                                          @php
                                              $available = $s->seats_available - $s->seats_taken;
                                          @endphp
                                        <div class="custom-control custom-radio">
                                            <input multiple="false" {{ $available == 0 ? 'disabled' : '' }} name="{{ sprintf('courses[%d][]', $s->wetlab->id) }}" type="radio" class="custom-control-input" value="{{ $s->id }}">
                                            <span class="price">{{ sprintf('%s - Starts on %s - Available Seats %d', $s->name, substr($s->start_time, 0, 5), $available) }}</span>
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
<!-- row modal for add wetlab -->