<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::search(request(['search', 'date']))->paginate(10);

        return view('categories.index',[
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|max:255|min:2'
        ]);

        $attributes+=[
            'slug' => Category::createSlug($attributes['name']),
            'created_by' => Auth::id()
        ];

        $category = Category::where('name',$attributes['name'])->withTrashed()->first();
        
        if($category)
        {
            if($category->deleted_at!=null)
            {
                $category->restore();
                $category->update($attributes);
            }
        }
        else
        {
            Category::create($attributes);
        }


        return to_route('categories')->with('status','Successfully Created');
    }

    public function edit(Category $category)
    {
        return view('categories.edit',[
            'category' => $category
        ]);
    }

    public function update(Request $request , Category $category)
    {
        $attributes = $request->validate([
            'name' => 'required|max:255|min:2'
        ]);

        $updated = $category->update($attributes);

        if($updated)
        {
            return to_route('categories')->with('status','Successfully Updated');
        }
        else
        {
            return to_route('categories')->with('error','Something Went Wrong In Connection');
        }
    }

    public function delete(Category $category)
    {
        $category->delete();

        return back()->with('status','Successfully Deleted');
    }
}
