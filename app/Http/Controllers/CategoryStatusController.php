<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryStatusController extends Controller
{
    public function status(Category $category)
    {
        if($category->status)
        {
            $update = $category->update([
                'status'=>0
            ]);
        }
        else
        {
            $update = $category->update([
                'status'=>1
            ]);
        }

        if(!$update)
        {
            return to_route('categories')->with('error','Something Went Wrong');
        }

        return to_route('categories');
    }
}
