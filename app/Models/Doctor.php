<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $hidden = ['pivot'];
    /**
     * Get all of the users booked.
     */
    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'service', 'user_booking_services', 'service_id', 'user_id');
    }
    /**
     * The category that belong to the doctor.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'doctor_categories', 'doctor_id', 'category_id');
    }
    public function category_name(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'doctor_categories', 'doctor_id', 'category_id')->select('name');
    }
}
