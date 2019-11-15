<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('course.category.index',
            [
              'categories'=>  $categories
            ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request)
    {
        auth()->user()->categories()->create(
          [
              'name'=>$request->input('name')
          ]
        );
        toastr()->success(trans('messages.success'));
        return back();

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('course.category.index',
            [
                'categories'=> $categories,
                'category'=>  $category,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, Category $category)
    {
        $category->name = $request->input('name');
        $category->updated_by = Auth::id();
        if ($category->update()){
            toastr()->success(trans('messages.success'));
            return redirect()->route('admin.categories');
        }
        toastr()->success(trans('messages.error'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

        if ($category->courses()->exists()){
            return response( [
                'status' => 'warning',
                'msg'    => trans('messages.cant_delete_category')
            ] );
        }
        $category->delete();
        return response( [
            'status' => 'success',
            'msg'    => trans('messages.delete')
        ] );
    }
}
