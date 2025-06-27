<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
         return [
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'is_featured' => 'boolean',
            'is_hot_trend' => 'boolean',
            'is_new_arrival' => 'boolean',
            'stock' => 'required|integer|min:0',
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|max:100',
            'sizes' => 'nullable|array',
            'sizes.*' => 'nullable|string|max:50',
            'product_images' => 'nullable|array',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

    }
}
