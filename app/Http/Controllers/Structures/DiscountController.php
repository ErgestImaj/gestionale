<?php

namespace App\Http\Controllers\Structures;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use App\Models\Structure;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Structure $structure)
    {
        return  $structure->load(['discounts.user']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request,Structure $structure)
    {
	    try {
		    $structure->discounts()->saveMany($request->fillFormFields());
		    return response( [
			    'status' => 'success',
			    'msg'    => trans( 'messages.success' )
		    ] );
	    } catch ( \Exception $exception ) {
		    logger( $exception->getMessage() );
		    return response( [
			    'status' => 'error',
			    'msg'    => trans( 'messages.error' )
		    ] );
	    }


    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Discount $discount
	 *
	 * @return void
	 */
    public function destroy(Discount $discount)
    {

	    $discount->update([
		    'updated_by'=>auth()->id(),
		    'deleted_at' => Carbon::now()->toDateTimeString()
	    ]);
	    return response( [
		    'status' => 'success',
		    'msg'    => trans( 'messages.delete' )
	    ] );
    }

}
