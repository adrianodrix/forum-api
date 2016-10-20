<?php

namespace Forum\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

class GetTopicsFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'section_id' => 'required|numeric|exists:sections,id',
        ];
    }
}
