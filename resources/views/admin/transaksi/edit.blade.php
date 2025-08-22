@extends('admin.layouts.app', [
'activePage' => 'transaksi',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Data Transaksi Barang</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Proses</a></li>
                  <li class="breadcrumb-item"><a href="/admin/transaksi">Data Transaksi Barang</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Data Transaksi Barang</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-edit-1"></i> Edit Data Transaksi Barang</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/transaksi" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
         </div>
      </div>
      <hr style="margin-top: 0px">
      <form action="/admin/transaksi/update/{{$transaksi->id}}" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-md-4">
               <div class="form-group">
                  <label>Tanggal<span class="text-danger">*</span></label>
                  <input type="date" autofocus name="tanggal" required class="form-control" placeholder="Masukkan Tanggal ....." value="{{$transaksi->tanggal}}">
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>Pukul<span class="text-danger">*</span></label>
                  <input type="time" name="pukul" required class="form-control" placeholder="Masukkan Pukul ....." value="{{$transaksi->pukul}}">
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>Keterangan</label>
                  <select class="form-control select2" name="keterangan">
                     <option value="">-- Pilih Keterangan --</option>
                     <option value="INVOICE" @if($transaksi->keterangan == 'INVOICE') selected @endif>INVOICE</option>
                     <option value="NOTA TITIPAN BARANG" @if($transaksi->keterangan == 'NOTA TITIPAN BARANG') selected @endif>NOTA TITIPAN BARANG</option>
                  </select>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>Nama Customer<span class="text-danger">*</span></label>
                  <input type="text" name="nama" required class="form-control" placeholder="Masukkan Nama Customer ....." value="{{$transaksi->nama}}">
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>Contact Customer</label>
                  <input type="number" name="contact" class="form-control" placeholder="Masukkan Contact Customer ....." value="{{$transaksi->contact}}">
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>Alamat Customer</label>
                  <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat Customer ....." value="{{$transaksi->alamat}}">
               </div>
            </div>
            @if(Auth::User()->level == '1')
            <div class="col-md-12">
               <div class="form-group">
                  <label>Cabang<span class="text-danger">*</span></label>
                  <select class="form-control select2" name="id_cabang" required>
                     @foreach($cabang as $data)
                        <option value="{{$data->id}}" @if($data->id == $transaksi->id_cabang) selected @endif>{{$data->nama}}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            @endif
         </div>
         <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span> Update Data</button>               
      </form>
   </div>
   <!-- Striped table End -->
</div>
<script>
	$(document).ready(function() {
	    $('.select2').select2();
    });
</script>
@endsection