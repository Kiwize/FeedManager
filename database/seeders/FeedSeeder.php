<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feeds = array(
            'https://inessential.com/feed.json',
            'https://korben.info/feed',
            'https://azure.microsoft.com/en-us/blog/feed/'
        );

        foreach($feeds as $feed) {
            DB::table("feeds")->insert([
                'name' => Str::random(8),
                'link' => $feed,
                'created_at' => now(),
                'updated_at' => now(),
                'published_at' => now()
            ]);
        }  
    }
}
