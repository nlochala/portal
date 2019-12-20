<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class BehaviorAssessment extends PortalBaseModel
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | SETUP
    |--------------------------------------------------------------------------
    */
    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected $casts = ['is_protected' => 'bool'];

    /**
     * Add mass-assignment to model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'student_id',
        'quarter_id',
        'class_id',
        'behavior_standard_item_id',
        'is_protected',
        'user_created_id',
        'user_created_ip',
        'user_updated_id',
        'user_updated_ip'
    ];

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */
    /**
     * Convert the given behavior average to grade.
     *
     * @param int $value
     * @return string
     */
    private static function convertAverage(int $value)
    {
        $average = 'Satisfactory';

        switch ($value) {
            case 3:
                $average = 'Satisfactory';
                break;
            case 2:
                $average = 'Needs Improvement';
                break;
            case 1:
                $average = 'Unsatisfactory';
                break;
            default:
                break;
        }

        return $average;
    }

    /**
     * @param Collection $assessments
     * @return int
     */
    public static function calculateAverage(Collection $assessments)
    {
        $sum = array_sum($assessments->pluck('item.value')->toArray());
        $average = (int) round($sum / $assessments->count(), 0);

        return static::convertAverage($average);
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */
    /**
     * Set created_at to Carbon Object
     *
     * @param $value
     *
     * @return mixed
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toFormattedDateString();
    }

    /**
     * Set updated_at to Carbon Object
     *
     * @param $value
     *
     * @return mixed
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->toFormattedDateString();
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /**
     * isQuarter query scope
     *
     * @param $query
     * @param $quarter_id
     */
    public function scopeIsQuarter($query, $quarter_id)
    {
        $query->where('quarter_id','=',$quarter_id);
    }

    /**
     * isStudent query scope
     *
     * @param $query
     * @param $student_id
     */
    public function scopeIsStudent($query, $student_id)
    {
        $query->where('student_id','=',$student_id);
    }

    /**
     * isClass query scope
     *
     * @param $query
     * @param $class_id
     */
    public function scopeIsClass($query, $class_id)
    {
        $query->where('class_id','=',$class_id);
    }

    /**
     * isStandard query scope
     *
     * @param $query
     * @param $standard_id
     */
    public function scopeIsStandard($query, $standard_id)
    {
        $query->where('behavior_standard_id','=',$standard_id);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
    /**
     * This assessment has a BehaviorStandard
     *
     * @return HasOne
     */
    public function standard()
    {
        return $this->hasOne('App\BehaviorStandard','id','behavior_standard_id');
    }

    /**
     * This assessment has a BehaviorStandardItem
     *
     * @return HasOne
     */
    public function item()
    {
        // 6 --> this is the key for the relationship on the table defined on 4
        return $this->hasOne('App\BehaviorStandardItem','id','behavior_standard_item_id');
    }

    /**
     *  This assessment was created by a user
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_created_id', 'id');
    }

    /**
     *  This assessment was updated by a user
     *
     * @return BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\User', 'user_updated_id', 'id');
    }
}
