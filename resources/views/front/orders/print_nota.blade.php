<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembelian - {{ $order->invoice_code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Arial', sans-serif; 
            font-size: 14px; 
            line-height: 1.6;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 { font-size: 28px; margin-bottom: 5px; }
        .header p { color: #666; font-size: 12px; }
        
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .info-box { flex: 1; }
        .info-box h3 { 
            font-size: 14px; 
            text-transform: uppercase;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }
        .info-box p { font-size: 13px; margin: 5px 0; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        thead {
            background: #f8f9fa;
            border-bottom: 2px solid #333;
        }
        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        .total-row {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin: 10px 0;
            font-size: 14px;
        }
        .total-row.grand {
            font-size: 20px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 15px;
            margin-top: 15px;
        }
        .total-label {
            margin-right: 30px;
            min-width: 150px;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
        
        .print-button {
            background: #4F46E5;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            margin: 20px 0;
        }
        .print-button:hover {
            background: #4338CA;
        }
    </style>
</head>
<body>
    
    <div class="no-print" style="text-align: center;">
        <button onclick="window.print()" class="print-button">🖨️ Print Nota</button>
    </div>

    <div class="header">
        <h1>TOKO UTAMA</h1>
        <p>Jl. Contoh No. 123, Surabaya | Telp: 031-1234567</p>
        <p>Email: info@tokoutama.com</p>
    </div>

    <div class="info-section">
        <div class="info-box">
            <h3>Informasi Pesanan</h3>
            <p><strong>No. Invoice:</strong> {{ $order->invoice_code }}</p>
            <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d F Y, H:i') }}</p>
            <p><strong>Tanggal Pembayaran:</strong> {{ $order->paid_at ? $order->paid_at->format('d F Y, H:i') : '-' }}</p>
            <p><strong>Status:</strong> <span style="color: green; font-weight: bold;">LUNAS</span></p>
        </div>
        
        <div class="info-box">
            <h3>Informasi Pelanggan</h3>
            <p><strong>Nama:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>No. HP:</strong> {{ $order->user->phone ?? '-' }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->qty }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row grand">
            <span class="total-label">TOTAL PEMBAYARAN:</span>
            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <p><strong>Terima kasih atas pembelian Anda!</strong></p>
        <p>Nota ini adalah bukti pembayaran yang sah.</p>
        <p style="margin-top: 10px;">Dicetak pada: {{ now()->format('d F Y, H:i:s') }}</p>
    </div>

</body>
</html>