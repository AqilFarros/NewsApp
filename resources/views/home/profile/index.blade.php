@extends('home.parent')

@section('content')

<div class="card p-4">
    <div class="row">
        <div class="col-md-6 d-flex justify-content-center">
            <img class="w-75" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="">
        </div>
        <div class="col-md-6 text-center">
            <h3>Profile Account</h3>
            <div class="card p-3">
                <ul class="list-group">
                    <li class="list-group-item" aria-current="true">Name Account: <strong>{{ Auth::user()->name }}</strong></li>
                    <li class="list-group-item">E-Mail Account: <strong>{{ Auth::user()->email }}</strong></li>
                    <li class="list-group-item">Role Account: <strong>{{ Auth::user()->role }}</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection