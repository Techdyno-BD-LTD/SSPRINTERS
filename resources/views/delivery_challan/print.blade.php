<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Challan Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 210mm;
            height: 297mm;
            padding: 10mm;
            box-sizing: border-box;
            position: relative;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .invoice__number{
            font-weight: 600;
            margin-top: -35px !important
        }
        .header img {
            width: 100px;
            height: auto;
            top: 15%;
            left: 54px;
            transform: translate(-50%, -50%);
            position: absolute;
        }
        .info-right td {
            padding: 2px 0;
            border: 1px solid !important;
            padding-left: 8px !important;
        }
        .header h1 {
            margin: 0;
            z-index: 2;
        }
        .header p {
            margin: 5px 0;
            z-index: 2;
        }
        .content {
            margin-top: 20px;
            position: relative;
            z-index: 2;
        }
        .info-table, .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            position: relative;
            z-index: 2;
        }
        .info-table td, .items-table th, .items-table td {
            border: 1px solid black;
            padding: 2px;
        }
        .items-table td{
            text-align: center;
        }
        .left__td{
            text-align: left !important;
        }
        .info-table {
            margin-bottom: 20px;
        }
        .info-table td {
            width: 50%;
            vertical-align: top;
        }
        .info-left {
            text-align: left;
            border: 0;
        }
        .info-right table {
            width: 100%;
            border: none;
            border-collapse: collapse;
        }
        .info-right td {
            border: none;
            padding: 2px 0;
        }
        .items-table th {
            background-color: #f2f2f2;
        }
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }
        .text-right {
            text-align: right;
        }
        .noprint {
            display: block;
            position: absolute;
            right: 0;
            background-color: green;
            border-color: green;
            padding: 5px 10px;
            color: #ffffff;
            cursor: pointer;
        }
        @media print {
            .noprint {
                display: none;
            }
        }
    </style>
</head>
<body>

<button class="noprint" onclick="window.print()">Print</button>

<div class="header">
    <img src="{{ getLogoUrl() }}" alt="SS Printers Logo">
    <h1>SS Printers</h1>
    <p>Ka-32, Shahjadpur, Gulshan-2, Dhaka-1212, Contact: 01788800019</p>
    <p>E-mail: ssprintersbd01@gmail.com</p>
    <h2>Delivery Challan</h2>
</div>

<div class="content">
    <table class="info-table" border="0">
        @php
            $invoice_data = getinvoicedetails($deliveryChallan->invoice_id);
        @endphp
        <tr>
            <td class="info-left" style="border: 0;">
                <div class="invoice__number">{{ sprintf('%04d', @$invoice_data->id) }}</div><br>
                To<br>
                {{ @$invoice_data->client->company_name }}<br>
                {!! @$invoice_data->client->address !!}<br>
                {!! @$invoice_data->client->note !!}<br>
                {!! @$invoice_data->client->postal_code !!}<br>
            </td>
            <td class="info-right">
                <table>
                    <tr>
                        <td>Date:</td>
                        <td>{{ \Carbon\Carbon::parse($deliveryChallan->created_at)->format('j M Y') }}</td>
                    </tr>
                    <tr>
                        <td>Buyer:</td>
                        <td>{{ @$deliveryChallan->buyer }}</td>
                    </tr>
                    <tr>
                        <td>Style:</td>
                        <td>{{ $invoice_data->style_number }}</td>
                    </tr>
                    <tr>
                        <td>PO:</td>
                        <td>{{ $invoice_data->po_number }}</td>
                    </tr>
                    <tr>
                        <td>PO Prov.:</td>
                        <td>{{ $deliveryChallan->po_provider }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <tr>
            <th>Sl. No.</th>
            <th>Description of Items</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Remarks</th>
        </tr>
        @foreach ($deliveryChallan->items as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="left__td">{{ $item->product_name }}<br><div class="text-right">{{ $item->variation }}</div></td>
            <td>{{ $item->quantity }}</td>
            <td>Pcs</td>
            <td>{{ $item->remarks }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2">Total</td>
            <td>{{ $deliveryChallan->items->sum('quantity') }}</td>
            <td>Pcs</td>
            <td></td>
        </tr>
    </table>
</div>

<div class="signature">
    <p>Receiver's Signature</p>
    <p>Authorized Signature</p>
</div>

</body>
</html>

<script>
    $(document).ready(function() {
        // Uncomment the line below if you want the print dialog to open automatically on page load
        // window.print();
    });
</script>
