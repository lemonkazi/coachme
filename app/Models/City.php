<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Models\User;
use App\Models\Camp;
use App\Models\Province;

class City extends Model
{

    protected $table = 'locations';

    protected $cascadeDeletes = [
        'users',
        'camps'
    ];
    
    protected $fillable= [
        'name',
        'province_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['province_name'];

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
        'province_id'

    ];

    /**
     * The attributes that are exact match filterable.
     *
     * @var array
     */
    protected $exactFilterable = [
        'id',
        'province_id'
    ];

    

   

    
   /**
     * Get the user's Province name.
     *
     * @return string
     */
    public function getProvinceNameAttribute()
    {
        return !empty($this->province) ? $this->province->name : null;
    }

    
   
    /**
     * Get the camps for the building.
     */
    public function camps()
    {
        return $this->hasMany(Camp::class);
    }

    /**
     * Get the users for the building.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the shop for the user.
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

   

    /**
     * Get the daily coupon usage details for the province
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

        return $this->hasMany(DailyCouponUsageDetail::class)->whereBetween('report_date', [$fromDate, $toDate]);
    }
}
