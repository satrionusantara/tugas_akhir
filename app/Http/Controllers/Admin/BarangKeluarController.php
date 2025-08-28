<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class BarangKeluarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function read(){
        $barang_keluar = DB::table('transaksi')
        ->join('barang_masuk', 'transaksi.id_barang', '=', 'barang_masuk.id')
        // ->select('barang_masuk.nama_barang','barang_masuk.exp_date', 'transaksi.tanggal')
        ->join('satuan', 'barang_masuk.id_satuan', '=', 'satuan.id')
        ->select('transaksi.*', 'satuan.nama as nama_satuan','barang_masuk.nama_barang','barang_masuk.exp_date')
        ->orderBy('transaksi.id','DESC')
        ->get();

        return view('admin.barang_keluar.index',['barang_keluar'=>$barang_keluar]);
    }

    // public function add(){
    //     $barang = DB::table('barang')->orderBy('nama','ASC')->get();

    //     return view('admin.barang_keluar.tambah',['barang'=>$barang]);
    // }

    // public function create(Request $request){
    //     $barang = DB::table('barang')->find($request->id_barang);
    //     $jumlah = preg_replace('/\D/', '', $request->jumlah);
    //     $detail_barang = DB::table('detail_barang')->find($request->ukuran);

    //     $stock = $detail_barang->stock - $jumlah;

    //     $keterangan = $barang->nama . 
    //           ($barang->warna ? ' Warna ' . $barang->warna : '') . 
    //           ' Ukuran ' . $detail_barang->ukuran; 

    //     DB::table('barang_keluar')->insert([  
    //         'tanggal' => $request->tanggal,
    //         'id_detail_barang' => $detail_barang->id,
    //         'keterangan' => $keterangan,
    //         'jumlah' => $jumlah
    //     ]);

    //     DB::table('detail_barang')  
    //         ->where('id', $detail_barang->id)
    //         ->update([
    //         'stock' => $stock]);

    //     return redirect('/admin/barang_keluar')->with("success","Data Berhasil Ditambah !");
    // }

    // public function delete($id)
    // {
    //     $barang_keluar = DB::table('barang_keluar')->find($id);
    //     $detail_barang = DB::table('detail_barang')->find($barang_keluar->id_detail_barang);

    //     $stock = $detail_barang->stock + $barang_keluar->jumlah;
        
    //     DB::table('barang_keluar')->where('id',$id)->delete();

    //     DB::table('detail_barang')  
    //         ->where('id', $detail_barang->id)
    //         ->update([
    //         'stock' => $stock]);

    //     return redirect('/admin/barang_keluar')->with("success","Data Berhasil Dihapus !");
    // }
}
