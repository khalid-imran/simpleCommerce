<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function save(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'title' => 'required',
            'discount_amount' => 'numeric',
            'variants' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $slug = Str::slug($requestData['title']);
        $checkSlug = Product::where('slug', $slug)->first();
        if ($checkSlug != null) {
            $slug = $slug . '-' . time();
        }
        $video_path = null;
        if ($request->file('video')) {
            $video = $request->file('video');
            $name = md5(uniqid(rand(), true)) . str_replace(' ', '-', $video->getClientOriginalName());
            $video->move(storage_path('/app/public/uploads'), $name);
            $video_path = $name;
        }
        $product = new Product();
        $product->category_id = $requestData['category_id'] ?? null;
        $product->title = $requestData['title'];
        $product->slug = $slug;
        $product->description = $requestData['description'] ?? null;
        $product->features = $requestData['features'] ?? null;
        $product->video = $video_path;
        $product->buy_price = $requestData['buy_price'] ?? null;
        $product->tranding = $requestData['tranding'] ?? 0;
        $product->upcoming = $requestData['upcoming'] ?? 0;
        $product->discount_type = $requestData['discount_type'] ?? 2;
        if (isset($requestData['discount_amount']) && $requestData['discount_amount'] > 0) {
            $product->discount_amount = $requestData['discount_amount'];
        }
        if (!$product->save()) {
            return response()->json(['status' => 500, 'message' => 'Cannot created product.']);
        }
        if (isset($requestData['images']) && count($requestData['images']) > 0) {
            $files = $request->file('images');
            $images = [];
            foreach ($files as $img) {
                $name = md5(uniqid(rand(), true)) . str_replace(' ', '-', $img->getClientOriginalName());
                $img->move(storage_path('/app/public/uploads'), $name);
                $images[] = ['product_id' =>  $product->id, 'file_path' => $name];
            }
            ProductImage::insert($images);
        }
        if (isset($requestData['variants']) && count($requestData['variants']) > 0) {
            $productVariant = [];
            foreach ($requestData['variants'] as $variant) {
                $productVariant[] = [
                    'product_id' => $product->id,
                    'title' => $variant['title'] ?? null,
                    'price' => $variant['price'],
                ];
            }
            ProductVariants::insert($productVariant);
        }
        $rv = $product->toArray();
        return response()->json(['status' => 200, 'data' => $rv, 'message' => 'Successfully saved product.']);
    }
    public function list(Request $request)
    {
        $requestData = $request->all();
        $limit = isset($requestData['limit']) && !empty($requestData['limit']) ? $requestData['limit'] : 10;
        $orderBy = isset($requestData['order_by']) && !empty($requestData['order_by']) ? $requestData['order_by'] : 'id';
        $orderMode = isset($requestData['order_mode']) && !empty($requestData['order_mode']) ? $requestData['order_mode'] : 'DESC';
        $keyword = isset($requestData['keyword']) ? $requestData['keyword'] : '';

        $result = Product::with('images');
        if (!empty($keyword)) {
            $result->where(function($q) use ($keyword) {
                $q->where('title', 'LIKE', '%'.$keyword.'%');
            });
        }
        $result = $result->orderBy($orderBy, $orderMode)
            ->paginate($limit);
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function single(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $result = Product::with('images', 'variants')->find($requestData['id']);
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function update(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
            'title' => 'required',
            'discount_amount' => 'numeric',
            'variants' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $product = Product::where('id', $requestData['id'])->first();
        $video_path = $product->video;
        if ($request->file('video')) {
            $video = $request->file('video');
            if ($video) {
                $name = md5(uniqid(rand(), true)) . str_replace(' ', '-', $video->getClientOriginalName());
                $video->move(storage_path('/app/public/uploads'), $name);
                $video_path = $name;
                if (!empty($product->video) && file_exists(public_path('storage/uploads/'.$product->video))) {
                    unlink(public_path('storage/uploads/'.$product->video));
                }
            }
        }
        $product->category_id = $requestData['category_id'] ?? null;
        $product->title = $requestData['title'];
        $product->description = $requestData['description'] ?? null;
        $product->features = $requestData['features'] ?? null;
        $product->video = $video_path;
        $product->buy_price = $requestData['buy_price'] ?? null;
        $product->tranding = $requestData['tranding'] ?? 0;
        $product->upcoming = $requestData['upcoming'] ?? 0;
        $product->discount_type = $requestData['discount_type'] ?? 2;
        if (isset($requestData['discount_amount']) && $requestData['discount_amount'] > 0) {
            $product->discount_amount = $requestData['discount_amount'];
        }
        if (!$product->save()) {
            return response()->json(['status' => 500, 'message' => 'Cannot created product.']);
        }
        if (isset($requestData['images']) && count($requestData['images']) > 0) {
            $files = $request->file('images');
            if ($files) {
                $images = [];
                foreach ($files as $img) {
                    $name = md5(uniqid(rand(), true)) . str_replace(' ', '-', $img->getClientOriginalName());
                    $img->move(storage_path('/app/public/uploads'), $name);
                    $images[] = ['product_id' =>  $product->id, 'file_path' => $name];
                }
                ProductImage::insert($images);
            }
        }
        return response()->json(['status' => 200, 'message' => 'Successfully saved product.']);
    }
    public function delete(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $product = Product::where('id', $requestData['id'])->first();
        if (!empty($product['video']) && file_exists(public_path('storage/uploads/'.$product['video']))) {
            unlink(public_path('storage/uploads/'.$product['video']));
        }
        $product->delete();
        ProductVariants::where('product_id', $requestData['id'])->forceDelete();
        $images = ProductImage::where('product_id', $requestData['id'])->get()->toArray();
        foreach ($images as $image) {
            if (!empty($image['file_path']) && file_exists(public_path('storage/uploads/'.$image['file_path']))) {
                unlink(public_path('storage/uploads/'.$image['file_path']));
            }
        }
        ProductImage::where('product_id', $requestData['id'])->delete();
        return response()->json(['status' => 200, 'message' => 'Successfully deleted product.']);
    }
    public function deleteProductImage(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $image = ProductImage::find($requestData['id']);
        if ($image == null) {
            return response()->json(['status' => 500, 'message' => 'Image not found.']);
        }
        if (!empty($image->file_path) && file_exists(public_path('storage/uploads/'.$image->file_path))) {
            unlink(public_path('storage/uploads/'.$image->file_path));
        }
        $image->delete();
        return response()->json(['status' => 200, 'message' => 'Successfully deleted product images.']);
    }
    public function deleteProductVideo(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $product = Product::find($requestData['id']);
        if ($product == null) {
            return response()->json(['status' => 500, 'message' => 'Product not found.']);
        }
        if (!empty($product->video) && file_exists(public_path('storage/uploads/'.$product->video))) {
            unlink(public_path('storage/uploads/'.$product->video));
        }
        $product->video = null;
        $product->save();
        return response()->json(['status' => 200, 'message' => 'Successfully deleted product video.']);
    }
    public function updateVariant(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'price' => 'required',
            'product_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        if (!empty($requestData['id'])) {
            $variant = ProductVariants::where('id', $requestData['id'])->first();
        } else {
            $variant = new ProductVariants();
        }
        $variant->product_id = $requestData['product_id'];
        $variant->price = $requestData['price'];
        $variant->title = $requestData['title'];
        if (!$variant->save()) {
            return response()->json(['status' => 500, 'message' => 'Cannot save product variants.']);
        }
        return response()->json(['status' => 200, 'message' => 'Variant save successfully.']);
    }
    public function deleteVariant(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        ProductVariants::where('id', $requestData['id'])->forceDelete();
        return response()->json(['status' => 200, 'message' => 'Variant deleted successfully.']);
    }
}
