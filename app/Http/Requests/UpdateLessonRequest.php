<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLessonRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => [
                'required', 'date'
            ],
            'position' => [
                'required', 'in:1,2,3,4,5,6'
            ],
            'group_id' => [
                'required', 'exists:groups,id',
                Rule::unique('lessons')->where(function ($query) {
                    $query->where('date', $this->date)
                        ->where('position', $this->position);
                })->ignore($this->id)
            ],
            'room_id' => [
                'required', 'exists:rooms,id',
                Rule::unique('lessons')->where(function ($query) {
                    $query->where('date', $this->date)
                        ->where('position', $this->position);
                })->ignore($this->id)
            ],
            'teacher_id' => [
                'required', 'exists:teachers,id',
                Rule::unique('lessons')->where(function ($query) {
                    $query->where('date', $this->date)
                        ->where('position', $this->position);
                })->ignore($this->id)
            ],
            'subject_id' => [
                'required', 'exists:subjects,id'
            ]
        ];
    }
}
