<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
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
            $pengeluaran = DB::table('pengeluaran')
                ->join('metode', 'pengeluaran.id_metode', '=', 'metode.id')
                ->select('pengeluaran.*', 'metode.nama as nama_metode')
                ->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')
                ->get();
        } else {
            $pengeluaran = DB::table('pengeluaran')
                ->join('metode', 'pengeluaran.id_metode', '=', 'metode.id')
                ->select('pengeluaran.*', 'metode.nama as nama_metode')
                ->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')
                ->get();
        }

        $total = DB::table('pengeluaran')->sum('total');
        return view('admin.pengeluaran.index', ['pengeluaran' => $pengeluaran, 'bln' => $bln, 'total' => $total]);
    }

    public function read_filter($bln)
    {
        if (Auth::User()->level == '1') {
            $pengeluaran = DB::table('pengeluaran')
                ->join('metode', 'pengeluaran.id_metode', '=', 'metode.id')
                ->select('pengeluaran.*', 'metode.nama as nama_metode')
                ->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')
                ->get();
        } else {
            $pengeluaran = DB::table('pengeluaran')
                ->join('metode', 'pengeluaran.id_metode', '=', 'metode.id')
                ->select('pengeluaran.*', 'metode.nama as nama_metode')
                ->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')
                ->get();
        }
        
        $total = DB::table('pengeluaran')->where('tanggal', 'LIKE', $bln . '%')->sum('total');
        return view('admin.pengeluaran.index', ['pengeluaran' => $pengeluaran, 'bln' => $bln, 'total' => $total]);
    }

    public function add()
    {
        $metode = DB::table('metode')->get();

        return view('admin.pengeluaran.tambah', ['metode' => $metode]);
    }

    public function create(Request $request)
    {
        $total = preg_replace('/\D/', '', $request->total);

        DB::table('pengeluaran')->insert([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'total' => $total,
            'id_metode' => $request->id_metode,
        ]);

        return redirect('/admin/pengeluaran')->with("success", "Data Berhasil Ditambah !");
    }

    public function edit($id)
    {
        $pengeluaran = DB::table('pengeluaran')->where('id', $id)->first();
        $metode = DB::table('metode')->get();

        return view('admin.pengeluaran.edit', ['pengeluaran' => $pengeluaran, 'metode' => $metode]);
    }

    public function update(Request $request, $id)
    {
        $total = preg_replace('/\D/', '', $request->total);

        DB::table('pengeluaran')
            ->where('id', $id)
            ->update([
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'total' => $total,
                'id_metode' => $request->id_metode
            ]);

        return redirect('/admin/pengeluaran')->with("success", "Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        DB::table('pengeluaran')->where('id', $id)->delete();

        return redirect('/admin/pengeluaran')->with("success", "Data Berhasil Dihapus !");
    }

    public function cetak($bln)
    {
        // Ambil data pengeluaran berdasarkan bulan yang diberikan
        $pengeluaran = DB::table('pengeluaran')
            ->where('tanggal', 'LIKE', $bln . '%')
            ->orderBy('id', 'DESC')
            ->get();

        // Format bulan menggunakan Carbon
        $formattedBulan = \Carbon\Carbon::parse($bln)->locale('id')->translatedFormat('F Y');

        // Load view dan set paper untuk PDF
        $pdf = Pdf::loadview('admin.pengeluaran.cetak', ['pengeluaran' => $pengeluaran, 'formattedBulan' => $formattedBulan, 'bln' => $bln]);
        $pdf->setPaper('A4', 'portrait');

        // Return PDF dengan nama yang sudah diformat
        return $pdf->stream('Laporan Pengeluaran Bulan ' . $formattedBulan . '.pdf');
    }
}
