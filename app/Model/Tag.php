<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [ 'name' ];

    public function scopeSearch($query, $search )
    {
        if( trim($search)!==''){
            $query->where('name', 'like', "%$search%");
        }
        return $query;
    }
}
