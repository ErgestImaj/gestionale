<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Models\DocumentCategories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentCategoriesController extends Controller
{
    //
    public function index(){
        $categroies = DocumentCategories::latest()->withCount('documents')->get();
        return $categroies;
    }
    public function store(CategoriesRequest $request){

        try {
            auth()->user()->documentcategories()->create(
                [
                    'name'=>$request->input('name')
                ]
            );
            return response( [
                'status' => 'success',
                'msg'    => trans('messages.success')
            ] );
        }catch (\Exception $exception){
            logger($exception->getMessage());
            return response( [
                'status' => 'error',
                'msg'    => trans('messages.error')
            ] );
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentCategories  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, DocumentCategories $category)
    {
        try {
            $category->name = $request->input('name');
            $category->updated_by = Auth::id();
            $category->update();
            return response( [
                'status' => 'success',
                'msg'    => trans('messages.success')
            ] );
        }catch (\Exception $exception){
            logger($exception->getMessage());
            return response( [
                'status' => 'error',
                'msg'    => trans('messages.error')
            ] );
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentCategories $category) {
        $category->update([
            'updated_by'=>auth()->id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ]);
        return response( [
            'status' => 'success',
            'msg'    => trans( 'messages.delete' )
        ] );
    }
}
