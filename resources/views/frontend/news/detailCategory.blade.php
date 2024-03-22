@extends('frontend.parent')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-9" data-aos="fade-up">
                    <h3 class="category-title">Category: {{ $detailCategory->name }}</h3>

                    @foreach ($news as $row)
                        <div class="d-md-flex post-entry-2 half">
                            <a href="{{ route('detail-news', $row->slug) }}" class="me-4 thumbnail">
                                <img src="{{ $row->image }}" alt="" class="img-fluid">
                            </a>
                            <div>
                                <div class="post-meta"><span class="date">{{ $row->category->name }}</span> <span
                                        class="mx-1">&bullet;</span>
                                    <span>{{ $row->created_at->format('d M Y') }}</span>
                                </div>
                                <h3><a href="{{ route('detail-news', $row->slug) }}">{{ $row->title }}</a></h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio placeat
                                    exercitationem
                                    magni voluptates dolore. Tenetur fugiat voluptates quas, nobis error deserunt aliquam
                                    temporibus sapiente, laudantium dolorum itaque libero eos deleniti?</p>
                                <div class="d-flex align-items-center author">
                                    <div class="photo"><img src="assets/img/person-2.jpg" alt="" class="img-fluid">
                                    </div>
                                    <div class="name">
                                        <h3 class="m-0 p-0">Wade Warren</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $news->links('pagination::bootstrap-5') }}
                </div>

                <div class="col-md-3">
                    <!-- ======= Sidebar ======= -->
                    <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
                        @foreach ($category as $row => $index)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $row == 0 ? 'active' : '' }}" id="pills-popular-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-popular{{ $index->id }}" type="button"
                                    role="tab" aria-controls="pills-popular{{ $index->id }}"
                                    aria-selected="true">{{ $index->name }}</button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="pills-tabContent">

                        @foreach ($category as $row => $index)
                            <div class="tab-pane fade show {{ $row == 0 ? 'active' : '' }}"
                                id="pills-popular{{ $index->id }}" role="tabpanel" aria-labelledby="pills-popular-tab">
                                @foreach ($index->news->sortByDesc('created_at')->take(3) as $news)
                                    <div class="post-entry-1 border-bottom">
                                        <div class="post-meta"><span class="date">{{ $index->name }}</span> <span
                                                class="mx-1">&bullet;</span>
                                            <span>{{ $news->created_at->diffForHumans() }}</span></div>
                                        <h2 class="mb-2"><a
                                                href="{{ route('detail-news', $news->slug) }}">{{ $news->title }}</a></h2>
                                        <span class="author mb-3 d-block">Admin</span>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                    </div>

                <div class="aside-block">
                    <h3 class="aside-title">Video</h3>
                    <div class="video-post">
                        <a href="https://www.youtube.com/watch?v=AiFfDjmd0jU" class="glightbox link-video">
                            <span class="bi-play-fill"></span>
                            <img src="assets/img/post-landscape-5.jpg" alt="" class="img-fluid">
                        </a>
                    </div>
                </div><!-- End Video -->

                <div class="aside-block">
                    <h3 class="aside-title">Categories</h3>
                    <ul class="aside-links list-unstyled">
                        @foreach ($category as $row)
                            <li><a href="{{ route('detail-category', $row->slug) }}"><i class="bi bi-chevron-right"></i>
                                    {{ $row->name }}</a></li>
                        @endforeach
                    </ul>
                </div><!-- End Categories -->

                <div class="aside-block">
                    <h3 class="aside-title">Tags</h3>
                    <ul class="aside-tags list-unstyled">
                        @foreach ($category as $row)
                            <li><a href="{{ route('detail-category', $row->slug) }}">{{ $row->name }}</a></li>
                        @endforeach
                    </ul>
                </div><!-- End Tags -->

            </div>
        </div>
        </div>
        </div>
    </section>
@endsection
