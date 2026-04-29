<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; margin: 0; padding: 40px; background-color: #f5f5f5; }
        .invoice-box { max-width: 850px; margin: auto; background: #fff; padding: 40px; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px; }
        
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #3498db; padding-bottom: 20px; margin-bottom: 30px; }
        .company-info h2 { margin: 0; color: #3498db; font-size: 28px; }
        .company-info p { margin: 5px 0; color: #7f8c8d; font-size: 14px; }
        
        .invoice-title h1 { margin: 0; color: #2c3e50; font-size: 32px; letter-spacing: 2px; }
        .invoice-title p { margin: 5px 0; text-align: right; font-weight: bold; }

        .details-container { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .details-box h3 { border-bottom: 2px solid #eee; padding-bottom: 5px; color: #2c3e50; font-size: 16px; text-transform: uppercase; }
        .details-box p { line-height: 1.6; margin: 5px 0; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background: #34495e; color: white; text-align: left; padding: 12px; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        tr:nth-child(even) { background-color: #f9f9f9; }

        .summary-wrapper { display: flex; justify-content: flex-end; }
        .summary-table { width: 250px; }
        .summary-table td { border: none; padding: 8px 0; }
        .grand-total { font-size: 18px; font-weight: bold; color: #27ae60; border-top: 2px solid #333 !important; }

        .footer { margin-top: 60px; display: flex; justify-content: space-between; align-items: flex-end; }
        .signature-box { border-top: 1px solid #333; width: 200px; text-align: center; padding-top: 10px; }
        .thanks { text-align: center; color: #95a5a6; flex-grow: 1; }

        .action-bar { text-align: center; margin-bottom: 30px; }
        .btn { padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; font-weight: bold; font-size: 14px; margin: 0 5px; display: inline-block; }
        .btn-print { background: #3498db; color: white; }
        .btn-close { background: #e74c3c; color: white; }

        @media print {
            .action-bar { display: none; }
            body { background: white; padding: 0; }
            .invoice-box { box-shadow: none; border: none; width: 100%; max-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="action-bar">
        <a href="javascript:window.close();" class="btn btn-close">✖ Close Tab</a>
        <button class="btn btn-print" onclick="window.print()">🖨️ Print / Save as PDF</button>
    </div>

    <div class="invoice-box">
        <div class="header">
            <div class="company-info">
                <h2>MY STORE</h2>
                <p>Near City Center, Rahim Yar Khan, PK</p>
                <p>Email: support@mystore.com | +92 300 1234567</p>
            </div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <p>#{{ $order->id }}</p>
                <p style="font-weight: normal; font-size: 14px;">Date: {{ $order->created_at->format('d M, Y') }}</p>
            </div>
        </div>

        <div class="details-container">
            <div class="details-box">
                <h3>Bill To</h3>
                <p>
                    <strong>{{ $order->full_name }}</strong><br>
                    {{ $order->address }}<br>
                    {{ $order->city }}<br>
                    <strong>Phone:</strong> {{ $order->phone }}
                </p>
            </div>
            <div class="details-box" style="text-align: right;">
                <h3>Payment Details</h3>
                <p><strong>Method:</strong> Cash on Delivery</p>
                <p><strong>Status:</strong> <span style="color: #e67e22;">{{ strtoupper($order->status) }}</span></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th style="text-align: center;">Qty</th>
                    <th>Price</th>
                    <th>Delivery</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->delivery_price, 2) }}</td>
                    <td style="text-align: right; font-weight: bold;">
                        ${{ number_format(($item->price * $item->quantity) + $item->delivery_price, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-wrapper">
            <table class="summary-table">
                <tr>
                    <td>Subtotal:</td>
                    <td style="text-align: right;">${{ number_format($order->total_amount - $order->items->sum('delivery_price'), 2) }}</td>
                </tr>
                <tr>
                    <td>Shipping:</td>
                    <td style="text-align: right;">${{ number_format($order->items->sum('delivery_price'), 2) }}</td>
                </tr>
                <tr class="grand-total">
                    <td>TOTAL:</td>
                    <td style="text-align: right;">${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <div class="signature-box">
                <p>Authorized Signature</p>
            </div>
            <div class="thanks">
                <p>Thank you for your business!</p>
                <p style="font-size: 10px;">Computer generated invoice. No signature required.</p>
            </div>
            <div class="signature-box" style="border: none;">
                <p>Customer Stamp</p>
            </div>
        </div>
    </div>

</body>
</html>