<?php

use App\Models\Product;

function getPriceByCurrency(Product $product): string
{
    $currencyCode = strtolower(session('currency_code', 'inr')); // default INR

    $symbol = match ($currencyCode) {
        'inr' => '₹',
        'usd' => '$',
        'eur' => '€',
        default => '₹',
    };

    $price = $product->price ?? 0;

    return $symbol . number_format($price, 2);
}