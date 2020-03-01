<?php

namespace App\Observers;

use App\Models\Structure;
use Illuminate\Support\Facades\Auth;

class StructureObserver
{


	/**
	 * Handle the structure "updated" event.
	 *
	 * @param Structure $structure
	 * @return void
	 */
    public function updated(Structure $structure)
    {
			$structure->updated_by = Auth::id();
    }


}
