<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryStatusController extends Controller
{
    public function __invoke(Category $category)
    {
        if($category->status)
        {
            $category->update([
                'status'=> Category::INACTIVE
            ]);
        }
        else
        {
            $category->update([
                'status'=> Category::ACTIVE
            ]);
        }

        return to_route('categories');
    }
}
