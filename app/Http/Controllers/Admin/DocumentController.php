<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Maengkom\Box\BoxAppUser;
use Yajra\DataTables\DataTables;

class DocumentController extends Controller
{
    public function index(){
        $documents = Document::latest()->get();

        $datatable = DataTables::of(   $documents )
                               ->addIndexColumn()
                               ->addColumn( 'name', function ($row )
                               {
                                   return $row->name;
                               } )
                               ->addColumn( 'category', function ( $row )
                               {
                                   return  $row->categories;
                               } )

                               ->addColumn( 'created', function ( $row )
                               {
                                   return format_date($row->created_at);
                               } )
                               ->addColumn( 'created_by', function ( $row )
                               {
                                   return optional($row->user)->displayName();
                               } )
                               ->addColumn( 'actions', function ( $row )
                               {
                                   $html ='<a class="delete-btn py-2 px-3 btn block-btn btn-danger" data-content="'.trans('messages.delete_confirm',['record'=>'record']).'" data-action="'.route('admin.deletemassemail',['log'=>$row->hashid()]).'" href="#">
                                                       <i class="fas fa-trash-alt"></i> </a>';

                                   return $html;
                               } )
                               ->rawColumns( ['actions','description'] )
                               ->make( true );

        return  $datatable;
    }
    public function store(DocumentRequest $request){
        $api = new BoxAppUser( config( 'boxapi' ) );
        dd( $api);
        $uploadedFile = $api->uploadFile( '', 0, '', false );

        dd($uploadedFile);
    }
}
