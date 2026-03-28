<?php


namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function product_list()
    {
        $products = Product::with('creator')->latest()->get();
        return view('admin.product.list', compact('products'));
    }
    public function product_create()
    {
        $categories = Category::where('status', 1)->latest()->get();
        return view('admin.product.create', compact('categories'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/products/';
            $file->move(public_path($path), $filename);
            $imageName = $path . $filename;
        }

        $status = $request->status ?? 0;

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageName,
            'status' => $status,
            'created_by' => Auth::id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully'
        ]);
    }
    public function product_edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('status', 1)->latest()->get();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function product_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = Product::findOrFail($request->id);

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/products/';
            $file->move(public_path($path), $filename);
            $product->image = $path . $filename;
        }


        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status ?? 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully'
        ]);
    }
}
