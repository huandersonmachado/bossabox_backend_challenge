<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Utils\Repository;

class TagsRepositories extends Repository
{
    protected $modelClass = Tag::class;
}
