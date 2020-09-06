<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\Model\Photo;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Product::search($request->search)
        ->orderBy('id', 'desc')->paginate(8);
        return ProductResource::collection($items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category.id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $product = new Product;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->price_ref = $request->price_ref;
            $product->descrip = $request->descrip;
            $product->category_id = $request->category['id'];
            $product->save();
            $product->saveTags( $request->tags );
            $product->savePhotos( $request->new_photos );
            DB::commit();

            return response()->json( new ProductResource( $product->refresh() ), 200);
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category.id' => 'required',
        ]);
        
        $product->name = $request->name;
        $product->price = $request->price;
        $product->price_ref = $request->price_ref;
        $product->descrip = $request->descrip;
        $product->category_id = $request->category['id'];
        $product->save();
        $product->saveTags($request->tags);
        $product->savePhotos($request->new_photos, $request->photos );

        return response()->json( new ProductResource( $product->refresh() ), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->deleteImages();
            $product->delete();
            DB::commit();
            return response(true, 200);
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return response($e->getMessage(), 500);
            // something went wrong
        }
    }

    public function photos(Product $product)
    {
        return $product;
    }
}
