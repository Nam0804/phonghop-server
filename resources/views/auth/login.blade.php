@extends('layouts.auth-master')

@section('content')
    <form method="post" action="{{ route('login.perform') }}" novalidate class="w-50 mx-auto">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <img class="mb-4" src="{!! url('images/bootstrap-logo.svg') !!}" alt="" width="72" height="57">

        <h1 class=" mb-3 fw-normal text-center">Login</h1>
        <h3 class=" text-center">Welcome to Phonghop.vn</h3>



        <div class="mb-3 w-75 mx-auto">
            <label for="username" class="form-label">Email address</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required="required">
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>
        <div class="mb-3 w-75 mx-auto">
            <label for="username" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>
        {{-- remember me & forgot password --}}
        <div class="mb-3 form-check w-75 mx-auto">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me" value="1">
            <label class="form-check-label" for="remember_me">Remember me</label>
            <a href="{{ route('forgot-password.show') }}" class="float-end">Forgot password?</a>
        </div>

        @include('layouts.partials.messages')

        <div class="form-group d-flex justify-content-evenly">
            <a href="{{route('register.show')}}" class="w-25 btn btn-lg btn-white">Sign up</a>
            <button class="w-25 btn btn-lg btn-red" type="submit">Login</button>
        </div>


    </form>
@endsection
