<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }
    public function allSubCategory(){
        $categoryArr = SubCategory::with('Category')->get();
        
        return view('admin.sub_categories', compact('categoryArr'));
    }

    public function destroy(SubCategory $subcategory, $id)
    {
        subcategory::destroy(array('id', $id));
        return redirect('sub_categories');
    }


    public function store(Request $request)
    {
        $res=new SubCategory;
        $res->cat_ID=$request->input('cat_ID');
        $res->sub_category_name=$request->input('sub_category_name');
        $res->save();

        $request->session()->flash('msg','Sub Category Added');
        return redirect ('add_Sub_Categories')->with('success', 'Sub Category Added');
    }

    public function showCategory(){
        $categories = Category::orderBy('category_name','ASC')->get();
        return view('admin.add_sub_category', compact('categories'));
    }

    
}
