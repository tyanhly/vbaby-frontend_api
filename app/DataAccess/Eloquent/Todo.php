<?php

namespace App\DataAccess\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Rutorika\Sortable\SortableTrait;

class Todo extends Model
{
    use SoftDeletes;

    use SortableTrait;

    protected static $sortableField = 'sort_order';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'todos';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        Todo::deleting(function ($model) {
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
        'due_date',
        'color',
        'todo_groups_id',
        'sort_order',
        'marked'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * Get the group that owns this todo
     */
    public function group()
    {
        return $this->belongsTo(App\TodoGroup::class, 'todo_groups_id');
    }
}
