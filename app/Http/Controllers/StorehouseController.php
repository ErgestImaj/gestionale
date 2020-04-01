<?php

namespace App\Http\Controllers;

use App\Models\Cart\CartCourseTransactions;
use App\Models\Course;
use App\Models\Structure;
use App\Models\User;

class StorehouseController extends Controller
{
	public function index()
	{
		$courses = Course::active()->get();
		foreach ($courses as $course) {
			$course->aquisti = $course->ordersItems()->type()->sum('qty') ?? 0;
			$total = 0;
			foreach ($course->ordersItems()->type()->get() as $order):

				$total += $order->qty * $order->price;

			endforeach;
			$course->total = price_formater($total);
			$course->admin = $course->cartCourseTransactions()->type(CartCourseTransactions::TYPE_ADMIN_ADDED)->sum('qty') ?? 0;
		}
		return view('struture.storehouse.admin', compact('courses'));
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
			$course->purchased_qty = $course->cartCourseTransactions()->where('user_id', $user_id)->type(CartCourseTransactions::TYPE_COURSE_PURCHASE)->where('order_id', '<>', 0)->sum('qty');
			$course->refunded_qty = $course->cartCourseTransactions()->where('user_id', $user_id)->type(CartCourseTransactions::TYPE_COURSE_REFUND)->sum('qty');
			$course->assigned_qty = abs($course->cartCourseTransactions()->where('user_id', $user_id)->type(CartCourseTransactions::TYPE_COURSE_REQUEST)->sum('qty'));
			$course->admin_qty = $course->cartCourseTransactions()->where('user_id', $user_id)->type(CartCourseTransactions::TYPE_ADMIN_ADDED)->sum('qty');
			$course->distributed_qty = abs($course->cartCourseTransactions()->where('user_id', $user_id)->type(CartCourseTransactions::TYPE_COURSE_DISTRIBUTE)->sum('qty')) - abs($course->cartCourseTransactions()->where('user_id', $user_id)->type(CartCourseTransactions::TYPE_COURSE_PURCHASE)->where('order_id', 0)->sum('qty'));
		endforeach;
		return $courses;
	}

	public function indexPartner()
	{

		$structures = Structure::where('type', Structure::TYPE_PARTNER)->get(['user_id', 'legal_name']);
		foreach ($structures as $structure):
			$structure->courses = $this->getAvailableCourses($structure->user_id);
		endforeach;

		return view('struture.storehouse.storehouse')->with([
			'type' => Structure::TYPE_PARTNER,
			'structure_type' => 'Partner',
			'structures' => $structures
		]);
	}

	public function indexMaster()
	{
		if (auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)) {
			$structures = Structure::where('type', Structure::TYPE_MASTER)->get(['user_id', 'legal_name']);
		} else {
			$structures = Structure::where('type', Structure::TYPE_MASTER)->where('parent_structure_id', auth()->user()->structure->id)->get(['user_id', 'legal_name']);
		}

		foreach ($structures as $structure):
			$structure->courses = $this->getAvailableCourses($structure->user_id);
		endforeach;

		return view('struture.storehouse.storehouse')->with([
			'type' => Structure::TYPE_PARTNER,
			'structure_type' => 'Master',
			'structures' => $structures
		]);
	}

	public function indexAffiliate()
	{
		if (auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)) {
			$structures = Structure::where('type', Structure::TYPE_AFFILIATE)->get(['user_id', 'legal_name']);
		} else {
			$structures = Structure::where('type', Structure::TYPE_AFFILIATE)->where('parent_structure_id', auth()->user()->structure->id)->get(['user_id', 'legal_name']);
		}
		foreach ($structures as $structure):
			$structure->courses = $this->getAvailableCourses($structure->user_id);
		endforeach;
		return view('struture.storehouse.storehouse')->with([
			'type' => Structure::TYPE_PARTNER,
			'structure_type' => 'Affiliate',
			'structures' => $structures
		]);

	}
}
