<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->id }}</title>
    <style>
        /* Define your styles for PDF here */
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-items table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-items th, .invoice-items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="invoice-details">
            <h2>Invoice {{ $invoice->id }}</h2>
            <p><strong>Client Name:</strong> {{ $invoice->client_name }}</p>
            <p><strong>Client Mobile:</strong> {{ $invoice->client_mobile }}</p>
            <p><strong>Client Address:</strong> {{ $invoice->client_address }}</p>
        </div>

        <div class="invoice-items">
            <h3>Invoice Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Discount (%)</th>
                        <th>Total with Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->discount }}</td>
                            <td>{{ $item->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
