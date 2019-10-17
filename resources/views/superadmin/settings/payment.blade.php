@extends('layouts.app')
@section('title',trans('menu.payment_settings'))
@section('pagestyle')
    <link rel="stylesheet" href="{{asset('css/addons.css')}}">
@endsection
@section('content')

    <div class="content-single">
        <div class="page-header">
            <h3 class="page-title">
                <span class="text-semibold"><i class="fas fa-list"></i>{{trans('menu.payment_settings')}}</span>
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{trans('headers.system_con')}}</h4>
                <p class="card-description">{{trans('headers.system_con_data')}}</p>
                <div class="mt-4 col-md-8">
                    <div class="accordion" id="accordion" role="tablist">
                        <div class="card">
                            <div class="card-header" role="tab" id="heading-1">
                                <h6 class="mb-0">
                                    <a data-toggle="collapse" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                                        {{trans('headers.iban_data')}}
                                    </a>
                                </h6>
                            </div>
                            <div id="collapse-1" class="collapse @if($errors->has('cart_iban') || $errors->has('cart_cc_postale') || $errors->has('cart_intestazione')) show @endif"
                                 role="tabpanel" aria-labelledby="heading-1" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{route('superadmin.iban.update',['key'=>'cart'])}}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="pl-lg-4">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="cart_iban">{{trans('form.cart_iban')}}</label>
                                                                <input type="text" name="cart_iban" id="cart_iban" class="tags form-control @error('cart_iban') is-invalid @enderror"  value="{{ $config['cart_iban'] ?? '' }}">
                                                                @error('cart_iban')
                                                                <span class="invalid-feedback" role="alert">
                                                                     <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="cart_cc_postale">{{trans('form.cart_cc_postale')}}</label>
                                                                <input type="text" name="cart_cc_postale" id="cart_cc_postale" class="tags form-control @error('cart_cc_postale') is-invalid @enderror"  value="{{@$config['cart_cc_postale'] ?? '' }}">
                                                                @error('cart_cc_postale')
                                                                    <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="cart_intestazione">{{trans('form.cart_intestazione')}}</label>
                                                                <input type="text" name="cart_intestazione" id="cart_intestazione" class="tags form-control @error('cart_intestazione') is-invalid @enderror" value="{{@$config['cart_intestazione'] ?? ''}}">
                                                                @error('cart_intestazione')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <button class="btn-info btn" type="submit ">{{trans('form.save')}}</button>
                                                        </div>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="heading-2">
                                <h6 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                        {{trans('headers.paypal')}}
                                    </a>
                                </h6>
                            </div>
                            <div id="collapse-2" class="collapse @if($errors->has('api_username') || $errors->has('api_signature') || $errors->has('api_password')|| $errors->has('api_currency')) show @endif"
                                 role="tabpanel" aria-labelledby="heading-2" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{route('superadmin.paypal.update',['key'=>'cart'])}}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="pl-lg-4">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="api_username">{{trans('form.username')}}</label>
                                                                <input type="text" name="api_username" id="api_username" class="tags form-control @error('api_username') is-invalid @enderror"  value="{{ $config['api_username'] ?? '' }}">
                                                                @error('api_username')
                                                                <span class="invalid-feedback" role="alert">
                                                                     <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="api_signature">{{trans('form.api_signature')}}</label>
                                                                <input type="text" name="api_signature" id="api_signature" class="tags form-control @error('api_signature') is-invalid @enderror"  value="{{@$config['api_signature'] ?? '' }}">
                                                                @error('api_signature')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="api_password">{{trans('form.api_password')}}</label>
                                                                <input type="text" name="api_password" id="api_password" class="tags form-control @error('api_password') is-invalid @enderror" value="{{@$config['api_password'] ?? ''}}">
                                                                @error('api_password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="api_currency">{{trans('form.api_currency')}}</label>
                                                                <input type="text" name="api_currency" id="api_currency" class="tags form-control @error('api_currency') is-invalid @enderror" value="{{@$config['api_currency'] ?? ''}}">
                                                                @error('api_currency')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <button class="btn-info btn" type="submit ">{{trans('form.save')}}</button>
                                                        </div>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="heading-3">
                                <h6 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                       {{trans('headers.stripe')}}
                                    </a>
                                </h6>
                            </div>
                            <div id="collapse-3" class="collapse @if($errors->has('stripe_key') || $errors->has('stripe_secret')) show @endif" role="tabpanel" aria-labelledby="heading-3" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{route('superadmin.stripe.update',['key'=>'cart'])}}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="pl-lg-4">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="stripe_key">{{trans('form.stripe_key')}}</label>
                                                                <input type="text" name="stripe_key" id="stripe_key" class="tags form-control @error('stripe_key') is-invalid @enderror"  value="{{ $config['stripe_key'] ?? '' }}">
                                                                @error('stripe_key')
                                                                <span class="invalid-feedback" role="alert">
                                                                     <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="stripe_secret">{{trans('form.stripe_secret')}}</label>
                                                                <input type="text" name="stripe_secret" id="stripe_secret" class="tags form-control @error('stripe_secret') is-invalid @enderror"  value="{{@$config['stripe_secret'] ?? '' }}">
                                                                @error('stripe_secret')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <button class="btn-info btn" type="submit ">{{trans('form.save')}}</button>
                                                        </div>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="heading-4">
                                <h6 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                        {{trans('headers.price')}}
                                    </a>
                                </h6>
                            </div>
                            <div id="collapse-4" class="collapse @if($errors->has('mediaform_structure_accreditation_price') ||
                             $errors->has('mediaform_former_accreditation_price') || $errors->has('mediaform_supervisor_accreditation_price')
                             || $errors->has('mediaform_examiner_accreditation_price') || $errors->has('lrn_structure_accreditation_price')
                             || $errors->has('lrn_examiner_accreditation_price') || $errors->has('lrn_invigilator_accreditation_price')
                             || $errors->has('price_certificate_duplicate') || $errors->has('price_for_extra_shipment')|| $errors->has('fast_track_price')) show @endif" role="tabpanel" aria-labelledby="heading-4" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{route('superadmin.price.update',['key'=>'cart'])}}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="pl-lg-4">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="mediaform_structure_accreditation_price">{{trans('form.mediaform_structure_accreditation_price')}}</label>
                                                                <input type="text" name="mediaform_structure_accreditation_price" id="mediaform_structure_accreditation_price" class="tags form-control @error('mediaform_structure_accreditation_price') is-invalid @enderror"  value="{{ $config['mediaform_structure_accreditation_price'] ?? '' }}">
                                                                @error('mediaform_structure_accreditation_price')
                                                                <span class="invalid-feedback" role="alert">
                                                                     <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="mediaform_former_accreditation_price">{{trans('form.mediaform_former_accreditation_price')}}</label>
                                                                <input type="text" name="mediaform_former_accreditation_price" id="mediaform_former_accreditation_price" class="tags form-control @error('mediaform_former_accreditation_price') is-invalid @enderror"  value="{{@$config['mediaform_former_accreditation_price'] ?? '' }}">
                                                                @error('mediaform_former_accreditation_price')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="mediaform_supervisor_accreditation_price">{{trans('form.mediaform_supervisor_accreditation_price')}}</label>
                                                                <input type="text" name="mediaform_supervisor_accreditation_price" id="mediaform_supervisor_accreditation_price" class="tags form-control @error('mediaform_supervisor_accreditation_price') is-invalid @enderror"  value="{{@$config['mediaform_supervisor_accreditation_price'] ?? '' }}">
                                                                @error('mediaform_supervisor_accreditation_price')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="mediaform_examiner_accreditation_price">{{trans('form.mediaform_examiner_accreditation_price')}}</label>
                                                                <input type="text" name="mediaform_examiner_accreditation_price" id="mediaform_examiner_accreditation_price" class="tags form-control @error('mediaform_examiner_accreditation_price') is-invalid @enderror"  value="{{@$config['mediaform_examiner_accreditation_price'] ?? '' }}">
                                                                @error('mediaform_examiner_accreditation_price')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="lrn_structure_accreditation_price">{{trans('form.lrn_structure_accreditation_price')}}</label>
                                                                <input type="text" name="lrn_structure_accreditation_price" id="lrn_structure_accreditation_price" class="tags form-control @error('lrn_structure_accreditation_price') is-invalid @enderror"  value="{{@$config['lrn_structure_accreditation_price'] ?? '' }}">
                                                                @error('lrn_structure_accreditation_price')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="lrn_examiner_accreditation_price">{{trans('form.lrn_examiner_accreditation_price')}}</label>
                                                                <input type="text" name="lrn_examiner_accreditation_price" id="lrn_examiner_accreditation_price" class="tags form-control @error('lrn_examiner_accreditation_price') is-invalid @enderror"  value="{{@$config['lrn_examiner_accreditation_price'] ?? '' }}">
                                                                @error('lrn_examiner_accreditation_price')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="lrn_invigilator_accreditation_price">{{trans('form.lrn_invigilator_accreditation_price')}}</label>
                                                                <input type="text" name="lrn_invigilator_accreditation_price" id="lrn_invigilator_accreditation_price" class="tags form-control @error('lrn_invigilator_accreditation_price') is-invalid @enderror"  value="{{@$config['lrn_invigilator_accreditation_price'] ?? '' }}">
                                                                @error('lrn_invigilator_accreditation_price')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="price_certificate_duplicate">{{trans('form.price_certificate_duplicate')}}</label>
                                                                <input type="text" name="price_certificate_duplicate" id="price_certificate_duplicate" class="tags form-control @error('price_certificate_duplicate') is-invalid @enderror"  value="{{@$config['price_certificate_duplicate'] ?? '' }}">
                                                                @error('price_certificate_duplicate')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="fast_track_price">{{trans('form.fast_track_price')}}</label>
                                                                <input type="text" name="fast_track_price" id="fast_track_price" class="tags form-control @error('fast_track_price') is-invalid @enderror"  value="{{@$config['fast_track_price'] ?? '' }}">
                                                                @error('fast_track_price')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="price_for_extra_shipment">{{trans('form.price_for_extra_shipment')}}</label>
                                                                <input type="text" name="price_for_extra_shipment" id="price_for_extra_shipment" class="tags form-control @error('price_for_extra_shipment') is-invalid @enderror"  value="{{@$config['price_for_extra_shipment'] ?? '' }}">
                                                                @error('price_for_extra_shipment')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <button class="btn-info btn" type="submit ">{{trans('form.save')}}</button>
                                                        </div>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="heading-5">
                                <h6 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                        {{trans('headers.billing_info')}}
                                    </a>
                                </h6>
                            </div>
                            <div id="collapse-5" class="collapse @if($errors->has('invoice_mediaform_piva') || $errors->has('invoice_mediaform_cf') || $errors->has('invoice_mediaform_tel')|| $errors->has('invoice_mediaform_fax')|| $errors->has('invoice_mediaform_address')) show @endif" role="tabpanel" aria-labelledby="heading-5" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="{{route('superadmin.bills.update',['key'=>'cart'])}}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="pl-lg-4">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="invoice_mediaform_piva">{{trans('form.invoice_mediaform_piva')}}</label>
                                                                <input type="text" name="invoice_mediaform_piva" id="invoice_mediaform_piva" class="tags form-control @error('invoice_mediaform_piva') is-invalid @enderror"  value="{{ $config['invoice_mediaform_piva'] ?? '' }}">
                                                                @error('invoice_mediaform_piva')
                                                                <span class="invalid-feedback" role="alert">
                                                                     <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="invoice_mediaform_cf">{{trans('form.invoice_mediaform_cf')}}</label>
                                                                <input type="text" name="invoice_mediaform_cf" id="invoice_mediaform_cf" class="tags form-control @error('invoice_mediaform_cf') is-invalid @enderror"  value="{{@$config['invoice_mediaform_cf'] ?? '' }}">
                                                                @error('invoice_mediaform_cf')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                 </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="invoice_mediaform_tel">{{trans('form.invoice_mediaform_tel')}}</label>
                                                                <input type="text" name="invoice_mediaform_tel" id="invoice_mediaform_tel" class="tags form-control @error('invoice_mediaform_tel') is-invalid @enderror"  value="{{@$config['invoice_mediaform_tel'] ?? '' }}">
                                                                @error('invoice_mediaform_tel')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                 </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="invoice_mediaform_fax">{{trans('form.invoice_mediaform_fax')}}</label>
                                                                <input type="text" name="invoice_mediaform_fax" id="invoice_mediaform_fax" class="tags form-control @error('invoice_mediaform_fax') is-invalid @enderror"  value="{{@$config['invoice_mediaform_fax'] ?? '' }}">
                                                                @error('invoice_mediaform_fax')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                 </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="invoice_mediaform_address">{{trans('form.invoice_mediaform_address')}}</label>
                                                                <input type="text" name="invoice_mediaform_address" id="invoice_mediaform_address" class="tags form-control @error('invoice_mediaform_address') is-invalid @enderror"  value="{{@$config['invoice_mediaform_address'] ?? '' }}">
                                                                @error('invoice_mediaform_address')
                                                                <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                 </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <button class="btn-info btn" type="submit ">{{trans('form.save')}}</button>
                                                        </div>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('js/addons.js')}}"></script>


@endpush
