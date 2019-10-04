<h6 class="heading-small text-muted mb-4">User information</h6>
<div class="pl-lg-4">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-control-label" for="input-first-name">Nome</label>
                <input type="text" name="first_name" id="input-first-name" class="form-control @error('first_name') is-invalid @enderror"  placeholder="Nome" value="{{ $user->firstname ?? '' }}">
                @error('first_name')
                <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
               </span>
                @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-control-label" for="input-last-name">Cognome</label>
                <input type="text" name="last_name" id="input-last-name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Cognome" value="{{$user->lastname ?? '' }}">
                @error('last_name')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                 </span>
                @enderror
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-control-label" for="input-email">Email address</label>
                <input type="email" name="email" id="input-email" class="form-control @error('email') is-invalid @enderror" value="{{$user->email ?? ''}}" placeholder="jesse@example.com">
                @error('email')
                <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror

            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-control-label" for="input-password">Password</label>
                <input type="password" name="password" id="input-password" class="form-control  @error('password') is-invalid @enderror">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Immagine Profilo</label>
                <input type="file" name="image" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info @error('image') is-invalid @enderror" disabled placeholder="Upload Image">
                    <span class="input-group-append">
                                              <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                            </span>
                </div>
                @error('image')
                <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                @enderror
            </div>
        </div>
        <div class="col-lg-12">
            <button class="btn-info btn" type="submit ">Salva</button>
        </div>
    </div>
</div>
