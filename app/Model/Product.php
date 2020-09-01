<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ 'name', 'descrip', 'price', 'price_ref', 'category_id' ];

    public function scopeSearch($query, $search )
    {
        if( trim($search)!==''){
            $query->where('name', 'like', "%$search%");
        }
        return $query;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }


    public function getDiscountAttribute()
    {
        if( $this->price_ref !== null){
            return ($this->price/$this->price_ref)*100;
        }   
        return null;
    }
}
