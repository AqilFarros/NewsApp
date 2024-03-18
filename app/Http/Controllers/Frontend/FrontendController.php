<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index() {
        $category = Category::latest()->get();
        $sliderNews = News::latest()->limit(3)->get();

        return view('frontend.news.index', compact('category', 'sliderNews'));
    }
}
