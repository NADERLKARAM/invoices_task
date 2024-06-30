<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->id }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles for invoice */
        body {
            font-family: Arial, sans-serif;
            padding-top: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .invoice-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-items th, .invoice-items td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .text-right {
            text-align: right;
        }
        .mt-4 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1 class="h4">Invoice #{{ $invoice->id }}</h1>
        </div>

        <div class="invoice-details">
            <div class="row">
                <div class="col-sm-6">
                    <p><strong>Client Name:</strong> {{ $invoice->client_name }}</p>
                    <p><strong>Client Mobile:</strong> {{ $invoice->client_mobile }}</p>
                    <p><strong>Client Address:</strong> {{ $invoice->client_address ?: 'N/A' }}</p>
                </div>
            </div>
        </div>

        <table class="table table-bordered invoice-items">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Discount (%)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->discount }}%</td>
                    <td>${{ number_format($item->price * $item->qty * (1 - $item->discount / 100), 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right"><strong>Total:</strong></td>
                    <td>${{ number_format($invoice->items->sum(function ($item) {
                        return $item->price * $item->qty * (1 - $item->discount / 100);
                    }), 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-sm-6">
                <div class="mt-4">
                    <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mt-4 text-right">
                    <a href="{{ route('invoices.index') }}" class="btn btn-primary">Back to Invoices</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional for some functionalities) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
