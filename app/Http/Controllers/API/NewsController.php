<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        try {
            $news = News::latest()->get();
            return ResponseFormatter::success($news, 'Data List Of News');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Data News Failed', 500);
        }
    }

    public function show($id)
    {
        try {
            $news = News::findOrFail($id);
            return ResponseFormatter::success($news, 'News Data');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Data News Failed', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required',
                'category_id' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'content' => 'required'
            ]);

            $image = $request->file('image');
            $image->storeAs('public/news', $image->hashName());

            $news = News::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'category_id' => $request->category_id,
                'image' => $image->hashName(),
                'content' => $request->content
            ]);

            return ResponseFormatter::success($news, 'News Has Been Created');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Failed To Create News', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'title' => 'required|max:255',
                'category_id' => 'required',
                'content' => 'required',
                'image' => 'image|mimes:jpg,jpeg,png|max:5120'
            ]);

            $news = News::findOrFail($id);

            if ($request->file('image') == '') {
                $news->update([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title),
                    'category_id' => $request->category_id,
                    'content' => $request->content
                ]);
            } else {
                Storage::disk('local')->delete('public/news/' . basename($news->image));

                $image = $request->file('image');
                $image->storeAs('public/news', $image->hashName());

                $news->update([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title),
                    'category_id' => $request->category_id,
                    'content' => $request->content,
                    'image' => $image->hashName()
                ]);
            };

            return ResponseFormatter::success($news, 'Data News Has Been Updated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Failed To Update News');
        }
    }

    public function destroy($id)
    {
        try {
            $news = News::findOrFail($id);

            Storage::disk('local')->delete('public/news/' . basename($news->image));

            $news->delete();

            return ResponseFormatter::success(null, 'News Has Been Deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Failed To Delete News', 500);
        }
    }
}
