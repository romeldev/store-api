<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [ 'name' ];

    public function scopeSearch($query, $search )
    {
        if( trim($search)!==''){
            $query->where('name', 'like', "%$search%");
        }
        return $query;
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
