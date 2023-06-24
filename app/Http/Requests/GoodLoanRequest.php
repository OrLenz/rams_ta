<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodLoanRequest extends FormRequest
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
            'rooms_id' => 'required|integer|exists:rooms,id',
            'borrower_name' => 'required|max:255',
            'date_borrow' => 'required|date',
            'status' => 'required|max:255'
        ];
    }
}
