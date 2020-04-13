<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\ElectronicInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ElectronicInvoiceController extends Controller
{
	public function index(){

		return ElectronicInvoice::where('created_by',auth()->id())->with(['user'=>function($query){
			$query->select('id','firstname');
		}])->latest()->get();
	}

	public function destroy(ElectronicInvoice $invoice){
		try {
			unlink(storage_path('app/public/'.ElectronicInvoice::CONTENT_PATH.DIRECTORY_SEPARATOR.$invoice->receipt));
			$invoice->delete();
			return response( [
				'status' => 'success',
				'msg'    => trans( 'messages.delete' )
			] );
		}catch (\Exception $exception){
			logger($exception->getMessage());
			return response([
				'status' => 'warning',
				'msg' => trans('messages.error')
			]);
		}
	}
}
