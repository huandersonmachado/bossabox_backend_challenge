<?php

namespace App\Utils;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class Repository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $modelClass;

    /**
     * @return Builder
     */
    protected function newQuery()
    {
        return app()->make($this->modelClass)->newQuery();
    }

    /**
     * @return Model
     */
    protected function getModel()
    {
        return app()->make($this->modelClass);
    }

    /**
     *
     * @param Builder $query
     * @param integer $take
     * @param boolean $paginate
     * @return Builder|AbstractPaginator
     */
    protected function doQuery($query = null, $take = 15, $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if ($paginate === true) {
            return $query->paginate($take);
        }

        if ($take > 0 && $take !== false) {
            $query->take($take);
        }

        return $query->get();
    }

    /**
     * @param integer $take
     * @param boolean $paginate
     * @return Builder|AbstractPaginator
     */
    public function getAll($take = 15, $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * @param string $column
     * @param string|null $key
     * @return Collection|array
     */
    public function pluck($column, $key = null): Collection
    {
        return $this->newQuery()->pluck($column, $key);
    }

    /**
     * @param int $id
     * @param boolean $fail
     * @return Model
     */
    public function findById($id, $fail = true) : Model
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        $this->newQuery()->find($id);
        return $this;
    }

    /**
     *
     * @param array $data
     * @return void
     */
    public function factory(array $data = []) : Model
    {
        $model = $this->newQuery()->getModel()->newInstance();
        $this->setModelData($model, $data);
        return $model;
    }

   /**
    *
    * @param Model $model
    * @param array $data
    * @return void
    */
    protected function setModelData(Model $model, array $data)
    {
        $model->fill($data);
    }

    /**
     * @param Model $model
     * @return void
     */
    public function save(Model $model)
    {
        $model->save();
        return $model;
    }

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data)
    {
        $model = $this->factory($data);
        $this->save($model);
        return $model;
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model)
    {
        $model->delete();
    }

    /**
     *
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function update(Model $model, array $data = [])
    {
        $this->setModelData($model, $data);
        return $this->save($model);
    }

    /**
     * @param Collection $collection
     * @return void
     */
    public function deleteCollection(EloquentCollection $collection)
    {
        $collection->each(fn(Model $model) => $this->delete($model));
    }
}
