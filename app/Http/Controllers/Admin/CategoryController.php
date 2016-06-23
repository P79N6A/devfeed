<?php

namespace Fedn\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Category;

class CategoryController extends Controller
{
    public function getCategories() {
        $categories = Category::orderBy('order')->orderBy('id','desc')->get()->toHierarchy();
        //$selectSource = Category::getNestedList('title','id','&nbsp;&nbsp;&nbsp;&nbsp;');

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
