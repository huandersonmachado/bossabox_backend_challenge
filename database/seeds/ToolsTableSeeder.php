<?php

use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tool::insert([
            [
                'title' => 'Notion',
                'description' => 'All in one tool to organize teams and ideas. Write, plan, collaborate, and get organized.',
                'link' => 'https://notion.so',
            ],
            [
                'title' => 'json-server',
                'description' => 'Fake REST API based on a json schema. Useful for mocking and creating APIs for front-end devs to consume in coding challenges.',
                'link' => 'https://github.com/typicode/json-server',
            ],
            [
                'title' => 'fastify',
                'description' => 'Extremely fast and simple, low-overhead web framework for NodeJS. Supports HTTP2.',
                'link' => 'https://www.fastify.io/',
            ],
        ]);
    }
}
