<?php

namespace App\Repositories;

use App\Models\Tool;
use App\Utils\Repository;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Resources\ToolsResource;
use App\Http\Resources\ToolsCollection;
use Illuminate\Database\Eloquent\Model;

class ToolsRepositories extends Repository
{
    protected $modelClass = Tool::class;

    /**
     * @var TagsRepositories
     */
    private $tagsRepository;

    /**
     * @param TagsRepositories $tagsRepositories
     */
    public function __construct(TagsRepositories $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     *
     * @return ToolsCollection
     */
    public function getAllWithTags()
    {
        $node = request('node');
        if ($node) {
            $tools = $this->newQuery()->whereHas('tags', function ($query) use ($node) {
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
        $toolData = Arr::except($data, ['tags']);
        $model = $this->factory($toolData);

        $this->save($model);

        $tagsIds = $this->tagsRepository->createOrUpdate($data['tags']);

        $model->tags()->sync($tagsIds);

        $toolModel = $this->newQuery()->with('tags')->find($model->id);

        return new ToolsResource($toolModel);
    }

    /**
     *
     * @param Model $model
     * @param array $data
     * @return ToolsResource
     */
    public function update(Model $model, array $data = [])
    {
        $this->setModelData($model, $data);
        $tagsIds = $this->tagsRepository->createOrUpdate($data['tags']);

        $model->tags()->sync($tagsIds);
        $this->save($model);

        $toolModel = $this->newQuery()->with('tags')->find($model->id);

        return new ToolsResource($toolModel);
    }
}
