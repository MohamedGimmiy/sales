<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoresRequest extends FormRequest
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
            'name' => 'required',
            'active' => 'required'
        ];
    }

    function messages() {
        return [
            'name.required' => 'اسم المخزن مطلوب',
            'active.required' => 'حالة تفعيل المخزن مطلوبة',

        ];
    }
}
