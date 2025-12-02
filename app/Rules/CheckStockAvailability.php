<?php

namespace App\Rules;

use Closure;
use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckStockAvailability implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::find($value);
        if (!$product) {
            $fail('Sản phẩm không tồn tại');
        }

        if ($product->stock_status == 'outofstock') {
            $fail("Sản phẩm {$product->name} đã hết hàng");
        }
    }
}
