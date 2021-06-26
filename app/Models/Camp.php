<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Models\User;
use App\Models\CampType;
use App\Models\Level;
use App\Models\Rink;
use App\Models\Location;
use App\Models\AttachedFile;
use Carbon\Carbon;


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


    protected $appends = [
        'location_name',
        'level_name',
        'rink_name',
        'camp_type_name',
        'camp_photo'
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
        'camp_type_id',
        'level_id',
        'location_id',
        'rink_id'
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
    public function camp_type()
    {
        return $this->belongsTo(CampType::class);
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
    public function getCampTypeNameAttribute()
    {
        return !empty($this->camp_type) ? $this->camp_type->name : null;
    }


    /**
    * Get the user's City name.
    *
    * @return string
    */
    public function getCampPhotoAttribute()
    {
       
        $camp_photo = AttachedFile::where([
                        ['content_id', $this->id],
                        ['content_type', 'CAMP'],
                        ['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->get(['name', 'path', 'id'])->toArray();

       
        return !empty($camp_photo) ? $camp_photo : null;

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

        //$today = new DateTime();
        $today = 'March 1';
        $start      = strtotime($today);
        $date_year = date('Y', $start);

        

        $query = $this->newQuery();

        
        
        if (empty($params) || !is_array($params)) {
            return $query;
        }

        
      
        if (isset($params['is_varified'])) {
            $params['is_verified'] = $params['is_varified'];
            unset($params['is_varified']);
        }

        $filtered_rink = array();
        if (isset($params['coach_id'])) {
            $array = explode(',', $params['coach_id']);

            $array = array_values(array_map('strval',$array));
            $query->where(function ($query) use ($array) {
               foreach ($array as $id) {
                   $query->orWhereJsonContains('coaches', $id);
               }
            })->get();
        }

        //$params['period'] = 'winter';
        //$today =  now();
       // echo 'Today is: ' . date('Y', $start) . '<br />';

        if (isset($params['month'])) {
            $dt =  now();
            $dt      = strtotime($dt);
            $year = date('Y', $dt);

            $array = explode(',', $params['month']);
            foreach ($array as $key => $value) {

                $query->orWhere(function ($sq) use ($value) {
                            $sq->whereRaw('extract(month from start_date) ='.$value)
                                ->whereRaw('extract(month from end_date) ='.$value);
                        });
            }
            
        }
        if (isset($params['date'])) {
            $dt =  now();
            $dt      = strtotime($params['date']);
            $dt = date('Y-m-d H:i:s', $dt);
            $query->where('start_date', '<=', $dt)
                          ->where('end_date', '>=', $dt);
        } 
        if (isset($params['current_date'])) {
            $dt =  now();
            $dt      = strtotime($dt);
            $dt = date('Y-m-d H:i:s', $dt);
            $query->where('start_date', '<=', $dt)
                          ->where('end_date', '>=', $dt);
           
        } 

        if (isset($params['duration'])) {

            $array = explode(',', $params['duration']);

            foreach ($array as $key => $value) {
                preg_match_all('#day_([^\s]+)#', $value, $matches);

                $days = implode(' ', $matches[1]);

                $duration = explode('-', $days);
                $diff = $duration[1] - $duration[0];


                // $days = 200;
                // $data= MyData::whereRaw('DATEDIFF(updated_at,created_at) < ?')
                //     ->setBindings([$days])
                //     ->get();
                if ($duration[0] != 22) {

                    $query->orWhere(function ($sq) use ($duration) {
                            $sq->whereRaw('DATEDIFF(end_date,start_date) >='.$duration[0])
                                ->whereRaw('DATEDIFF(end_date,start_date) <='.$duration[1]);
                        });
                }
                if ($duration[0] == 22) {
                    $query->orWhereRaw('DATEDIFF(end_date,start_date) >='.$duration[0]);
                }
                
              
            }
            
           
        }

        if (isset($params['min']) && isset($params['max'])) {
            $min_value = $params['min'];
            $max_value = $params['max'];
            // if none of them is null
            if (! (is_null($min_value) && is_null($max_value))) {
                // fetch all between min & max values
                $query->whereBetween('price', [$min_value, $max_value]);
            }
            // if just min_value is available (is not null)
            elseif (! is_null($min_value)) {
                // fetch all greater than or equal to min_value
                $query->where('price', '>=', $min_value);
            }
            // if just max_value is available (is not null)
            elseif (! is_null($max_value)) {
                // fetch all lesser than or equal to max_value
                $query->where('price', '<=', $max_value);
            }
        }
        


        //$data['start_date'] = Carbon::createFromFormat('Y/m/d H:i', $data['start_date']);
        //$data['end_date'] = Carbon::createFromFormat('Y/m/d H:i', $data['end_date']);
        //echo config('global.spring');
        //exit();
        
        foreach ($params as $key => $value) { 
            if ($value != "") {
                if (in_array($key, $this->partialFilterable)) { 
                    $query->where($key, 'LIKE', "%{$value}%");
                } elseif (in_array($key, $this->exactFilterable)) {
                    if (is_array($value)) {
                        $query->whereIn($key, $value);
                    } else {
                        $query->where($key, '=', $value);
                    }
                }
            }
        }
        return $query;
    }
}
