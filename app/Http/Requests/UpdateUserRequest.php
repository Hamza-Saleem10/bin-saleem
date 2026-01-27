<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'role' => 'required|exists:roles,id',
            'username' => 'required|max:50',
            'name' => 'required|max:150',
            'mobile' => 'required',
            'email' => 'required|email|max:100|unique:users,email,'.$this->user->id,
            'attendance_rule_id' => 'required|exists:attendance_rules,id',
            // 'level_1_id' => 'nullable|exists:level_1,id',
            // 'level_2_id' => 'nullable|exists:level_2,id',
            // 'level_3_id' => 'nullable|exists:level_3,id',
        ];
    }
}
