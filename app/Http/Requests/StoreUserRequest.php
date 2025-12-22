<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules;
use App\Http\Requests\BaseRequest;

class StoreUserRequest extends BaseRequest
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
            'email' => 'required|email|unique:users,email|max:100',
            'mobile' => 'required',
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()]
            'password' => ['required', 'confirmed', Rules\Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            'level_1_id' => 'nullable|exists:level_1,id',
            'level_2_id' => 'nullable|exists:level_2,id',
            'level_3_id' => 'nullable|exists:level_3,id',
        ];
    }
}
