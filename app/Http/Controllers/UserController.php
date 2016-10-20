<?php

namespace Forum\Http\Controllers;

use Forum\Transformers\UserTransformer;
use Illuminate\Http\Request;

use Forum\Http\Requests;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return fractal()
            ->item($request->user())
            ->transformWith(new UserTransformer())
            ->toArray();
    }
}
