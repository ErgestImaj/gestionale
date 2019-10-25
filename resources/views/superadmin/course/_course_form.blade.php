<div class="row">
        <div class="col-xl-8 mb-3 order-md-1 order-sm-1 order-lg-0">
            <div class="card">
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">@lang('headers.base_info')</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="course_name">@lang('form.name')</label>
                                    <input type="text" name="course_name" id="course_name" class="form-control @error('course_name') is-invalid @enderror"  value="{{$course->name ?? old('course_name') }}">
                                    @error('course_name')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="category">{{ucfirst(trans('form.category'))}}</label>
                                    <select name="category" id="category" class="form-control form-control-lg @error('category') is-invalid @enderror">
                                        @foreach($categories as $category)
                                            <option value="{{$category->hashid()}}" @if(isset($course) && $course->category->hashid() == $category->hashid()) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="course_code">@lang('form.code')</label>
                                    <input type="text" name="course_code" id="course_code" class="form-control @error('course_code') is-invalid @enderror"  value="{{$course->code ?? old('course_code') }}">
                                    @error('course_code')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="duration">@lang('form.duration')</label>
                                    <input type="text" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror"  value="{{$course->duration ?? old('duration') }}">
                                    @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="expiry">@lang('form.expiry')</label>
                                    <select name="expiry" id="expiry" class="form-control form-control-lg @error('expiry') is-invalid @enderror">
                                        @foreach($expirations as $expiry)
                                            <option value="{{$expiry->hashid()}}" @if(isset($course) && $course->expiration->hashid() == $expiry->hashid()) selected @endif>{{$expiry->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('expiry')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="course_description">@lang('form.description')</label>
                                    <textarea  name="course_description" id="course_description" class=" summernote form-control @error('course_description') is-invalid @enderror">{{$course->description ?? old('course_description') }}</textarea>
                                    @error('course_description')
                                    <span class="invalid-feedback d-block" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="skills">@lang('form.skills')</label>
                                    <textarea  name="skills" id="skills" class="form-control summernote @error('skills') is-invalid @enderror">{{$course->skills ?? old('skills') }}</textarea>
                                    @error('skills')
                                    <span class="invalid-feedback d-block" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                        <label for="program_description">{{trans('form.program_description')}}</label>
                                        <textarea class="form-control summernote" name="program_description" id="program_description" rows="4">{{$course->program_description ?? old('program_description')}}</textarea>
                                        @error('program_description')
                                        <span class="invalid-feedback d-block" role="alert">
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
                </div>
            </div>
        </div>

        <div class="col-xl-4 order-md-0 mb-3 order-sm-0 order-lg-1">
            <div class="card">
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">{{trans('headers.costs_info')}}</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="costo">@lang('form.costo')</label>
                                    <input type="text" name="price" id="costo" class="form-control @error('price') is-invalid @enderror"  value="{{$course->price ?? old('price') }}">
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="min_order_partner">@lang('form.min_order_partner')</label>
                                    <input type="text" name="min_order_partner" id="min_order_partner" class="form-control @error('min_order_partner') is-invalid @enderror"  value="{{$course->min_order_partner ?? old('min_order_partner') }}">
                                    @error('min_order_partner')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="min_order_master">@lang('form.min_order_master')</label>
                                    <input type="text" name="min_order_master" id="min_order_master" class="form-control @error('min_order_master') is-invalid @enderror"  value="{{$course->min_order_master ?? old('min_order_master') }}">
                                    @error('min_order_master')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="min_order_affiliate">@lang('form.min_order_affiliate')</label>
                                    <input type="text" name="min_order_affiliate" id="min_order_affiliate" class="form-control @error('min_order_affiliate') is-invalid @enderror"  value="{{$course->min_order_affiliate ?? old('min_order_affiliate') }}">
                                    @error('min_order_affiliate')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="vat_rate">@lang('form.vat_rate')</label>
                                    <select name="vat_rate" id="vat_rate" class="form-control form-control-lg @error('vat_rate') is-invalid @enderror">
                                        @foreach($vatrates as $vat)
                                            <option value="{{$vat->hashid()}}" @if(isset($course) && $course->vatRate->hashid() == $vat->hashid()) selected @endif>{{$vat->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('vat_rate')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

