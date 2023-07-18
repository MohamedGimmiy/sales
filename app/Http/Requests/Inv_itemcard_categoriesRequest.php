<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Inv_itemcard_categoriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */


    public function rules()
    {
        return [
            'name' => 'required',
            'active' => 'required',
        ];
    }

    function messages() {
        return [
            'name.required' => 'اسم الفئة مطلوب',
            'active.required' => 'حالة تفعيل الفئة مطلوبة',
        ];
    }
}
