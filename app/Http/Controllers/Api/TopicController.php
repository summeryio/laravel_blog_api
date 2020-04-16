<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Topic;
use Symfony\Component\HttpFoundation\Response;

class TopicController extends Controller
{
    public function index(Topic $topic, User $user, Request $request) {
        $topics = Topic::where('user_id', $request->user()->id);

        TopicResource::wrap('data');
        return TopicResource::collection($topics->paginate());
    }

    public function store(TopicRequest $request, Topic $topic) {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->excerpt = $request->title;
        $topic->save();

        return response(null, Response::HTTP_CREATED);
    }

    public function update(TopicRequest $request, Topic $topic) {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return response(null, Response::HTTP_CREATED);
    }

    public function destroy(Topic $topic) {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
