<?php

namespace App\Http\Requests;

use App\DTOs\CartData;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'name' => 'required|max:100',
            'phone' => 'required|numeric|digits:10',
            'locality' => 'required|',
            'city' => 'required|',
            'address' => 'required|',
            'state' => 'required|',
            'landmark' => 'required|',
            'zip' => 'required|numeric|digits:6',
        ];
    }

    /*public function toDTO(): CartData
    {
        $data = $this->validated();
        return new CartData(
            name: $data['name'],
            locality: $data['locality'],
            phone: $data['phone'] ?? null,
            city: $data['city'],
            address: $data['address'],
            state: $data['state'],
            landmark: $data['landmark'],
            zip: $data['zip'],
        );
    }*/
}
