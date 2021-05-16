<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function manageCategory(){
        $categoryArr = Category::orderBy('id','DESC')->get();
        return view('admin.categories', compact('categoryArr'));
    }

    public function destroy(Category $category, $id)
    {
        category::destroy(array('id', $id));
        return redirect('categories');
    }

    public function store(Request $request)
    {
        $res=new Category;
        $res->category_name=$request->input('category_name');
        $res->save();

        $request->session()->flash('msg','Product Information Added');
        return redirect ('add_categories');
    }
}
