<?php

namespace App\Repositories;

use App\Models\User;
use App\Utils\Repository;

class UsersRepository extends Repository
{
    protected $modelClass = User::class;

     /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $model = $this->factory($data);
        $this->save($model);
        return $model;
    }
}
