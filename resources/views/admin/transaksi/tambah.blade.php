@extends('admin.layouts.app', [
    'activePage' => 'transaksi',
])
@section('content')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>Data Transaksi</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Data Proses</a></li>
                            <li class="breadcrumb-item"><a href="/admin/transaksi">Data Transaksi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Data Transaksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Striped table start -->
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <div class="pull-left">
                    <h2 class="text-primary h2"><i class="icon-copy dw dw-add-file-1"></i> Tambah Data Transaksi</h2>
                </div>
                <div class="pull-right">
                    <a href="/admin/transaksi" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
              @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <hr style="margin-top: 0px">
            <form action="/admin/transaksi/create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor Nota<span class="text-danger">*</span></label>
                            <input type="text" name="nomor_nota" required class="form-control" value="{{$nomor_nota}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal<span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" required class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pukul<span class="text-danger">*</span></label>
                            <input type="time" name="pukul" required class="form-control" value="{{ date('H:i') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Barang<span class="text-danger">*</span></label>
                            <select class="form-control select2" id="id_barang" name="id_barang">
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barang as $data)
                                    <option value="{{ $data->id }}" data-harga-jual="{{ $data->harga_jual }}">
                                        {{ $data->nama_barang }} ({{$data->stock}})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="text" id="jumlah" name="jumlah" class="form-control"
                                placeholder="Masukkan Jumlah Barang .....">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Total</label>
                            <input type="text" id="total" name="total" class="form-control" readonly
                                oninput="formatNumber(this)">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Potongan</label>
                            <input type="text" id="potongan" name="potongan" class="form-control"
                                placeholder="Masukkan Potongan ....." oninput="formatNumber(this)">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bayar</label>
                            <input type="text" id="bayar" name="bayar" class="form-control"
                                placeholder="Masukkan Jumlah Bayar ....." oninput="formatNumber(this)">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kembali</label>
                            <input type="text" id="kembali" name="kembali" class="form-control"
                                placeholder="Masukkan Kembali ....." readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <select class="form-control" name="id_metode">
                                <option value="">-- Pilih Metode --</option>
                                @foreach ($metode as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span> Simpan
                    Data</button>
              
            </form>
        </div>
        <!-- Striped table End -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function () {
        $('.select2').select2();

        function cleanNumber(value) {
            return parseInt((value || '0').toString().replace(/\D/g, '')) || 0;
        }

        function hitungTotal() {
            let harga_jual = $('#id_barang').find(':selected').data('harga-jual') || 0;
            let jumlah = cleanNumber($('#jumlah').val());
            let potongan = cleanNumber($('#potongan').val());

            let total = (harga_jual * jumlah) - potongan;
            $('#total').val(new Intl.NumberFormat().format(total >= 0 ? total : 0));

            hitungKembali();
        }

        function hitungKembali() {
            let total = cleanNumber($('#total').val());
            let bayar = cleanNumber($('#bayar').val());
            let kembali = bayar - total;
            $('#kembali').val(new Intl.NumberFormat().format(kembali >= 0 ? kembali : 0));
        }

        function formatNumber(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = new Intl.NumberFormat().format(value);
        }

        // Event listeners
        $('#id_barang').on('change', hitungTotal);
        $('#jumlah').on('input', function () {
            formatNumber(this);
            hitungTotal();
        });
        $('#potongan').on('input', function () {
            formatNumber(this);
            hitungTotal();
        });
        $('#bayar').on('input', function () {
            formatNumber(this);
            hitungKembali();
        });
    });
</script>

@endsection
