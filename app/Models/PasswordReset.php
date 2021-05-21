<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PasswordReset extends Model
{

    protected $table = 'password_resets';
    const UPDATED_AT = null;
    //public $timestamps = false;
    // protected $cascadeDeletes = [
    //     'users'
    // ];
    protected $dates = [
        'created_at'
    ];
    
    protected $fillable= [
        'email',
        'token'
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
        'created_at' => 'date:Y/m/d H:i'
    ];

    /**
     * The attributes that are partially match filterable.
     *
     * @var array
     */
    protected $partialFilterable = [
        'email'

    ];

    /**
     * The attributes that are exact match filterable.
     *
     * @var array
     */
    protected $exactFilterable = [
        'email'
    ];
}
