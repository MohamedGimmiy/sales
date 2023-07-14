<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class treasuresRequest extends FormRequest
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
            'name' => 'required|unique:treasures,name',
            'is_master' => 'required',
            'last_isal_exchange' => 'required|integer|min:0',
            'last_isal_collect' => 'required|integer|min:0',
            'active' => 'required'
        ];
    }

    function messages() {
        return [
            'name.required' => 'اسم الخزنة مطلوب',
            'name.unique' => 'عفوا اسم الخزنة موجود مسبقا',
            'is_master.required' => 'نوع الخزنة مطلوب',
            'active.required' => 'حالة تفعيل الخزنة مطلوبة',
            'last_isal_exchange.required' => 'اخر رقم ايصال صرف نقدية لهذه الخزنة مطلوب',
            'last_isal_exchange.integer' => 'اخر رقم ايصال صرف نقدية لهذه الخزنة رقم صحيح',
            'last_isal_collect.required' => 'اخر رقم ايصال تحصيل نقدية لهذه الخزنة مطلوب',
            'last_isal_collect.integer' => 'اخر رقم ايصال تحصيل نقدية لهذه الخزنة رقم صحيح',

            ''
        ];
    }
}
