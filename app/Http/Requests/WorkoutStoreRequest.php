<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkoutStoreRequest extends FormRequest
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
            'workout_name' => 'required',
            'workout_type' => 'required',
            'exercises' => 'required|array|min:1',
            'exercises.*.input_1' => 'required',
            'exercises.*.input_2' => 'required',
            'exercises.*.input_3' => 'required',
            'exercises.*.input_4' => 'required',
        ];
    }
}
