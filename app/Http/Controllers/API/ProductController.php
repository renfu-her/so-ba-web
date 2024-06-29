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
            'image' => 'nullable|string',
            'price' => 'required|numeric',
            'order_number' => 'nullable|integer',
            'memo' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id',
            'type' => 'required|integer',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $this->convertToWebP($request->file('image'));
        }

        $product = Product::create([
            'name' => $request->name,
            'image' => $path,
            'price' => $request->price,
            'order_number' => $request->order_number,
            'memo' => $request->memo,
            'user_id' => $request->user_id,
            'type' => $request->type,
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
            'name' => 'sometimes|required|string|max:255',
            'image' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'order_number' => 'nullable|integer',
            'memo' => 'nullable|string',
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'type' => 'sometimes|required|integer',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $this->convertToWebP($request->file('image'));
            $product->image = $path;
        }

        $product->update($request->all());
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

    protected function convertToWebP($file)
    {
        $file_name = 'img_' . Str::uuid()->toString() . '.webp';
        $imagePath = public_path('upload/images/' . $file_name);

        if (!file_exists(dirname($imagePath))) {
            mkdir(dirname($imagePath), 0755, true);
        }

        Image::read($file)->scale(640, 640)->toWebp()->save($imagePath);

        return 'upload/images/' . $file_name;
    }
}
