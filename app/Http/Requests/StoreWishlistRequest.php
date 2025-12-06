<?php

namespace App\Http\Requests;

use App\DTOs\WishlistData;
use Illuminate\Foundation\Http\FormRequest;

class StoreWishlistRequest extends FormRequest
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
            'id' => 'required|integer',
            'name' => 'required|string',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ];
    }

    public function toDTO(): WishlistData
    {
        $data = $this->validated();
        return new WishlistData(
            id: $data['id'],
            name: $data['name'],
            qty: $data['qty'],
            price: $data['price']
        );
    }
}
