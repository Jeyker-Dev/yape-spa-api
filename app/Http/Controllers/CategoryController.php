<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories for the authenticated user.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = Category::all();

        return response()->json(['categories' => $categories], 200);
    }

    /**
     * Display the specified category for the authenticated user.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $category = $request->user()->categories()->find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        return response()->json(['category' => $category], 200);
    }

    /**
     * Store a newly created category in storage.
     *
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $request->validated();

        $category = $request->createCategory();

        return response()->json(['message' => 'Category created successfully.', 'category' => $category], 201);
    }

    /**
     * Update the specified category in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $category = $request->user()->categories()->find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->name = $request->input('name');
        $category->save();

        return response()->json(['message' => 'Category updated successfully.', 'category' => $category], 200);
    }
    /**
     * Remove the specified category from storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $category = $request->user()->categories()->find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.'], 200);
    }
}
