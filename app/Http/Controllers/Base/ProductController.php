<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Common helper methods for product management
    protected function validateProductData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . ($request->product->id ?? ''),
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);
    }

    protected function checkStockLevel(int $productId, int $requestedQuantity): bool
    {
        // Placeholder for stock check logic
        return true;
    }
}
