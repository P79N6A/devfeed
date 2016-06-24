<?php

namespace Fedn\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;

use Fedn\Models\Category;

use Validator;

class CategoryController extends Controller
{
    public function getIndex() {

        return view('backend.category');
    }

    public function saveApi(Request $request) {
        $this->validate($request, [
            'title' => 'required|unique:categories|max:255',
            'slug' => 'required|unique:categories|regex:/[a-zA-Z0-9\-]/',
            'parent_id' => 'integer'
        ]);

        $data = $request->only(['title', 'slug', 'parent_id', 'description']);

        if($data['parent_id'] === 0) {
            $category = Category::create($data);
        } else {
            $parent = Category::find($data['parent_id']);
            $category = $parent->children()->create($data);
        }

        return response()->json($category);
    }

    public function listApi() {
        $collection = Category::orderBy('id', 'desc')->get()->toHierarchy();

        $categories = [];

        foreach($collection as $one) {
            $categories[] = $one;
        }

        return response()->json($categories);
    }

    public function delApi(Request $request) {
        $ids = (array)$request->get('ids');
        $result = [];
        foreach($ids as $id) {
            $node = Category::find($id);
            if($node) {
                $node->articles()->detach();
                $result[$id] = $node->delete();
            } else {
                $result[$id] = '404';
            }
        }
        return response()->json($result);
    }

}
