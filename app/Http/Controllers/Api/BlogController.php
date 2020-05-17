<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Topic;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TopicResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\CategoryResource;


class BlogController extends Controller
{
    public function topicList(Topic $topic, Request $request) {
        $topics = QueryBuilder::for(Topic::class)
            ->allowedIncludes('user', 'category')
            ->allowedFilters([
                'title',
                AllowedFilter::exact('category_id'),
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        TopicResource::wrap('list');
        return TopicResource::collection($topics);
    }

    public function topicDetail($topicId) {
        $topic = QueryBuilder::for(Topic::class)
            ->allowedIncludes('user', 'category')
            ->findOrFail($topicId);

        return new TopicResource($topic);
    }

    public function getCategory(Category $category) {
        CategoryResource::wrap('data');
        return CategoryResource::collection(Category::all());
    }
}
