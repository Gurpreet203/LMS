<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('user')
            ->withCount('courses')
            ->latest()
            ->visibleTo()
            ->search(request(['search', 'sort']))
            ->paginate();

        return view('categories.index', [
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
            'created_by' => Auth::id()
        ];
        $category = Category::where('name', $attributes['name'])
            ->withTrashed()
            ->first();
        
        if ($category)
        {
            if ($category->deleted_at!=null)
            {
                $category->restore();
                $category->update($attributes);
            }
        }
        else
        {
            Category::create($attributes);
        }
    
        return to_route('categories')->with('status', 'Successfully Created');
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return view('categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request , Category $category)
    {
        $this->authorize('update', $category);

        $attributes = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'category' => ['required',
                    Rule::in(
                        Category::visibleTo()
                            ->get()
                            ->pluck('slug')
                            ->toArray()
                )],
        ]);

        $category->update($attributes);
        

        return to_route('categories')->with('status','Successfully Updated');
    }

    public function delete(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return back()->with('status','Successfully Deleted');
    }
}
