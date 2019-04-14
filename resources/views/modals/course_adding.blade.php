<!-- row modal for add course-->
<div id="course-adding-modal" class="speaker-modal modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="speaker-modal-close" data-dismiss="modal"></button>
            <div class="modal-body">
                <div class="row">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="course-title">Course Title</label>
                                <input type="text" class="form-control" id="course-title" placeholder="Enter Course Title">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="course-date">Course Date</label>
                                <input type="date" class="form-control" id="course-date" placeholder="Enter Course Date">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="course-category">Choose Course Category</label>
                                <select name="basic[]" multiple="multiple" class="2col active">
                                    @foreach ($courses_list as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>    
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
<!-- row modal for add course -->