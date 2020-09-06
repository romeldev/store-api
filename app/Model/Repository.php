<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Tag;
use App\Model\Category;
use App\Model\Product;

class Repository extends Model
{
    public static function getAllCategories( $request )
    {
        return Category::select('id', 'name')->get();
    }

    public static function getAllTags( $request )
    {
        return Tag::select('id', 'name')->get();
    }
}
