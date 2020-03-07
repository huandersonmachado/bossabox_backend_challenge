<?php

namespace App\Utils;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

interface RepositoryInterface
{
    public function getAll($take = 15, $paginate = true);
    public function pluck($column, $key = null): Collection;
    public function findById($id, $fail = true) : Model;
    public function findByUuid($uuid);
    public function create(array $data);
    public function delete(Model $model);
    public function update(Model $model, array $data = []);
    public function deleteCollection(EloquentCollection $collection);
}
