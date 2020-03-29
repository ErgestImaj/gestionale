<?php


namespace App\Helpers;


use DOMDocument;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadHelper
{
	/**
	 * @param $request
	 * @return array
	 * To do: addapt for diferent models
	 */
	public static function uploadAndGetUrl($file, $path)
	{
		#get file extension
		$extension = $file->getClientOriginalExtension();
		#register file name
		$name = $file->getClientOriginalName();
		$name = microtime() . '_' . $name;
		#take care of save
		if (in_array($extension, FileExtensionsHelper::allowedExtensions())) {
			$upload = new Upload();
			$file = $upload->upload($file, 'public/' . $path)->getData();
			return [
				'url' => $file['basename'],
				'is_url' => false,
				'extension' => $extension
			];
		} else if (in_array($extension, FileExtensionsHelper::allowedExtensionsForBox())) {
			return [
				'url' => UploadToBox::exportFile($file),
				'is_url' => true,
				'extension' => $extension
			];
		}
		return [
			'url' => '',
			'is_url' => false,
			'extension' => ''
		];
	}

	public static function storeImagesFromEditor($content, $path = 'editor_images')
	{

		$dom = new DomDocument();

		$dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
		$images = $dom->getElementsByTagName('img');

		foreach ($images as $img) {
			$src = $img->getAttribute('src');

			// if the img source is 'data-url'
			if (preg_match('/data:image/', $src)) {

				// get the mimetype
				preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
				$mimetype = $groups['mime'];

				// Generating a random filename
				$filename = uniqid();
				$filepath = $filename . '.' . $mimetype;

				$image = Image::make($src)
					// resize if required
					/* ->resize(300, 200) */
					->encode($mimetype, 100);
				Storage::disk('local')->put('public/' . $path . '/' . $filepath, $image);
				$new_src = Storage::url($path . '/' . $filepath);
				$img->removeAttribute('src');
				$img->setAttribute('src', $new_src);
			}
		}

		$message = $dom->saveHTML();
		return $message;
	}
}
