<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    
    public function images(): HasMany
    {
        return $this->hasMany(AlbumImage::class);
    }
}
