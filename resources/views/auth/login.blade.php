@extends('layouts.auth')

@section('content')
<form class="form-horizontal" method="POST" action="{{ route('login') }}">
    <div class="form-contact">
        <div class="section-title">
            <h3 class="title"><span>Login to your account</span></h3>
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
            <div class="form-group">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="padding-right: 6px;"><i class="fa fa-lock text-info"></i></div>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="Your Password" required>
                </div>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="text-center">
                <input type="submit" value="Submit" class="btn btn-info btn-block rounded-0 py-2">
            </div>
            <div class="text-right">
                <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
            </div>
        </div>
    </div>
    {{ csrf_field() }}
</form>
@endsection
