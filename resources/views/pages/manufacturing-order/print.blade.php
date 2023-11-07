<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="bg-white">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Bill of Material</h3>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <table>
                            <tr>
                                <td>Kode BOM</td>
                                <td>:</td>
                                <td>{{ $bom->kode_bom }}</td>
                            </tr>
                            <tr>
                                <td>Produk</td>
                                <td>:</td>
                                <td>{{ $bom->product->nama_produk }}</td>
                            </tr>
                            <tr>
                                <td>Harga</td>
                                <td>:</td>
                                <td>Rp. {{ number_format($bom->product->harga) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Bahan Baku</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bom->bomDetail as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->material->nama_bahan }}</td>
                            <td>{{ $item->jumlah }} {{ $item->satuan }}</td>
                            <td>Rp. {{ number_format($item->subtotal) }}</td>
                        </tr>
                        @endforeach
                        <tr class="text-center">
                            <th colspan="3">Total</th>
                            <th>Rp. {{ number_format($item->totalHarga) }}</th>
                        </tr>
                    </tbody>
                </table>
                <hr>
            </div>
        </div>
    </div>
</body>

</html>