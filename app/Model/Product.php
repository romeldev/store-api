<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getImageAttribute()
    {
        $photos = $this->photos;
        if( $photos->count()) {

            return url($photos->first()->path);
        }

        return url('/images/no_image_product.png');
    }


    public function getDiscountAttribute()
    {
        if( $this->price_ref !== null){
            return (1-($this->price/$this->price_ref))*100;
        }   
        return null;
    }

    public function deleteImages()
    {
        foreach($this->photos as $photo){
            if( Storage::disk('public')->exists($photo->path) ){
                $remove = Storage::disk('public')->delete($photo->path);
            }
        }
        return true;
    }

    public function saveTags( $tags )
    {
        if( isset($tags[0]) )
        {
            // $this->tags()->detach();
            // $this->tags()->attach($tags);
            $this->tags()->sync( $tags );
        }
    }


    public function savePhotos( $new_photos, $current_photos=false )
    {

        if( $current_photos!==false) { // Only update mode
            
            if( isset($current_photos[0]) ){

                $photos_now = [];

                foreach( collect($current_photos)->chunk(3) as $photoArray)
                {
                    $photos_now[] = collect($photoArray)->values()[1]['path'];
                }

                foreach($this->photos as $photo)
                {
                    if( !in_array( $photo->path, $photos_now) ){
                        if( Storage::disk('public')->exists($photo->path) ){
                            $remove = Storage::disk('public')->delete($photo->path);
                        }
                        $photo->delete();
                    }
                }
            }
        }
        

        if( isset($new_photos[0]) ){
            foreach($new_photos as $image)
            {
                $path = Storage::disk('public')->put('images/products', $image);
                $this->photos()->save( new Photo(['path' => $path]) );
            }
        }
    }
}
