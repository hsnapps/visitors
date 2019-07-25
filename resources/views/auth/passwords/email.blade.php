@extends('layouts.auth')

@section('content')
<form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
    <div class="form-contact">
        <div class="section-title">
            <h3 class="title"><span>Reset Your Password</span></h3>
        </div>
        <div>
            <!--Body-->
            <div class="form-group">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                    </div>
                    <input type="email" class="form-control"  name="email" placeholder="Your Email" required>
                </div>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="text-center">
                <input type="submit" value="Send Link" class="btn btn-info btn-block rounded-0 py-2">
            </div>
        </div>
    </div>
    {{ csrf_field() }}
</form>
@endsection
