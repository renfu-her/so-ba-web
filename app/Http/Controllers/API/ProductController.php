<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::orderBy('order_number', 'asc')->with('user')->paginate(20);

        $products->getCollection()->transform(function ($product) {
            $product->image = url('images/products/' . $product->image);
            return $product;
        });

        return response()->json([
            'message' => 'Get Products success',
            'data' => $products
        ]);
    }


    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'price' => 'required|numeric',
            'memo' => 'nullable|string',
            'type' => 'required|integer',
            'user_id' => 'required|integer',
        ]);



        $path = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = 'img_' . Str::uuid()->toString() . '.webp';
            $imagePath = public_path('images/products/' . $file_name);

            // 確保目錄存在
            if (!file_exists(public_path('images/products/'))) {
                mkdir(public_path('images/products/'), 0755, true);
            }

            // 轉換為 WebP 格式
            Image::read($file)->scale(640, 640)->toWebp()->save($imagePath);

            $path = $file_name;
        }

        $product = Product::create([
            'name' => $request->name,
            'image' => $path,
            'price' => $request->price,
            'memo' => $request->memo,
            'type' => $request->type,
            'user_id' => $request->user_id,
        ]);

        return response()->json($product, 201);
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {

        $product->image = url('images/products/' . $product->image);

        return response()->json($product);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'price' => 'required|numeric',
            'memo' => 'nullable|string',
            'type' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = 'img_' . Str::uuid()->toString() . '.webp';
            $imagePath = public_path('images/products/' . $file_name);

            // 確保目錄存在
            if (!file_exists(public_path('images/products/'))) {
                mkdir(public_path('images/products/'), 0755, true);
            }

            // 轉換為 WebP 格式
            Image::read($file)->scale(640, 640)->toWebp()->save($imagePath);

            $data['image'] = $file_name;
        }

        $product->update($data);

        return response()->json($product);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
