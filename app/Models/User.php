<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\Rink;
use App\Models\Speciality;
use App\Models\Price;
use App\Models\Language;
use App\Models\Experience;
use App\Models\Certificate;
use App\Traits\ModelTrait;
use DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ACCESS_LEVEL_MASTER_ADMIN = 'SUPER_ADMIN';
    const ACCESS_LEVEL_RINK = 'RINK_USER';
    const ACCESS_LEVEL_COACH = 'COACH_USER';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'family_name',
        'email',
        'password',
        'about',
        'province',
        'city',
        'phone_number',
        'whatsapp',
        'avatar_image_path',
        'gender',
        'authority',
        'is_verified',
        'deleted_at'
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */


    protected $appends = [
        'speciality_name',
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


    /**
     * Get the user's speciality name.
     *
     * @return string
     */
    public function getSpecialityNameAttribute()
    {
        return !empty($this->speciality) ? $this->speciality->name : null;
    }


    /**
     * Get the speciality for the user.
     */
    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

     /**
     * Get the rinks for the user.
     */
    public function rink()
    {
        return $this->belongsTo(Rink::class);
    }

     /**
     * Get the rinks for the user.
     */
    public function price()
    {
        return $this->belongsTo(Price::class);
    }
     /**
     * Get the language for the user.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

     /**
     * Get the language for the user.
     */
    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
     /**
     * Get the certificate for the user.
     */
    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }
}
