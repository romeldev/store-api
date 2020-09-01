<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ 'name', 'descrip', 'price', 'price_ref', 'category_id' ];

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
            return ($this->price_ref/$this->price)*100;
        }   
        return null;
    }
}
