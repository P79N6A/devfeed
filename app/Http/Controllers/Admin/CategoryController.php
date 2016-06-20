<?php

namespace Fedn\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Category;

class CategoryController extends Controller
{
    public function getCategories() {
        $categories = Category::root()->with('children')->paginate(10);

        return view('backend.category', compact('categories'));
    }

    public function create(Category $category=null){
        $newCategory = new Category();

        if($category) {
            $newCategory->pid = $category->id;
        }

        $rootCategories = Category::root();

        return view('backend.form.category', ['categories'=>$rootCategories, 'category'=>$newCategory]);
    }
}
