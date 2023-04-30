<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function like(Request $request) {

        $rules = array(
            'product_id' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        $productId = $request->product_id;

        $user = Auth::user();
        $product = Product::find($productId);

        $user->likedProducts()->attach($product->id);

        return response()->json([
            'success' => true,
            'message' => 'Product liked',
        ], 200);

    }

    public function getLiked(Request $request) {

        $user = Auth::user();

        $likedProducts = $user->likedProducts()->get();

        return response()->json([
            'success' => true,
            'message' => 'Liked products',
            'data' => $likedProducts,
        ], 200);

    }

    public function productLikes(Request $request) {

        $product = Product::find($request->product_id);
        $likers = $product->likers()->get();

        return response()->json([
            'success' => true,
            'message' => 'Product likes',
            'data' => $likers,
        ], 200);

    }
}
