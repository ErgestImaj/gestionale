<div class="row">
    <div class="col-xl-12 mb-3 order-md-1 order-sm-1 order-lg-0">
        <div class="card">
            <div class="card-body">
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

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="category">{{ucfirst(trans('form.share_with'))}}</label>
                                <select name="category" id="category" class="form-control form-control-lg @error('category') is-invalid @enderror">

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="category">{{ucfirst(trans('form.doc_file'))}}</label>
                                <select name="category" id="category" class="form-control form-control-lg @error('category') is-invalid @enderror">

                                </select>
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
</div>

