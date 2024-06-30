<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List of Invoices</title>

  <!-- Bootstrap 4 CSS (for layout consistency) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mb-4">List of Invoices</h2>
        <div class="mt-4">
            <td>
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">create invoice</a>
              </td>
          </div>
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Client Name</th>
              <th>Client Mobile</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->client_name }}</td>
                <td>{{ $invoice->client_mobile }}</td>
                <td>
                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-primary">View</a>
                    <a href="{{ route('invoices.print', $invoice->id) }}" class="btn btn-secondary">Print PDF</a>
                </td>
            </tr>
        @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Bootstrap 4 JS (including Popper.js for dropdowns, tooltips, etc.) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
