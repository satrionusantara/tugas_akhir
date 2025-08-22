@extends('admin.layouts.app', [
'activePage' => 'barang',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-12 col-sm-12">
            <div class="title">
               <h4>Data Barang</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Input</a></li>
                  <li class="breadcrumb-item"><a href="/admin/barang">Data Barang</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Data Barang</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-add-file-1"></i> Tambah Data Barang</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/barang" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
         </div>
      </div>
      <hr style="margin-top: 0px">
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
      <form action="/admin/barang/create" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}
         <div class="row">
            {{-- <div class="col-md-4">
               <div class="form-group">
                  <label>Type Sales<span class="text-danger">*</span></label>
                  <select class="select2" autofocus name="id_type" required id="typeSales">
                     <option value="1">Sales Lama</option>
                     <option value="2">Sales Baru</option>
                  </select>
               </div>
            </div> --}}
            <!-- Nama Sales Dropdown (Sales Lama) -->
            {{-- <div class="col-md-8" id="salesDropdown">
               <div class="form-group">
                  <label>Nama Sales<span class="text-danger">*</span></label>
                  <select class="select2" name="id_sales" required>
                     <option value="">-- Pilih Nama Sales --</option>
                     @foreach($sales as $data)
                        <option value="{{$data->id}}">{{$data->nama}}</option>
                     @endforeach
                  </select>
               </div>
            </div> --}}

            <!-- Input Fields (Sales Baru) -->
            {{-- <div class="col-md-3" id="inputNama" style="display: none;">
               <div class="form-group">
                  <label>Nama Sales<span class="text-danger">*</span></label>
                  <input type="text" name="nama" required class="form-control" placeholder="Masukkan Nama Sales .....">
               </div>
            </div>
            <div class="col-md-2" id="inputContact" style="display: none;">
               <div class="form-group">
                  <label>Contact Sales</label>
                  <input type="number" name="contact" class="form-control" placeholder="Masukkan Contact Sales .....">
               </div>
            </div>
            <div class="col-md-3" id="inputAlamat" style="display: none;">
               <div class="form-group">
                  <label>Alamat Sales</label>
                  <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat Sales .....">
               </div>
            </div> --}}

            <div class="col-md-4">
               <div class="form-group">
                  <label>Nama Barang<span class="text-danger">*</span></label>
                  <input type="text" name="nama_barang" required class="form-control" placeholder="Masukkan Nama Barang ....." value="" required>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <label>Stock Barang</label>
                  <input type="number" name="stock" class="form-control" placeholder="Masukkan Jumlah ....." step="any" required>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>Satuan</label>
                  <select class="select2" name="id_satuan" required>
                     <!-- <option value="">-- Pilih Satuan --</option> -->
                     @foreach($satuan as $data)
                        <option value="{{$data->id}}">{{$data->nama}}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>Harga Modal<span class="text-danger">*</span></label>
                  <input type="text" name="harga_modal" required class="form-control" placeholder="Masukkan Harga Jual ...."  oninput="formatNumber(this)">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>Harga Jual<span class="text-danger">*</span></label>
                  <input type="text" name="harga_jual" required class="form-control" placeholder="Masukkan Harga Modal ....." oninput="formatNumber(this)">
               </div>
            </div>
            {{-- <div class="col-md-6">
               <div class="form-group">
                  <label>Harga Kampas/Gudang</label>
                  <input type="text" name="harga_kampas" class="form-control" placeholder="Masukkan Harga Kampas/Gudang ....." oninput="formatNumber(this)">
               </div>
            </div> --}}
            {{-- <div class="col-md-6">
               <div class="form-group">
                  <label>Harga Khusus</label>
                  <input type="text" name="harga_khusus" class="form-control" placeholder="Masukkan Harga Khusus ....." oninput="formatNumber(this)">
               </div>
            </div> --}}
         </div>
         <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span> Tambah Data</button> 
      </form>
   </div>
   <!-- Striped table End -->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#typeSales').on('change', function() {
        let value = $(this).val();

        if (value == '1') {
            // Tampilkan dropdown, sembunyikan input manual
            $('#salesDropdown').show().find('select').attr('required', true);
            $('#inputNama, #inputContact, #inputAlamat').hide()
                .find('input').removeAttr('required');
        } else if (value == '2') {
            // Tampilkan input manual, sembunyikan dropdown
            $('#salesDropdown').hide().find('select').removeAttr('required');
            $('#inputNama').show().find('input').attr('required', true);
            $('#inputContact, #inputAlamat').show().find('input').removeAttr('required');
        } else {
            // Sembunyikan semua jika belum dipilih
            $('#salesDropdown').hide().find('select').removeAttr('required');
            $('#inputNama, #inputContact, #inputAlamat').hide()
                .find('input').removeAttr('required');
        }
    }).trigger('change'); // Agar jalan saat halaman load
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
<script>
	$(document).ready(function() {
	    $('.select2').select2();
    });
</script>
@endsection