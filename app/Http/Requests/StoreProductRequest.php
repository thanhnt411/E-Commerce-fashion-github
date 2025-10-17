<?php

namespace App\Http\Requests;

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
            'name' => 'required|',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required|',
            'description' => 'required|',
            'regular_price' => 'required|',
            'sale_price' => 'required|',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'SKU' => 'required|',
            'stock_status' => 'required|',
            'featured' => 'required|',
            'quantity' => 'required|',
            'brand_id' => 'required|',
            'category_id' => 'required|',
        ];
    }
}
