<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Iatstuti\Database\Support\CascadeSoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

use App\Traits\ModelTrait;


class BaseModel extends Model
{
    use SoftDeletes, CascadeSoftDeletes, ModelTrait;
    
    /**
     * If you need to customize the format of your timestamp
     * columns "created_at" and "updated_at"
     * set the $dateFormat property on your model.
     * examples:
     * 'U' - timestamp (seconds from 01.01.1970)
     * 'Y-m-d H:i:s' - e.g. 1985-12-25 15:01:24
     * etc.
     *
     * @var string
     */
    // protected $dateFormat = 'U';

    

    /**
     * The attributes that are partially match filterable.
     *
     * @var array
     */
    protected $partialFilterable = [
        
    ];


    /**
     * The attributes that are exact match filterable.
     *
     * @var array
     */
    protected $exactFilterable = [
        'id',
    ];


    /**
     * Get status label
     *
     * @return string
     */
    protected function getStatusLabel($status)
    {
        $statusLabel = '';
        
        switch ($status) {
            case 'RELEASED':
                $statusLabel = '公開';
                break;
            case 'PRIVATE':
                $statusLabel = '非公開';
                break;
            case 'PENDING':
                $statusLabel = '未対応';
                break;
            case 'IN_PROGRESS':
                $statusLabel = '対応中';
                break;
            case 'COMPLETED':
                $statusLabel = '完了';
                break;
            case 'UNSET':
                $statusLabel = '未設定';
                break;
            case 'VACANT_SEAT':
                $statusLabel = '空席';
                break;
            case 'NO_VACANT_TABLE':
                $statusLabel = '満席';
                break;
            case 'DRAFT':
                $statusLabel = '非公開';
                break;
            case 'COMING':
                $statusLabel = '未対応';
                break;
            case 'DOING':
                $statusLabel = '対応中';
                break;
            case 'DONE':
                $statusLabel = '完了';
                break;
            case 'APPROVED':
                $statusLabel = '承認';
                break;
            case 'UNAPPROVED':
                $statusLabel = '非承認';
                break;
            default:
                $statusLabel = '';
        }

        return $statusLabel;
    }


    /**
     * Get content type label
     *
     * @return string
     */
    protected function getContentTypeLabel($contentType)
    {
        $contentTypeLabel = '';
        
        switch ($contentType) {
            case 'EVENT':
                $contentTypeLabel = 'イベント';
                break;
            case 'NEWS':
                $contentTypeLabel = 'ニュース';
                break;
            case 'WORK':
                $contentTypeLabel = 'ワーク';
                break;
            case 'THREAD':
                $contentTypeLabel = '掲示板';
                break;
            case 'COMMENT':
                $contentTypeLabel = 'コメント';
                break;
            case 'EXCHANGE_ITEM':
                $contentTypeLabel = '交換アイテム';
                break;
            case 'COMMON':
                $contentTypeLabel = '一般';
                break;
            default:
                $contentTypeLabel = '';
        }

        return $contentTypeLabel;
    }
    
    /**
     * Get Start End Format 
     *
     * @return string
     */
    protected function getStartEnd($start,$end)
    {
        return  substr(str_replace('-', '/', $start),0,-3) ."~".substr(str_replace('-', '/',$end),0,-3);
    }

    /**
     * filter data based request parameters
     * 
     * @param array $params
     * @return $query
     */
    public function filter($params)
    {
        $query = $this->newQuery();
        $request = request();
        $authUser = $request->user();
        
        if ($authUser) {
            if ($authUser->isCityAdmin()) { 
                if (in_array('city_id', $this->fillable)) {
                    $query->where('city_id', '=', $authUser->city_id);
                }
            } elseif ($authUser->isUser()) { 
                
                if (in_array('city_id', $this->fillable)) {
                    if (get_class($this) === 'App\Models\News') {
                        $query->where(function ($sq) use ($authUser) {
                                $sq->where('city_id', '=', $authUser->city_id)
                                    ->orWhere('city_id', null);
                            });
                    } else {
                        $query->where('city_id', '=', $authUser->city_id);
                    }
                }

                if (in_array('start_show_date', $this->fillable)) {
                    $query->where('start_show_date', '<=', now())
                          ->where('end_show_date', '>=', now());
                }
                if (in_array('start_display_date', $this->fillable)) {
                    $query->where('start_display_date', '<=', now())
                          ->where('end_display_date', '>=', now());
                }

                if (in_array('delivery_date', $this->fillable)) {
                    $query->where('delivery_date', '<=', now())
                          ->where('end_date', '>=', now());
                }

                if (in_array('status', $this->fillable)) {

                    if (get_class($this) === 'App\Models\UserExchangeItemHistory') {
                         $query->where('status', 'COMING');
                    }
                    elseif (get_class($this) === 'App\Models\ThreadReported') {
                         $query->whereNotNull('status');
                    } else {
                         $query->where('status', 'RELEASED');
                    }
                   
                }
            }
        } else { 
            if ($request->hasHeader('CITY-ID') && $request->header('CITY-ID')) {
                if (in_array('city_id', $this->fillable)) {
                    if (get_class($this) === 'App\Models\News') {
                        $query->where(function ($sq) use ($request) {
                                $sq->where('city_id', '=', $request->header('CITY-ID'))
                                    ->orWhere('city_id', null);
                            });
                    } else {
                        $query->where('city_id', '=', $request->header('CITY-ID'));
                    }
                }

                if (in_array('start_show_date', $this->fillable)) {
                    $query->where('start_show_date', '<=', now())
                          ->where('end_show_date', '>=', now());
                }
                if (in_array('start_display_date', $this->fillable)) {
                    $query->where('start_display_date', '<=', now())
                          ->where('end_display_date', '>=', now());
                }

                if (in_array('delivery_date', $this->fillable)) {
                    $query->where('delivery_date', '<=', now())
                          ->where('end_date', '>=', now());
                }

                if (get_class($this) === 'App\Models\UserExchangeItemHistory') {
                         $query->where('status', 'COMING');
                }
                elseif (get_class($this) === 'App\Models\ThreadReported') {
                     $query->whereNotNull('status');
                } else {
                     $query->where('status', 'RELEASED');
                }

            }
        }
        
        if (empty($params) || !is_array($params)) {
            return $query;
        }

        $fromFilterDate = null;
        $toFilterDate = null;
        $sortingParams = [];

        if (isset($params['sort'])) { 
            $sortingParams = explode(',', $params['sort']);
            unset($params['sort']);
        }

        foreach ($params as $key => $value) { 
            if (in_array($key, $this->partialFilterable)) { 
                $query->where($key, 'LIKE', "%{$value}%");
            } elseif (in_array($key, $this->exactFilterable)) {
                $query->where($key, '=', $value);
            } elseif ($key === 'start_show_date' && in_array($key, $this->fillable)) {
                $fromFilterDate = str_replace('/', '-', $value);
                
                if (!$toFilterDate) {
                    $toFilterDate = now();
                }
            } elseif ($key === 'end_show_date' && in_array($key, $this->fillable)) {
                $toFilterDate = str_replace('/', '-', $value)." 23:59";
                
                if (!$fromFilterDate) {
                    $fromFilterDate = now();
                }
            } elseif ($key === 'start_display_date' && in_array($key, $this->fillable)) {
                $fromFilterDate = str_replace('/', '-', $value);
                
                if (!$toFilterDate) {
                    $toFilterDate = now();
                }
            } elseif ($key === 'end_display_date' && in_array($key, $this->fillable)) {
                $toFilterDate = str_replace('/', '-', $value)." 23:59";
                
                if (!$fromFilterDate) {
                    $fromFilterDate = now();
                }
            }
        }

        if (!empty($sortingParams)) { 
            
            $column = null;
            $direction = null;

            foreach ($sortingParams as $sortingParam) {
                $columnAndDirection = explode(':', str_replace(' ', '', $sortingParam));

                if (!empty($columnAndDirection[0])) {
                    $column = $columnAndDirection[0];
                } else {
                    continue;
                }

                if (!empty($columnAndDirection[1])) {
                    $direction = $columnAndDirection[1];
                } else {
                    $direction = 'asc';
                }

                if (in_array($column, $this->fillable)) {
                    $query->orderBy($column, $direction);
                }
            }

        } 
        
        try {
            if ($fromFilterDate && $toFilterDate) {
                $query->where(function ($q) use ($fromFilterDate, $toFilterDate) {
                    $q->whereBetween('start_show_date', [$fromFilterDate, $toFilterDate])
                        ->orWhereBetween('end_show_date', [$fromFilterDate, $toFilterDate])
                        ->orWhere(function ($sq) use ($fromFilterDate, $toFilterDate) {
                            $sq->where('start_show_date', '<', $fromFilterDate)
                                ->where('end_show_date', '>', $toFilterDate);
                        })
                        ;
                });
            }
        } catch (\Exception $e) {
            
        }

        return $query;
    }

    /**
     * Search param based request parameters
     * 
     * @param array $params
     * @return $query
     */
    public function search($params)
    {
        //print_r($params);
        $query = $this->newQuery();

        if (empty($params) || !is_array($params)) {
            return $query;
        }

        foreach ($params as $key => $value) { 
            if (in_array($key, $this->filterable) && !empty($value)) {
                $query->orWhere($key, 'LIKE', "%{$value}%");
            }
        }

        return $query;
    }

    public function prev($id){
        $query = $this->newQuery();
        return $query->where('id', '<', $id)->max('id');
    }
    public function next($id){
        $query = $this->newQuery();
        return $query->where('id', '>', $id)->min('id');
    }
    
}
