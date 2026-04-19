<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Branches avec leurs métiers actifs
     * GET /api/categories
     */
    public function index(): JsonResponse
    {
        $branches = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->where('is_active', true)
                  ->select('id', 'name', 'slug', 'parent_id');
            }])
            ->get(['id', 'name', 'slug']);

        return response()->json(['categories' => $branches]);
    }
}
