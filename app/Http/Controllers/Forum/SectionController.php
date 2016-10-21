<?php

namespace Forum\Http\Controllers\Forum;


use Forum\Http\Controllers\Controller;
use Forum\Models\Section;
use Forum\Transformers\SectionTransformer;

class SectionController extends Controller
{
    public function index(Section $section)
    {
        return fractal()
            ->collection($section->get())
            ->transformWith(new SectionTransformer())
            ->toArray();
    }
}