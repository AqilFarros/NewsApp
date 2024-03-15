@extends('home.parent')

@section('content')
    <div class="row">
        <div class="card p-4">
            <h3 class="card-title">Change Password</h3>

            <form action="{{ route('update-password') }}" method="post">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Current Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="Current Password" name="current_password">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="New Password" name="password">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-full">Change Password</button>
            </form>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endsection
