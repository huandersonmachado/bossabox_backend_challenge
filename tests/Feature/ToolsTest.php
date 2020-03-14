<?php

namespace Tests\Feature;

use App\Models\Tool;
use App\Repositories\TagsRepositories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToolsTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnAllTools()
    {
        $response = $this->get('/tools');

        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                "id"=> 1,
                "title"=> "Notion",
                "description"=> "All in one tool to organize teams and ideas.
                                 Write, plan, collaborate, and get organized.",
                "link"=> "https://notion.so",
                "tags"=> [
                    "organization",
                    "planning",
                    "collaboration"
                ]
            ]
        );
    }

    public function testSearchByTag()
    {
        $response = $this->get('/tools?node=planning');

        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                "id"=> 1,
                "title"=> "Notion",
                "description"=> "All in one tool to organize teams and ideas.
                                 Write, plan, collaborate, and get organized.",
                "link"=> "https://notion.so",
                "tags"=> [
                    "organization",
                    "planning",
                    "collaboration"
                ]
            ]
        );
    }

    public function testCreateToolAndTag()
    {
        $response = $this->post('/tools', [
                'title' => 'fastify',
                'link' => 'https://www.fastify.io/',
                'description' => 'Extremely fast and simple, low-overhead web framework for NodeJS. Supports HTTP2.',
                'tags' => [
                    'web',
                    'framework',
                    'node',
                    'http2',
                    'https',
                    'localhost'
                ]
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(
            [
                'title' => 'fastify',
                'link' => 'https://www.fastify.io/',
                'description' => 'Extremely fast and simple, low-overhead web framework for NodeJS. Supports HTTP2.',
                'tags' => [
                    'web',
                    'framework',
                    'node',
                    'http2',
                    'https',
                    'localhost'
                ]
            ]
        );

        $tool = Tool::with('tags')->find(1);

        $tool->tags->each(function ($tag) use ($tool) {
            $this->assertDatabaseHas('tools_tags', [
                'tool_id' => $tool->id,
                'tag_id' => $tag->id,
            ]);
        });

        $this->assertDatabaseHas('tools', [
            'title' => 'fastify',
            'link' => 'https://www.fastify.io/',
            'description' => 'Extremely fast and simple, low-overhead web framework for NodeJS. Supports HTTP2.',
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'web',
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => 'framework',
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => 'node',
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => 'http2',
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => 'https',
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => 'localhost',
        ]);
    }

    public function testDeleteTool()
    {
        $tool = Tool::create([
            "title"=> "Notion",
            "description"=> "All in one tool to organize teams and ideas. Write, plan, collaborate, and get organized.",
            "link"=> "https://notion.so",
        ]);

        $response = $this->delete("/tools/$tool->id");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tools', [
            'id' => $tool->id
        ]);
    }

    public function testUpdateTool()
    {

        $tool = Tool::create([
            "title"=> "Laravel Debugbar",
            "description"=> "This is a package to integrate PHP Debug Bar with Laravel 5.
                             It includes a ServiceProvider to register the debugbar and attach it to the output.",
            "link"=> "https://github.com/barryvdh/laravel-debugbar",
        ]);

        $tagsRespository = app()->make(TagsRepositories::class);

        $tags = $tagsRespository->createOrUpdate([
            'Laravel',
            'Debug',
            'PHP'
        ]);

        $tool->tags()->sync($tags);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])
        ->json('PUT', '/tools', [
            'id' => $tool->id,
            'title' => 'Debugbar Laravel',
            'description' => 'Debugbar para o Laravel',
            'link' => 'https://github.com/barryvdh/laravel-debugbar',
            'tags' => [
                'Laravel',
                'web',
                'framework',
                'node',
                'http2',
                'https',
                'localhost'
            ]
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $tool->id,
            'title' => 'Debugbar Laravel',
            'description' => 'Debugbar para o Laravel',
            'tags' => [
                'Laravel',
                'web',
                'framework',
                'node',
                'http2',
                'https',
                'localhost'
            ],
        ]);

        $this->assertDatabaseHas('tools', [
            'id' => $tool->id,
            'title' => 'Debugbar Laravel',
            'description' => 'Debugbar para o Laravel',
        ]);

        $toolUpdated = Tool::with('tags')->find($tool->id);

        $this->assertCount(7, $toolUpdated->tags);

        $toolUpdated->tags->each(function ($tag) use ($tool) {
            $this->assertDatabaseHas('tools_tags', [
                'tool_id' => $tool->id,
                'tag_id' => $tag->id,
            ]);
        });
    }
}
