<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Models\User;
use App\Models\CampType;
use App\Models\Speciality;
use App\Models\Age;
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
        'province_id',
        'level_id',
        'rink_id',
        'camp_type_id',
        'speciality_id',
        'age_id',
        'website',
        'web_site_url',
        'start_date',
        'end_date',
        'price',
        'price_text',
        'about',
        'contacts',
        'whatsapp',
        'coaches',
        'user_id',
        'email',
        'coach_name'
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
        'speciality_name',
        'age_name',
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
        //'camp_type_id',
        'province_id',
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




    public function getCampTypeNameAttribute()
    {
        

        // $info  = DB::table('user_infos')
        //              ->select('id', 'content_type', 'content_id')
        //              ->where('user_id', '=', $this->id)
        //              ->where('deleted_at', '=', null)
        //              ->get();


        $camp_types=array();
        if(!empty($this->camp_type_id)){
            $camp_type_id_data = json_decode($this->camp_type_id);
            foreach ($camp_type_id_data as $key=>$camp_type) {
              $camp_types[] = CampType::find($camp_type, ['name', 'id'])->toArray();
            }
        }

        $speciality_ids = array();
        if (!empty($this->speciality_id)) {
            $speciality_id_data = json_decode($this->speciality_id);
            foreach ($speciality_id_data as $key => $speciality) {
                $speciality_ids[] = CampType::find($speciality, ['name', 'id'
                ])->toArray();
            }
        }

        $age_ids = array();
        if (!empty($this->age_id)) {
            $age_id_data = json_decode($this->age_id);
            foreach ($age_id_data as $key => $age) {
                $age_ids[] = CampType::find($age, ['name', 'id'])->toArray();
            }
        }
        
        
        return $camp_types;
    }

    public function getSpecialityNameAttribute()
    {
        $speciality_ids = array();
        if (!empty($this->speciality_id)) {
            $speciality_id_data = json_decode($this->speciality_id);
            foreach ($speciality_id_data as $key => $speciality) {
                $speciality_ids[] = Speciality::find($speciality, ['name', 'id'
                ])->toArray();
            }
        }
        return $speciality_ids;
    }
    public function getAgeNameAttribute()
    {

        $age_ids = array();
        if (!empty($this->age_id)) {
            $age_id_data = json_decode($this->age_id);
            foreach ($age_id_data as $key => $age) {
                $age_ids[] = Age::find($age, ['name', 'id'])->toArray();
            }
        }
        return $age_ids;
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

        
        if (isset($params['level_id'])) {
            $params['level_id'] = explode(',', $params['level_id']);
        }
        if (isset($params['age_id'])) {
            $params['age_id'] = explode(',', $params['age_id']);
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


        if (isset($params['camp_type_id'])) {
            $array = explode(',', $params['camp_type_id']);

            $array = array_values(array_map('strval',$array));
            $query->where(function ($query) use ($array) {
               foreach ($array as $id) {
                   $query->orWhereJsonContains('camp_type_id', $id);
               }
            })->get();
        }
        if (isset($params['speciality_id'])) {
            $array = explode(',', $params['speciality_id']);

            $array = array_values(array_map('strval',$array));
            $query->where(function ($query) use ($array) {
               foreach ($array as $id) {
                   $query->orWhereJsonContains('speciality_id', $id);
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
            $query->where('start_date', '<=', "$dt")
                          ->where('end_date', '>=', "$dt");
        } 
        if (isset($params['current_date']) && !empty($params['current_date'])) {
            $dt =  now();
            $dt      = strtotime($dt);
             $dt = date('Y-m-d', $dt);
            $query->where('start_date', '<=', "$dt")
                          ->where('end_date', '>=', "$dt");
           
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
            //if (! (is_null($min_value) && is_null($max_value))) {
                // fetch all between min & max values
                $query->whereBetween('price', [$min_value, $max_value]);
            // }
            // // if just min_value is available (is not null)
            // elseif (! is_null($min_value)) {
            //     // fetch all greater than or equal to min_value
            //     $query->where('price', '>=', $min_value);
            // }
            // // if just max_value is available (is not null)
            // elseif (! is_null($max_value)) {
            //     // fetch all lesser than or equal to max_value
            //     $query->where('price', '<=', $max_value);
            // }
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
        //echo $query->toSql();exit();
        return $query;
    }
}
