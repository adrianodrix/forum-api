<?php

namespace Forum\Transformers;

use Forum\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user'];

    protected $availableIncludes = ['topic'];

    public function transform(Post $model)
    {
        return [
            'id' => (int) $model->id,
            'body' => $model->body,
            'diffForHumans' => $model->created_at->diffForHumans()
        ];
    }

    public function includeTopic(Post $model)
    {
        return $this->item($model->topic, new TopicTransformer());
    }

    public function includeUser(Post $model)
    {
        return $this->item($model->user, new UserTransformer());
    }
}