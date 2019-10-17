<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendModalLabel">{{trans('form.edit')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="editform" action="">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg alert-dismissible fade show" role="alert"
                         style="display:none">
                        <ul></ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success print-success-msg alert-dismissible fade show" role="alert"
                         style="display:none">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="form-group">
                            <label for="vat-name">{{trans('form.name')}}</label>
                            <input type="text" name="vat_name" required class="form-control" placeholder="{{trans('form.name')}}" id="vat-name" >
                        </div>
                        <div class="form-group">
                            <label for="vat-value">{{trans('form.value')}}</label>
                            <input type="text" name="vat_value" required class="form-control" id="vat-value" placeholder="{{trans('form.value')}}">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submit">{{trans('form.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
