<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'phone_name' => ['required', 'string', 'max:255'],
            'seller_id' => ['required', 'integer', 'exists:sellers,id'],
            'display_size' => ['required', 'numeric'],
            'quantity' => ['required', 'integer', 'min:0'],
            'cost' => ['required', 'numeric', 'min:0']
        ];
    }
}
