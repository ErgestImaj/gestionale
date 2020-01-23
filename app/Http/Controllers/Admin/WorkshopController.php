<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkshopRequest;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getWorkshops()
    {
        $workshops  = Workshop::latest()->get();
        $datatable = DataTables::of(   $workshops )
                               ->addIndexColumn()
                               ->addColumn( 'data', function ($row )
                               {
                                   $html = '<p>';
                                   $html.=$row->when == 1 ? trans('form.afternoon') : trans('form.morning');
                                   $html.=' | '.format_date($row->date);
                                   $html.= '</p>' ;
                                   return $html;
                               } )
                               ->addColumn( 'description', function ( $row )
                               {
                                   return   Str::limit($row->note,20,'...');
                               } )
                               ->addColumn( 'participants', function ( $row )
                               {
                                   return  implode(', ',array_pluck($row->partecipants,'name'));
                               } )
                               ->addColumn( 'created_by', function ( $row )
                               {
                                   return optional($row->user)->displayName();
                               } )
                                ->addColumn( 'updated_by', function ( $row )
                                {
                                    return optional($row->updatedByUser)->displayName();
                                } )
                               ->addColumn( 'actions', function ( $row )
                               {
                                   $html ='<a class="action btn block-btn btn-dark mb-1" data-tooltip="'.trans('form.edit').'" href="'.route('admin.workshop.edit',$row->hashid()).'">
                                                       <i class="fas fa-pencil-alt"></i>
                                                  </a>
                                               <a class="delete-btn action btn block-btn btn-danger" data-content="'.trans('messages.delete_confirm',['record'=>'workshop']).'" data-action="'.route('admin.workshop.destroy',$row->hashid()).'" href="#">
                                                       <i class="fas fa-trash-alt"></i> </a>';

                                   return $html;
                               } )
                               ->rawColumns( ['actions','description','data'] )
                               ->make( true );

        return  $datatable;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkshopRequest $request)
    {

          $workshop = new Workshop;
          $workshop->fill($request->fillFormData());
        try {
            $workshop->save();
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
     * Display the specified resource.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function show(Workshop $workshop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function edit(Workshop $workshop)
    {
        return view('workshops.edit')->with(['workshop'=>$workshop]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function update(WorkshopRequest $request, Workshop $workshop)
    {
       $workshop->fill($request->fillFormData());
       $workshop->update_by = auth()->id();
        try {
            $workshop->update();
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
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workshop $workshop)
    {

        try {
            $workshop->delete();
            return response( [
                'status' => 'success',
                'msg'    => trans('messages.delete_msg',['record'=>'workshop'])
            ] );
        }catch (\Exception $exception){
            return response( [
                'status' => 'error',
                'msg'    => trans('messages.error')
            ] );
        }


    }
}
