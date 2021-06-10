<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Models\User;
use App\Models\ProgramType;
use App\Models\Level;
use App\Models\Rink;
use App\Models\Location;
use App\Models\AttachedFile;


class Program extends Model
{

    protected $cascadeDeletes = [
        //
    ];
    
    protected $fillable= [
        'name',
        'location_id',
        'level_id',
        'rink_id',
        'program_type_id',
        'web_site_url',
        'reg_start_date',
        'reg_end_date',
        'price',
        'about',
        'contacts',
        'whatsapp',
        'user_id',
        'email',
        'starting_age',
        'schedule_start_date',
        'schedule_end_date',
        'schedule_log'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */


    protected $appends = [
        'location_name',
        'level_name',
        'rink_name',
        'program_type_name',
        'program_photo'
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
        'name'

    ];

    /**
     * The attributes that are exact match filterable.
     *
     * @var array
     */
    protected $exactFilterable = [
        'id',
        'program_type_id',
        'level_id',
        
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
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * The coupons that belong to the city.
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * The coupons that belong to the city.
     */
    public function rink()
    {
        return $this->belongsTo(Rink::class);
    }
    /**
     * The coupons that belong to the city.
     */
    public function program_type()
    {
        return $this->belongsTo(ProgramType::class);
    }


    

    /**
     * Get the user's speciality name.
     *
     * @return string
     */
    public function getLocationNameAttribute()
    {
        return !empty($this->location) ? $this->location->name : null;
    }

    /**
     * Get the user's speciality name.
     *
     * @return string
     */
    public function getLevelNameAttribute()
    {
        return !empty($this->level) ? $this->level->name : null;
    }

    /**
     * Get the user's speciality name.
     *
     * @return string
     */
    public function getRinkNameAttribute()
    {
        return !empty($this->rink) ? $this->rink->name : null;
    }
    /**
     * Get the user's speciality name.
     *
     * @return string
     */
    public function getProgramTypeNameAttribute()
    {
        return !empty($this->program_type) ? $this->program_type->name : null;
    }


    /**
    * Get the user's City name.
    *
    * @return string
    */
    public function getProgramPhotoAttribute()
    {
       
        $program_photo = AttachedFile::where([
                        ['content_id', $this->id],
                        ['content_type', 'PROGRAM'],
                        ['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->get(['name', 'path', 'id'])->toArray();

       
        return !empty($program_photo) ? $program_photo : null;

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


    /**
     * Search user based request parameters
     * 
     * @param array $params
     * @return $query
     */
    public function filter($params)
    {
        $query = $this->newQuery();

        
        
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
}
