<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $brand_list = [
            "Adidas",
            "Abercrombie & Fitch",
            "Aéropostale",
            "AG Jeans",
            "Akademiks",
            "American Apparel",
            "American Eagle Outfitters",
            "Armani",
            "ASOS",
            "BCBGMAXAZRIA",
            "Billabong",
            "Burberry",
            "Calvin Klein",
            "Champion",
            "Chanel",
            "Christian Dior",
            "Coach",
            "Columbia",
            "Converse",
            "Crocs",
            "Diesel",
            "DKNY",
            "Dockers",
            "Dolce & Gabbana",
            "Ecko Unltd",
            "Elie Tahari",
            "Fendi",
            "Forever 21",
            "G-Star RAW",
            "Gap",
            "Givenchy",
            "Gucci",
            "Guess",
            "H&M",
            "Hollister",
            "Hurley",
            "J.Crew",
            "J.C. Penney",
            "Jil Sander",
            "Joe's Jeans",
            "Juicy Couture",
            "Keds",
            "Kenneth Cole",
            "Kohl's",
            "Lacoste",
            "Levi's",
            "Louis Vuitton",
            "Lucky Brand",
            "Lululemon",
            "Macy's",
            "Marc Jacobs",
            "Michael Kors",
            "Moncler",
            "Nautica",
            "New Balance",
            "Nike",
            "Nordstrom",
            "Old Navy",
            "PacSun",
            "Perry Ellis",
            "Polo Ralph Lauren",
            "Prada",
            "Puma",
            "Quiksilver",
            "Ralph Lauren",
            "Reebok",
            "Roxy",
            "Saks Fifth Avenue",
            "Salvatore Ferragamo",
            "Skechers",
            "Stussy",
            "Tommy Hilfiger",
            "True Religion",
            "UGG",
            "Under Armour",
            "Uniqlo",
            "Urban Outfitters",
            "Vans",
            "Versace",
            "Victoria's Secret",
            "Vineyard Vines",
            "Volcom",
            "Walmart",
            "Zara"
          ];

          $kind_list = [
            "T-Shirt",
            "Shirt",
            "Polo",
            "Sweater",
            "Hoodie",
            "Jacket",
            "Coat",
            "Jeans",
            "Pants",
            "Shorts",
            "Socks",
            "Shoes",
            "Sneakers",
            "Boots",
            "Sandals",
            "Hat",
            "Cap",
            "Beanie",
            "Gloves",
            "Scarf",
            "Sunglasses",
            "Watch",
          ];

        User::factory()->count(1)->create([
            'firstname' => 'Admin',
            'initials' => 'A',
            'lastname' => 'Admin',
            'email' => 'admin@admin.nl',
            'password' => Hash::make('admin'),
            'data' => "{}",
        ]);

        for ($i=0; $i < 1000; $i++) { 
            Product::factory()->count(1)->create([
                'seller_id' => 1,
                'name' => 'Product' . rand(1, 1000),
                'description' => 'Description' . rand(1, 1000),
                'image' => "https://m.media-amazon.com/images/I/A13usaonutL._AC_CLa%7C2140%2C2000%7C51OP0ymLxBL.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0_UY1000_.png",
                'price' => rand(1, 1000),
                'kind' => $kind_list[rand(0, count($kind_list) - 1)],
                'model' => 'Model' . rand(1, 1000),
                'main_color' => 'Main Color' . rand(1, 1000),
                "other_color" => 'Other Colors' . rand(1, 1000),
                'size' => 'Size' . rand(1, 1000),
                'material' => "test",
                'condition' => "Good",
                'brand' => $brand_list[rand(0, count($brand_list) - 1)],
                'sex' => "Unisex",
                'bought_at' => '2021-01-01',
            ]);
        }

        
    }
}
