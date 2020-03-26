<?php


namespace App\Helpers;


use App\Models\ModuleContent;

class UploadHelper
{
	/**
	 * @param $request
	 * @return array
	 */
	public static function uploadAndGetUrl($request){
		 if ($request->hasFile('lms_file')){
			 if ($request->file('lms_file')->isValid()) {
				 #file
				 $file = $request->file('lms_file');
				 #get file extension
				 $extension =  $file->getClientOriginalExtension();
				 #register file name
				 $name = $file->getClientOriginalName();
				 $name = microtime() . '_' . $name;
				 #take care of save
				 if (in_array($extension,FileExtensionsHelper::allowedExtensions())){
					 $upload = new Upload();
					 $file = $upload->upload($file, 'public/'.ModuleContent::CONTENT_PATH)->getData();
					 return [
						 'url'=>$file['basename'],
						 'is_url'=>false
					 ];
				 }else if(in_array($extension,FileExtensionsHelper::allowedExtensionsForBox())){
					 return [
						 'url'=>UploadToBox::exportFile($file),
						 'is_url'=>true
					 ];
				 }
			 }
		 }
		 return [
			 'url'=>'',
			 'is_url'=>false
		 ];
   }
}
