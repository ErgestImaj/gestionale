<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CertificatesExport;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Maatwebsite\Excel\Facades\Excel;

class CertificateController extends Controller
{
	public function export()
	{
		return Excel::download(new CertificatesExport(request()->from_date, request()->to_date, request()->course), 'certificate.xlsx');
	}

	public function index()
	{
		return Certificate::with([
			'user' => function ($query) {
				$query->select(['id', 'firstname', 'lastname', 'username']);
			},
			'examSession' => function ($query) {
				$query->select(['id', 'course_id', 'date', 'user_id']);
			},
			'examSession.course' => function ($query) {
				$query->select(['id', 'name']);
			},
			'examSession.owner' => function ($query) {
				$query->select(['id', 'firstname', 'username']);
			}
		])->get(['type', 'user_id', 'exam_session_id', 'date_issue']);

	}
}
