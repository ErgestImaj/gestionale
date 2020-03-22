<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
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
     * API get all categories
     *
     * @return Response
     */
    public function getAll()
    {
        $categories = Category::all();
				return response( [
					'data' => $categories->jsonSerialize()
				] );
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
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
     * API Create Category
     *
     * @param  CategoriesRequest  $request
     * @return Response
     */
    public function apiCreate(CategoriesRequest $request)
    {
				auth()->user()->categories()->create(
					[
						'name'=>$request->input('name')
					]
				);
				return response( [
					'message' => 'Category created!'
				] );
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return Response
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
     * @return Response
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
		 * API Update Category
		 *
		 * @param  CategoriesRequest $request
		 * @param  Category $category
		 * @return Response
		 */
		public function apiUpdate(CategoriesRequest $request, Category $category)
		{
			$category->name = $request->input('name');
			$category->updated_by = Auth::id();
			if ($category->update()){
				return response( [
					'message' => trans('messages.success')
				] );
			}
			return response( [
				'message' => trans('messages.error')
			], 500 );
		}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return Response
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
