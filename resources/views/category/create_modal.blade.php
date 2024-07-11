<div id="addCategoryModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{__('messages.category.add_category')}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'addNewCategoryForm']) }}
            <div class="modal-body scroll-y">
                <div class="alert alert-danger display-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-sm-12 mb-5">
                        {{ Form::label('name', __('messages.common.name').':', ['class' => 'form-label required mb-3']) }}
                        {{ Form::text('name', null, ['id'=>'name','class' => 'form-control ','required','placeholder' => __('messages.common.name')]) }}
                    </div>
                    <div class="form-group col-sm-12 mb-5">
                        {{ Form::label('variations', __('Variations').':', ['class' => 'form-label required mb-3']) }}
                         {{ Form::text('variations', null, ['id'=>'name','class' => 'form-control ','required','placeholder' => __('Variations')]) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary me-3','id' => 'btnSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" class="btn btn-secondary btn-active-light-primary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>


@push('scripts')
<script src="{{ asset('assets/js/tagify.js') }}"></script>
<script src="{{ asset('assets/js/tagify.polyfills.min.js') }}"></script>
<link href="{{ asset('assets/css/tagify.css') }}" rel="stylesheet" type="text/css" />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var input = document.querySelector('input[name=variations]');
        new Tagify(input);
    });
</script>
@endpush
