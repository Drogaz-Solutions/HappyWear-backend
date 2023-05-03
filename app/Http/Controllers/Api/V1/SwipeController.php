<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SwipeController extends Controller
{
    public function showProducts(Request $request)
    {

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 200);
        }

        $user = User::find($user->id);

        $liked_products = $user->likedProducts()->get();

        if (!$liked_products->count()) {
            $liked_products = Product::all();

            $liked_products = $liked_products->shuffle();

            if ($request->limit) {
                $liked_products = $liked_products->slice(0, $request->limit);
            }

            $liked_products = $liked_products->unique('id');


            return response()->json([
                'success' => true,
                'message' => 'Products',
                'data' => $liked_products,
            ], 200);
        }

        $list = [];

        if ($request->filters) {
            $filters = json_decode($request->filters);

            $products = Product::whereNotIn('id', $liked_products->pluck('id'))
                ->whereNotIn('id', $user->dislikedProducts()->get()->pluck('id'))
                ->whereNotIn('available', [0]);

            foreach ($filters as $column => $values) {
                if (is_array($values)) {
                    $products->where(function ($query) use ($column, $values) {
                        foreach ($values as $value) {
                            $query->orWhere($column, $value);
                        }
                    });
                } else {
                    $products->where($column, $values);
                }
            }

            $result = $products->get();

            // limit
            if ($request->limit) {
                $result = $result->slice(0, $request->limit);
            }

            // unique
            $result = $result->unique('id');

            // shuffle
            $result = $result->shuffle();

            return response()->json([
                'success' => true,
                'message' => 'Products',
                'data' => $result,
            ], 200);

            // $list = array_filter($list, function ($item) use ($liked_products) {
            //     return !in_array($item['id'], $liked_products->pluck('id')->toArray());
            // });

            // if ($request->limit) {
            //     $list = array_slice($list, 0, $request->limit);
            // }

            // shuffle($list);

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Products',
            //     'data' => $list,
            // ], 200);
        }

        foreach ($liked_products as $product) {
            $products = Product::where('brand', $product->brand)
                ->orWhere('kind', $product->kind)
                ->whereNotIn('id', $liked_products->pluck('id'))
                ->whereNotIn('id', $user->dislikedProducts()->get()->pluck('id'))
                ->whereNotIn('available', [0])
                ->get();

            $list = array_merge($list, $products->toArray());
        }

        $list = array_unique($list, SORT_REGULAR);

        $list = array_filter($list, function ($item) use ($liked_products) {
            return !in_array($item['id'], $liked_products->pluck('id')->toArray());
        });

        if ($request->limit) {
            $list = array_slice($list, 0, $request->limit);
        }

        shuffle($list);

        return response()->json([
            'success' => true,
            'message' => 'Products',
            'data' => $list,
        ], 200);
    }

    public function productDetails(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 200);
        }

        $rules = array(
            'product_id' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 200);
        }

        $product = Product::find($request->product_id);

        return response()->json([
            'success' => true,
            'message' => 'Product details',
            'data' => $product,
        ], 200);
    }
}
