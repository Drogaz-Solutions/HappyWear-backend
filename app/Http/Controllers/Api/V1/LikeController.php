<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function action(Request $request)
    {

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 200);
        }

        $user = User::find($user->id);

        $rules = [
            'product_id' => 'required|integer|exists:products,id',
            'action' => 'required|in:like,dislike',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 200);
        }

        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 200);
        }

        if ($request->action == 'like') {
            $user->likedProducts()->attach($product->id);
        } else {
            $user->dislikedProducts()->attach($product->id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product ' . $request->action . 'd',
        ], 200);
        
    }

    public function getLiked(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 200);
        }

        $user = User::find($user->id);

        $likedProducts = $user->likedProducts()->get();

        return response()->json([
            'success' => true,
            'message' => 'Liked products',
            'data' => $likedProducts,
        ], 200);
    }

    public function productLikes(Request $request)
    {

        $product = Product::find($request->product_id);
        $likers = $product->likers()->get();

        return response()->json([
            'success' => true,
            'message' => 'Product likes',
            'data' => $likers,
        ], 200);
    }
}
