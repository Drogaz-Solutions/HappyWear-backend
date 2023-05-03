<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function sell(Request $request) {

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 200);
        }

        $user = User::find($user->id);

        $rules = array(
        
        'name' => 'required',
        'description' => 'required',
        'image' => 'required',
        'price' => 'required',
        'kind' => 'required',
        'model' => 'required',
        'main_color' => 'required',
        'other_color' => 'required',
        'size' => 'required',
        'material' => 'required',
        'condition' => 'required',
        'brand' => 'required',
        'sex' => 'required',
        // 'bought_at' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
            ], 200);
        }

        $product = new Product();
        $product->seller_id = $request->user()->id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->image = 'https://m.media-amazon.com/images/I/A13usaonutL._AC_CLa%7C2140%2C2000%7C51OP0ymLxBL.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0_UY1000_.png';
        $product->price = $request->price;
        $product->kind = $request->kind;
        $product->model = $request->model;
        $product->main_color = $request->main_color;
        $product->other_color = $request->other_color;
        $product->size = $request->size;
        $product->material = $request->material;
        $product->condition = $request->condition;
        $product->brand = $request->brand;
        $product->sex = $request->sex;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product,
        ], 201);
    }
}
