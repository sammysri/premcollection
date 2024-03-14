<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'active',
        'otp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get all of the hotels that are booked by user.
     */
    public function bookedHotels(): MorphToMany
    {
        return $this->morphedByMany(Hotel::class, 'service', 'user_booking_services')->withPivot('extra_data', 'status');
    }
 
    /**
     * Get all of the doctors that are booked by user.
     */
    public function bookedDoctors(): MorphToMany
    {
        return $this->morphedByMany(Doctor::class, 'service', 'user_booking_services')->withPivot('extra_data', 'status');
    }

    /**
     * Get all of the astrologer that are booked by user.
     */
    public function bookedAstrologers(): MorphToMany
    {
        return $this->morphedByMany(Astrologer::class, 'service', 'user_booking_services')->withPivot('extra_data', 'status');
    }
    /**
     * Get all of the dinner menu that are booked by user.
     */
    public function bookedDinnerMenu(): MorphToMany
    {
        return $this->morphedByMany(DinnerMenu::class, 'service', 'user_booking_services')->withPivot('extra_data', 'status');
    }
    /**
     * Get all of the car that are booked by user.
     */
    public function bookedCar(): MorphToMany
    {
        return $this->morphedByMany(Car::class, 'service', 'user_booking_services')->withPivot('extra_data', 'status');
    }
    /**
     * Get the details associated with the user.
     */
    public function userDetails(): HasOne
    {
        return $this->hasOne(UserDetails::class, 'user_id');
    }

    public function bookedServices(): HasMany
    {
        return $this->hasMany(UserBookingService::class, 'user_id');
    }
    
}
