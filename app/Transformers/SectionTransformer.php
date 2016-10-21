<?php

namespace Forum\Transformers;

use Forum\Models\Section;
use League\Fractal\TransformerAbstract;

class SectionTransformer extends TransformerAbstract
{
    public function transform(Section $model)
    {
        return [
            'id' => (int) $model->id,
            'title' => $model->title,
            'slug' => $model->slug,
            'description' => $model->description
        ];
    }
}