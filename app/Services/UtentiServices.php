<?php


namespace App\Services;


use App\Models\User;

class UtentiServices
{
    public static function basicUserEditData(User $user){
			$corsi = [];
			if($user->getUserRole() == User::TUTOR){
				$corsi = $user->userCourses()->pluck('id');
			}
			$user_data =[
				'first_name'=>$user->firstname,
				'last_name'=>$user->lastname,
				'email'=>$user->email,
				'id'=>$user->id,
				'avatar'=>$user->avatar_url
			];
			return [
				'corsi'=>$corsi,
				'user'=>$user_data
			];
		}

		public static function advancedUserEditData(User $user){

		  $corsi = $user->userCourses()->pluck('id');

			$user_data =[
				'firstname'=>$user->firstname,
				'lastname'=>$user->lastname,
				'email'=>$user->email,
				'avatar'=>$user->avatar_url
			];

			return [
				'corsi'=>$corsi,
				'user'=>$user_data,
				'user_info'=>$user->userInfo
			];

		}
	public static function advancedUserShowData(User $user){
    $base_info = $personal_info = $address_info = $education = $other_info =[];
    $base_info['corsi']=	$user->userCourses()->pluck('name');
    if ($user->userInfo()->exists()){
			$base_info=[
				'phone'=>$user->userInfo->phone,
				'mobile'=>$user->userInfo->mobile,
				'lrn_user'=>$user->userInfo->types,
			];
			$personal_info=[
				'fiscal_code'=>$user->userInfo->fiscal_code,
				'gender'=>$user->userInfo->gender,
				'birth_date'=>format_date($user->userInfo->birth_date),
				'avatar'=>$user->avatar_url,
				'birth_place'=>optional($user->userInfo->birthPlace)->title ?? '',
				'nationality'=>optional($user->userInfo->userNationality)->name ?? '',
			];
			$address_info=[
				'country'=>optional($user->userInfo->userCountry)->name ?? '',
				'region'=>optional($user->userInfo->userRegion)->title ?? '',
				'prov'=>optional($user->userInfo->userProv)->title ?? '',
				'town'=>optional($user->userInfo->userTown)->title ?? '',
				'address'=>$user->userInfo->address,
				'zipcode'=>$user->userInfo->zipcode,
			];
			$education=[
				'high_school_diploma_name'=>$user->userInfo->high_school_diploma_name,
				'high_school_diploma_institute'=>$user->userInfo->high_school_diploma_institute,
				'university_degree_faculty'=>$user->userInfo->university_degree_faculty,
				'university_degree_name'=>$user->userInfo->university_degree_name,
				'university_degree_institute'=>$user->userInfo->university_degree_institute,
				'high_school_diploma_date'=>format_date($user->userInfo->high_school_diploma_date),
				'university_degree_date'=>format_date($user->userInfo->university_degree_date),
			];
			$other_info = [
				'document_expire_date'=>format_date($user->userInfo->document_expire_date),
//				'created'=>format_date($user->userInfo->created),
//				'updated'=>format_date($user->userInfo->updated),
//				'created_by'=>optional($user->userInfo->user)->display_name ?? '',
//				'updated_by'=>optional($user->userInfo->updatedByUser)->display_name ?? '',
				'school_region'=>optional($user->userInfo->userSchoolRegion)->title ?? '',
				'structure'=>optional($user->userInfo->structure)->legal_name ?? '',
				'school_name'=>$user->userInfo->school_name,
				'school_codice_meccanografico'=>$user->userInfo->school_codice_meccanografico,
				'education'=>optional($user->userInfo->userEducation)->title ?? '',
				'employment'=>optional($user->userInfo->job)->title ?? '',
				'document_type'=>optional($user->userInfo->documentType)->name ?? '',
				'document_number'=>$user->userInfo->document_number,
				'cv_exists'=>$user->userInfo->cv ? true:false,
				'document_exists'=>$user->userInfo->document ? true:false,
				'cv'=>$user->userInfo->content_path.$user->userInfo->token.DIRECTORY_SEPARATOR.$user->userInfo->cv,
				'document'=>$user->userInfo->content_path.$user->userInfo->token.DIRECTORY_SEPARATOR.$user->userInfo->document,
			];
		}
		$user_details=[
			'firstname'=>$user->firstname,
			'lastname'=>$user->lastname,
			'email'=>$user->email,
			'created_by'=>$user->user->display_name,
			'display_name'=>$user->display_name,
			'updated_by'=>$user->updatedByUser->display_name ?? '',
			'created_at'=>format_date($user->created),
			'updated_at'=>format_date($user->updated),
			'last_login_id'=>$user->last_login_ip,
			'last_login'=>diffForHumans($user->last_login),
		];
		return [
			'base_info'=>$base_info,
			'user_details'=>$user_details,
			'personal_info'=>$personal_info,
			'address_info'=>$address_info,
			'education'=>$education,
			'other_info'=>$other_info,
		];
	}
}
