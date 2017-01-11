<?php

namespace App\DataAccess\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Rutorika\Sortable\SortableTrait;

class Content extends Model
{
    use SoftDeletes;

    use SortableTrait;

    protected static $sortableField = 'ordering';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'vbaby_contents';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        Content::deleting(function ($model) {
            $model->next()->decrement(self::$sortableField);
        });
    }

    /**
     * The attributes excluded from the model query
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'content_category_id',
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at','created_at', 'updated_at'
    ];

    /**
     * Get the group that owns this content
     */
    public function category()
    {
        return $this->belongsTo(\App\DataAccess\Eloquent\ContentCategory::class, 'content_category_id');
    }
}
