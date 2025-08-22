<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function read(){
        $id_cabang = '0';
        $modal = DB::table('barang')->select(DB::raw('SUM(stock * harga_modal) as total'))->value('total');
        $jual = DB::table('barang')->select(DB::raw('SUM(stock * harga_jual) as total'))->value('total');
        $kampas = DB::table('barang')->select(DB::raw('SUM(stock * harga_kampas) as total'))->value('total');
        $khusus = DB::table('barang')->select(DB::raw('SUM(stock * harga_khusus) as total'))->value('total');
        $cabang = DB::table('cabang')->get();
        $total_barang = DB::table('barang')->sum('stock');
        $satuan = DB::table('satuan')->orderBy('nama', 'ASC')->get();

        return view('admin.asset.index',['id_cabang'=>$id_cabang,'cabang'=>$cabang,'modal'=>$modal,'jual'=>$jual,'kampas'=>$kampas,'khusus'=>$khusus,'total_barang'=>$total_barang,'satuan'=>$satuan]);
    }
    
    public function read_filter($id_cabang){
        if($id_cabang == '0'){
            return redirect("/admin/asset");
        }
        $modal = DB::table('barang')->where('id_cabang',$id_cabang)->select(DB::raw('SUM(stock * harga_modal) as total'))->value('total');
        $jual = DB::table('barang')->where('id_cabang',$id_cabang)->select(DB::raw('SUM(stock * harga_jual) as total'))->value('total');
        $kampas = DB::table('barang')->where('id_cabang',$id_cabang)->select(DB::raw('SUM(stock * harga_kampas) as total'))->value('total');
        $khusus = DB::table('barang')->where('id_cabang',$id_cabang)->select(DB::raw('SUM(stock * harga_khusus) as total'))->value('total');
        $cabang = DB::table('cabang')->get();
        $total_barang = DB::table('barang')->where('id_cabang',$id_cabang)->sum('stock');
        $satuan = DB::table('satuan')->orderBy('nama', 'ASC')->get();

        return view('admin.asset.index',['id_cabang'=>$id_cabang,'cabang'=>$cabang,'modal'=>$modal,'jual'=>$jual,'kampas'=>$kampas,'khusus'=>$khusus,'total_barang'=>$total_barang,'satuan'=>$satuan]);
    }
}
