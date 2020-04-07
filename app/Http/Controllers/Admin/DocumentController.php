<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileExtensionsHelper;
use App\Helpers\Upload;
use App\Helpers\UploadHelper;
use App\Helpers\UploadToBox;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Models\UserGroups;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class DocumentController extends Controller
{
	public function index()
	{

		$documents = Document::latest()->get();

		$datatable = DataTables::of($documents)
			->addIndexColumn()
			->addColumn('name', function ($row) {
				return $row->name;
			})
			->addColumn('category', function ($row) {
				$names = '';
				foreach ($row->categories as $category) {
					$names .= $category->name . ', ';
				}
				return Str::replaceLast(',', '', $names);
			})
			->addColumn('shared_with', function ($row) {
				$rules = '';
				foreach ($row->share_with as $role) {
					$rules .= ucfirst(UserGroups::find($role)->name) . ', ';
				}
				return Str::replaceLast(',', '', $rules);
			})
			->addColumn('created', function ($row) {
				return format_date($row->created_at);
			})
			->addColumn('created_by', function ($row) {
				return optional($row->user)->displayName();
			})
			->addColumn('updated_by', function ($row) {
				return optional($row->updatedByUser)->displayName();
			})
			->addColumn('editlink', function ($row) {
				return route('admin.download.edit', $row->hashid());
			})
			->addColumn('remlink', function ($row) {
				return route('admin.download.destroy', $row->hashid());
			})
			->addColumn('remMessage', function ($row) {
				return trans('messages.delete_confirm', ['record' => 'record']);
			})
			->rawColumns(['actions', 'description'])
			->make(true);

		return $datatable;
	}

	public function store(DocumentRequest $request)
	{

		try {
			$file=[];
			if ($request->hasFile('doc_file')){
				if ($request->file('doc_file')->isValid()) {
					$file = UploadHelper::uploadAndGetUrl($request->file('doc_file'), Document::CONTENT_PATH);
				}
			}


			if (empty(@$file['url'])){
				return response([
					'status' => 'error',
					'msg' => trans('messages.error_file')
				]);
			}

			//preapre date for save
			$document = new Document;
			$document->name = $request->input('name');
			$document->share_with = $request->input('role');
			$document->type = $file['extension'];
			$document->types = $request->input('types');
			$document->created_by = auth()->id();
			$document->doc_file = $file['url'];

			$document->save();
			$document->categories()->attach($request->input('category'));
			return response([
				'status' => 'success',
				'msg' => trans('messages.success'),
				'redirect'=>route('admin.download.index')
			]);
		} catch (\Exception $exception) {
			logger($exception->getMessage());
			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}


	}

	public function edit(Document $document)
	{
		return [
			'document' => $document,
			'categories' => $document->categories,
			'roles' => UserGroups::whereIn('id', $document->share_with)->get(['id', 'name'])
		];
	}

	public function update(DocumentRequest $request, Document $document)
	{

		$file = [];
		try {

			if ($request->hasFile('doc_file')) {
				if ($request->file('doc_file')->isValid()) {
					$file = UploadHelper::uploadAndGetUrl($request->file('doc_file'), Document::CONTENT_PATH);
					if (empty(@$file['url'])){
						return response([
							'status' => 'error',
							'msg' => trans('messages.error_file')
						]);
					}
				}
			}
			//preapre date for update

			$document->name = $request->input('name');
			$document->share_with = $request->input('role');
			$document->types = $request->input('types');
			$document->type = $request->hasFile('doc_file') ? 	$file['extension'] : $document->type;
			$document->updated_by = auth()->id();
			$document->doc_file = $request->hasFile('doc_file') ? 	$file['url'] : $document->doc_file;

			$document->update();
			$document->categories()->sync($request->input('category'));

			return response([
				'status' => 'success',
				'msg' => trans('messages.success'),
				'redirect'=>route('admin.download.index')
			]);
		} catch (\Exception $exception) {
			logger($exception->getMessage());

			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}

	}

	public function destroy(Document $document)
	{
		try {
			$document->update(
				[
					'updated_by' => auth()->id(),
					'deleted_at' => Carbon::now()->toDateTimeString()
				]
			);
			return response([
				'status' => 'success',
				'msg' => trans('messages.delete_msg', ['record' => 'record'])
			]);
		} catch (\Exception $exception) {
			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}
	}
}
