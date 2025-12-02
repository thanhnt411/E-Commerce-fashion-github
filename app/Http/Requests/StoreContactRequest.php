<?php

namespace App\Http\Requests;

use App\DTOs\ContactData;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
    public function prepareForValidation()
    {
        $this->merge([
            'name' => Str::title(trim($this->name)),
            'email' => strtolower(trim($this->email)),
            'phone' => preg_replace('/^0/', '+84', $this->phone),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'comment' => 'required|',
        ];
    }

    public function toDTO(): ContactData
    {
        $data = $this->validated();
        return new ContactData(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'] ?? null,
            comment: $data['comment'],
        );
    }
}
