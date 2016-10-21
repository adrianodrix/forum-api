<?php

namespace Forum\Transformers;


use Forum\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $model)
    {
        return [
            'username' => $model->username,
            'avatar' => $model->avatar(),
        ];
    }
}