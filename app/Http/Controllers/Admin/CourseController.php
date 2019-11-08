<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Expiry;
use App\Models\VatRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{

    public function filter(){

        $categories = Category::all();
        return view('superadmin.course.index',[
            'categories'=>$categories
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
       $this->authorize('index',Course::class);

        $courses = Course::latest()->get();

        $datatable = DataTables::of( $courses )
            ->addIndexColumn()
            ->addColumn( 'code', function ($row )
            {
                return $row->code;
            } )
            ->addColumn( 'category', function ($row )
            {
                return optional($row->category)->name;
            } )
            ->addColumn( 'name', function ( $row )
            {
                return ucwords( $row->name );
            } )
            ->addColumn( 'costo', function ( $row )
            {
                return  price_formater($row->price);
            } )
            ->addColumn( 'status', function ( $row )
            {
                return $row->isActive() ? '<span class="badge badge-success">'.trans('form.active').'</span>'
                    : '<span class="badge badge-secondary">'.trans('form.disabled').'</span>';
            } )

            ->addColumn( 'created_by', function ( $row )
            {
                return  $row->user->displayName();
            } )
            ->addColumn( 'updated_by', function ( $row )
            {
                return  optional($row->updatedByUser)->displayName();
            } )
            ->addColumn( 'actions', function ( $row )
            {
                $html =' <a class=" action btn block-btn btn-dark mb-1" data-tooltip="'.trans('headers.edit_course').'" href="'.route('admin.courses.edit',['course'=>$row->hashid()]).'">
                               <i class="fas fa-pencil-alt"></i>
                          </a>';
                $html .= '
                          <div class="btn-group mb-1">
                            <button type="button" class="btn block-btn dropdown-toggle" data-toggle="dropdown"><span class="caret ml-0"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">

                                    <li>
                                      <a class="d-block update-btn btn-link page-link" href="#" data-action="'.route('admin.course.status',['course'=>$row->hashid()]).'">';
                                        if ($row->isActive()):
                                            $html .='  <i class="fas fa-times"></i>'.trans('messages.disable');
                                        else:
                                            $html .='  <i class="fas fa-ticket-alt"></i>'.trans('messages.active');
                                        endif;
                          $html .=' </a>
                                    </li>
                                    <li>
                                        <a class="d-block btn-link page-link" href="'.route('module.index',['course'=>$row->hashid()]).'">
                                           <i class="fas fa-cubes"></i>'.trans('form.add_module').'
                                        </a>
                                    </li>
                                     <li>
                                        <a class="d-block delete-btn btn-link page-link" data-content="'.trans('messages.delete_confirm',['record'=>trans('form.course')]).'" data-action="'.route('admin.courses.destroy',['course'=>$row->hashid()]).'" href="#">
                                           <i class="fas fa-trash-alt"></i>'.trans('form.delete').'
                                        </a>
                                    </li>
                            </ul>
                        </div>';

                return $html;
            } )
            ->rawColumns( ['actions','status'] )
            ->make( true );

        return  $datatable;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Course::class);

        $categories = Category::all();
        $expirations = Expiry::all();
        $vatrates = VatRate::all();
        return view('superadmin.course.create',[
            'categories'=>$categories,
            'expirations'=>$expirations,
            'vatrates'=>$vatrates
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $this->authorize('create',Course::class);
        $course = new Course();
        $course->fill($request->fillFormData());

        if ( $course->save()){
            toastr()->success(trans('messages.success'));
            return redirect()->route('admin.courses.list');
        }
        toastr()->success(trans('messages.error'));
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $categories = Category::all();
        $expirations = Expiry::all();
        $vatrates = VatRate::all();
        return view('superadmin.course.edit',[
            'categories'=>$categories,
            'course'=>$course,
            'expirations'=>$expirations,
            'vatrates'=>$vatrates,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        $this->authorize('update',$course);

        $course->fill($request->fillFormData());

        if ( $course->update()){
            toastr()->success(trans('messages.success'));
            return redirect()->route('admin.courses.list');
        }
        toastr()->success(trans('messages.error'));
        return back();

    }

    public function updateStatus(Course $course){

        if (!auth()->user()->can('update',$course)) {
            return response( [
                'status' => 'unauthorized',
                'msg'    => trans('messages.unauthorized')
            ] );

        }
        $course->isActive() ? $course->disable() : $course->enable();

        return response( [
            'status' => 'success',
            'msg'    => trans('messages.change_status')
        ] );



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return response( [
            'status' => 'success',
            'msg'    => trans('messages.delete_msg',['record'=>trans('form.course')])
        ] );
    }
}
