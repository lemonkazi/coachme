<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Models\User;
use App\Models\ProgramType;
use App\Models\Level;
use App\Models\Rink;
use App\Models\Location;
use App\Models\AttachedFile;
use App\Models\Period;
use Carbon\Carbon;



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
        'price_text',
        'about',
        'contacts',
        'whatsapp',
        'user_id',
        'email',
        'starting_age',
        //'schedule_start_date',
        //'schedule_end_date',
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
        'program_photo',
        'program_period'
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
        //'program_type_id',
        'level_id',
        'location_id',
        'rink_id',
        'starting_age'
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
    /**
     * Get the user's speciality name.
     *
     * @return string
     */
    public function getProgramTypeNameAttribute()
    {
        $program_types=array();
        if(!empty($this->program_type_id)){
            $program_type_id_data = json_decode($this->program_type_id);
            foreach ($program_type_id_data as $key=>$program_type) {
              $program_types[] = ProgramType::find($program_type, ['name', 'id'])->toArray();
            }
        }
        
        
        return $program_types;
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
    * Get the user's City name.
    *
    * @return string
    */
    public function getProgramPeriodAttribute()
    {
       
        $program_photo = Period::where([
                        ['content_id', $this->id],
                        ['content_type', 'PROGRAM'],
                        //['type', 'PHOTO'],
                        ['deleted_at', null],
                    ])->get(['start_date', 'end_date', 'id', 'type'])->toArray();

       
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

        if (isset($params['program_type_id'])) {
            $array = explode(',', $params['program_type_id']);

            $array = array_values(array_map('strval',$array));
            $query->where(function ($query) use ($array) {
               foreach ($array as $id) {
                   $query->orWhereJsonContains('program_type_id', $id);
               }
            })->get();
        }

        if (isset($params['period'])) {
            $params['period'] = strtoupper($params['period']);
            
            $filterParams = [];
            $filterParams['content_type'] = 'PROGRAM';
            //$params['period'] = strtoupper($params['period']);
            $params['period'] = explode(',', $params['period']);
            $filterParams['type'] = $params['period'];
            
            $newsQuery = (new Period())->filter($filterParams);

            $periods = $newsQuery->get(['content_id', 'start_date', 'end_date'])
                    ->toArray();
            $ids = array();
            foreach ($periods as $key => $value) {
                $ids[]=$value['content_id'];
            }
            $params['id'] = $ids;
            // print_r($params['id']);
            // exit();


            
            // if ($params['period'] == 'winter') {
            //     $params['period'] = strtoupper($params['period']);
            //     $dt =  now();
            //     $query->where('reg_start_date', '<', $date_year.'-03-01')
            //                    ->where(function($query) use ($date_year){
            //                         return $query
            //                         ->whereNull('reg_end_date')
            //                         ->orWhere('reg_end_date', '>=', $date_year.'-12-01');
            //                     });
            //     # code...
            // }
            
           
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
        return $query;
    }
}
