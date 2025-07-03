<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         $isUpdate = $this->method() === 'PUT' || $this->method() === 'PATCH';

         return [
            'name' => ['required', 'string', 'max:255'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'lt:price'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_hot_trend' => ['sometimes', 'boolean'],
            'is_new_arrival' => ['sometimes', 'boolean'],
            'stock' => ['required', 'integer', 'min:0'],

            'colors' => $isUpdate ? ['nullable', 'array'] : ['required', 'array'],
            'colors.*' => ['required', 'string', 'max:100'],

            'sizes' => $isUpdate ? ['nullable', 'array'] : ['required', 'array'],
            'sizes.*' => ['required', 'string', 'max:50'],

            'product_images' => $isUpdate ? ['nullable', 'array'] : ['required', 'array'],
            'product_images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];

    }
}
