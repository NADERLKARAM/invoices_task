<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController extends Controller
{


    public function index()
    {
        $invoices = Invoice::all();

        return view('invoices.index', compact('invoices'));
    }


    public function show($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }

    public function create()
    {
        return view('invoices.createnIvoice');
    }
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_mobile' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.name' => 'required|string|max:255',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.discount' => 'required|numeric|min:0|max:100',
        ]);

        $invoice = Invoice::create([
            'client_name' => $request->client_name,
            'client_mobile' => $request->client_mobile,
            'client_address' => $request->client_address,
        ]);

        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'discount' => $item['discount'],
            ]);
        }

        return redirect()->route('invoices.create')->with('success', 'Invoice created successfully.');
    }


    public function print(Invoice $invoice)
    {
        // Fetch invoice data
        $data = [
            'invoice' => $invoice,
        ];

        // Create PDF instance
        $pdf = new Dompdf();

        // Load HTML content
        $html = view('invoices.print', $data)->render();
        $pdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (important for PDF generation to work)
        $pdf->render();

        // Stream or download PDF to user
        return $pdf->stream('invoice_'.$invoice->id.'.pdf');
    }
    }