<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Topic;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TopicResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class BlogController extends Controller
{
    public function topicList(Topic $topic, Request $request) {

        $topics = QueryBuilder::for(Topic::class)
            ->allowedIncludes('user', 'category')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        TopicResource::wrap('list');
        return TopicResource::collection($topics);
    }
}
