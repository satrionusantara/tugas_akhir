<!DOCTYPE html>
<html>
<head>
    <title>Cetak Struk</title>
    <style>
       body {
    font-family: monospace;
    font-size: 12px;
    display: flex;
    justify-content: center; /* center horizontal */
    align-items: flex-start; /* kalau mau atas pakai flex-start, kalau mau tengah semua pakai center */
    min-height: 100vh; /* biar full halaman */
    margin: 0;
}

        .struk { width: 230px; margin: auto; }
        .center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
        table { width: 100%; font-size: 12px; border-collapse: collapse; }
        td { padding: 2px 0; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="struk">
        <div class="center">
            <h3>Toko Syukurillah PS</h3>
            <small>Jorong Rajawali, Tigo Jangko</small>
        </div>
        <div class="line"></div>
        <p>Nota : {{ $transaksi->nomor_nota }}</p>
        <p>Tanggal : {{ date('d-m-Y', strtotime($transaksi->tanggal)) }} {{ $transaksi->pukul }}</p>
        <div class="line"></div>

        <table>
            <tr>
                 <td>{{ $transaksi->nama_barang }} x {{ $transaksi->jumlah }} {{ $transaksi->nama_satuan }}</td>
                <td class="right">Rp {{ number_format($transaksi->total,0,',','.') }}</td>
            </tr>
        </table>

        <div class="line"></div>
        <table>
            <tr>
                <td>Total</td>
                <td class="right">Rp {{ number_format($transaksi->total,0,',','.') }}</td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td class="right">Rp {{ number_format($transaksi->bayar,0,',','.') }}</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td class="right">Rp {{ number_format($transaksi->kembali,0,',','.') }}</td>
            </tr>
        </table>
        <div class="line"></div>
        <div class="center">
            <p>Terima Kasih</p>
        </div>
    </div>
</body>
</html>
