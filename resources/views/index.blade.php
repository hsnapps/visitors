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
                        <td colspan="2"><img src="{{ $avatar }}" class="profile-img"></td>
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
                    @each('components.courses_list', $courses, 'course', 'components.courses_empty')
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
                    @each('components.wetlabs_list', $wetlabs, 'wetlab', 'components.wetlabs_empty')
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- row -->

@include('modals.profile_edit')
@include('modals.course_adding')
@include('modals.wetlab_adding')
@endsection

