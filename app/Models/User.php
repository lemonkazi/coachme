<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\UserInfo;
use App\Models\Rink;
use App\Models\Speciality;
use App\Models\Price;
use App\Models\Language;
use App\Models\Level;
use App\Models\City;
use App\Models\Age;
use App\Models\Camp;
use App\Models\Program;
use App\Models\Province;
use App\Models\Experience;
use App\Models\Certificate;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Carbon\Carbon;
//use App\Notifications\PasswordReset; // Or the city that you store your notifications (this is default).


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
        'experience_id',
        'certificate_id',
        'certificate_name',
        'price_id',
        'province_id',
        'city_id',
        'email',
        'password',
        'about',
        'province',
        'city',
        'phone_number',
        'website',
        'whatsapp',
        'avatar_image_path',
        'gender',
        'authority',
        'is_verified',
        'is_published',
        'deleted_at',
        'token',
        'web_site_url',
        'age_id',
        'level_id',
        'language_id',
        'speciality_id'
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
        'experience_name',
        'age_name',
        //'certificate_name',
        'price_name',
        'userinfos',
        'city_name',
        'province_name'
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
        'camps',
        'programs'
        
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
        'certificate_name'
    ];

    /**
     * The attributes that are exact match filterable.
     *
     * @var array
     */
    protected $exactFilterable = [
        'id',
        'authority',
        'experience_id',
        'certificate_id',
        'price_id',
        'is_published',
        'is_verified',
        'province_id',
        'city_id',
        //'age_id'
    ];


    /**
     * Get the users for the building.
     */
    public function camps()
    {
        return $this->hasMany(Camp::class);
    }

    /**
     * Get the users for the building.
     */
    public function programs()
    {
        return $this->hasMany(Program::class);
    }

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
     * Check user has specified authority
     * 
     * @param string $authority
     * @return boolean
     */
    public function hasAuthority($authority)
    {
        return $this->authority === strtoupper($authority);
    }


    // /**
    //  * Get the user's speciality name.
    //  *
    //  * @return string
    //  */
    // public function getSpecialityNameAttribute()
    // {
    //     return !empty($this->speciality) ? $this->speciality->name : null;
    // }

    /**
     * Get the user's speciality name.
     *
     * @return string
     */
    // public function getCertificateNameAttribute()
    // {
    //     return !empty($this->certificate) ? $this->certificate->name : null;
    // }

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
     * Get the user's speciality name.
     *
     * @return string
     */
    public function getCityNameAttribute()
    {
        return !empty($this->city) ? $this->city->name : null;
    }


    /**
     * Get the user's speciality name.
     *
     * @return string
     */
    public function getProvinceNameAttribute()
    {
        return !empty($this->province) ? $this->province->name : null;
    }

    // /**
    //  * Get the user's rink name.
    //  *
    //  * @return string
    //  */
    // public function getRinkNameAttribute()
    // {
    //     return !empty($this->rink) ? $this->rink->name : null;
    // }

    // /**
    //  * Get the user's rink name.
    //  *
    //  * @return string
    //  */
    // public function getLangNameAttribute()
    // {
    //     return !empty($this->language) ? $this->language->name : null;
    // }

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
     * Get the user's Age  anme.
     *
     * @return string
     */
    public function getAgeNameAttribute()
    {
        return !empty($this->age) ? $this->age->name : null;
    }



     /**
     * Get the rinks for the user.
     */
    public function price()
    {
        return $this->belongsTo(Price::class);
    }

     /**
     * Get the rinks for the user.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }


     /**
     * Get the rinks for the user.
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    
     /**
     * Get the experience for the user.
     */
    public function age()
    {
        return $this->belongsTo(Age::class);
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

    /** Get the favorites.
     *
     * @return string
     */
    // public function userinfoo()
    // {
    //     $result  = DB::table('user_infos')
    //                  ->select('id', 'content_type', 'content_id')
    //                  ->where('user_id', '=', $this->id)
    //                  ->where('deleted_at', '=', null)
    //                  ->get();
    //     return $result;


        
    // }


     /**
     * Get user's favorite for the event.
     */
    public function userinfo()
    {
        //$userId = request()->user() ? request()->user()->id : null;
        $userId = $this->id;
        return $this->hasMany(UserInfo::class, 'user_id', 'id')->where(['user_id' => $userId]);
    }


    public function getUserinfosAttribute()
    {
        $info_array = array();
        $info_array["speciality"] = array();
        $info_array["rinks"] = array();
        $info_array["languages"] = array();
        $info_array["levels"] = array();

        //$userId = $this->id; //request()->user() ? request()->user()->id : null;
        //$info = $this->hasMany(UserInfo::class)->where(['user_id' => $userId]);
        //return $info;

        // $info  = DB::table('user_infos')
        //              ->select('id', 'content_type', 'content_id')
        //              ->where('user_id', '=', $this->id)
        //              ->where('deleted_at', '=', null)
        //              ->get();
        
        foreach ($this->userinfo as $userinfo) {
            if ($userinfo->content_type == "SPECIALITY") {
                $info_array["speciality"][] = $userinfo;
            } elseif ($userinfo->content_type == "RINK") {
                $info_array["rinks"][] = $userinfo;
            }
            elseif ($userinfo->content_type == "LANGUAGE") {
                $info_array["languages"][] = $userinfo;
            }
            elseif ($userinfo->content_type == "LEVEL") {
              $info_array["levels"][] = $userinfo;
          }
        }
        return $info_array;
    }


    /**
     * Search user based request parameters
     * 
     * @param array $params
     * @return $query
     */
    public function coach_filter($params)
    {
        $query = $this->newQuery();

        $authUser = request()->user();

        // if ($authUser) {
        //     $query->whereNotIn('id', [$authUser->id]);
        //     if ($authUser->isRinkUser()) {
        //         $query->where('rink_id', '=', $authUser->rink_id);
        //     }
        // }

        

        
        $list_authority = array(self::ACCESS_LEVEL_COACH);
        
        $query->whereIn('authority', $list_authority);
        if (empty($params) || !is_array($params)) {
            return $query;
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



    /**
     * Search user based request parameters
     * 
     * @param array $params
     * @return $query
     */
    public function filter_coach($params)
    {
        // print_r($params);
        // exit();
        $query = $this->newQuery();
        $query->select('users.*');
        //$query->distinct();
        

        $authUser = request()->user();
        if (empty($params) || !is_array($params)) {
            return $query;
        }

        // $query->leftJoin('user_infos', function($join)
        // {
        //     $join->on('users.id', '=', 'user_infos.user_id')
        //         ->where('user_infos.deleted_at',null);
        // });
        
        

       
        


        if (isset($params['is_varified'])) {
            $params['is_verified'] = $params['is_varified'];
            unset($params['is_varified']);
        }
        // $ids = array();
        // $content_type = array();

        // if (isset($params['speciality'])) {
        //     $content_type[] = 'SPECIALITY';
        //     $params['speciality'] = explode(',', $params['speciality']);
        //     $filterParams = [];
        //     $filterParams['content_type'] = 'SPECIALITY';
        //     $filterParams['content_id'] = $params['speciality'];
        //     //foreach ($params['speciality'] as $key => $value) {
        //         // $query->where('user_infos.content_type', '=', 'SPECIALITY')
        //         //       ->whereIn('user_infos.content_id', $params['speciality']);
        //     //}
        //     unset($params['speciality']);
        //     //$filterParams['type'] = $params['period'];
            
        //     $newsQuery = (new UserInfo())->filter($filterParams);

        //     $periods = $newsQuery->get(['content_id','user_id', 'content_type', 'id'])
        //             ->toArray();

            
        //     foreach ($periods as $key => $value) {
        //         $ids[]=$value['id'];
        //     }
        //     //$params['userid'] = $ids;
        // }
        // if (isset($params['rink'])) {
        //   $content_type[] = 'RINK';
        //     $params['rink'] = explode(',', $params['rink']);
        //     $filterParams = [];
        //     $filterParams['content_type'] = 'RINK';
        //     $filterParams['content_id'] = $params['rink'];

        //     //$filterParams['type'] = $params['period'];
        //     // //foreach ($params['rink'] as $key => $value) {
        //     //     $query->where('user_infos.content_type', '=', 'RINK')
        //     //           ->whereIn('user_infos.content_id', $params['rink']);
        //     // //}
        //     unset($params['rink']);
        //     $newsQuery = (new UserInfo())->filter($filterParams);

        //     $periods = $newsQuery->get(['content_id','user_id', 'content_type', 'id'])
        //             ->toArray();
        //     //$ids = array();
        //     foreach ($periods as $key => $value) {
        //         $ids[]=$value['id'];
        //     }
        //      $query->where('user_infos.content_type', '=', 'RINK');
        //     // $params['id'] = $ids;
        // }
        // if (isset($params['language'])) {
        //   $content_type[] = 'LANGUAGE';
        //     $params['language'] = explode(',', $params['language']);
        //     $filterParams = [];
        //     $filterParams['content_type'] = 'LANGUAGE';
        //     $filterParams['content_id'] = $params['language'];
        //     // foreach ($params['language'] as $key => $value) {
        //     //     $query->where('user_infos.content_type', '=', 'LANGUAGE')
        //     //           ->whereIn('user_infos.content_id', $params['language']);
        //     //}
        //     unset($params['language']);

            
        //     $newsQuery = (new UserInfo())->filter($filterParams);

        //     $periods = $newsQuery->get(['content_id','user_id', 'content_type', 'id'])
        //             ->toArray();
        //     //$ids = array();
        //     foreach ($periods as $key => $value) {
        //         $ids[]=$value['id'];
        //     }
        //     // $params['id'] = $ids;
        // }
        // if (isset($params['level'])) {
        //   $content_type[] = 'LEVEL';
        //   $params['level'] = explode(',', $params['level']);
        //   $filterParams = [];
        //   $filterParams['content_type'] = 'LEVEL';
        //   $filterParams['content_id'] = $params['level'];

        //   //$filterParams['type'] = $params['period'];
        //   //foreach ($params['level'] as $key => $value) {
        //       // $query->where('user_infos.content_type', '=', 'LEVEL')
        //       //       ->whereIn('user_infos.content_id', $params['level']);
        //   //}
        //   unset($params['level']);

        //   $newsQuery = (new UserInfo())->filter($filterParams);

        //   $periods = $newsQuery->get(['content_id','user_id', 'content_type', 'id'])
        //           ->toArray();
        //   //$ids = array();
        //   foreach ($periods as $key => $value) {
        //       $ids[]=$value['id'];
        //   }
        //   // $params['id'] = $ids;
        // }
        // // print_r(implode(',',$ids));
        // // exit();

        // if (!empty($ids)) {
        //   $query->whereIn('user_infos.id', $ids);
        //   $query->whereIn('user_infos.content_type', $content_type);
        //   //$content_type[] = 'LEVEL';
        // }

        // print_r($params);
        // exit();
        if (isset($params['location_id'])) {
            $params['city_id'] = $params['location_id'];
        }
        
        if (isset($params['price_id'])) {
            //$params['city_id'] = $params['price_id'];
            $params['price_id'] = explode(',', $params['price_id']);
        }
        if (isset($params['age'])) {
            $array = explode(',', $params['age']);

            $array = array_values(array_map('strval',$array));
            $query->where(function ($query) use ($array) {
               foreach ($array as $id) {
                   $query->orWhereJsonContains('users.age_id', $id);
               }
            })->get();
        }
        if (isset($params['level'])) {
            $array = explode(',', $params['level']);

            $array = array_values(array_map('strval',$array));
            $query->where(function ($query) use ($array) {
               foreach ($array as $id) {
                   $query->orWhereJsonContains('users.level_id', $id);
               }
            })->get();
        }
        if (isset($params['language'])) {
            $array = explode(',', $params['language']);

            $array = array_values(array_map('strval',$array));
            $query->where(function ($query) use ($array) {
               foreach ($array as $id) {
                   $query->orWhereJsonContains('users.language_id', $id);
               }
            })->get();
        }
        if (isset($params['speciality'])) {
            $array = explode(',', $params['speciality']);

            $array = array_values(array_map('strval',$array));
            $query->where(function ($query) use ($array) {
               foreach ($array as $id) {
                   $query->orWhereJsonContains('users.speciality_id', $id);
               }
            })->get();
        }
        if (isset($params['certificate_id'])) {
            //$params['city_id'] = $params['price_id'];
            $params['certificate_id'] = explode(',', $params['certificate_id']);
        }
        foreach ($params as $key => $value) { 
            if ($value != "") {
                if (in_array($key, $this->partialFilterable)) { 
                    $query->where('users.'.$key, 'LIKE', "%{$value}%");
                } elseif (in_array($key, $this->exactFilterable)) {
                    if (is_array($value)) {
                        $query->whereIn('users.'.$key, $value);
                    } else {
                        $query->where('users.'.$key, '=', $value);
                    }
                }
            }
        }
        //echo $query->toSql();exit();
        return $query;
    }
}
