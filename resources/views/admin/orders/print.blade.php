<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .thank-you {
            text-align: center;
            margin-top: 30px;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ $title }}</h1>
        </div>

        <table>
            <tr>
                <th>ID Pesanan</th>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <th>Nama Pelanggan</th>
                <td>{{ $order->user->nama }}</td>
            </tr>
            <tr>
                <th>Nama Menu</th>
                <td>{{ $order->nama_menu }}</td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td>{{ $order->qty }}</td>
            </tr>
            <tr>
                <th>Harga</th>
                <td>Rp. {{ number_format($order->harga, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>Rp. {{ number_format($order->total, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Dibayar</th>
                <td>
                    @if ($order->dibayar)
                        Yes
                    @else
                        No
                    @endif
                </td>
            </tr>
            <tr>
                <th>Diantar</th>
                <td>
                    @if ($order->diantar)
                        Yes
                    @else
                        No
                    @endif
                </td>
            </tr>
        </table>

        <div class="thank-you">
            <p>Thank you for your order at our cafe!</p>
        </div>
    </div>
</body>

</html>
