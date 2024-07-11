<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerformaInvoice;
use App\Models\Invoice;
use App\Models\Client;

class PerformaInvoiceController extends Controller
{
    //
     public function create()
    {   
        $data = Invoice::all();
        $client = Client::with(['user'])->get();
        return view('performa_invoice.create',compact('data','client'));
    }

    public function index(Request $request)
    {   
        $deliveryChallans = PerformaInvoice::where('id','>','0');
        if($request->search){
                $deliveryChallans->where("po_number",'like','%'.$request->search.'%');
        }
        $deliveryChallans = $deliveryChallans->paginate(20);
        return view('performa_invoice.index', compact('deliveryChallans'));
    }

    public function store(Request $request){
        $performaInvoice = new PerformaInvoice();
        $performaInvoice->po_provider = $request->po_provider;
        $performaInvoice->invoice_ids = implode(',',$request->invoice_id);
        $performaInvoice->save();
        return redirect()->route('performa-invoice.index')->with('success', 'Performa Invoice created successfully');
    }

    public function edit($id)
    {
        $deliveryChallan = PerformaInvoice::findOrFail($id);
        return view('delivery_challan.edit', compact('deliveryChallan'));
    }

    public function update(Request $request, $id)
    {
        $deliveryChallan = PerformaInvoice::findOrFail($id);
        $deliveryChallan->update($request->all());
        return redirect()->route('performa-invoice.index')->with('success', 'Delivery Challan updated successfully');
    }

    public function destroy($id)
    {
        PerformaInvoice::findOrFail($id)->delete();
        return redirect()->route('performa-invoice.index')->with('success', 'Delivery Challan deleted successfully');
    }

    public function show($id)
    {
        $deliveryChallan = DeliveryChallan::findOrFail($id);
        return view('delivery_challan.show', compact('deliveryChallan'));
    }

    public function print($id)
    {
        $deliveryChallan = PerformaInvoice::where('id',$id)->first();
        $provider = Client::with('user')->where('id',$deliveryChallan->po_provider)->first();
        $buyer = Client::with('user')->where('id',$deliveryChallan->po_number)->first();
        $invoices = Invoice::with(['invoiceItems','client'])->whereIn('id',explode(",",$deliveryChallan->invoice_ids))->get();

        return view('performa_invoice.print', compact('deliveryChallan','provider','invoices','buyer','deliveryChallan'));
    }
}
