<?php

namespace App\Repositories;

use App\Http\Resources\ToolsCollection;
use App\Models\Tool;
use App\Utils\Repository;

class ToolsRepositories extends Repository
{
    protected $modelClass = Tool::class;

    public function getAllWithTags()
    {
        $tools =  $this->newQuery()->with('tags')->get();
        return new ToolsCollection($tools);
    }
}
