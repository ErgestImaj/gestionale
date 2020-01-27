<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Expiry;
use App\Models\VatRate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('download.index', []);
    }

    public function create()
    {
//        $this->authorize('create',Course::class);
        $expirations = Expiry::all();
        $vatrates = VatRate::all();
        return view('download.create',[
            'expirations'=>$expirations,
            'vatrates'=>$vatrates
        ]);
    }
}
