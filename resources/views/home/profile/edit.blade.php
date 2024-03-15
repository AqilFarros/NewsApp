@extends('home.parent')

@section('content')
    <div class="row">
        <div class="card p-4">
            <h3 class="card-title">
                Create Profile {{ Auth::user()->name }}
            </h3>

            <form action="{{ route('update-profile') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col mb-3">
                    <label for="" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" value="{{ $user->profile->first_name }}">
                </div>

                <div class="col mb-3">
                    <label for="" class="form-label">Image</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-pencil"></i>
                    Update Profile
                </button>
            </form>
        </div>
    </div>
@endsection
