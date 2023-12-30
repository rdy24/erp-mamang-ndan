<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order</title>
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
            border: 1px solid #000;
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
        <h1>Purchase Order {{ $purchase->kode_purchase }}</h1>

        <div>
            <strong>Vendor:</strong> {{ $purchase->vendor->name }}<br> <br>
            <strong>Tanggal Dibuat:</strong> {{ $purchase->created_at->format('d M Y') }} <br> <br>
        </div>

        <strong>Tanggal Konfirmasi : </strong> {{ $purchase->confirm_date->format('d M Y') }} <br> <br>
        @if ($purchase?->bill?->payment?->status)
        <strong>Payment Status: </strong> {{ $purchase->bill->payment->status }} <br> <br>
        @endif
        @if ($purchase?->bill?->payment?->status == 'Paid')
        <strong>Payment Date: </strong> {{ $purchase->bill->payment->created_at->format('d M Y') }} <br> <br>
        @endif
        @if ($purchase->receive_status)
        <strong>Status Barang: </strong> {{ $purchase->receive_status }} <br>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Bahan Baku</th>
                    <th>Jumlah Bahan</th>
                    <th>Harga Per Unit</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase->purchaseDetails as $item)
                <tr>
                    <td>{{ $item->material->nama_bahan }}</td>
                    <td>{{ $item->jumlah }} {{ $item->satuan }}</td>
                    <td>Rp. {{ number_format($item->material->harga) }}</td>
                    <td>Rp. {{ number_format($item->total_harga) }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="3" style="text-align: center">Total Harga</th>
                    <th>Rp. {{ number_format($purchase->total) }}</th>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>