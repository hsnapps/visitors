<button data-toggle="modal" data-target="#test-mail" class="btn btn-primary">Test Email</button>

<!-- row modal for add booking -->
<div id="test-mail" class="speaker-modal modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="speaker-modal-close" data-dismiss="modal"></button>
            <div class="modal-body">
                <div class="row">
                    <form action="{{ route('test.mail') }}" method="POST">
                        <div class="form-row col-md-12">
                            <button type="submit" class="btn btn-primary">Send Test Mail</button>
                        </div>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row modal for add booking -->