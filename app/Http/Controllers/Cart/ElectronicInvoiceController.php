<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\ElectronicInvoice;
use Illuminate\Http\Request;

class ElectronicInvoiceController extends Controller
{
	public function index(){

		return ElectronicInvoice::with(['user'=>function($query){
			$query->select('id','firstname');
		}])->latest()->get();
	}
}
