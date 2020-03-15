<?php

use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolsTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tool = Tool::find(1);
        $tool->tags()->attach(1);
        $tool->tags()->attach(2);
        $tool->tags()->attach(3);
    }
}
