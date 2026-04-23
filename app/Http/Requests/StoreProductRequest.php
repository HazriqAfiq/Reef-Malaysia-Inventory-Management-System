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
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'sku'             => ['required', 'string', 'max:50', 'unique:products,sku'],
            'name'            => ['required', 'string', 'max:255'],
            'product_type_id' => ['nullable', 'integer', 'exists:product_types,id'],
            'category_id'     => ['nullable', 'integer', 'exists:categories,id'],
            'volume_ml'       => ['nullable', 'integer', 'min:1'],
            'description'     => ['nullable', 'string'],
            'top_note'        => ['nullable', 'string'],
            'heart_note'      => ['nullable', 'string'],
            'base_note'       => ['nullable', 'string'],
            'wholesale_price' => ['required', 'numeric', 'min:0'],
            'retail_price'    => ['required', 'numeric', 'min:0'],
            'stock'           => ['required', 'integer', 'min:0'],
            'release_date'    => ['nullable', 'date'],
            'is_active'       => ['nullable', 'boolean'],
            'promotion_type'      => ['nullable', 'string', 'in:discount_percent,bogo'],
            'promotion_value'     => ['nullable', 'integer', 'min:1', 'max:100'],
            'promotion_badge'     => ['nullable', 'string', 'max:50'],
            'promotion_starts_at' => ['nullable', 'date'],
            'promotion_ends_at'   => ['nullable', 'date', 'after_or_equal:promotion_starts_at'],
        ];
    }
}
