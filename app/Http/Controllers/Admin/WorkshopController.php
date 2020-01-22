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
                                   $html ='<a class="delete-btn py-2 px-3 btn block-btn btn-danger" data-content="'.trans('messages.delete_confirm',['record'=>'email']).'" data-action="'.route('admin.deletemassemail',['log'=>$row->hashid()]).'" href="#">
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workshop $workshop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workshop  $workshop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workshop $workshop)
    {
        //
    }
}
