<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $fillable = [ 'path', 'product_id' ];

    public function getUrlAttribute()
    {
        $url = Storage::disk('public')->url($this->path);
        return $url;
    }
}
