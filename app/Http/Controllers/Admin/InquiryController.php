<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function inquiry_list()
    {
        return view('admin.inquiry.list');
    }
    public function inquiry_create()
    {
        $products = Product::where('status', 1)->latest()->get();
        return view('admin.inquiry.create', compact('products'));
    }
}
