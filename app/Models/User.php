<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    /**
     * Set the user's password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    /**
     * Get the status label
     *
     * @return string
     */
    public function getGenderLabelAttribute()
    {
        return $this->getGenderLabel($this->gender);
    }

    /**
     * Get status label
     *
     * @return string
     */
    public function getGenderLabel($gender)
    {
        $grnderLabel = '';
        
        switch ($gender) {
            case 'MALE':
                $grnderLabel = 'male';
                break;
            case 'FEMALE':
                $grnderLabel = 'female';
                break;
            case 'OTHER':
                $grnderLabel = 'other';
                break;
            default:
                $grnderLabel = '';
        }

        return $grnderLabel;
    }

    /**
     * Check user has SERVICE_ADMIN authority
     * 
     * @return boolean
     */
    public function isSuperAdmin()
    {
        return $this->authority === 'SUPER_ADMIN';
    }

    /**
     * Check user has CITY_ADMIN authority
     * @param  integer  $shopId
     * @return boolean
     */
    public function isCoachUser($cityId = null)
    {
        if ($cityId) {
            return $this->city_id === $cityId && $this->authority === 'COACH_USER';
        }

        return $this->authority === 'COACH_USER';
    }

    /**
     * Check user has USER authority
     * @param  integer  $buildingId
     * @return boolean
     */
    public function isUser($cityId = null)
    {
        if ($cityId) {
            return $this->city_id === $cityId && $this->authority === 'RINK_USER';
        }

        return $this->authority === 'RINK_USER';
    }

    /**
     * Check user has specified authority
     * 
     * @param string $authority
     * @return boolean
     */
    public function hasAuthority($authority)
    {
        return $this->authority === strtoupper($authority);
    }
}
