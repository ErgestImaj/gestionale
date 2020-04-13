<?php

namespace App\Exports;

use App\Models\Course;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CoursesExport implements FromView
{

	public function __construct($course = 0, $category = null)
	{
		$this->course = $course;
		$this->category = $category;
	}

	public function view(): View
	{
		$query = Course::query();
		if ($this->course) {
			$query->where('id', $this->course);
		}

		if (!is_null($this->category)) {
			$query->whereHas('category', function ($q) {
				$q->where('type', $this->category);
			});
		}
		$courses = $query->cursor();

		return view('course.export', ['courses' => $courses]);
	}
}
