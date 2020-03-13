<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToolsTest extends TestCase
{
    use RefreshDatabase;

    public function testReturnAllTools()
    {
        $response = $this->get('/api/tools');

        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                "id"=> 1,
                "title"=> "Notion",
                "description"=> "All in one tool to organize teams and ideas. Write, plan, collaborate, and get organized.",
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
        $response = $this->get('/api/tools?node=planning');

        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                "id"=> 1,
                "title"=> "Notion",
                "description"=> "All in one tool to organize teams and ideas. Write, plan, collaborate, and get organized.",
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
        $response = $this->post('/api/tools', [
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
}
