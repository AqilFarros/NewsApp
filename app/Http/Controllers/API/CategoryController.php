<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
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
}
