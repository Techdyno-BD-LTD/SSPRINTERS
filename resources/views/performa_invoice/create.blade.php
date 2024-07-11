@extends('layouts.app')
@section('title')
    {{ __('Performa Invoice') }}
@endsection


@section('content')
<div class="container">
    <div class="card">
    <div class="card-body">
    <h1>Create Performa Invoice</h1>
    <form action="{{ route('performa-invoice.store') }}" method="POST" id="chalan_form">
        @csrf

        <div class="form-group">
            <div class="row">
                <div class="row">
                    <div class="col-md-4">
                         <label for="po_provider" class="mb-2">PO Provider</label>
                         <select class="form-select productId product  fw-bold select2 mt-3"  name="po_provider"  required>
                            <option value="">--Select--</option>
                            @foreach($client as $row)
                                <option value="{{ $row->id }}">{{ $row->user->first_name." ".$row->user->last_name }}</option>
                            @endforeach
                         </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="po_number" class="mb-2">PO Number</label>
            <select class="form-select productId product variations  fw-bold select2 mt-3"  name="invoice_id[]"  multiple required>
                <option value="">--Select--</option>
                @foreach($data as $key)
                    <option value="{{ $key->id }}">{{ $key->po_number }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" id="search_invoice" class="btn btn-primary mt-3">Create</button>


    </form>
</div>
</div>
</div>



@endsection
