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
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|max:2000',
            'price' => 'numeric'
        ];

        // if ($route === 'product.store' || $this->file('image')) {
        //     $rule['image'] = 'required|file|image|mimes:jpg,png';
        // }
        if ($route === 'product.update') {
            $rule['due_date'] = 'required|date';
        }

        return $rule;
    }
}
