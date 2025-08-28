<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemasukanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read()
    {
        date_default_timezone_set('Asia/Jakarta');
        $bln = date('Y-m');
        if (Auth::User()->level == '1') {
            $pemasukan = DB::table('transaksi')
                ->join('barang_masuk', 'transaksi.id_barang', '=', 'barang_masuk.id')
                ->join('metode', 'transaksi.id_metode', '=', 'metode.id')
                ->join('satuan', 'barang_masuk.id_satuan', '=', 'satuan.id')
                ->select('transaksi.*', 'satuan.nama as nama_satuan' ,'barang_masuk.nama_barang', 'metode.nama as nama_metode', 'barang_masuk.exp_date')
                ->where('transaksi.tanggal', 'LIKE', $bln . '%')
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $pemasukan = DB::table('transaksi')->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')->get();
        }
        return view('admin.pemasukan.index', ['pemasukan' => $pemasukan, 'bln' => $bln]);
    }

    public function read_filter($bln)
    {
        if (Auth::User()->level == '1') {
            $pemasukan = DB::table('transaksi')
             ->join('barang_masuk', 'transaksi.id_barang', '=', 'barang_masuk.id')
            ->join('satuan', 'barang_masuk.id_satuan', '=', 'satuan.id')
            ->join('metode', 'transaksi.id_metode', '=', 'metode.id')
            ->select('transaksi.*', 'satuan.nama as nama_satuan' ,'barang_masuk.nama_barang', 'metode.nama as nama_metode', 'barang_masuk.exp_date')
            ->where('transaksi.tanggal', 'LIKE', $bln . '%')->orderBy('transaksi.id', 'DESC')->get();
            // dd($pemasukan);
        } else {
            $pemasukan = DB::table('transaksi')
             ->join('barang_masuk', 'transaksi.id_barang', '=', 'barang_masuk.id')
             ->join('satuan', 'barang_masuk.id_satuan', '=', 'satuan.id')
             ->join('metode', 'transaksi.id_metode', '=', 'metode.id')
            ->select('transaksi.*', 'satuan.nama as nama_satuan' ,'barang_masuk.nama_barang', 'metode.nama as nama_metode', 'barang_masuk.exp_date')
            ->where('transaksi.tanggal', 'LIKE', $bln . '%')->orderBy('transaksi.id', 'DESC')->get();
        }
        return view('admin.pemasukan.index', ['pemasukan' => $pemasukan, 'bln' => $bln]);
    }

    public function cetak($bln)
    {
        // Ambil data pengeluaran berdasarkan bulan yang diberikan
        $pemasukan = DB::table('transaksi')
            ->join('barang_masuk', 'transaksi.id_barang', '=', 'barang_masuk.id')
             ->join('satuan', 'barang_masuk.id_satuan', '=', 'satuan.id')
             ->join('metode', 'transaksi.id_metode', '=', 'metode.id')
            ->select('transaksi.*', 'satuan.nama as nama_satuan' ,'barang_masuk.nama_barang', 'metode.nama as nama_metode', 'barang_masuk.exp_date')
            ->where('transaksi.tanggal', 'LIKE', $bln . '%')
            ->orderBy('id', 'DESC')
            ->get();

        // Format bulan menggunakan Carbon
        $formattedBulan = \Carbon\Carbon::parse($bln)->locale('id')->translatedFormat('F Y');

        // Load view dan set paper untuk PDF
        $pdf = Pdf::loadview('admin.pemasukan.cetak', ['pemasukan' => $pemasukan, 'formattedBulan' => $formattedBulan, 'bln' => $bln]);
        $pdf->setPaper('A4', 'portrait');

        // Return PDF dengan nama yang sudah diformat
        return $pdf->stream('Laporan Pemasukan Bulan ' . $formattedBulan . '.pdf');
    }
}
