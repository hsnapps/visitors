<!-- row modal for add wetlab-->
<div id="wetlab-adding-modal" class="speaker-modal modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="speaker-modal-close" data-dismiss="modal"></button>
            <div class="modal-body">
                <div class="row">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="course-title">Wetlab Title</label>
                                <input type="text" class="form-control" id="course-title" placeholder="Enter Course Title">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="course-category">Choose Wetlab Category</label>
                                <select name="basic[]" multiple="multiple" class="2col active">
                                    @foreach ($wetlabs_list as $wetlab)
                                    <option value="{{ $wetlab->id }}">{{ $wetlab->name }}</option>    
                                    @endforeach                                                        
                                </select>
                            </div>

                        </div>


                        <div class="form-row col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- row modal for add wetlab -->