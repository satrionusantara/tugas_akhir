<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read()
    {
        $supplier = DB::table('supplier')->orderBy('id', 'DESC')->get();

        return view('admin.supplier.index', ['supplier' => $supplier]);
    }

    public function add()
    {
        return view('admin.supplier.tambah');
    }

    public function create(Request $request)
    {
        DB::table('supplier')->insert([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return redirect('/admin/supplier')->with("success", "Data Berhasil Ditambah !");
    }

    public function edit($id)
    {
        $supplier = DB::table('supplier')->where('id', $id)->first();


        return view('admin.supplier.edit', ['supplier' => $supplier]);
    }

    public function update(Request $request, $id)
    {
        DB::table('supplier')
            ->where('id', $id)
            ->update([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
            ]);

        return redirect('/admin/supplier')->with("success", "Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        DB::table('supplier')->where('id', $id)->delete();

        return redirect('/admin/supplier')->with("success", "Data Berhasil Dihapus !");
    }

    // public function reset($id)
    // {
    //     DB::table('supplier')
    //         ->where('id', $id)
    //         ->update([
    //             'password' => bcrypt('Blazer2025')
    //         ]);

    //     return redirect('/admin/supplier')->with("success", "Password Berhasil Direset ! | Password Default : Blazer2025");
    // }
}
