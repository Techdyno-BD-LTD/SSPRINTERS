<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performa Invoice Print</title>
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


        /* New Css */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            padding: 10px;
            border: none;
        }
        .no-border {
            border: none;
        }
        .buyer-info, .seller-info {
            width: 50%;
        }
        .buyer-info {
            padding-right: 10px;
        }
        .seller-info {
            padding-left: 10px;
        }
        .contact-info {
            padding: 10px 0;
        }
        /* New Css */


        @media print {
            .noprint {
                display: none;
            }
        }
    </style>
</head>
<body>


    @php
            $invoice_data = getinvoicedetails($deliveryChallan->invoice_id);
        @endphp
<button class="noprint" onclick="window.print()">Print</button>


<div class="content">
    <table>
    <tr>
        <td colspan="2" class="header">PROFORMA INVOICE</td>
    </tr>
    <tr>
        <td>Proforma Invoice No:</td>
        <td>{{ sprintf('%04d', @$deliveryChallan->id) }}</td>
    </tr>
    <tr>
        <td>Date:</td>
        <td>{{ \Carbon\Carbon::parse($deliveryChallan->created_at)->format('j M Y') }}</td>
    </tr>
    <tr>
        <td>Buyer:</td>
        <td>{{ @$deliveryChallan->buyer }}</td>
    </tr>
    <tr>
        <td>REF:</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td class="buyer-info">
                        <strong>Messers (Buyer)</strong><br>
                          {{ @$buyer->user->first_name." ".@$buyer->user->last_name }}<br>
                {!! @$buyer->address !!}<br>
                {!! @$buyer->note !!}<br>
                {!! @$buyer->postal_code !!}<br>
                    </td>
                    <td class="seller-info">
                        <strong>S.S. PRINTERS</strong><br>
                        Ka-32, Shahjadpur, Gulshan,<br>
                        Dhaka-1212<br>
                        Cell: +880-1788800019<br><br>
                        <strong>To:</strong><br>
                         {{ @$provider->user->first_name." ".@$provider->user->last_name }}<br>
                {!! @$provider->address !!}<br>
                {!! @$provider->note !!}<br>
                {!! @$provider->postal_code !!}<br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            The BUYER agree to buy and the VENDOR agree to sell the following products/service(s) with the terms and conditions as stated
        </td>
    </tr>
</table>
      

    <table class="items-table">
        <tr>
            <th>Sl. No.</th>
            <th>PO Number (WFX)</th>
            <th>Description of Items</th>
            <th>Number of Units</th>
            <th>Price/Units</th>
            <th>TOTAL AMOUNT USD</th>
        </tr>
        @php
            $counter = 0;
        @endphp
        @foreach ($invoices as $data)
        @php 
            $counter++;
            $temp_counter = count($data->invoiceItems);
            $count_item = 0;
            $bool = true;
        @endphp
        <tr>
            <td rowspan="{{ count($data->invoiceItems)+1 }}">{{ $counter }}</td>
            <td rowspan="{{ count($data->invoiceItems)+1 }}">{{ $data->po_number }}</td>
             
             @foreach ($data->invoiceItems as $item)
                @if($count_item<=$temp_counter)
                    <tr>
                @endif
            <td class="left__td">{{ $item->product_name }} ({{ $item->variations }})</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->total }}</td>
         @if($count_item>=$temp_counter)
                    </tr>
                @endif
            @php  $count_item++;   @endphp
        @endforeach
        </tr>
         @endforeach

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
