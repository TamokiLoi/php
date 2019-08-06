<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 50)->create()->each(function ($product) {
            // Tags
            $tags = [];
            for ($i = 0; $i <= rand(0, 2); $i++) {
                switch ($i) {
                    case (0):
                        $tags[] = rand(1, 15);
                        break;
                    case (1):
                        $tags[] = rand(16, 35);
                        break;
                    case (2):
                        $tags[] = rand(36, 50);
                        break;
                }
            }
            $product->tags()->sync($tags);

            // Orders
            $orders = [];
            for ($i = 0; $i <= rand(0, 2); $i++) {
                switch ($i) {
                    case (0):
                        $orders[rand(1, 15)] = ['quantity' => rand(1, 99)];
                        break;
                    case (1):
                        $orders[rand(16, 35)] = ['quantity' => rand(1, 99)];
                        break;
                    case (2):
                        $orders[rand(36, 50)] = ['quantity' => rand(1, 99)];
                        break;
                }
            }
            $product->orders()->sync($orders);
        });
    }
}
