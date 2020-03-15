<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::insert([
            [
                'name' => 'organization',
            ],
            [
                'name' => 'planning',
            ],
            [
                'name' => 'collaboration',
            ],
            [
                'name' => 'writing',
            ],
            [
                'name' => 'calendar',
            ],
            [
                'name' => 'api',
            ],
            [
                'name' => 'json',
            ],
            [
                'name' => 'schema',
            ],
        ]);
    }
}
