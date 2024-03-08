@extends('home.parent')

@section('content')
    <div class="row">
        <div class="card p-4">
            <h5 class="card-title">{{ $news->title }} - <span
                    class="badges badges-success">{{ $news->category->name }}</span></h5>
            <p>
                <img src="{{ $news->image }}" alt="Ini Gambar Berita" class="img-fluid">
            </p>
            <textarea id="editor" disabled readonly>
                {!! $news->content !!}
            </textarea>
        </div>
        <div class="container">
            <div class="d-flex justify-content-end">
                <a href="{{ route('news.index') }}">
                <i class="bi bi-arrow-left"></i> Back To Index</a>
            </div>
        </div>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
                editor.isReadOnly; // `false`.
                editor.enableReadOnlyMode('my-feature-id');
                editor.isReadOnly; // `true`.

            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
