<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index() {
        CategoryResource::wrap('data');
        return CategoryResource::collection(Category::all());
    }

    public function store(CategoryRequest $request, Category $category) {
        $attributes = $request->only(['name', 'description']);
        $category->create($attributes);

        return response(null, Response::HTTP_CREATED);
    }

    public function update(CategoryRequest $request, Category $category) {
        $category->update($request->all());

        return response(null, Response::HTTP_CREATED);
    }

    public function destroy(Category $category) {
        $category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
