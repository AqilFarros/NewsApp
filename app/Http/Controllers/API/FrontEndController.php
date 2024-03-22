<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\News;
use Exception;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index() {
        try {
            $slider = News::latest()->limit(3)->get();
            return ResponseFormatter::success($slider, 'List Data Of Slider');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Failed Gat Data Slider');
        }
    }
}
