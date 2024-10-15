@extends('layouts.app')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>
            <div class="card-body">
                <div class="alert alert-success">
                    @if ($message = Session::get('success'))
                    {{ $message }}
                    @else
                    You are login as a user role. - User
                    @endif
                </div>
            </div>
        </div>

        <h1 class="display-5 fw-bold">Hi, {{ auth()->user()->name }}</h1>
        <p class="col-md-8 fs-4">Welcome to dashboard.</p>
        <button class="btn btn-primary btn-lg" type="button">Dashboard</button>
    </div>
</div>

@endsection