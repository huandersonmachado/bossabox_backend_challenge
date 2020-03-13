<?php

namespace App\Repositories;

use App\Models\Tool;
use App\Utils\Repository;
use Illuminate\Http\Request;
use App\Http\Resources\ToolsCollection;
use App\Http\Resources\ToolsResource;
use Illuminate\Support\Arr;

class ToolsRepositories extends Repository
{
    protected $modelClass = Tool::class;

    /**
     *
     * @return ToolsCollection
     */
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

    /**
     * @param array $data
     * @return ToolsResource
     */
    public function create(array $data)
    {
        $tagsRepository = app()->make(TagsRepositories::class);
        $toolData = Arr::except($data, ['tags']);
        $model = $this->factory($toolData);

        $this->save($model);

        $tagsIds = $tagsRepository->createOrUpdate($data['tags']);

        $model->tags()->sync($tagsIds);

        $toolModel = $this->newQuery()->with('tags')->find($model->id);

        return new ToolsResource($toolModel);
    }
}
