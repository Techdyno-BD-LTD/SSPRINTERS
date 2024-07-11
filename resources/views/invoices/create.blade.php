@extends('layouts.app')
@section('title')
    {{ __('messages.invoice.new_invoice') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end">
                <a class="btn btn-outline-primary float-end"
                   href="{{ url()->previous() }}">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('layouts.errors')
                    <div class="alert alert-danger display-none hide" id="validationErrorsBox"></div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'invoices.store', 'id' => 'invoiceForm', 'name' => 'invoiceForm']) }}
                    @include('invoices.fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    @include('invoices.templates.templates')
    {{ Form::hidden('clients',json_encode($clients, true),['id' => 'clients']) }}
    {{ Form::hidden('products',json_encode($associateProducts, true),['id' => 'products']) }}
    {{ Form::hidden('taxes',json_encode($associateTaxes, true),['id' => 'taxes']) }}
    {{ Form::hidden('invoice_note',isset($invoice->note) ,['id' => 'invoiceNote']) }}
    {{ Form::hidden('invoice_term',isset($invoice->term) ,['id' => 'invoiceTerm']) }}
    {{ Form::hidden('invoice_recurring',isset($invoice->recurring) ,['id' => 'invoiceRecurring']) }}
    {{ Form::hidden('thousand_separator',getSettingValue('thousand_separator') ,['id' => 'thousandSeparator']) }}
    {{ Form::hidden('decimal_separator',isset($invoice->recurring) ,['id' => 'decimalSeparator']) }}
    {{ Form::hidden('default_tax',json_encode($defaultTax, true),['id' => 'defaultTax']) }}


    <script>
$(document).ready(function() {
    $('#product_id').on('change', function() {
        var productId = $(this).val();
        var $variationsSelect = $(this).closest('tr').find('select.variations');

        if (productId) {
            $.ajax({
                url: '{{ route("get.product.variations") }}',
                type: 'GET',
                data: { product_id: productId },
                success: function(data) {
                    $variationsSelect.empty(); // Clear previous options
                    $.each(data, function(key, value) {
                        $variationsSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $variationsSelect.trigger('change'); // Reinitialize select2
                }
            });
        } else {
            $variationsSelect.empty(); // Clear previous options
        }
    });
});

$(document).ready(function() {
    $('#po_value, #costing').keyup(function() {
        var poValue = parseFloat($('#po_value').val()) || 0;
        var costing = parseFloat($('#costing').val()) || 0;

        var profitLoss = poValue - costing;
        $('#profit_loss').val(profitLoss);

        var verdict = profitLoss >= 0 ? 'Profit' : 'Loss';
        $('#verdict').val(verdict);
    });
});

</script>
@endsection
