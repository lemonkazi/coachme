<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Models\User;
use App\Models\Location;


class Camp extends Model
{

    protected $cascadeDeletes = [
        //
    ];
    
    protected $fillable= [
        'name',
        'location_id',
        'level_id',
        'rink_id',
        'camp_type_id',
        'web_site_url',
        'start_date',
        'end_date',
        'price',
        'about',
        'contacts',
        'whatsapp',
        'coaches',
        'user_id',
        'email'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

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
        'name'

    ];

    /**
     * The attributes that are exact match filterable.
     *
     * @var array
     */
    protected $exactFilterable = [
        'id'
    ];

    

    
    /**
     * Get the users for the building.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * The coupons that belong to the city.
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }

    /**
     * The news that belong to the city.
     */
    public function location()
    {
        return $this->hasMany(Location::class);
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
