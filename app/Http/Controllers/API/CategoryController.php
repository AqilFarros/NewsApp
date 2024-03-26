<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $category = Category::latest()->get();
            return ResponseFormatter::success($category, 'List Data Of Category');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Category Data Failed', 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return ResponseFormatter::success($category, 'Category Data');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Get Data Category Failed', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:categories',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            $image = $request->file('image');
            $image->storeAs('public/category', $image->hashName());

            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $image->hashName()
            ]);

            return ResponseFormatter::success($category, 'Category Successfully Created');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Failed To Store Category', 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'image' => 'image|mimes:jpg,jpeg,png|max:2048'
            ]);

            $category = Category::findOrFail($id);

            if ($request->file('image') == '') {
                $category->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name)
                ]);
            } else {
                Storage::disk('local')->delete('public/category/' . basename($category->image));

                $image = $request->file('image');
                $image->storeAs('public/category', $image->hashName());

                $category->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'image' => $image->hashName()
                ]);
            }

            return ResponseFormatter::success($category, 'Category Data Has Been Successfully Updated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                "message" => 'Something Went Wrong',
                'error' => $error
            ], 'Failed To Update Category', 500);
        }
    }

    public function destroy($id) {
        try {
            $category = Category::findOrFail($id);

            Storage::disk('local')->delete('public/category/' . basename($category->image));

            $category->delete();

            return ResponseFormatter::success(null, 'Category Data Has Been Successfully Deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Failed To Delete Data');
        }
    }
}
