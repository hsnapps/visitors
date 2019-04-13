@extends('layouts.main')

@section('content')
<!-- row -->
<div class="row">
    <!-- row -->
    <div class="row">
        <!-- section title -->
        <div class="section-title">
            <h3 class="title"><span>My</span> <span style="color: #e92c30;">Dashboard</span></h3>
        </div>
        <!-- section title -->
    </div>
    <!-- row -->

    <div class="col-md-12 container">
        <div class="col-md-4">
            <table class="user-profile-table" cellspacing="5px" cellpadding="" width="100%">
                <tbody>
                    <tr>
                        <td colspan="2"><img src="img/speaker_1.jpg" class="profile-img"></td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Name</h3>
                        </td>
                        <td>
                            <p>{{ $user->fullName() }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Email</h3>
                        </td>
                        <td>
                            <p><a href="emailto:{{ $user->email }}">{{ $user->email }}</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Position</h3>
                        </td>
                        <td>
                            <p>{{ isset($user->profession) ? $user->profession : 'N/A' }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button data-toggle="modal" data-target="#user-profile-edit" class="btn btn-primary">Edit</button>
        </div>
        <div class="col-md-8 course-edit-container">
            <table class="course-list-container" cellpadding="20px" cellspacing="20px">
                <tbody>
                    <tr>
                        <th>
                            <h2>My Courses</h2>
                        </th>
                        <th><a href="" data-toggle="modal" data-target="#course-adding-modal" class=" btn-primary">Add</a></th>
                    </tr>
                    <tr>
                        <td>Course A</td>
                        <td>25/5/2019</td>
                    </tr>
                    <tr>
                        <td>Course A</td>
                        <td>25/5/2019</td>
                    </tr>
                    <tr>
                        <td>Course A</td>
                        <td>25/5/2019</td>
                    </tr>
                    <tr>
                        <td>Course A</td>
                        <td>25/5/2019</td>
                    </tr>
                </tbody>
            </table>
            <table class="course-list-container">
                <tbody>
                    <tr>
                        <th>
                            <h2>My Wetlabs</h2>
                        </th>
                        <th><a href="" data-toggle="modal" data-target="#wetlab-adding-modal" class=" btn-primary">Add</a></th>
                    </tr>
                    <tr>
                        <td colspan="2">Wetlab A</td>
                    </tr>
                    <tr>
                        <td colspan="2">Wetlab B</td>
                    </tr>
                    <tr>
                        <td colspan="2">Course C</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- row -->

<!-- row modal for editing user profile-->
<div id="user-profile-edit" class="speaker-modal modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="speaker-modal-close" data-dismiss="modal"></button>
            <div class="modal-body">
                <div class="row">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="f-name">First Name</label>
                                <input type="text" class="form-control" id="f-name" placeholder="Your First Name">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="m-name">Middle Name</label>
                                <input type="text" class="form-control" id="l-name" placeholder="Your Middle Name">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="l-name">Last Name</label>
                                <input type="text" class="form-control" id="l-name" placeholder="Your Last Name">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Your Email">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="old-password">Old Password</label>
                                <input type="password" class="form-control" id="old-password" placeholder="Your Old Password">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="new-password">New Password</label>
                                <input type="password" class="form-control" id="new-password" placeholder="Your New Password">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="confirm-password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Your Password">
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-12">
                                <label for="user-img">Upload Your New Image</label>
                                <input type="file" name="user-img" class="form-control" accept="image/*">

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

@include('modals.course-adding-modal')
@include('modals.wetlab-adding-modal')
@endsection

