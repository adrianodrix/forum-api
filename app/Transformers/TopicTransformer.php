<?php

namespace Forum\Transformers;


use Forum\Models\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'section', 'posts'];

    public function transform(Topic $model)
    {
        return [
            'id' => (int) $model->id,
            'title' => $model->title,
            'slug' => $model->slug,
            'body' => $model->body,
            'diffForHumans' => $model->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Topic $model)
    {
        return $this->item($model->user, new UserTransformer());
    }

    public function includeSection(Topic $model)
    {
        return $this->item($model->section, new SectionTransformer());
    }

    public function includePosts(Topic $model)
    {
        return $this->collection($model->posts, new PostTransformer());
    }
}