<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class OrderRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'customer' => 'required|integer',
            'additionals' => 'array',
            'additionals.*.name' => 'required|string',
            'additionals.*.addition' => 'required|boolean',
            'additionals.*.value' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id' => 'required|integer',
            'products.*.value' => 'required|numeric',
            'products.*.quantity' => 'required|integer',
        ];
    }
}
