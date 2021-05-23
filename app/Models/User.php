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

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Carbon\Carbon;
//use App\Notifications\PasswordReset; // Or the location that you store your notifications (this is default).


use App\Traits\ModelTrait;
use DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, CascadeSoftDeletes, ModelTrait;

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
        'rink_id',
        'speciality_id',
        'experience_id',
        'certificate_id',
        'language_id',
        'price_id',
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
        'experience_name',
        'certificate_name',
        'rink_name',
        'lang_name',
        'price_name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'created_at' => 'date:Y/m/d H:i',
        'updated_at' => 'date:Y/m/d H:i',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $cascadeDeletes = [
        //'userNewsReads',
        
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are partially match filterable.
     *
     * @var array
     */
    protected $partialFilterable = [
        'name',
        'email',
        'phone_number',
        //'shop_name',
    ];

    /**
     * The attributes that are exact match filterable.
     *
     * @var array
     */
    protected $exactFilterable = [
        'rink_id',
        'speciality_id',
        'authority'
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
        return $this->authority === self::ACCESS_LEVEL_MASTER_ADMIN;
    }

    /**
     * Check user has CITY_ADMIN authority
     * @param  integer  $shopId
     * @return boolean
     */
    public function isCoachUser($cityId = null)
    {
        if ($cityId) {
            return $this->city_id === $cityId && $this->authority === self::ACCESS_LEVEL_COACH;
        }

        return $this->authority === self::ACCESS_LEVEL_COACH;
    }

    /**
     * Check user has RINK_USER authority
     * @param  integer  $rinkId
     * @return boolean
     */
    public function isRinkUser($rinkId = null)
    {
        if ($rinkId) {
            return $this->rink_id === $rinkId && $this->authority === self::ACCESS_LEVEL_RINK;
        }

        return $this->authority === self::ACCESS_LEVEL_RINK;
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

        return $this->authority === self::ACCESS_LEVEL_RINK;
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
     * Get the user's speciality name.
     *
     * @return string
     */
    public function getCertificateNameAttribute()
    {
        return !empty($this->certificate) ? $this->certificate->name : null;
    }

    /**
     * Get the user's experience name.
     *
     * @return string
     */
    public function getExperienceNameAttribute()
    {
        return !empty($this->experience) ? $this->experience->name : null;
    }

    /**
     * Get the user's rink name.
     *
     * @return string
     */
    public function getRinkNameAttribute()
    {
        return !empty($this->rink) ? $this->rink->name : null;
    }

    /**
     * Get the user's rink name.
     *
     * @return string
     */
    public function getLangNameAttribute()
    {
        return !empty($this->language) ? $this->language->name : null;
    }

    /**
     * Get the user's rink name.
     *
     * @return string
     */
    public function getPriceNameAttribute()
    {
        return !empty($this->price) ? $this->price->name : null;
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
     * Get the experience for the user.
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


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification1($token)
    {
        //$this->notify(new PasswordReset($token));


        // $this->notify(new MyCustomResetPasswordNotification($token)); <--- remove this, use Mail instead like below

        // $data = [
        //     $this->email
        // ];

        // Mail::send('email.reset-password', [
        //     'fullname'      => $this->fullname,
        //     'reset_url'     => route('user.password.reset', ['token' => $token, 'email' => $this->email]),
        // ], function($message) use($data){
        //     $message->subject('Reset Password Request');
        //     $message->to($data[0]);
        // });
    }



    /**
     * Search user based request parameters
     * 
     * @param array $params
     * @return $query
     */
    public function filter($params)
    {
        $query = $this->newQuery();

        $authUser = request()->user();

        if ($authUser) {
            $query->whereNotIn('id', [$authUser->id]);
            if ($authUser->isRinkUser()) {
                $query->where('rink_id', '=', $authUser->rink_id);
            }
        }

        

        if ($authUser['authority'] == self::ACCESS_LEVEL_MASTER_ADMIN) {
            $list_authority = array(self::ACCESS_LEVEL_MASTER_ADMIN,self::ACCESS_LEVEL_COACH,self::ACCESS_LEVEL_RINK);
        } else {
            $list_authority = array(self::ACCESS_LEVEL_COACH,self::ACCESS_LEVEL_RINK);
        }
        $query->whereIn('authority', $list_authority);
        if (empty($params) || !is_array($params)) {
            return $query;
        }

        /*if (isset($params['authority:in']) && is_array($params['authority:in'])) {
            $query->whereIn('authority', $params['authority:in']);
            unset($params['authority:in']);
        } elseif (isset($params['authority:not_in']) && is_array($params['authority:not_in'])) {
            $query->whereNotIn('authority', $params['authority:not_in']);
            unset($params['authority:not_in']);
        } elseif (!empty($params['authority:not'])) { 
            $query->where('authority', '<>', $params['authority:not']);
        }  elseif (empty($params['authority'])) { 
            $query->where('authority', '<>', 'AGENT');
        } */
        if (isset($params['group'])) {
            $shop_ids = $this->groupShops($params['group']);
            if (!empty($shop_ids)) {
                $query->whereHas('shops', function($q) use ($shop_ids)
                {
                    $q->whereIn('id', $shop_ids);

                });
            }
            
        }
        if (isset($params['cookie_shop'])) {

            $query->whereHas('shops', function($q) use ($params)
            {
                $q->where('shop_id', '=', $params['cookie_shop']);

            });
        }

        if (isset($params['shop_name'])) {

            $query->whereHas('shops', function($q) use ($params)
            {
                $q->where('shop_name', 'LIKE', "%{$params['shop_name']}%");

            });
        } 

        if (isset($params['is_varified'])) {
            $params['is_verified'] = $params['is_varified'];
            unset($params['is_varified']);
        }
        
        foreach ($params as $key => $value) { 
            if ($value != "") {
                if (in_array($key, $this->partialFilterable)) { 
                    $query->where($key, 'LIKE', "%{$value}%");
                } elseif (in_array($key, $this->exactFilterable)) {
                    $query->where($key, '=', $value);
                }
            }
        }
        return $query;
    }
}
