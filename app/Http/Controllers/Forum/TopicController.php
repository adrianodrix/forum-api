<?php

namespace Forum\Http\Controllers\Forum;


use Forum\Http\Controllers\Controller;
use Forum\Http\Requests\Forum\GetTopicsFormRequest;
use Forum\Http\Requests\Forum\TopicFormRequest;
use Forum\Models\Section;
use Forum\Models\Topic;
use Forum\Transformers\TopicTransformer;
use Illuminate\Http\Response;

class TopicController extends Controller
{
    public function index(GetTopicsFormRequest $request, Section $section)
    {
        $topics = $section
            ->find($request->get('section_id'))
            ->topics()
            ->latestFirst()
            ->get();

        return response()
            ->json(
            fractal()
                ->collection($topics)
                ->includeUser()
                ->includeSection()
                ->transformWith(new TopicTransformer())
                ->toArray(),
            Response::HTTP_OK);
    }

    public function show(Topic $topic)
    {
        return response()
            ->json(
            fractal()
                ->item($topic)
                ->includeUser()
                ->includeSection()
                ->includePosts()
                ->transformWith(new TopicTransformer())
                ->toArray(),
            Response::HTTP_OK);
    }

    public function store(TopicFormRequest $request)
    {
        $topic = $request->user()->topics()->create([
            'title' => $request->json('title'),
            'slug' => str_slug($request->json('title')),
            'body' => $request->json('body'),
            'section_id' => $request->json('section_id'),
        ]);

        return response()
            ->json(
            fractal()
                ->item($topic)
                ->includeUser()
                ->includeSection()
                ->transformWith(new TopicTransformer())
                ->toArray(),
            Response::HTTP_CREATED);
    }
}