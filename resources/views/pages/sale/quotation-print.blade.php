<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #quotation {
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        tfoot td {
            font-weight: bold;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<body>

    <div id="quotation">
        <h1>Quotation</h1>

        <div>
            <strong>Customer:</strong> {{ $sale->customer->name }}<br>
            <strong>Date:</strong> {{ $sale->created_at->format('d M Y') }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($sale->sale_details) --}}
                @foreach ($sale->sale_details as $item)
                <tr>
                    <td>{{ $item->product->nama_produk }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp. {{ number_format($item->product->harga) }}</td>
                    <td>Rp. {{ number_format($item->qty * $item->product->harga) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>