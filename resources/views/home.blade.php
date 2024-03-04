@extends('home.parent')

@section('content')
    <div class="container">
        <div class="row card">
            <h1>Welcome {{ Auth::user()->name }}</h1>
            <hr>
            <div class="card p-3">
                <h3 class="text-center">Detail Account</h3>
                <ul class="list-group">
                    <li class="list-group-item" aria-current="true">Name Account: <strong>{{ Auth::user()->name }}</strong></li>
                    <li class="list-group-item">E-Mail Account: <strong>{{ Auth::user()->email }}</strong></li>
                    <li class="list-group-item">Role Account: <strong>{{ Auth::user()->role }}</strong></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
