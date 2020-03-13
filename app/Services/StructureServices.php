<?php


namespace App\Services;


use App\Models\Structure;

class StructureServices
{
     public static function dataForVue(Structure $structure){

			 $status_details = [
				 'status_mf'=>$structure->status->status ?? '',
				 'data_mf'=>format_date($structure->status->date) ?? '',
				 'status_lrn'=>$structure->status->status_lrn ?? '',
				 'data_lrn'=>format_date($structure->status->date_lrn) ?? '',
				 'status_dile'=>$structure->status->status_dile ?? '',
				 'data_dile'=>format_date($structure->status->date_dile) ?? '',
				 'status_miur'=>$structure->status->status_miur ?? '',
				 'data_miur'=>format_date($structure->status->date_miur) ?? '',
				 'status_iiq'=>$structure->status->status_iiq ?? '',
				 'data_iiq'=>format_date($structure->status->date_iiq) ?? '',
			 ];
			 $structure_details =[
				 'name'=>$structure->name,
				 'legal_name'=>$structure->legal_name,
				 'piva'=>$structure->piva,
				 'tax_code'=>$structure->tax_code,
				 'legal_country'=>$structure->county->name ?? '',
				 'legal_region'=>$structure->region->title ?? '',
				 'legal_prov'=>$structure->province->title ?? '',
				 'legal_town'=>$structure->town->title ?? '',
				 'legal_address'=>$structure->legal_address,
				 'legal_zipcode'=>$structure->legal_zipcode,
				 'operational_country'=>$structure->operationalCountry->name ?? '',
				 'operational_region'=>$structure->operationalRegion->title ?? '',
				 'operational_prov'=>$structure->operationalProvince->title ?? '',
				 'operational_town'=>$structure->operationalTown->title ?? '',
				 'operational_address'=>$structure->operational_address,
				 'operational_zipcode'=>$structure->operational_zipcode,
				 'phone'=>$structure->phone,
				 'fax'=>$structure->fax,
				 'email'=>$structure->email,
				 'pec'=>$structure->pec,
				 'webiste'=>$structure->website,
				 'codice_destinatario'=>$structure->codice_destinatario,
				 'structura_madre'=>$structure->parent->legal_name ?? '',
				 'lrn_code'=>$structure->lrn,
				 'profile_img'=>$structure->content_path.$structure->token.DIRECTORY_SEPARATOR.$structure->image,
				 'visura_camerale'=>$structure->content_path.$structure->token.DIRECTORY_SEPARATOR.$structure->visura_camerale,
				 'validation_request'=>$structure->content_path.$structure->token.DIRECTORY_SEPARATOR.$structure->validation_request,
				 'minimum_order'=>$structure->minimum_order

			 ];
			 $user_details=[
				 'created_by'=>$structure->user->display_name,
				 'updated_by'=>$structure->updatedByUser->display_name ?? '',
				 'created_at'=>format_date($structure->created) ?? '',
				 'updated_at'=>format_date($structure->updated) ?? '',
				 'state'=>$structure->user->state,
				 'username'=>$structure->owner->username,
				 'locked'=>format_date($structure->user->locked) ?? '',
				 'locked_by'=>format_date($structure->user->locked) ?? '',
				 'last_login_id'=>$structure->user->last_login_ip,
				 'last_login'=>diffForHumans($structure->user->last_login),
			 ];

			 return [
				 'status_details'=>$status_details,
				 'structure_details'=>$structure_details,
				 'user_details'=>$user_details
			 ];
		 }

}
