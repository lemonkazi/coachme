<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Models\User;
use App\Models\Location;
use App\Models\Province;

class Rink extends Model
{

    protected $cascadeDeletes = [
        //'users'
    ];
    
    protected $fillable= [
        'name',
        'province_id',
        'location_id',
        'address',
        'latitude',
        'longitude'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'date:Y/m/d H:i',
        'updated_at' => 'date:Y/m/d H:i',
        'deleted_at' => 'date:Y/m/d H:i',
    ];

    /**
     * The attributes that are partially match filterable.
     *
     * @var array
     */
    protected $partialFilterable = [
        'name',
        'address'

    ];

    /**
     * The attributes that are exact match filterable.
     *
     * @var array
     */
    protected $exactFilterable = [
        'id',
        'province_id',
        'location_id'
    ];

    protected $dates = ['deleted_at'];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */


    protected $appends = [
        'city_name',
        'province_name'
    ];

    


     /**
     * Get the experience for the user.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
     /**
     * Get the certificate for the user.
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }


    /**
     * Get the users for the building.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }



    /**
     * Get the user's speciality name.
     *
     * @return string
     */
    public function getCityNameAttribute()
    {
        return !empty($this->location) ? $this->location->name : null;
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
    

    /**
     * Get the daily coupon usage details for the city
     */
    public function dailyReport()
    {
        $fromDate = request()->input('from_date', null);
        $toDate = request()->input('to_date', null);

        if (!$fromDate) {
            $fromDate = date('Y-m-01');
        }

        if (!$toDate) {
            $toDate = date('Y-m-t');
        }

        //return $this->hasMany(DailyCouponUsageDetail::class)->whereBetween('report_date', [$fromDate, $toDate]);
    }
}
