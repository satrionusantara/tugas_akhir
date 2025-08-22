<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
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
            $barang_masuk = DB::table('barang_masuk')->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')->get();
        } else {
            $barang_masuk = DB::table('barang_masuk')->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')->get();
        }

        return view('admin.barang_masuk.index', ['barang_masuk' => $barang_masuk, 'bln' => $bln]);
    }

    public function read_filter($bln)
    {
        if (Auth::User()->level == '1') {
            $barang_masuk = DB::table('barang_masuk')->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')->get();
        } else {
            $barang_masuk = DB::table('barang_masuk')->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')->get();
        }

        return view('admin.barang_masuk.index', ['barang_masuk' => $barang_masuk, 'bln' => $bln]);
    }

    public function add()
    {
        return view('admin.barang_masuk.tambah');
    }

    public function create(Request $request)
    {
        $harga_modal = preg_replace('/\D/', '', $request->harga_modal);
        $harga_jual = preg_replace('/\D/', '', $request->harga_jual);

        DB::table('barang_masuk')->insert([
            'tanggal' => $request->tanggal,
            'nama_barang' => $request->nama_barang,
            'harga_modal' => $harga_modal,
            'harga_jual' => $harga_jual,
        ]);

        return redirect("/admin/barang_masuk/")->with("success", "Data Berhasil Ditambah!");
    }

    public function edit($id)
    {
        $barang_masuk = DB::table('barang_masuk')->find($id);

        return view('admin.barang_masuk.edit', ['barang_masuk' => $barang_masuk]);
    }

    public function update(Request $request, $id)
    {
        $harga_modal = preg_replace('/\D/', '', $request->harga_modal);
        $harga_jual = preg_replace('/\D/', '', $request->harga_jual);

        DB::table('barang_masuk')->where('id', $id)->update([
            'tanggal' => $request->tanggal,
            'nama_barang' => $request->nama_barang,
            'harga_modal' => $harga_modal,
            'harga_jual' => $harga_jual,
        ]);

        return redirect("/admin/barang_masuk")->with("success", "Data Berhasil Diupdate!");
    }

    public function delete($id)
    {
        DB::table('barang_masuk')->where('id', $id)->delete();
        DB::table('detail_barang_masuk')->where('id_barang_masuk', $id)->delete();

        return redirect('/admin/barang_masuk')->with("success", "Data Berhasil Dihapus !");
    }
}
