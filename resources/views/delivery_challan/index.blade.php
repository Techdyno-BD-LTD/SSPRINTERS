@extends('layouts.app')

@section('title')
    {{ __('Delivery Challans') }}
@endsection

@section('content')
    <div class="container-fluid">
        <h1>Delivery Challan</h1>
        
        @include('flash::message')

        <!-- Search Form -->
        <a type="submit" href="{{ route('delivery-challan.create') }}" class="btn btn-primary">New Delivery Challan</a>
        <br>
        <form action="{{ route('delivery-challan.index') }}" method="GET" class="mb-3 mt-5">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request()->query('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="table-responsive">
            <table id="delivery-challan-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Invoice ID</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveryChallans as $deliveryChallan)
                        <tr>
                            <td>{{ $deliveryChallan->po_number }}</td>
                            <td>{{ $deliveryChallan->invoice_id }}</td>
                            <td>{{ $deliveryChallan->created_at }}</td>
                            <td>
                                <a href="{{ route('delivery-challan.edit', $deliveryChallan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('delivery-challan.destroy', $deliveryChallan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                <a href="{{ route('delivery-challan.print', $deliveryChallan->id) }}" class="btn btn-secondary btn-sm">Print</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $deliveryChallans->links() }}
        </div>
    </div>
@endsection
