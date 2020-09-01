<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Model\Photo;
use App\Model\Product;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete products of images
        Photo::query()->delete();
        $files = Storage::disk('public')->files('/images/products');
        $deleted = Storage::disk('public')->delete($files);

        // Get Images mock
        $images = collect( Storage::disk('mock')->files() );
        $path_mock_images = Storage::disk('mock')->getAdapter()->getPathPrefix();
        $imgPerProduct = 3;
        $images = $images->chunk($imgPerProduct);

        $products = Product::all();
        
        
        $rows = [];
        foreach($products as $key => $product)
        {
            foreach($images[$key] as $fileName )
            {
                $filePath = Storage::disk('mock')->path($fileName);
                $storePath = Storage::disk('public')->putFile('images/products', $filePath);

                if( $storePath )
                {
                    $photo = Photo::create([
                        'product_id' => $product->id,
                        'path' => $storePath
                    ]);
                }
            }   
        }
    }
}
