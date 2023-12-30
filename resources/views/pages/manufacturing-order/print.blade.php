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
                <h3 class="text-center">Manufacturing Order</h3>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <table>
                            <tr>
                                <td>Kode Manufacturing Order</td>
                                <td>:</td>
                                <td>{{ $manufacturingOrder->kode_order }}</td>
                            </tr>
                            <tr>
                                <td>BOM</td>
                                <td>:</td>
                                <td>{{ $manufacturingOrder->bom->kode_bom ?? '-' }} - {{
                                    $manufacturingOrder->bom->product->nama_produk ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Produk</td>
                                <td>:</td>
                                <td>{{ $manufacturingOrder->product->nama_produk }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td>:</td>
                                <td>{{ $manufacturingOrder->jumlah_order }}</td>
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
                            <th>Jumlah Bahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($manufacturingOrder->manufacturingOrderDetails as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->material->nama_bahan }}</td>
                            <td>{{ $item->jumlah }} {{ $item->satuan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
            </div>
        </div>
    </div>
</body>

</html>