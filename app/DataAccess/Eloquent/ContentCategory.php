<?php

namespace App\DataAccess\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Rutorika\Sortable\SortableTrait;

class ContentCategory extends Model
{
    use SoftDeletes;

    use SortableTrait;

    protected static $sortableField = 'ordering';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'vbaby_content_categories';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        ContentCategory::deleting(function ($model) {
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
        'name',
        'parent_id',
        'parent'

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
     * Get the group that owns this contentCategory
     */
    public function parent()
    {
        return $this->belongsTo(App\DataAccess\Eloquent\ContentCategory::class, 'parent_id');
    }
}
