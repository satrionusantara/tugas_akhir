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
                  <li class="breadcrumb-item"><a href="/admin/barang">Data Barang</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Data Barang Masuk</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
<div class="row">
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 mb-30">
         <div class="pd-20 card-box height-100-p">
            <div class="profile-photo">
               <a
                  href="/admin/barang_masuk/edit/{{$barang_masuk->id}}"
                  class="edit-avatar"
                  ><i class="fa fa-pencil"></i
                  ></a>
                  <img
                      src="{{url('assets-admin/vendors/images/browsing.png')}}"
                      alt=""
                      class="avatar-photo" style="width: 160px; height: 160px; object-fit: cover; object-position: center;"
                   />
            </div>
            <h5 class="text-center h5 mb-2">{{$sales->nama ?? '-'}}</h5>
            <p class="text-center text-muted font-14">{{$sales->alamat ?? '-'}}</p>
            <div class="profile-info">
               <h5 class="mb-20 h5 text-blue">Detail Barang</h5>
               <ul>
                  <li>
                     <span>Jenis Barang :</span>
                     {{$jenis->nama ?? '-'}}
                  </li>
                  <li>
                     <span>Tanggal Nota/Faktur :</span>
                     {{date ('d M Y', strtotime($barang_masuk->tanggal))}}
                  </li>
                  <li>
                     <span>Nomor Nota/Faktur :</span>
                     {{$barang_masuk->nomor}}
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 mb-30">
         <div class="pd-20 card-box height-100-p">
            <div class="clearfix">
               <div class="pull-left">
                  <h2 class="text-primary h2"><i class="icon-copy fa fa-address-card"></i> List Detail Barang</h2>
               </div>
               <div class="pull-right">
                  <a href="/admin/barang" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
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
            <form action="/admin/barang_masuk/detail/create/{{$barang_masuk->id}}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               <input type="hidden" name="id_sales" class="form-control" value="{{$sales->id}}">
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Type Barang<span class="text-danger">*</span></label>
                        <select class="select2" autofocus name="id_type" required id="typeSales">
                           <option value="1">Barang Lama</option>
                           <option value="2">Barang Baru</option>
                        </select>
                     </div>
                  </div>
                  <!-- Tambahkan ID pada elemen-elemen untuk manipulasi -->
                  <div class="col-md-8" id="selectBarangGroup">
                     <div class="form-group">
                        <label>Nama Barang<span class="text-danger">*</span></label>
                        <select class="select2" name="id_barang" id="selectBarang" class="form-control" required>
                           <option value="">-- Pilih Nama Barang --</option>
                           @foreach($barang as $data)
                              <option value="{{$data->id}}">{{$data->nama}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>

                  <div class="col-md-8" id="inputBarangGroup" style="display: none;">
                     <div class="form-group">
                        <label>Nama Barang<span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="inputBarang" class="form-control" placeholder="Masukkan Nama Barang .....">
                     </div>
                  </div>

                  <div class="col-md-2">
                     <div class="form-group">
                        <label>Jumlah<span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Masukkan Jumlah ....." step="any">
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label>Satuan<span class="text-danger">*</span></label>
                        <select class="select2" name="id_satuan" required>
                           <!-- <option value="">-- Pilih Satuan --</option> -->
                           @foreach($satuan as $data)
                              <option value="{{$data->id}}">{{$data->nama}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Harga<span class="text-danger">*</span></label>
                        <input type="text" name="harga" class="form-control" placeholder="Masukkan Harga ....." oninput="formatNumber(this)">
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label>Diskon</label>
                        <input type="number" name="diskon" class="form-control" placeholder="Masukkan Diskon ....." value="0">
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label style="color:white">Action</label>
                        <button type="submit" class="btn btn-primary btn-block"><span class="icon-copy ti-plus"></span></button>
                     </div>
                  </div>
               </div>
            </form>
            <table class="table table-bordered table-striped data-table hover">
               <thead class="bg-primary text-white">
                  <tr>
                     <th width="5%" class="text-center align-middle text-center">#</th>
                     <th class="align-middle text-center">Nama Barang</th>
                     <th class="align-middle text-center">Jumlah</th>
                     <th class="text-center align-middle text-center">Harga</th>
                     <th class="text-center align-middle text-center">Diskon</th>
                     <th class="text-center align-middle text-center">Sub Total</th>
                     <th class="table-plus datatable-nosort text-center align-middle">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $no = 1; $total_harga = 0; ?>
                  @foreach($detail_barang_masuk as $data)
                  <?php
                     $nama_satuan = DB::table('satuan')->find($data->id_satuan);
                     $nama_barang = DB::table('barang')->find($data->id_barang);
                     $total_harga += $data->total;
                  ?>
                  <tr>
                     <td class="text-center">{{$no++}}</td>
                     <td class="text-left">{{$nama_barang->nama ?? '-'}}</td>
                     <td class="text-center">{{$data->jumlah}} {{$nama_satuan->nama ?? '-'}}</td>
                     <td class="text-left" width="15%">{{ 'Rp ' . number_format($data->harga, 0, ',', '.') }}</td>
                     <td class="text-center" width="5%">{{$data->diskon}}</td>
                     <td class="text-left" width="17%">{{ 'Rp ' . number_format($data->total, 0, ',', '.') }}</td>
                     <td class="text-center" width="10%">
                        <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#edit-{{$data->id}}"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit Data"></i></button>
                        <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete-{{$data->id}}"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete Data"></i></button>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
               <tfoot>
                   <thead>
                       <th colspan="5">Total Pembelian</th>
                       <th colspan="2">{{ 'Rp ' . number_format($total_harga, 0, ',', '.') }}</th>
                   </tr>
               </tfoot>
            </table>
         </div>
      </div>
   </div>
   <!-- Striped table End -->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#typeSales').on('change', function() {
        let selected = $(this).val();

        if (selected === '1') {
            // Barang Lama: tampilkan select
            $('#selectBarangGroup').show();
            $('#selectBarang').attr('required', true);

            $('#inputBarangGroup').hide();
            $('#inputBarang').removeAttr('required');
        } else if (selected === '2') {
            // Barang Baru: tampilkan input
            $('#inputBarangGroup').show();
            $('#inputBarang').attr('required', true);

            $('#selectBarangGroup').hide();
            $('#selectBarang').removeAttr('required');
        }
    }).trigger('change'); // Trigger awal supaya sesuai kondisi saat halaman dimuat
});
</script>
<script>
   function formatNumber(input) {
       // Menghapus semua karakter kecuali angka
       let value = input.value.replace(/\D/g, '');
       
       // Menambahkan format pemisah ribuan
       input.value = new Intl.NumberFormat().format(value);
   }
</script>
@foreach($detail_barang_masuk as $data)
<?php
   $nama_barang = DB::table('barang')->find($data->id_barang);
?>
<div class="modal fade" id="edit-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <h2 class="text-center">
            Apakah Anda Yakin Mengupdate Data Ini ?
            </h2>
            <hr>
            <form action="/admin/barang_masuk/detail/update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type='hidden' name="id_barang" value="{{$nama_barang->id}}">
                <div class="row">
                   <div class="col-md-12">
                      <div class="form-group" style="font-size: 14px;">
                         <label>Nama Barang<span class="text-danger">*</span></label>
                         <input type="text" name="nama" required class="form-control" placeholder="Masukkan Nama Barang ....." value="{{$nama_barang->nama}}">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group" style="font-size: 14px;">
                         <label>Jumlah<span class="text-danger">*</span></label>
                         <input type="number" name="jumlah" class="form-control" placeholder="Masukkan Jumlah ....." value="{{$data->jumlah}}" step="any">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group" style="font-size: 14px;">
                         <label>Satuan<span class="text-danger">*</span></label>
                         <select class="select2" name="id_satuan" required>
                           <!-- <option value="">-- Pilih Satuan --</option> -->
                           @foreach($satuan as $data2)
                              <option value="{{$data2->id}}" @if($data->id_satuan == $data2->id) selected @endif>{{$data2->nama}}</option>
                           @endforeach
                        </select>
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group" style="font-size: 14px;">
                         <label>Harga<span class="text-danger">*</span></label>
                         <input type="text" name="harga" class="form-control" placeholder="Masukkan Harga ....." oninput="formatNumber(this)" value="{{number_format($data->harga, 0, ',', '.') }}">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group" style="font-size: 14px;">
                         <label>Diskon</label>
                         <input type="number" name="diskon" class="form-control" placeholder="Masukkan Diskon ....." value="{{$data->diskon}}">
                      </div>
                   </div>
                </div>
                <div class="row mt-2">
                   <div class="col-md-6">
                      <button type="submit" class="btn btn-primary btn-block">Ya</button>
                   </div>
                   <div class="col-md-6">
                      <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" aria-label="Close">Tidak</button>
                   </div>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="delete-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <h2 class="text-center">
            Apakah Anda Yakin Menghapus Data Ini ?
            </h2>
            <hr>
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group" style="font-size: 17px;">
                     <label for="exampleInputUsername1">Nama Barang</label>
                     <input class="form-control" value="{{$nama_barang->nama}}" readonly style="background-color: white;pointer-events: none;">
                  </div>
               </div>
            </div>
            <div class="row mt-2">
               <div class="col-md-6">
                  <a href="/admin/barang_masuk/detail/delete/{{$data->id}}" style="text-decoration: none;">
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
<script>
	$(document).ready(function() {
	    $('.select2').select2();
    });
</script>
@endsection