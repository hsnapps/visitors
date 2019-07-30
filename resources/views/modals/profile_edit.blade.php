<!-- row modal for editing user profile-->
<div id="user-profile-edit" class="speaker-modal modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="speaker-modal-close" data-dismiss="modal"></button>
                <div class="modal-body">
                    <div class="row">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="title">Category</label>
                                    <select disabled name="title" id="title" class="form-control">
                                        @foreach (App\Category::all() as $title)
                                        <option {{ $title->id == $user->passprt_title_id ? 'selected' : '' }} value="{{ $title->id }}">{{ $title->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" name="first_name" placeholder="Your First Name" value="{{ $user->first_name }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" name="middle_name" placeholder="Your Middle Name" value="{{ $user->middle_name }}">
                                </div>
    
                                <div class="form-group col-md-4">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Your Last Name" value="{{ $user->last_name }}" required>
                                </div>
    
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="old-password">Old Password</label>
                                    <input type="password" class="form-control" name="old_password" placeholder="Your Old Password">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="new-password">New Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Your New Password">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Your Password">
                                </div>
    
                            </div>
                            <div class="form-row">
                                    <div class="form-group col-md-12">
                                    <label for="user-img">Upload Your New Image</label>
                                    <input type="file" name="avatar" class="form-control" accept="image/*">
    
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
    <!-- row -->