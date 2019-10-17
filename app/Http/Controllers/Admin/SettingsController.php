<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillsRequest;
use App\Http\Requests\EmailSettingsRequest;
use App\Http\Requests\IBANRequest;
use App\Http\Requests\PayPalRequest;
use App\Http\Requests\PriceRequest;
use App\Http\Requests\StripeRequest;
use App\Http\Requests\UtilitiesRequest;
use App\Http\Requests\VatRequest;
use App\Models\Config;
use App\Models\UserGroups;
use App\Models\VatRate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SettingsController extends Controller
{

    public function permissionSettings(){

        $usergroups = UserGroups::with('usersCount')->orderBy('name')->cursor();

        return view('superadmin.settings.permission',
                           [
                               'usergroups'=>$usergroups
                           ]
        );
    }

    public function changeGroupStatus(UserGroups $userGroups){
        $userGroups->isActive() ? $userGroups->disableGroup() : $userGroups->activeGroup();
        if ($userGroups->update()){
            toastr()->success(trans('messages.change_status'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();
    }

    public function maintenance(){
        $mode = config('maintenance.maintenace_mode');
        return view('superadmin.settings.maintenance',[
               'mode'=>$mode,
        ]);
    }

    public function setMaintenaceMode(Request $request){

        setEnvironmentValue( [
            'MAINTENANCE_MODE' => $request->input('status') == 'on' ? 1 : 0,
        ] );

        toastr()->success(trans('messages.change_status'));
        return back();

    }

    public function emailSettings(){

        $config = Config::where('name', 'utilities')->pluck('config_values')->first();

        return view('superadmin.settings.emails',[
            'config'=>$config,
            'host'=>config('mail.host'),
            'port'=>config('mail.port'),
            'address'=>config('mail.from.address'),
            'name'=>config('mail.from.name'),
            'encryption'=>config('mail.encryption'),
            'username'=>config('mail.username'),
            'password'=>config('mail.password'),
        ]);
    }
    public function updateEmailSettings(UtilitiesRequest $request,$key){

        if ($key !='utilities'){
            toastr()->error(trans('messages.error'));
            return back();
        }

        $utilities  = Config::where('name', 'utilities')->firstOrFail();
        $data_array = $utilities->config_values;
        $filtered = Arr::set(  $data_array, 'lrn_email',  $request->input('lrn_email'));
        $filtered = Arr::set(  $filtered, 'lrn_email_cc',  $request->input('lrn_email_cc'));
        $filtered = Arr::set(  $filtered, 'support_email',  $request->input('support_email'));

        $utilities->config_values = $filtered;
        if ( $utilities->push()){
            toastr()->success(trans('messages.success'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();


    }
    public function updateEmailSMTPSettings(EmailSettingsRequest $request){

        setEnvironmentValue( [
            'MAIL_HOST' => $request->input('mail_host'),
            'MAIL_PORT' => $request->input('mail_port'),
            'MAIL_FROM_ADDRESS' => $request->input('email_address')??'',
            'MAIL_FROM_NAME' => $request->input('email_name') ?? '',
            'MAIL_ENCRYPTION' => $request->input('encryption') ?? '',
            'MAIL_USERNAME' => $request->input('username'),
            'MAIL_PASSWORD' => $request->input('password'),
        ] );

        toastr()->success(trans('messages.success'));
        return back();

    }

    public function PaymentSettings(){
        $config = Config::where('name', 'cart')->pluck('config_values')->first();

        return view('superadmin.settings.payment',[
            'config'=>$config
        ]);
    }
    public function updateIBANSettings(IBANRequest $request,$key){

        if ($key !='cart'){
            toastr()->error(trans('messages.error'));
            return back();
        }

        $utilities  = Config::where('name', 'cart')->firstOrFail();
        $data_array = $utilities->config_values;
        $filtered = Arr::set(  $data_array, 'cart_iban',  $request->input('cart_iban'));
        $filtered = Arr::set(  $filtered, 'cart_cc_postale',  $request->input('cart_cc_postale'));
        $filtered = Arr::set(  $filtered, 'cart_intestazione',  $request->input('cart_intestazione'));

        $utilities->config_values = $filtered;
        if ( $utilities->push()){
            toastr()->success(trans('messages.success'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();


    }
    public function updatePayPalSettings(PayPalRequest $request,$key){

        if ($key !='cart'){
            toastr()->error(trans('messages.error'));
            return back();
        }

        $utilities  = Config::where('name', 'cart')->firstOrFail();
        $data_array = $utilities->config_values;
        $filtered = Arr::set(  $data_array, 'api_username',  $request->input('api_username'));
        $filtered = Arr::set(  $filtered, 'api_signature',  $request->input('api_signature'));
        $filtered = Arr::set(  $filtered, 'api_password',  $request->input('api_password'));
        $filtered = Arr::set(  $filtered, 'api_currency',  strtoupper($request->input('api_currency')));

        $utilities->config_values = $filtered;
        if ( $utilities->push()){
            toastr()->success(trans('messages.success'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();


    }
    public function updateStripeSettings(StripeRequest $request,$key){

        if ($key !='cart'){
            toastr()->error(trans('messages.error'));
            return back();
        }

        $utilities  = Config::where('name', 'cart')->firstOrFail();
        $data_array = $utilities->config_values;
        $filtered = Arr::set(  $data_array, 'stripe_key',  $request->input('stripe_key'));
        $filtered = Arr::set(  $filtered, 'stripe_secret',  $request->input('stripe_secret'));

        $utilities->config_values = $filtered;
        if ( $utilities->push()){
            toastr()->success(trans('messages.success'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();

    }
    public function updateBillsSettings(BillsRequest $request,$key){

        if ($key !='cart'){
            toastr()->error(trans('messages.error'));
            return back();
        }

        $utilities  = Config::where('name', 'cart')->firstOrFail();
        $data_array = $utilities->config_values;
        $filtered = Arr::set(  $data_array, 'invoice_mediaform_piva',  $request->input('invoice_mediaform_piva'));
        $filtered = Arr::set(  $filtered, 'invoice_mediaform_cf',  $request->input('invoice_mediaform_cf'));
        $filtered = Arr::set(  $filtered, 'invoice_mediaform_tel',  $request->input('invoice_mediaform_tel'));
        $filtered = Arr::set(  $filtered, 'invoice_mediaform_fax',  $request->input('invoice_mediaform_fax') ?? '');
        $filtered = Arr::set(  $filtered, 'invoice_mediaform_address',  $request->input('invoice_mediaform_address') ?? '');

        $utilities->config_values = $filtered;
        if ( $utilities->push()){
            toastr()->success(trans('messages.success'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();

    }
    public function updatePriceSettings(PriceRequest $request,$key){

        if ($key !='cart'){
            toastr()->error(trans('messages.error'));
            return back();
        }

        $utilities  = Config::where('name', 'cart')->firstOrFail();
        $data_array = $utilities->config_values;
        $filtered = Arr::set(  $data_array, 'mediaform_structure_accreditation_price',  $request->input('mediaform_structure_accreditation_price'));
        $filtered = Arr::set(  $filtered, 'mediaform_former_accreditation_price',  $request->input('mediaform_former_accreditation_price'));
        $filtered = Arr::set(  $filtered, 'mediaform_supervisor_accreditation_price',  $request->input('mediaform_supervisor_accreditation_price'));
        $filtered = Arr::set(  $filtered, 'mediaform_examiner_accreditation_price',  $request->input('mediaform_examiner_accreditation_price'));
        $filtered = Arr::set(  $filtered, 'lrn_structure_accreditation_price',  $request->input('lrn_structure_accreditation_price'));
        $filtered = Arr::set(  $filtered, 'lrn_examiner_accreditation_price',  $request->input('lrn_examiner_accreditation_price'));
        $filtered = Arr::set(  $filtered, 'lrn_invigilator_accreditation_price',  $request->input('lrn_invigilator_accreditation_price'));
        $filtered = Arr::set(  $filtered, 'price_certificate_duplicate',  $request->input('price_certificate_duplicate'));
        $filtered = Arr::set(  $filtered, 'fast_track_price',  $request->input('fast_track_price'));
        $filtered = Arr::set(  $filtered, 'price_for_extra_shipment',  $request->input('price_for_extra_shipment'));

        $utilities->config_values = $filtered;
        if ( $utilities->push()){
            toastr()->success(trans('messages.success'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();

    }

    public function ivaSettings(){
        $vats = VatRate::cursor();
        return view('superadmin.settings.iva',[
            'vats'=>$vats
        ]);
    }

    public function addIvaSettings(VatRequest $request){
        $vat = VatRate::create([
           'name'=> $request->input('vat_name'),
           'value'=> convert_to_price($request->input('vat_value'))
        ]);

        if ( $vat){
            toastr()->success(trans('messages.success'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();
    }
    public function updateIvaSettings(VatRequest $request,VatRate $rate){

        $rate->name = $request->input('vat_name');
        $rate->value = convert_to_price($request->input('vat_value'));
        if ( $rate->update()){
            toastr()->success(trans('messages.success'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();
    }
    public function destroyIvaSettings(VatRate $rate){
        $rate->delete();
        return response( [
            'status' => 'success',
            'msg'    => trans('messages.delete')
        ] );
    }
}
