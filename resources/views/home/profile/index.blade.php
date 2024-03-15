@extends('home.parent')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-4">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-center">
                @if (empty(Auth::user()->profile->image))
                    <img class="w-75" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="">
                @else
                    <img class="w-75" src="{{ Auth::user()->profile->image }}" alt="Ini Profile Image">
                @endif
            </div>
            <div class="col-md-6 text-center">
                <h3>Profile Account</h3>
                <div class="card p-3">
                    <ul class="list-group">
                        <li class="list-group-item" aria-current="true">Name Account:
                            <strong>{{ Auth::user()->name }}</strong>
                        </li>
                        <li class="list-group-item">E-Mail Account: <strong>{{ Auth::user()->email }}</strong></li>
                        <li class="list-group-item">First Name: <strong>{{ Auth::user()->profile->first_name }}</strong>
                        </li>
                        <li class="list-group-item">Role Account: <strong>{{ Auth::user()->role }}</strong></li>
                    </ul>
                    @if (empty(Auth::user()->profile->image))
                        <a href="{{ route('create-profile') }}" class="mt-5 btn btn-primary">
                            <i class="bi bi-plus"></i>Create Profile
                        </a>
                    @else
                        <a href="{{ route('edit-profile') }}" class="mt-5 btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit Profile
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
