<?php

namespace App\Models\Exams;

use Illuminate\Database\Eloquent\Model;

class MediaformExamSessionCms extends Model
{
	public $timestamps =false;
	protected $table = 'utilities_exam_session_cms';
	protected $guarded = [];
	protected $casts = [
		'files' => 'array',
	];
}
