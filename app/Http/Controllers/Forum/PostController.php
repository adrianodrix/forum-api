<?php

namespace Forum\Http\Controllers\Forum;

use Forum\Http\Controllers\Controller;
use Forum\Http\Requests\Forum\PostFormRequest;
use Forum\Models\Topic;
use Forum\Transformers\PostTransformer;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function store(PostFormRequest $request, Topic $topic)
    {
        $post = $topic->posts()->create([
            'user_id' => $request->user()->id,
            'body' => $request->json('body'),
        ]);

        return response()->json(
            fractal()
            ->item($post)
            ->transformWith(new PostTransformer())
            ->toArray(),
            Response::HTTP_CREATED);
    }
}