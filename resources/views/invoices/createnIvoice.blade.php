<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Invoice</title>

  <!-- Bootstrap 4 CSS (for layout consistency) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Bootstrap-select CSS (for dropdown styling) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mb-4">Create Invoice</h2>

        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif

        <form method="post" action="{{ route('invoices.store') }}" enctype="multipart/form-data" oninput="updateTotals()">
            @csrf

            <!-- Customer Details -->
            <div class="form-group">
                <label for="client_name">Name:</label>
                <input type="text" class="form-control" id="client_name" name="client_name" required>
            </div>
            <div class="form-group">
                <label for="client_mobile">Mobile No:</label>
                <input type="text" class="form-control" id="client_mobile" name="client_mobile" required>
            </div>
            <div class="form-group">
                <label for="client_address">Address:</label>
                <input type="text" class="form-control" id="client_address" name="client_address">
            </div>

            <!-- Invoice Items -->
            <table class="table invoice-items" id="dynamic_field">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th class="text-center">Price</th>
                        <th>Quantity</th>
                        <th>Discount (%)</th>
                        <th>Total without discount</th>
                        <th>Total with discount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><input type="text" name="items[0][name]" class="form-control" required></td>
                        <td><input type="number" name="items[0][price]" class="form-control price" min="1" value="0" required></td>
                        <td><input type="number" name="items[0][qty]" class="form-control qty" min="1" value="0" required></td>
                        <td><input type="number" name="items[0][discount]" class="form-control discount" min="0" value="0" required></td>
                        <td class="total-without-discount">0.00</td>
                        <td class="total-with-discount">0.00</td>
                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Create Invoice</button>

        </form>

        <div class="col-sm-6">
            <div class="mt-4 text-right">
                <a href="{{ route('invoices.index') }}" class="btn btn-primary">List Of Invoices</a>
            </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 4 JS (including Popper.js for dropdowns, tooltips, etc.) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery (required by Bootstrap and custom scripts) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Bootstrap-select JS (for dropdown functionality) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

  <script>
    function updateTotals() {
      let totalWithoutDiscount = 0;
      let totalDiscount = 0;
      let totalWithDiscount = 0;
      let total = 0;

      $('.price, .qty, .discount').each(function() {
        const price = parseFloat($(this).closest('tr').find('.price').val()) || 0;
        const qty = parseFloat($(this).closest('tr').find('.qty').val()) || 0;
        const discount = parseFloat($(this).closest('tr').find('.discount').val()) || 0;
        const totalWithoutDiscountForRow = price * qty;
        const totalWithDiscountForRow = totalWithoutDiscountForRow - (totalWithoutDiscountForRow * (discount / 100));

        $(this).closest('tr').find('.total-without-discount').text(totalWithoutDiscountForRow.toFixed(2));
        $(this).closest('tr').find('.total-with-discount').text(totalWithDiscountForRow.toFixed(2));

        totalWithoutDiscount += totalWithoutDiscountForRow;
        totalDiscount += totalWithoutDiscountForRow * (discount / 100);
        totalWithDiscount += totalWithDiscountForRow;
        total += totalWithDiscountForRow;
      });

      $('#totalWithoutDiscount').text(totalWithoutDiscount.toFixed(2));
      $('#totalDiscount').text(totalDiscount.toFixed(2));
      $('#totalWithDiscount').text(totalWithDiscount.toFixed(2));
      $('#total').text(total.toFixed(2));
    }

    $(document).ready(function() {
      var i = 1;

      $('#add').click(function() {
        i++;
        $('#dynamic_field').append(`
          <tr id="row${i}">
            <td>${i}</td>
            <td><input type="text" name="items[${i}][name]" class="form-control" required></td>
            <td><input type="number" name="items[${i}][price]" class="form-control price" min="1" value="0" required></td>
            <td><input type="number" name="items[${i}][qty]" class="form-control qty" min="1" value="0" required></td>
            <td><input type="number" name="items[${i}][discount]" class="form-control discount" min="0" value="0" required></td>
            <td class="total-without-discount">0.00</td>
            <td class="total-with-discount">0.00</td>
            <td><button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove">X</button></td>
          </tr>
        `);
        updateTotals();
      });

      $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
        updateTotals();
      });

      // Initial calculation on page load
      updateTotals();
    });
  </script>
</body>
</html>
