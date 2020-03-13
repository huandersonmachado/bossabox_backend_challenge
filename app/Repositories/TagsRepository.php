<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Utils\Repository;

class TagsRepositories extends Repository
{
    protected $modelClass = Tag::class;

    public function createOrUpdate(array $data)
    {

        $tags = collect($data);

        return $tags->map(function($tag) {
            $tagModel = $this->findByName($tag);
            //dd($tagModel);
            if ($tagModel !== null)
                return $tagModel->id;

            $tagCreated = $this->create(['name' => $tag]);
            return $tagCreated->id;
        });
    }

    public function findByName(string $name)
    {
        return $this->newQuery()->where('name', $name)->first();
    }
}
