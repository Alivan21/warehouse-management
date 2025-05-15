<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Common helper methods for supplier management
    protected function validateSupplierData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'nullable|string',
        ]);
    }

    protected function getPaginatedSuppliers(int $perPage = 15)
    {
        // Placeholder logic for fetching paginated suppliers
        return [];
    }
}
