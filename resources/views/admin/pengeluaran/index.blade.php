@extends('admin.layouts.app', [
'activePage' => 'pengeluaran',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Data Pengeluaran</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Input</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data Pengeluaran</li>
               </ol>
            </nav>
         </div>
         <div class="col-md-6 col-sm-12 text-right">
             <div class="d-flex align-items-center justify-content-end">
                 <div class="form-group mb-0 ml-2">
                     <input type="month" required class="form-control" onchange="location = '/admin/pengeluaran/filter/'+this.value;" name="bln" value="{{$bln}}">
                 </div>
             </div>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-list"></i> List Data Pengeluaran</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/pengeluaran/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Data</a>
            <a href="/admin/pengeluaran/cetak/{{$bln}}" target="_blank" class="btn btn-dark btn-sm"><i class="fa fa-print"></i> Cetak Data</a>
         </div>
      </div>
      <hr style="margin-top: 0px;">
      @if (session('error'))
      <div class="alert alert-danger">
         {{ session('error')}}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      @endif
      @if (session('success'))
      <div class="alert alert-success">
         {{ session('success')}}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      @endif
      <table class="table table-striped table-bordered data-table hover">
         <thead class="bg-primary text-white">
            <tr>
               <th width="5%" >#</th>
               <th>Tanggal</th>
               <th>Keterangan</th>
               <th class="text-center">Metode Pengeluaran</th>
               <th class="text-center">Total</th>
               <th class="table-plus datatable-nosort text-center">Action</th>
            </tr>
         </thead>
         <tbody>
            <?php $no = 1; ?>
            @foreach($pengeluaran as $data)
            <tr>
               <td class="text-center">{{$no++}}</td>
               <td>{{date ('d M Y', strtotime($data->tanggal))}}</td>
               <td>{{ ucwords(strtolower($data->keterangan)) }}</td>
               <td class="text-center">{{ $data->nama_metode }}</td>
               <td>{{ 'Rp ' . number_format($data->total, 0, ',', '.') }}</td>
               <td class="text-center" width="15%">
                  <a href="/admin/pengeluaran/edit/{{$data->id}}"><button class="btn btn-success btn-xs"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Data"></i></button></a>
                  <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#data-{{$data->id}}"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete Data"></i></button>
               </td>
            </tr>
            @endforeach
         </tbody>
         <tfoot>
             <tr>
                 <th colspan="5">Total Pengeluaran</th>
                 <th>{{ 'Rp ' . number_format($total ?? '0', 0, ',', '.') }}</th>
             </tr>
         </tfoot>
      </table>
   </div>
   <!-- Striped table End -->
</div>
<!-- Modal -->
@foreach($pengeluaran as $data)
<div class="modal fade" id="data-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <h2 class="text-center">
            Apakah Anda Yakin Menghapus Data Ini ?
            <h2>
            <hr>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group" style="font-size: 17px;">
                     <label for="exampleInputUsername1">Tanggal Pengeluaran</label>
                     <input class="form-control" value="{{date ('d M Y', strtotime($data->tanggal))}}" readonly style="background-color: white;pointer-events: none;">
                  </div>   
               </div>
               <div class="col-md-6">
                  <div class="form-group" style="font-size: 17px;">
                     <label for="exampleInputUsername1">Keterangan Pengeluaran</label>
                     <input class="form-control" value="{{$data->keterangan}}" readonly style="background-color: white;pointer-events: none;">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group" style="font-size: 17px;">
                     <label for="exampleInputUsername1">Total Pengeluaran</label>
                     <input class="form-control" value="{{ 'Rp ' . number_format($data->total, 0, ',', '.') }}" readonly style="background-color: white;pointer-events: none;">
                  </div>
               </div>
            </div>
            <div class="row mt-2">
               <div class="col-md-6">
                  <a href="/admin/pengeluaran/delete/{{$data->id}}" style="text-decoration: none;">
                  <button type="button" class="btn btn-primary btn-block">Ya</button>
                  </a>
               </div>
               <div class="col-md-6">
                  <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" aria-label="Close">Tidak</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endforeach
@endsection