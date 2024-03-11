<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Category - Index';
        $category = Category::latest()->paginate(5);
        return view('home.category.index', compact('category', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Category - Index';
        return view('home.category.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $messages = [
            'name.required' => 'Nama kategori wajib diisi',
            'name.max' => 'Nama kategori maksimal 255 karakter',
            'image.image' => 'File yang diupload harus gambar',
            'image.mimes' => 'File yang diupload harus berformat jpeg, png, jpg',
            'image.max' => 'Ukuran gambar maksimal 5MB',
            'image.required' => 'Gambar wajib diisi'
        ];

        //membuat validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg|max:5120|required'
        ], $messages);

        //jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $image = $request->file('image');
        $image->storeAs('public/category', $image->hashName());

        // melakukan save to database

        if (Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $image->hashName()
        ])) {
            return redirect()->route('category.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            // melakukan return redirect
            return redirect()->route('category.create')->with(['error'], 'data gagal');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Category - Edit';
        $category = Category::find($id);

        return view('home.category.edit', compact('title', 'category'));
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
            'name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $category = Category::find($id);

        if ($request->file('image') == '') {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name)
            ]);
        } else {
            // Hapus image lama
            Storage::disk('local')->delete('public/category/' . basename($category->image));

            $image = $request->file('image');
            $image->storeAs('public/category', $image->hashName());

            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $image->hashName()
            ]);
        }

        return redirect()->route('category.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        Storage::disk('local')->delete('public/category/' . basename($category->image));

        $category->delete();

        return redirect()->route('category.index')->with('success', 'Data Berhasil Dihapus');
    }
}
