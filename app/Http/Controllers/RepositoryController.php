<?php

namespace App\Http\Controllers;

use App\Model\Repository;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class RepositoryController extends Controller
{
    public function index( Request $request )
    {
        switch( $request->resource )
        {
            case 'all-categories': return Repository::getAllCategories($request);

            case 'all-tags': return Repository::getAllTags($request);

            default: return [];
        }
    }
}
