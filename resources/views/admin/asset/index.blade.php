@extends('admin.layouts.app', [
'activePage' => 'asset',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Asset</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Asset</li>
               </ol>
            </nav>
         </div>
         <!-- <div class="col-md-6 col-sm-12 text-right">
             <div class="d-flex align-items-center justify-content-end">
                 @if(Auth::User()->level == '1')
                 <div class="form-group mb-0">
                    <select class="form-control" onchange="location = '/admin/asset/filter/' + this.value">
                        @foreach($cabang as $data)
                        <option value="{{$data->id}}" @if($data->id == $id_cabang) selected @endif>{{$data->nama}}</option>
                        @endforeach
                    </select>
                 </div>
                 @endif
             </div>
         </div> -->
      </div>
   </div>
   <div class="row">
      <div class="col-xl-6 col-lg-6 col-md-6 mb-10">
         <div
            class="card-box pd-20 mb-20"
            data-toggle="modal" data-target="#pemasukan_cash"
            data-bgcolor="#7978e9"
            >
            <div class="d-flex justify-content-between align-items-end">
               <div class="text-white">
                  <div class="font-14">Asset Modal Barang</div>
                  <div class="font-24 weight-500">Rp {{number_format($modal,0, ".", ".")}}</div>
               </div>
               <div class="max-width-150">
                  <div id="appointment-chart"></div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 mb-10">
         <div
            class="card-box pd-20 mb-20"
            data-toggle="modal" data-target="#pemasukan_transfer"
            data-bgcolor="#00bcd4"
            >
            <div class="d-flex justify-content-between align-items-end">
               <div class="text-white">
                  <div class="font-14">Asset Jual Barang Harga Biasa</div>
                  <div class="font-24 weight-500">Rp {{number_format($jual,0, ".", ".")}}</div>
               </div>
               <div class="max-width-150">
                  <div id="appointment-chart"></div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 mb-10">
         <div
            class="card-box pd-20 mb-20"
            data-toggle="modal" data-target="#pengeluaran_cash"
            data-bgcolor="#FFB347"
            >
            <div class="d-flex justify-content-between align-items-end">
               <div class="text-white">
                  <div class="font-14">Asset Jual Barang Harga Kampas</div>
                  <div class="font-24 weight-500">Rp {{number_format($kampas,0, ".", ".")}}</div>
               </div>
               <div class="max-width-150">
                  <div id="appointment-chart"></div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 mb-10">
         <div
            class="card-box pd-20 mb-20"
            data-toggle="modal" data-target="#pengeluaran_transfer"
            data-bgcolor="#f96332"
            >
            <div class="d-flex justify-content-between align-items-end">
               <div class="text-white">
                  <div class="font-14">Asset Jual Barang Harga Khusus</div>
                  <div class="font-24 weight-500">Rp {{number_format($khusus,0, ".", ".")}}</div>
               </div>
               <div class="max-width-150">
                  <div id="appointment-chart"></div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-6 mb-10">
         <div
            class="card-box pd-20 mb-20"
            data-toggle="modal" data-target="#pengeluaran_transfer"
            data-bgcolor="#333333"
            >
            <div class="d-flex justify-content-between align-items-end">
               <div class="text-white">
                  <div class="font-14">Total Stock Barang</div>
                  <div class="font-24 weight-500">{{number_format($total_barang,0, ".", ".")}}</div>
               </div>
               <div class="max-width-150">
                  <div id="appointment-chart"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row pb-10">
      <div class="col-md-12 mb-20">
         <div class="card-box height-100-p pd-20">
            <div
               class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3"
               >
               <div class="h5 mb-md-0">Total Stock Barang Berdasarkan Satuan</div>
            </div>
            <hr style="margin-top: 0px;">
            <table class="table table-striped table-bordered data-table hover">
             <thead class="bg-primary text-white">
                <tr>
                   <th width="5%" >#</th>
                   <th>Satuan</th>
                   <th class="text-center">Stock</th>
                </tr>
             </thead>
             <tbody>
                <?php $no = 1; $total = 0; ?>
                @foreach($satuan as $data)
                <?php
                    $stock = DB::table('barang')->where('id_satuan',$data->id)->sum('stock');
                ?>
                <tr>
                   <td class="text-center">{{$no++}}</td>
                   <td>{{$data->nama}}</td>
                   <td>{{$stock}} {{$data->nama}}</td>
                </tr>
                @endforeach
             </tbody>
            </table>
         </div>
      </div>
</div>
@endsection