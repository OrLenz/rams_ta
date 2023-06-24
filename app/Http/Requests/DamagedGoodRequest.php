<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DamagedGoodRequest extends FormRequest
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
            'warehouses_id' => 'required|integer|exists:warehouses,id',
            'name_pic' => 'required|max:255',
            'quantity' => 'required|integer',
            'date_damaged' => 'required|date',
            'condition' => 'required|max:255'
        ];
    }
}
