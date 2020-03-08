<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
