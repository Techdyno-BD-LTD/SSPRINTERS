<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends AppBaseController
{
    /** @var CategoryRepository */
    public $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    public function index(Request $request)
    {
        return view('category.index');
    }

    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['variations'] = json_encode($input['variations']);
        $category = $this->categoryRepository->store($input);

        return $this->sendResponse($category, __('messages.flash.category_saved_successfully'));
    }

    public function edit(Category $category): JsonResponse
    {
        return $this->sendResponse($category,  __('messages.flash.category_retrieved_successfully'));
    }

    public function update(UpdateCategoryRequest $request, $categoryId): JsonResponse
    {
        $input = $request->all();
        $input['variations'] = $input['editvariations'];
        $this->categoryRepository->update($input, $categoryId);

        return $this->sendSuccess(__('messages.flash.category_updated_successfully'));
    }

    public function variations($categoryId)
    {
        $category = Category::find($categoryId);

        if ($category) {
            $variations = json_decode($category->variations, true); // Assuming variations is stored as JSON
            return response()->json($variations);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    public function destroy(Category $category): JsonResponse
    {
        $productModels = [
            Product::class,
        ];
        $result = canDelete($productModels, 'category_id', $category->id);
        if ($result) {
            return $this->sendError(__('messages.flash.category_cant_deleted'));
        }
        $category->delete();

        return $this->sendSuccess(__('messages.flash.category_deleted_successfully'));
    }
}
