@extends('home.parent')


@section('content')
    <div class="row">
        <div class="card p-4">
            <h3>Add News</h3>

            <form action="{{ route('news.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="mb-2 col-12">
                    <label for="inputTitle" class="form-label">News Title</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" value="{{ old('title') }}">
                </div>

                <div class="mb-2 col-12">
                    <label for="inputImage" class="form-label">News Image</label>
                    <input type="file" class="form-control" id="inputImage" name="image" value="{{ old('image') }}">
                </div>

                <div class="mb-2">
                    <label class="col-sm-2 col-form-label">Select</label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Default select example" name="category_id">
                            <option selected>Open this select menu</option>
                            @foreach ($category as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-2">
                    <label for="editor" class="col-sm-2 col-form-label">Content</label>
                    <textarea id="editor" name="content"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-plus"></i>
                        Add News
                    </button>
                </div>

                <script>
                    ClassicEditor
                        .create(document.querySelector('#editor'))
                        .then(editor => {
                            console.log(editor);
                        })
                        .catch(error => {
                            console.error(error);
                        });
                </script>
            </form>
        </div>
    </div>
@endsection
