<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
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
            $barang = DB::table('barang_masuk')
             ->join('satuan', 'barang_masuk.id_satuan', '=', 'satuan.id')
            ->select('barang_masuk.*', 'satuan.nama as nama_satuan')
            ->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')->get();
        } else {
            $barang = DB::table('barang_masuk')
             ->join('satuan', 'barang_masuk.id_satuan', '=', 'satuan.id')
            ->select('barang_masuk.*', 'satuan.nama as nama_satuan')
            ->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')->get();
        }
        return view('admin.barang.index', ['barang' => $barang, 'bln' => $bln]);
    }

    public function read_filter($bln)
    {
        if (Auth::User()->level == '1') {
            $barang = DB::table('barang_masuk')
             ->join('satuan', 'barang_masuk.id_satuan', '=', 'satuan.id')
            ->select('barang_masuk.*', 'satuan.nama as nama_satuan')
            ->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')->get();
        } else {
            $barang = DB::table('barang_masuk')
             ->join('satuan', 'barang_masuk.id_satuan', '=', 'satuan.id')
            ->select('barang_masuk.*', 'satuan.nama as nama_satuan')
            ->where('tanggal', 'LIKE', $bln . '%')->orderBy('id', 'DESC')->get();
        }

        return view('admin.barang.index', ['barang' => $barang, 'bln' => $bln]);
    }

    public function add()
    {
        $sales = DB::table('sales')->orderBy('nama', 'ASC')->get();
        $satuan = DB::table('satuan')->orderBy('nama', 'ASC')->get();

        return view('admin.barang.tambah', ['sales' => $sales, 'satuan' => $satuan]);
    }

    public function create(Request $request)
    {
        if ($request->id_type == '2') {
            $cek_sales = DB::table('sales')->where('nama', $request->nama)->where('contact', $request->contact)->first();
            if ($cek_sales) {
                $id_sales = $cek_sales->id;
            } else {
                $id_sales = DB::table('sales')->insertGetId([
                    'nama' => $request->nama,
                    'contact' => $request->contact,
                    'alamat' => $request->alamat
                ]);
            }
        } else {
            $id_sales = $request->id_sales;
        }

        $harga_modal = preg_replace('/\D/', '', $request->harga_modal);
        $harga_jual = preg_replace('/\D/', '', $request->harga_jual);
        $harga_kampas = preg_replace('/\D/', '', $request->harga_kampas);
        $harga_khusus = preg_replace('/\D/', '', $request->harga_khusus);

        DB::table('barang')->insert([
            'id_sales' => $id_sales,
            'id_jenis' => $request->id_jenis,
            'id_satuan' => $request->id_satuan,
            'nama' => $request->nama_barang,
            'stock' => $request->stock,
            'harga_modal' => $harga_modal,
            'harga_jual' => $harga_jual,
            'harga_kampas' => $harga_kampas,
            'harga_khusus' => $harga_khusus,
            'id_user' => Auth::user()->id
        ]);

        return redirect("/admin/barang/add")->with("success", "Data Berhasil Ditambah!");
    }

    public function edit($id)
    {
        $barang = DB::table('barang')->where('id', $id)->first();

        $jenis = DB::table('jenis')->orderBy('id', 'ASC')->get();
        $sales = DB::table('sales')->orderBy('nama', 'ASC')->get();
        $satuan = DB::table('satuan')->orderBy('nama', 'ASC')->get();

        return view('admin.barang.edit', ['barang' => $barang, 'jenis' => $jenis, 'sales' => $sales, 'satuan' => $satuan]);
    }

    public function update(Request $request, $id)
    {
        if ($request->id_type == '2') {
            $cek_sales = DB::table('sales')->where('nama', $request->nama)->where('contact', $request->contact)->first();
            if ($cek_sales) {
                $id_sales = $cek_sales->id;
            } else {
                $id_sales = DB::table('sales')->insertGetId([
                    'nama' => $request->nama,
                    'contact' => $request->contact,
                    'alamat' => $request->alamat
                ]);
            }
        } else {
            $id_sales = $request->id_sales;
        }

        $harga_modal = preg_replace('/\D/', '', $request->harga_modal);
        $harga_jual = preg_replace('/\D/', '', $request->harga_jual);
        $harga_kampas = preg_replace('/\D/', '', $request->harga_kampas);
        $harga_khusus = preg_replace('/\D/', '', $request->harga_khusus);

        DB::table('barang')->where('id', $id)->update([
            'id_sales' => $id_sales,
            'id_jenis' => $request->id_jenis,
            'id_satuan' => $request->id_satuan,
            'nama' => $request->nama_barang,
            'stock' => $request->stock,
            'harga_modal' => $harga_modal,
            'harga_jual' => $harga_jual,
            'harga_kampas' => $harga_kampas,
            'harga_khusus' => $harga_khusus
        ]);

        return redirect('/admin/barang')->with("success", "Data Berhasil Diupdate!");
    }

    public function delete($id)
    {
        DB::table('detail_barang_masuk')->where('id_barang', $id)->delete();
        DB::table('barang')->where('id', $id)->delete();

        return redirect('/admin/barang')->with("success", "Data Berhasil Dihapus!");
    }
}
