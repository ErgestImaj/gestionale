<?php

namespace App\Http\Requests;

use App\Models\Course;
use App\Models\ModuleContent;
use App\Rules\CheckIfModuleBelongsToGivenCourse;
use Illuminate\Foundation\Http\FormRequest;

class LmsContentRequest extends FormRequest
{

    public $is_url = false;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Prepare the data for validation.
     */

    protected function prepareForValidation()
    {
        $content = json_decode($this->get('content'),true);

        $this->merge([
            'title' => isset( $content['title']) ? $content['title'] : '',
            'code'=> isset($content['code']) ? $content['code'] : '',
            'description'=>isset($content['description']) ? $content['description'] : '',
            'course'=> isset($content['course']['id']) ? $content['course']['id'] : '',
            'module'=> isset($content['module']['id']) ? $content['module']['id'] : '',
            'content_type'=> isset($content['content_type']['value']) ? $content['content_type']['value'] : 'text',
            'file_path'=> isset($content['file_path']) ? $content['file_path'] : '',
        ]);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'          	   	       => 'bail|required|max:191' ,
            'code'                         => 'bail|nullable|sometimes',
            'description'                  => 'required_if:content_type,text',
            'course'                       => 'bail|required|exists:courses_courses,id',
            'module'                       => ['bail','required','exists:courses_course_modules,id',new CheckIfModuleBelongsToGivenCourse($this->course)],

        ];

        switch ($this->content_type) {
            case 'url':
            case 'video_url':
            case 'audio_url':
                $rules['file_path'] = 'bail|required|active_url';
                $this->is_url = true;
                break;
            case 'file' :
                $rules['lms_file'] = 'bail|required|mimes:jpeg,png,jpg,pdf';
                break;
            case 'video' :
                $rules['lms_file'] = 'bail|required|mimetypes:video/avi,video/mpeg,video/quicktime,video/x-flv,video/3gpp,video/quicktime,video/mp4';
                $this->file_path = $this->file('lms_file');
                break;
            case 'audio' :
                $rules['lms_file'] = 'bail|required';
                break;

        }

        return  $rules;

    }

    public function fillFormData()
    {
        return [
            'title'=>$this->title,
            'code'=>$this->code,
            'description'=>$this->description,
            'module_id'=>$this->module,
            'is_url'=>$this->is_url,
            'content_type'=>$this->content_type,
            'state'=>ModuleContent::IS_ACTIVE
        ];
    }
}
