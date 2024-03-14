<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Casts\Attribute;

class UserBookingService extends Pivot
{
    protected  $table = 'user_booking_services';
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    // public function getCustomStatus()
    // {
    //     return $this->status;
    // }
    // protected function custom_status() : Attribute
    // {
    //     return Attribute::make(
    //         get: fn($status) => $status,
    //     );
    // }
}
