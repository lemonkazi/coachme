<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Models\User;
use App\Models\Speciality;
use App\Models\Rink;
use App\Models\Language;

class UserInfo extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_infos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content_type',
        'content_id',
        'content_name'
    ];

     /**
     * Get the user for the News.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
