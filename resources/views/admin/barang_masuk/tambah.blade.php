@extends('admin.layouts.app', [
'activePage' => 'barang_masuk',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-12 col-sm-12">
            <div class="title">
               <h4>Data Barang Masuk</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Input</a></li>
                  <li class="breadcrumb-item"><a href="/admin/barang_masuk">Data Barang Masuk</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Data Barang Masuk</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-add-file-1"></i> Tambah Data Barang Masuk</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/barang_masuk" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
         </div>
      </div>
      <hr style="margin-top: 0px">
      <form action="/admin/barang_masuk/create" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-md-6">
               <div class="form-group">
                  <label>Tanggal<span class="text-danger">*</span></label>
                  <input type="date" name="tanggal" required class="form-control" placeholder="Masukkan Tanggal ....." value="{{date('Y-m-d')}}">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>Nama Barang<span class="text-danger">*</span></label>
                  <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan Nama Barang .....">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>Harga Modal<span class="text-danger">*</span></label>
                  <input type="text" name="harga_modal" class="form-control" placeholder="Masukkan Harga Modal ....." oninput="formatNumber(this)">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>Harga Jual<span class="text-danger">*</span></label>
                  <input type="text" name="harga_jual" class="form-control" placeholder="Masukkan Harga Jual ....." oninput="formatNumber(this)">
               </div>
            </div>
         </div>
         <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span> Tambah Data</button> 
      </form>
   </div>
   <!-- Striped table End -->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   function formatNumber(input) {
       // Menghapus semua karakter kecuali angka
       let value = input.value.replace(/\D/g, '');
       
       // Menambahkan format pemisah ribuan
       input.value = new Intl.NumberFormat().format(value);
   }
</script>
<script>
	$(document).ready(function() {
	    $('.select2').select2();
    });
</script>
@endsection