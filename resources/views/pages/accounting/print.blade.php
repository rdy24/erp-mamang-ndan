<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounting</title>
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
            margin-top: 50px;
        }

        th,
        td {
            border: 2px solid black;
            padding: 6px;
            text-align: center;
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
        <h1>Accounting</h1>
        <div>
            <h4>Total Pemasukan : {{ $totalDebit }}</h4>
            <h4>Total Pengeluaran : {{ $totalKredit }}</h4>
            <h4>{{ $keterangan }}</h4>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kode Pembayaran</th>
                    <th>Kode Invoice</th>
                    <th>Status</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($debit as $item)
                    <tr>
                        <td>{{ $item->tanggal->format('d-m-Y') }}</td>
                        <td>{{ $item->payment->kode_payment }}</td>
                        <td>{{ $item->payment->invoice->kode_invoice }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->jumlah }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="text-align: center; font-weight: bold">Total</td>
                    <td>{{ $totalDebit }}</td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kode Pembayaran</th>
                    <th>Kode Bill</th>
                    <th>Status</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kredit as $item)
                    <tr>
                        <td>{{ $item->tanggal->format('d-m-Y') }}</td>
                        <td>{{ $item->payment->kode_payment }}</td>
                        <td>{{ $item->payment->bill->kode_bill }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->jumlah }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="text-align: center; font-weight: bold">Total</td>
                    <td>{{ $totalKredit }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>
