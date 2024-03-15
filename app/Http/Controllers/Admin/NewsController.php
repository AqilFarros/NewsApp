<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Index News';
        // get data terbaru dari table news untuk dikirim ke view
        $news = News::latest()->paginate(5);
        $category = Category::all();
        return view('home.news.index', compact('title', 'category', 'news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add News';

        $category = Category::all();

        return view('home.news.create', compact('title', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'content' => 'required'
        ]);

        // upload image
        $image = $request->file('image');

        $image->storeAs('public/news', $image->hashName());

        News::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'image' => $image->hashName(),
            'content' => $request->content
        ]);

        return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'News';
        $news = News::findOrFail($id);
        return view('home.news.show', compact('title', 'news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'News || Edit';
        $news = News::findOrFail($id);
        $category = Category::all();

        return view('home.news.edit', compact('title', 'news', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png|max:5120'
        ]);

        $news = News::findOrFail($id);

        if ($request->file('image')) {
            Storage::disk('local')->delete('public/news/' . basename($news->image));

            $image = $request->file('image');
            $image->storeAs('public/news', $image->hashName());

            $news->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'category_id' => $request->category_id,
                'content' => $request->content,
                'image'=> $image->hashName()
            ]);
        } else {
            $news->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'category_id' => $request->category_id,
                'content' => $request->content
            ]);
        };

        return redirect()->route('news.index')->with('success', 'News Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        Storage::disk('local')->delete('public/news/' . basename($news->image));

        $news->delete();

        return redirect()->route('news.index')->with('success', 'News Berhasil Dihapus');
    }
}
