<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    public function getFilters(Request $request) {

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 200);
        }

        $filters = [
            "Shirt" => ["T-Shirt", "Shirt", "Polo Shirt", "Tank Top", "Blouse", "Tunic", "Tube Top", "Crop Top"],
            "Shoes" => ["Sneakers", "Boots", "Sandals", "Slippers", "Flip Flops"],
            "Pants" => ["Jeans", "Pants", "Shorts"],
            "Jacket" => ["Bomber Jacket", "Denim Jacket", "Leather Jacket", "Parka", "Rain Jacket", "Trench Coat", "Windbreaker"],
            "Hoodies" => ["Hoodie", "Sweater", "Cardigan", "Sweatshirt", "Jumper", "Turtleneck", "Vest"],
            "Hats" => ["Hat", "Cap", "Beanie"],
            "Accessories" => ["Gloves", "Scarf", "Sunglasses", "Watch", "Belt", "Tie", "Wallet", "Backpack", "Purse", "Handbag", "Suitcase", "Umbrella"],
            "Dress" => ["Dress", "Gown", "Jumpsuit", "Romper", "Skirt"],
            "Disguise" => ["Costume", "Cosplay", "Uniform"],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Filters',
            'data' => $filters,
        ], 200);

    }
}
