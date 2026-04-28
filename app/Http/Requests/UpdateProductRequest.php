<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'sku'             => ['required', 'string', 'max:50', Rule::unique('products')->ignore($this->product)],
            'name'            => ['required', 'string', 'max:255'],
            'product_type_id' => ['nullable', 'integer', 'exists:product_types,id'],
            'category_id'     => ['nullable', 'integer', 'exists:categories,id'],
            'volume_ml'       => ['nullable', 'integer', 'min:1'],
            'description'     => ['nullable', 'string'],
            'top_note'        => ['nullable', 'string'],
            'heart_note'      => ['nullable', 'string'],
            'base_note'       => ['nullable', 'string'],
            'wholesale_price' => ['nullable', 'numeric', 'min:0'],
            'retail_price'    => ['nullable', 'numeric', 'min:0'],
            'stock'           => ['nullable', 'integer', 'min:0'],
            'release_date'    => ['nullable', 'date'],
            'is_active'       => ['nullable', 'boolean'],
            'promotion_type'      => ['nullable', 'string', 'in:discount_percent,bogo'],
            'promotion_value'     => ['nullable', 'integer', 'min:1', 'max:100'],
            'promotion_badge'     => ['nullable', 'string', 'max:50'],
            'promotion_starts_at' => ['nullable', 'date'],
            'promotion_ends_at'   => ['nullable', 'date', 'after_or_equal:promotion_starts_at'],
            'images'              => ['nullable', 'array'],
            'images.*'            => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'delete_images'       => ['nullable', 'array'],
            'delete_images.*'     => ['integer', 'exists:product_images,id'],
        ];
    }
}
