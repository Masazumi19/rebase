<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $route = $this->route()->getName();

        $rule = [
            'product_name' => 'required|string|max:50',
            'category_id' => 'required|exists:occupations,id',
            'due_date' => 'required|after_or_equal:today',
            'description' => 'required|string|max:2000',
            'is_published' => 'nullable|boolean',
        ];

        if ($route === 'product.update') {
            $rule['due_date'] = 'required|date';
        }

        return $rule;
    }
}
