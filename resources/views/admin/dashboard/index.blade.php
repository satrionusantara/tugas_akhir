@extends('admin.layouts.app', [
'activePage' => 'dashboard',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Dashboard</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
         <div class="card-box pd-20 height-100-p mb-30">
           <div class="row align-items-center">
               <div class="col-md-4">
                  <img src="{{url('assets-admin')}}/vendors/images/banner-img.png" alt="" />
               </div>
               <div class="col-md-8">
                 <h4 class="font-20 weight-500 mb-10 text-capitalize">
                     Welcome back
                     <div class="weight-600 font-30 text-blue">{{Auth::User()->name}}</div>
                  </h4>
                  <p class="font-18 max-width-600 text-justify">
                       Toko Syukurilah PS adalah toko yang bergerak dalam bidang penjualan berbagai jenis obat ayam, mulai dari vitamin, jamu, antibiotik, hingga suplemen penambah stamina. Kami menyediakan produk berkualitas terpercaya dengan harga yang terjangkau untuk mendukung kesehatan dan performa unggas Anda.
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection