@extends('admin.layouts.app', [
'activePage' => 'metode',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-12 col-sm-12">
            <div class="title">
               <h4>Data Metode Pembayaran</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                  <li class="breadcrumb-item"><a href="/admin/metode">Data Metode Pembayaran</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Data Metode Pembayaran</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-add-file-1"></i> Tambah Data Metode Pembayaran</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/metode" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
         </div>
      </div>
      <hr style="margin-top: 0px">
      <form action="/admin/metode/create" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}
         <div class="form-group">
            <label>Nama Metode Pembayaran<span class="text-danger">*</span></label>
            <input type="text" autofocus name="nama" required class="form-control" placeholder="Masukkan Nama Metode Pembayaran .....">
         </div>
         <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span> Tambah Data</button>               
      </form>
   </div>
   <!-- Striped table End -->
</div>
@endsection