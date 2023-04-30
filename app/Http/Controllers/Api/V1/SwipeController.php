<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SwipeController extends Controller
{
    public function showProducts(Request $request) {

        $user = Auth::user();

        $liked_products = $user->likedProducts()->get();
        
        $list = [];

        // NOTE: Old algorithm
        // foreach ($liked_products as $product) {
        //     $similar_brands = Product::where('brand', $product->brand)
        //     ->where('id', '!=', $product->id)
        //     ->get();

        //     array_push($list, $similar_brands);

        //     $similar_kinds = Product::where('kind', $product->kind)
        //     ->where('id', '!=', $product->id)
        //     ->get();

        //     array_push($list, $similar_kinds);
        // }

        // NOTE: New algorithm
        // foreach ($liked_products as $product) {
        //     $products = Product::where('brand', $product->brand)
        //     ->orWhere('kind', $product->kind)
        //     ->get();

        //     array_push($list, $products);
        // }
    
        // get products with same brand or kind as liked products and exclude liked products
        foreach ($liked_products as $product) {
            $products = Product::where('brand', $product->brand)
            // ->orWhere('kind', $product->kind)
            ->whereNotIn('id', $liked_products->pluck('id'))
            ->get();

            array_push($list, $products);
        }

        // // insert some random products to random places in the list
        // $random_products = Product::inRandomOrder()->limit(10)->get();
        // $random_products = $random_products->toArray();
        // $random_products = array_chunk($random_products, 1);

        // $random_products = array_map(function($item) {
        //     return $item[0];
        // }, $random_products);

        // // merge random products with the list
        // $list = array_merge($list, $random_products);

        return response()->json([
            'success' => true,
            'message' => 'Products',
            'data' => $list,
        ], 200);


        return response()->json([
            'success' => true,
            'message' => 'Products',
            'data' => $liked_products,
        ], 200);


    }
}
