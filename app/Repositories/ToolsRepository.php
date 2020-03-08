<?php

namespace App\Repositories;

use App\Models\Tool;
use App\Utils\Repository;
use Illuminate\Http\Request;
use App\Http\Resources\ToolsCollection;

class ToolsRepositories extends Repository
{
    protected $modelClass = Tool::class;

    public function getAllWithTags()
    {
        $node = request('node');
        if ($node) {
            $tools = $this->newQuery()->whereHas('tags', function ($query) use($node) {
                $query->where('name', '=', $node);
            })->get();
        } else {
            $tools = $this->newQuery()->with('tags')->get();
        }

        return new ToolsCollection($tools);
    }
}
