<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $items = Product::search($request->search)->paginate(6);
        return ProductResource::collection($items);
    }
}
