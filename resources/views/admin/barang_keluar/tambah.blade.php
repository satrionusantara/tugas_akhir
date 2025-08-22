@extends('admin.layouts.app', [
'activePage' => 'barang_keluar',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-12 col-sm-12">
            <div class="title">
               <h4>Data Barang Keluar</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Input</a></li>
                  <li class="breadcrumb-item"><a href="/admin/barang_keluar">Data Barang Keluar</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Data Barang Keluar</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-add-file-1"></i> Tambah Data Barang Keluar</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/barang_keluar" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
         </div>
      </div>
      <hr style="margin-top: 0px">
      <form action="/admin/barang_keluar/create" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Barang <span class="text-danger">*</span></label>
                    <select autofocus class="select2 form-control" name="id_barang" id="id_barang" required>
                        <option value="">-- Pilih Nama Barang --</option>
                        @foreach($barang as $data)
                            <option value="{{ $data->id }}">
                                {{ $data->nama }} 
                                @if($data->warna) Warna {{ $data->warna }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Ukuran <span class="text-danger">*</span></label>
                    <select class="select2 form-control" name="ukuran" id="ukuran" required>
                        <option value="">-- Pilih Ukuran --</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Stock Saat Ini <span class="text-danger">*</span></label>
                    <input type="text" name="stock" id="stock" required class="form-control" placeholder="Masukkan Stock Saat Ini ....." style="pointer-events: none;">
                </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>Tanggal Barang Keluar<span class="text-danger">*</span></label>
                  <input type="date" name="tanggal" required class="form-control" placeholder="Masukkan Tanggal Barang Keluar ....." value="{{date('Y-m-d')}}">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>Jumlah Barang Keluar<span class="text-danger">*</span></label>
                  <input type="text" name="jumlah" required class="form-control" placeholder="Masukkan Jumlah Barang Keluar ....." value="" oninput="formatNumber(this)">
               </div>
            </div>
         </div>
         <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span> Tambah Data</button>
      </form>
   </div>
   <!-- Striped table End -->
</div>
<!-- JavaScript untuk Fetch Ukuran -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#id_barang").on("change", function () {
            let id_barang = $(this).val();
            let ukuranSelect = $("#ukuran");
            let stockInput = $("#stock");

            // Reset ukuran dan stok
            ukuranSelect.empty().append('<option value="">-- Pilih Ukuran --</option>').prop("disabled", true);
            stockInput.val("").prop("disabled", true);

            if (id_barang) {
                $.ajax({
                    url: `/admin/barang/get-ukuran/${id_barang}`,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        ukuranSelect.append('<option disabled>Loading...</option>');
                    },
                    success: function (data) {
                        ukuranSelect.empty().append('<option value="">-- Pilih Ukuran --</option>');

                        if (data.length === 0) {
                            alert("Tidak ada ukuran tersedia untuk barang ini!");
                        } else {
                            let fragment = document.createDocumentFragment();
                            data.forEach(item => {
                                let option = new Option(item.ukuran, item.id);
                                fragment.appendChild(option);
                            });

                            ukuranSelect.append(fragment).prop("disabled", false);
                        }
                    },
                    error: function () {
                        alert("Terjadi kesalahan saat mengambil data ukuran.");
                    }
                });
            } else {
                ukuranSelect.prop("disabled", true);
            }
        });

        // Ketika ukuran dipilih, ambil stok dari server
        $("#ukuran").on("change", function () {
            let id_ukuran = $(this).val();
            let stockInput = $("#stock");

            stockInput.val("Loading...").prop("disabled", true);

            if (id_ukuran) {
                $.ajax({
                    url: `/admin/barang/get-stock/${id_ukuran}`,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        if (data && data.stock !== undefined) {
                            stockInput.val(data.stock).prop("disabled", false);
                        } else {
                            stockInput.val("0").prop("disabled", false);
                        }
                    },
                    error: function () {
                        stockInput.val("Error").prop("disabled", false);
                        alert("Terjadi kesalahan saat mengambil data stok.");
                    }
                });
            }
        });
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
@endsection