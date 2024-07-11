<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\DeliveryChallan;
use App\Models\DeliveryChallanItem;

class DeliveryChallanController extends Controller
{
    public function create()
    {
        return view('delivery_challan.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'po_number' => 'required|string|max:255',

        ]);


        $deliveryChallan = new DeliveryChallan();
        $deliveryChallan->invoice_id = $request->invoice_id;
        $deliveryChallan->po_number = $request->po_number;
        $deliveryChallan->buyer = $request->buyer;
        $deliveryChallan->po_provider = $request->po_provider;
        $deliveryChallan->save();


        // Save the items
        foreach ($request->items as $item) {
            foreach ($item['variations'] as $variation) {
                if($variation['quantity']){
                DeliveryChallanItem::create([
                    'delivery_challan_id' => $deliveryChallan->id,
                    'invoice_item_id' => $item['invoice_item_id'],
                    'product_name' => $item['product_name'],
                    'variation' => $variation['name'],
                    'quantity' => $variation['quantity'],
                ]);
            }
            }
        }

        return redirect()->route('delivery-challan.index')->with('success', 'Delivery Challan created successfully.');
    }

    public function searchInvoice(Request $request)
    {
        $invoice = Invoice::where('po_number', $request->po_number)->with('invoiceItems')->first();
        return response()->json($invoice);
    }

    public function index(Request $request)
    {   
        $deliveryChallans = DeliveryChallan::where('id','>','0');
        if($request->search){
                $deliveryChallans->where("po_number",'like','%'.$request->search.'%');
        }
        $deliveryChallans = $deliveryChallans->paginate(20);
        return view('delivery_challan.index', compact('deliveryChallans'));
    }

    public function edit($id)
    {
        $deliveryChallan = DeliveryChallan::findOrFail($id);
        return view('delivery_challan.edit', compact('deliveryChallan'));
    }

    public function update(Request $request, $id)
    {
        $deliveryChallan = DeliveryChallan::findOrFail($id);
        $deliveryChallan->update($request->all());
        return redirect()->route('delivery-challan.index')->with('success', 'Delivery Challan updated successfully');
    }

    public function destroy($id)
    {
        DeliveryChallanItem::where('delivery_challan_id',$id)->delete();
        DeliveryChallan::findOrFail($id)->delete();
        return redirect()->route('delivery-challan.index')->with('success', 'Delivery Challan deleted successfully');
    }

    public function show($id)
    {
        $deliveryChallan = DeliveryChallan::findOrFail($id);
        return view('delivery_challan.show', compact('deliveryChallan'));
    }

    public function print($id)
    {
        $deliveryChallan = DeliveryChallan::with(['items'])->where('id',$id)->first();
        return view('delivery_challan.print', compact('deliveryChallan'));
    }
}

