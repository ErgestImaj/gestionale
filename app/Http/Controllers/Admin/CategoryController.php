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
        return view('course.category.index');
    }

    /**
     * API get all categories
     *
     * @return Response
     */
    public function getAll()
    {
			return Category::with([
				'user'=>function($query){
					$query->select(['id','firstname','lastname']);
				},
				'updatedByUser'=>function($query){
					$query->select(['id','firstname','lastname']);
				},
			])->get(['id','name','type','created_by','updated_by']);
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
						'name'=>$request->input('name'),
						'type'=>$request->input('type'),
					]
				);
				return response( [
					'message' => 'Category created!'
				] );
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

			try {
				$category->name = $request->input('name');
				$category->type = $request->input('type');
				$category->updated_by = Auth::id();
				$category->update();
					return response( [
						'message' => trans('messages.success')
					] );
			}catch (\Exception $exception){
				return response( [
					'message' => trans('messages.error')
				], 500 );
			}

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
