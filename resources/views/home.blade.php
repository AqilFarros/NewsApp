@extends('home.parent')

@section('content')

<div class="container">
    <div class="row card">
        <h1>Welcome {{ Auth::user()->name }}</h1>
    </div>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button class="btn btn-danger">Logout</button>
    </form>
</div>

@endsection
