<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileExtensionsHelper;
use App\Helpers\Upload;
use App\Helpers\UploadToBox;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Models\DocumentCategories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
                                   $names = '';
                                   foreach ($row->categories as $category){
                                       $names.= $category->name.', ';
                                   }
                                   return  Str::replaceLast(',','', $names);
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
                                   $html ='<a class="delete-btn py-2 px-3 btn block-btn btn-danger" data-content="'.trans('messages.delete_confirm',['record'=>'record']).'" data-action="'.route('admin.download.destroy',$row->hashid()).'" href="#">
                                                       <i class="fas fa-trash-alt"></i> </a>';

                                   return $html;
                               } )
                               ->rawColumns( ['actions','description'] )
                               ->make( true );

        return  $datatable;
    }
    public function store(DocumentRequest $request){

        $file = null;

        if ($request->hasFile('doc_file')){
            if ($request->file('doc_file')->isValid()) {
                #file
                $file = $request->file('doc_file');
                #get file extension
                $extension =  $file->getClientOriginalExtension();
                #register file name
                $name = $file->getClientOriginalName();
                $name = microtime() . '_' . $name;
                #take care of save
                if (in_array($extension,FileExtensionsHelper::allowedExtensions())){
                     $upload = new Upload();
                     $file = $upload->upload($file, 'public/'.Document::CONTENT_PATH)->getData();
                     $url = $file['basename'];
                }else if(in_array($extension,FileExtensionsHelper::allowedExtensionsForBox())){
                    $url = UploadToBox::exportFile($file);
                }else{
                    return response( [
                        'status' => 'error',
                        'msg'    => trans('messages.error_file')
                    ] );
                }
                //preapre date for save
                $document = new Document;
                $document->name = $request->input('name');
                $document->share_with = $request->input('role');
                $document->type = $extension;
                $document->created_by = auth()->id();
                $document->doc_file = $url;

                try{
                   $document->save();
                   $document->categories()->attach($request->input('category'));
                    return response( [
                        'status' => 'success',
                        'msg'    => trans('messages.success')
                    ] );
                }catch(\Exception $exception){
                    logger($exception->getMessage());
                    return response( [
                        'status' => 'error',
                        'msg'    => trans('messages.error')
                    ] );
                }

            }
        }
        return response( [
            'status' => 'error',
            'msg'    => trans('messages.error_file')
        ] );


    }
    public function destroy(Document $document){
        try {
            $document->update(
                [
                    'updated_by'=>auth()->id(),
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ]
            );
            return response( [
                'status' => 'success',
                'msg'    => trans('messages.delete_msg',['record'=>'record'])
            ] );
        }catch (\Exception $exception){
            return response( [
                'status' => 'error',
                'msg'    => trans('messages.error')
            ] );
        }
    }
}
