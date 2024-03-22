<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\News;
use Exception;
use Illuminate\Http\Request;

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
}
