<?php

namespace App\Http\Controllers;

use App\Exports\StorehouseAdminExport;
use App\Exports\StructureStoreHouseExport;
use App\Models\Cart\CourseTransactions;
use App\Models\Course;
use App\Models\Structure;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class StorehouseController extends Controller
{
	public function adminCourses(){
		$courses = Course::active()->get();
		foreach ($courses as $course) {
			$course->aquisti = $course->ordersItems()->type()->sum('qty') ?? 0;
			$total = 0;
			foreach ($course->ordersItems()->type()->get() as $order):

				$total += $order->qty * $order->price;

			endforeach;
			$course->total = price_formater($total);
			$course->admin = $course->cartCourseTransactions()->type(CourseTransactions::TYPE_ADMIN_ADDED)->sum('qty') ?? 0;
		}
		return $courses;
	}
	public function index()
	{
		$courses = $this->adminCourses();
		return view('struture.storehouse.admin', compact('courses'));
	}

	public function exportIndex(){
		return Excel::download(new StorehouseAdminExport($this->adminCourses()),'personale.xlsx');
	}

	public function personal()
	{
		$user_id = 37; //to be replaced with auth()->id();
		$courses = $this->getAvailableCourses($user_id);
		return view('struture.storehouse.personal', compact('courses'));
	}

	public function getAvailableCourses($user_id)
	{
		$courses = Course::whereHas('cartCourseTransactions', function ($query) use ($user_id) {
			$query->whereHas('owner', function ($query) use ($user_id) {
				$query->where('user_id', $user_id);
			});
		}
		)->get(['id', 'name']);
		foreach ($courses as $course):
			$course->available_qty = $course->cartCourseTransactions->where('user_id', $user_id)->sum('qty');
			$course->purchased_qty = $course->cartCourseTransactions()->where('user_id', $user_id)->type(CourseTransactions::TYPE_COURSE_PURCHASE)->where('order_id', '<>', 0)->sum('qty');
			$course->refunded_qty = $course->cartCourseTransactions()->where('user_id', $user_id)->type(CourseTransactions::TYPE_COURSE_REFUND)->sum('qty');
			$course->assigned_qty = abs($course->cartCourseTransactions()->where('user_id', $user_id)->type(CourseTransactions::TYPE_COURSE_REQUEST)->sum('qty'));
			$course->admin_qty = $course->cartCourseTransactions()->where('user_id', $user_id)->type(CourseTransactions::TYPE_ADMIN_ADDED)->sum('qty');
			$course->distributed_qty = abs($course->cartCourseTransactions()->where('user_id', $user_id)->type(CourseTransactions::TYPE_COURSE_DISTRIBUTE)->sum('qty')) - abs($course->cartCourseTransactions()->where('user_id', $user_id)->type(CourseTransactions::TYPE_COURSE_PURCHASE)->where('order_id', 0)->sum('qty'));
		endforeach;
		return $courses;
	}

	public function indexPartner()
	{
		return view('struture.storehouse.storehouse')->with([
			'type' => Structure::TYPE_PARTNER,
			'structure_type' => 'Partner',
			'structures' => $this->getStructureCourses(Structure::TYPE_PARTNER)
		]);
	}

	public function indexMaster()
	{

		return view('struture.storehouse.storehouse')->with([
			'type' => Structure::TYPE_MASTER,
			'structure_type' => 'Master',
			'structures' => $this->getStructureCourses(Structure::TYPE_MASTER)
		]);
	}

	public function indexAffiliate()
	{
		return view('struture.storehouse.storehouse')->with([
			'type' => Structure::TYPE_AFFILIATE,
			'structure_type' => 'Affiliate',
			'structures' => $this->getStructureCourses(Structure::TYPE_AFFILIATE)
		]);

	}

	/**
	 * @param $type
	 * @return mixed
	 */
	public function getStructureCourses($type){
		if (auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)) {
			$structures = Structure::where('type', $type)->get(['user_id', 'legal_name']);
		} else {
			$structures = Structure::where('type', $type)->where('parent_structure_id', auth()->user()->structure->id)->get(['user_id', 'legal_name']);
		}
		foreach ($structures as $structure):
			$structure->courses = $this->getAvailableCourses($structure->user_id);
		endforeach;
		return $structures;
	}

	public function exportStructureStorehouse(){
		if (request()->structure){
			$structure =	Structure::findByHashid(request()->structure);
			$structure->courses = $this->getAvailableCourses($structure->user_id);
			return Excel::download(new StructureStoreHouseExport($structure,true),'storehouse.xlsx');
		}
		return Excel::download(new StructureStoreHouseExport($this->getStructureCourses(request()->type)),'storehouse.xlsx');

	}
}
