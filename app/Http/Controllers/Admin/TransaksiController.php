<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date("Y-m-d");

        if (Auth::User()->level == '1') {
            $transaksi = DB::table('transaksi')
                ->where('transaksi.tanggal', $tgl)
                ->join('barang_masuk', 'transaksi.id_barang', '=', 'barang_masuk.id')
                ->join('metode', 'transaksi.id_metode', '=', 'metode.id')
                ->select('transaksi.*', 'barang_masuk.nama_barang','barang_masuk.exp_date', 'metode.nama as metode_pembayaran')
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $transaksi = DB::table('transaksi')
                ->where('transaksi.tanggal', $tgl)
                ->join('barang_masuk', 'transaksi.id_barang', '=', 'barang_masuk.id')
                ->join('metode', 'transaksi.id_metode', '=', 'metode.id')
                 ->select('transaksi.*', 'barang_masuk.nama_barang','barang_masuk.exp_date', 'metode.nama as metode_pembayaran')
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('admin.transaksi.index', ['tgl' => $tgl, 'transaksi' => $transaksi]);
    }

    public function read_filter($tgl)
    {
        date_default_timezone_set('Asia/Jakarta');

        if (Auth::User()->level == '1') {
            $transaksi = DB::table('transaksi')
            ->join('barang_masuk', 'transaksi.id_barang', '=', 'barang_masuk.id')
            ->join('metode', 'transaksi.id_metode', '=', 'metode.id')
                 ->select('transaksi.*', 'barang_masuk.nama_barang','barang_masuk.exp_date', 'metode.nama as metode_pembayaran')

            ->where('transaksi.tanggal', $tgl)->orderBy('id', 'DESC')->get();
        } else {
            $transaksi = DB::table('transaksi')
            ->join('barang_masuk', 'transaksi.id_barang', '=', 'barang_masuk.id')
            ->join('metode', 'transaksi.id_metode', '=', 'metode.id')
                 ->select('transaksi.*', 'barang_masuk.nama_barang','barang_masuk.exp_date', 'metode.nama as metode_pembayaran')

            ->where('transaksi.tanggal', $tgl)->orderBy('id', 'DESC')->get();
        }

        return view('admin.transaksi.index', ['tgl' => $tgl, 'transaksi' => $transaksi]);
    }

    public function add()
    {
        date_default_timezone_set('Asia/Jakarta');
         $count = DB::table('transaksi')->count();

        // Buat nomor nota dengan prefix
        $nomor_nota = 'NOTA-' . str_pad($count + 1, 5, '0', STR_PAD_LEFT); 
        $metode = DB::table('metode')->orderBy('id', 'DESC')->get();
        $barang = DB::table('barang_masuk')->orderBy('id', 'DESC')->get();
        return view('admin.transaksi.tambah', ['metode' => $metode, 'barang' => $barang, 'nomor_nota' => $nomor_nota]);
    }

    public function create(Request $request)
{
    $barang = DB::table('barang_masuk')->where('id', $request->id_barang)->first();

    if (!$barang) {
        return redirect()->back()->withErrors(['Barang tidak ditemukan.'])->withInput();
    }

    $harga_jual = (int)$barang->harga_jual;
    $jumlah     = (int)$request->jumlah; // jumlah barang yg dibeli

    $potongan = (int)preg_replace('/\D/', '', $request->potongan);
    $bayar    = (int)preg_replace('/\D/', '', $request->bayar);

    $total    = max(0, ($harga_jual * $jumlah) - $potongan);
    $kembali  = max(0, $bayar - $total);

    // ✅ Validasi jika uang bayar tidak cukup
    if ($bayar < $total) {
        return redirect()->back()->withErrors(['Bayar' => 'Uang yang dibayarkan tidak cukup.'])->withInput();
    }

    // ✅ Validasi stok cukup
    if ($barang->stock < $jumlah) {
        return redirect()->back()->withErrors(['Stok' => 'Stok barang tidak mencukupi.'])->withInput();
    }

    // Simpan data transaksi
    $id = DB::table('transaksi')->insertGetId([
        'nomor_nota'   => $request->nomor_nota,
        'tanggal'   => $request->tanggal,
        'pukul'     => $request->pukul,
        'id_barang' => $request->id_barang,
        'jumlah'    => $jumlah,
        'total'     => $total,
        'potongan'  => $potongan,
        'bayar'     => $bayar,
        'kembali'   => $kembali,
        'id_metode' => $request->id_metode,
    ]);

    // ✅ Update stok barang masuk
    DB::table('barang_masuk')
        ->where('id', $request->id_barang)
        ->update([
            'stock' => $barang->stock - $jumlah
        ]);

    return redirect("/admin/transaksi/")->with("success", "Data Berhasil Ditambah !");
}


    public function edit($id)
    {
        $transaksi = DB::table('transaksi')->where('id', $id)->first();

        return view('admin.transaksi.edit', ['transaksi' => $transaksi]);
    }

    public function update(Request $request, $id)
    {
        if (Auth::User()->level == '1') {
            $id_cabang = $request->id_cabang;
        } else {
            $id_cabang = Auth::User()->id_cabang;
        }

        DB::table('transaksi')
            ->where('id', $id)
            ->update([
                'id_cabang' => $id_cabang,
                'tanggal' => $request->tanggal,
                'pukul' => $request->pukul,
                'keterangan' => $request->keterangan,
                'nama' => $request->nama,
                'contact' => $request->contact,
                'alamat' => $request->alamat,
                'id_user' => Auth::User()->id
            ]);

        return redirect('/admin/transaksi')->with("success", "Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        DB::table('transaksi')->where('id', $id)->delete();
        DB::table('detail_transaksi')->where('id_transaksi', $id)->delete();
        DB::table('piutang')->where('id_transaksi', $id)->delete();

        return redirect('/admin/transaksi')->with("success", "Data Berhasil Dihapus !");
    }

    public function cetak($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = DB::table('transaksi')
            ->join('barang_masuk', 'transaksi.id_barang', '=', 'barang_masuk.id')
            ->join('metode', 'transaksi.id_metode', '=', 'metode.id')
            ->select('transaksi.*', 'barang_masuk.nama_barang', 'metode.nama as nama_metode', 'barang_masuk.exp_date')
            ->where('transaksi.id', $id)
            ->orderBy('id', 'DESC')
            ->first();
            // ->get();

        // Load view dan set paper untuk PDF
        $pdf = Pdf::loadview('admin.transaksi.cetak', [
            'transaksi' => $transaksi,
            'id' => $id
        ]);
        $pdf->setPaper([0, 0, 226.77, 600], 'portrait'); 

        // Return PDF dengan nama yang sesuai ID
        return $pdf->stream('Laporan Transaksi ID-' . $id . '.pdf');
    }



    public function searchBarang(Request $request)
    {
        $q = $request->input('q');
        $id_jenis = $request->input('jenis');
        $id_cabang = $request->input('cabang');

        // Tentukan kolom harga yang dipakai
        $hargaColumn = match ((int)$id_jenis) {
            1 => 'harga_jual',
            2 => 'harga_kampas',
            3 => 'harga_khusus',
            default => 'harga_jual'
        };

        $barang = DB::table('barang')
            ->leftJoin('satuan', 'satuan.id', '=', 'barang.id_satuan')
            ->select('barang.id', 'barang.nama', 'satuan.nama as nama_satuan', 'barang.stock', DB::raw("{$hargaColumn} as harga"))
            ->where('id_cabang', $id_cabang)
            ->where($hargaColumn, '>', 0)
            ->where('barang.nama', 'like', "%{$q}%")
            ->orderBy('barang.nama', 'ASC')
            ->limit(20)
            ->get();

        return response()->json($barang);
    }

    public function detail($id)
    {
        $transaksi = DB::table('transaksi')->where('id', $id)->first();
        $detail_transaksi = DB::table('detail_transaksi')->where('id_transaksi', $id)->orderBy('id', 'DESC')->get();
        $metode = DB::table('metode')->get();
        $satuan = DB::table('satuan')->orderBy('id', 'ASC')->get();
        $barang = DB::table('barang_masuk')->orderBy('id', 'ASC')->get();

        return view('admin.transaksi.detail', ['barang' => $barang, 'transaksi' => $transaksi, 'detail_transaksi' => $detail_transaksi, 'metode' => $metode, 'satuan' => $satuan]);
    }

    public function create_detail(Request $request, $id)
    {
        $transaksi = DB::table('transaksi')->find($id);
        $jumlah = preg_replace('/\D/', '', $request->jumlah);
        $harga = preg_replace('/\D/', '', $request->harga);
        $diskon = preg_replace('/\D/', '', $request->diskon);
        $total = preg_replace('/\D/', '', $request->total);
        $barang = DB::table('barang')->find($request->id_barang);

        if ($request->id_jenis == '4') {
            $nama_barang = $request->nama;
            $satuan = DB::table('satuan')->find($request->satuan);
        } else {
            $nama_barang = $barang->nama ?? '-';
            $satuan = DB::table('satuan')->find($barang->id_satuan);
        }

        DB::table('detail_transaksi')->insert([
            'id_transaksi' => $id,
            'id_barang' => $request->id_barang,
            'keterangan' => $request->keterangan,
            'nama' => $nama_barang,
            'satuan' => $satuan->nama ?? '-',
            'jumlah' => $jumlah,
            'harga' => $harga,
            'diskon' => $diskon,
            'total' => $total,
            'id_user' => Auth::User()->id
        ]);

        $total_transaksi = $transaksi->total + $total;

        DB::table('transaksi')
            ->where('id', $id)
            ->update([
                'total' => $total_transaksi
            ]);

        return redirect("/admin/transaksi/detail/$transaksi->id")->with("success", "Data Berhasil Ditambah !");
    }

    public function delete_detail($id)
    {
        $detail_transaksi = DB::table('detail_transaksi')->find($id);
        $transaksi = DB::table('transaksi')->find($detail_transaksi->id_transaksi);
        $total = $transaksi->total - $detail_transaksi->total;

        DB::table('transaksi')
            ->where('id', $transaksi->id)
            ->update([
                'total' => $total
            ]);

        DB::table('detail_transaksi')->where('id', $id)->delete();

        return redirect("/admin/transaksi/detail/$transaksi->id")->with("success", "Data Berhasil Dihapus !");
    }

    public function bayar(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $transaksi = DB::table('transaksi')->find($id);
        $total = preg_replace('/\D/', '', $request->total_pembayaran);
        $potongan = preg_replace('/\D/', '', $request->potongan);
        $bayar = preg_replace('/\D/', '', $request->bayar);
        $kembali = preg_replace('/\D/', '', $request->kembali);

        DB::table('transaksi')
            ->where('id', $transaksi->id)
            ->update([
                'total' => $total,
                'potongan' => $potongan,
                'bayar' => $bayar,
                'kembali' => $kembali,
                'status' => '1',
                'id_metode' => $request->id_metode
            ]);

        $keterangan = "Pembayaran Transaksi Atas Nama " . $transaksi->nama;

        DB::table('pemasukan')->insert([
            'id_cabang' => $transaksi->id_cabang,
            'tanggal' => date('Y-m-d'),
            'keterangan' => $keterangan,
            'total' => $total,
            'id_metode' => $request->id_metode,
            'id_transaksi' => $transaksi->id,
            'id_user' => Auth::User()->id
        ]);

        DB::table('piutang')
            ->where('id_transaksi', $transaksi->id)
            ->update([
                'status' => '1'
            ]);

        return redirect("/admin/transaksi/detail/$transaksi->id")->with("success", "Data Berhasil Dibayar !");
    }

    public function hutang(Request $request, $id)
    {
        $transaksi = DB::table('transaksi')->find($id);

        DB::table('transaksi')
            ->where('id', $transaksi->id)
            ->update([
                'tanggal_pelunasan' => $request->tanggal_pelunasan,
                'status' => '2'
            ]);

        $keterangan = "Hutang Transaksi Atas Nama " . $transaksi->nama;

        DB::table('piutang')->insert([
            'id_cabang' => $transaksi->id_cabang,
            'id_transaksi' => $transaksi->id,
            'keterangan' => $keterangan,
            'nama' => $transaksi->nama,
            'contact' => $transaksi->contact,
            'alamat' => $transaksi->alamat,
            'tanggal' => $transaksi->tanggal,
            'jatuh_tempo' => $request->tanggal_pelunasan,
            'total' => $transaksi->total,
            'id_user' => $transaksi->id_user,
            'status' => '0',
        ]);

        return redirect("/admin/transaksi/detail/$transaksi->id")->with("success", "Data Berhasil Dihutangkan !");
    }

    public function nota($id)
    {
        $transaksi = DB::table('transaksi')->find($id);
        $detail_transaksi = DB::table('detail_transaksi')->where('id_transaksi', $id)->orderBy('id', 'ASC')->get();
        $metode = DB::table('metode')->find($transaksi->id_metode);
        $kasir = DB::table('users')->find($transaksi->id_user);

        $pdf = Pdf::loadview('admin.transaksi.nota', ['transaksi' => $transaksi, 'metode' => $metode, 'detail_transaksi' => $detail_transaksi, 'kasir' => $kasir]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('NOTA PEMBELIAN ' . strtoupper($transaksi->nama) . '.pdf');
    }

    public function edit_detail($id)
    {
        $detail_transaksi = DB::table('detail_transaksi')->where('id', $id)->first();
        $transaksi = DB::table('transaksi')->where('id', $detail_transaksi->id_transaksi)->first();
        $satuan = DB::table('satuan')->orderBy('id', 'ASC')->get();

        return view('admin.transaksi.edit_detail', ['transaksi' => $transaksi, 'detail_transaksi' => $detail_transaksi, 'satuan' => $satuan]);
    }

    public function update_detail(Request $request, $id)
    {
        $detail_transaksi = DB::table('detail_transaksi')->find($id);
        $transaksi = DB::table('transaksi')->find($detail_transaksi->id_transaksi);

        $total_transaksi = $transaksi->total - $detail_transaksi->total;
        DB::table('transaksi')
            ->where('id', $id)
            ->update([
                'total' => $total_transaksi
            ]);

        $jumlah = preg_replace('/\D/', '', $request->jumlah);
        $harga = preg_replace('/\D/', '', $request->harga);
        $diskon = preg_replace('/\D/', '', $request->diskon);
        $total = preg_replace('/\D/', '', $request->total);
        $barang = DB::table('barang')->find($request->id_barang);

        if ($request->id_jenis == '4') {
            $nama_barang = $request->nama;
            $satuan = DB::table('satuan')->find($request->satuan);
        } else {
            $nama_barang = $barang->nama ?? '-';
            $satuan = DB::table('satuan')->find($barang->id_satuan);
        }

        DB::table('detail_transaksi')
            ->where('id', $id)
            ->update([
                'id_barang' => $request->id_barang,
                'keterangan' => $request->keterangan,
                'nama' => $nama_barang,
                'satuan' => $satuan->nama ?? '-',
                'jumlah' => $jumlah,
                'harga' => $harga,
                'diskon' => $diskon,
                'total' => $total
            ]);

        $transaksi = DB::table('transaksi')->find($detail_transaksi->id_transaksi);
        $total_transaksi = $transaksi->total + $total;

        DB::table('transaksi')
            ->where('id', $id)
            ->update([
                'total' => $total_transaksi
            ]);

        return redirect("/admin/transaksi/detail/$transaksi->id")->with("success", "Data Berhasil Ditambah !");
    }
}
