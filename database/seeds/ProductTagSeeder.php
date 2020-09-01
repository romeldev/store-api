<?php

use Illuminate\Database\Seeder;
use App\Model\Product;
use App\Model\Tag;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_tag')->delete();
        $tags = Tag::all();
        $rows = [];
        foreach(Product::all() as $product)
        {
            foreach( $tags->random( rand(1, 3)) as $tag)
            {
                $rows[] = [
                    'product_id' => $product->id,
                    'tag_id' => $tag->id,
                ];
            }
        }

        DB::table('product_tag')->insert($rows);
    }
}
