<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'total' => 'required|gt:0',
            'invoice_no' => 'required',
            'supplier_id' => 'required|exists:suppliers,id',
            'type' => 'required',
            'item.barcode' => 'required|array|min:1',
            'item.quantity' => 'required|array|min:1',
            'item.quantity.*' => 'required|gte:0',
            'item.sppi' => 'required|array|min:1',
            'item.bonus' => 'required|array|min:1',
            'item.ppi' => 'required|array|min:1',
            'item.ppi.*' => 'required|gte:0',
            'item.exp' => 'required|array|min:1',
            'item.exp.*' => 'required|date',
        ];
    }
}
