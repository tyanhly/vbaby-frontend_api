<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class ContentRepository extends BaseRepository
{

    /**
     * Searchable fields
     *
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'parent_id',
        'ordering'
    ];

    /**
     * Model class name
     *
     * @return string
     */
    public function model()
    {
        return \App\DataAccess\Eloquent\Content::class;
    }

    /**
     * Get all with sorted
     *
     * @param  array  $columns
     *
     * @return object
     */
    public function all($columns = ['*'])
    {
        //var_dump($this->model::with(['category']));die;
        $result =$this->model::with(['category'])->orderBy('ordering', 'asc')->get($columns);
        return $result;
    }

    /**
     * Delete todo
     *
     * @param  int $id
     * @return object/bool
     */
    public function delete($id)
    {
        $todo = $this->find($id);
        if (parent::delete($id)) {
            return $todo;
        }
        return false;
    }

    /**
     * Move Content After another Content
     *
     * @param  int $id
     * @param  int $priorSiblingId
     *
     * @return object
     */
    public function move($id, $priorSiblingId)
    {
        $todo = $this->find($id);
        $beforeOrder = $todo->sort_order;
        if (empty($priorSiblingId)) {
            $priorSibling = $this->model::sorted()->first();
            $todo->moveBefore($priorSibling);
        } else {
            $priorSibling = $this->find($priorSiblingId);
            $todo->moveAfter($priorSibling);
        }
        $afterOrder = $todo->sort_order;
        if (intval($beforeOrder) === intval($afterOrder)) {
            return false;
        }
        return $todo;
    }
}
