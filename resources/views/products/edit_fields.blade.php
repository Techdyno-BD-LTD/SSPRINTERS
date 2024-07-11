<div class="row gx-10 mb-5">
    <div class="col-lg-4">
        {{ Form::label('name', __('messages.product.name') . ':', ['class' => 'form-label required mb-3']) }}
        <div class="input-group mb-5">
            {{ Form::text('name', $product->name, ['class' => 'form-control', 'placeholder' => __('messages.product.name'), 'required', 'onkeypress' => 'return blockSpecialChar(event)']) }}
        </div>
    </div>
    <div class="col-lg-4">
        {{ Form::label('code', __('messages.product.code') . ':', ['class' => 'form-label required mb-3']) }}
        <span data-bs-toggle="tooltip" data-placement="top" data-bs-original-title="{{ __('messages.flash.click_refresh_icon_generate_product_code') }}">
            <i class="fas fa-question-circle ml-1"></i>
        </span>
        <div class="input-group mb-5">
            {{ Form::text('code', $product->code, ['class' => 'form-control', 'placeholder' => __('messages.product.code'), 'required', 'id' => 'code', 'maxlength' => 6, 'onkeypress' => 'return blockSpecialChar(event)']) }}
            <a class="input-group-text border-0" id="autoCode" href="javascript:void(0)" data-bs-toggle="tooltip" data-placement="right" title="Generate Code">
                <i class="fas fa-sync-alt fs-4"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="mb-5">
            {{ Form::label('category', __('messages.product.category') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::select('category_id', $categories, $product->category_id, ['id' => 'categoryId', 'class' => 'form-select io-select2', 'placeholder' => __('messages.product.category'), 'required', 'data-control' => 'select2', 'onchange' => 'handleCategoryChange(event)']) }}
        </div>
    </div>
    <div class="col-lg-4" id="variations-container">
        <!-- Placeholder for the variations select element -->
    </div>
    <div class="col-lg-4">
        <div class="mb-5">
            {{ Form::label('unit_price', __('messages.product.unit_price') . ':', ['class' => 'form-label mb-3']) }}
            {{ Form::number('unit_price', $product->unit_price, ['id' => 'unitPriceId', 'class' => 'form-control', 'placeholder' => __('messages.product.unit_price'), 'min' => '0', 'step' => '.01', 'oninput' => "validity.valid||(value=value.replace(/\D+/g, '.'))"]) }}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="mb-5">
            {{ Form::label('description', __('messages.product.description') . ':', ['class' => 'form-label mb-3']) }}
            {{ Form::textarea('description', $product->description, ['class' => 'form-control', 'placeholder' => __('messages.product.description'), 'rows' => '5']) }}
        </div>
    </div>
    <div class="col-lg-4 mb-7 d-none">
        <div class="mb-3" io-image-input="true">
            <label for="exampleInputImage" class="form-label">{{ __('messages.product.image') . ':' }}</label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="previewImage" style="background-image: url('{{ !empty($product->product_image) ? $product->product_image : asset('images/default-product.jpg') }}')">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip" title="Change image">
                        <label>
                            <i class="fa-solid fa-pen" id="productImage"></i>
                            <input type="file" id="productImage" name="image" class="image-upload d-none" accept="image/*" />
                            <input type="hidden" name="image_remove">
                        </label>
                    </span>
                </div>
            </div>
            <div class="form-text">{{ __('messages.flash.allowed_file_types_png_jpg_jpeg') }}</div>
        </div>
    </div>
</div>
<div class="float-end">
    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
    <a href="{{ route('products.index') }}" type="reset" class="btn btn-secondary btn-active-light-primary">{{ __('messages.common.cancel') }}</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Trigger the handleCategoryChange function on page load if category is already selected
        const categoryId = document.getElementById('categoryId').value;
        if (categoryId) {
            handleCategoryChange({ target: { value: categoryId } });
        }
    });

    function handleCategoryChange(event) {
        const container = document.getElementById('variations-container');
        const selectedCategory = event.target.value;
        const selectedVariations = "{{ $product->variations }}".split(',');

        // Clear previous select element
        container.innerHTML = '';

        if (selectedCategory) {
            fetch(`/admin/categories/${selectedCategory}/variations`)
                .then(response => response.json())
                .then(data => {
                    if (data && Array.isArray(data)) {
                        const variationsSelect = `
                            <div class="mb-5">
                                {{ Form::label('variations', __('Values') . ':', ['class' => 'form-label required mb-3']) }}
                                <select name="variations[]" id="variations" class="form-select" multiple>
                                    ${data.map(variation => `<option value="${variation.value}" ${selectedVariations.includes(variation.value) ? 'selected' : ''}>${variation.value}</option>`).join('')}
                                </select>
                            </div>
                        `;
                        container.innerHTML = variationsSelect;
                        // Initialize Select2 for the new select element
                        $('#variations').select2();
                    }
                })
                .catch(error => console.error('Error fetching variations:', error));
        }
    }
</script>
