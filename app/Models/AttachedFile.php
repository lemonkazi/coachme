<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Models\User;
use App\Models\Speciality;
use App\Models\Rink;
use App\Models\Language;

class AttachedFile extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attached_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content_type',
        'content_id',
        'name',
        'type',
        'path'
    ];

    protected $dates = ['deleted_at'];

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
        'content_type',
        'content_id',
        'type',
        'user_id'
    ];


     /**
     * Get the user for the News.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
