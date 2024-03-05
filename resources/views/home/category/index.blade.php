@extends('home')

@section('content')
    <div class="row">
        <div class="card p-4">
            <h3>Category Index</h3>

            <div class="d-flex justify-content-end">
                <a href="{{ route('category.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i>
                    Create Category
                </a>
            </div>
        </div>

        <div class="container mt-3">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Category</h5>
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($category as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->slug }}</td>
                                    <td><img src="{{ $row->image }}" alt="ini gambar" width="100px"></td>
                                    <td>
                                        <!-- Show Modal -->
                                        @include('home.category.include.modal-show')
                                        <!-- End Show Modal-->

                                        {{-- Edit --}}
                                        <a href="{{ route('category.edit', $row->id) }}" class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- End Edit --}}

                                        {{-- Delete --}}
                                        <form action="{{ route('category.destroy', $row->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger d-inline">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        {{-- Delete --}}
                                    </td>
                                </tr>
                            @empty
                                <p>Belum Ada Category</p>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $category->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
