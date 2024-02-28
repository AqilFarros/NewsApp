@extends('home.parent')

@section('content')

<div class="container">
    <div class="row card">
        <h1>Welcome {{ Auth::user()->name }}</h1>
    </div>
</div>

@endsection
