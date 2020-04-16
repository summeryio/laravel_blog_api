<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsSeeder extends Seeder
{
    public function run()
    {
        $userId = User::first()->id;
        $category_ids = Category::all()->pluck('id')->toArray();
        $faker = app(\Faker\Generator::class);

        $topics = factory(Topic::class)
            ->times(100)
            ->make()
            ->each(function ($topic, $index) use ($userId, $category_ids, $faker) {
                $topic->user_id = $userId;
                $topic->category_id = $faker->randomElement($category_ids);
        });

        Topic::insert($topics->toArray());
    }
}
