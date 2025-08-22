@extends('admin.layouts.app', [
    'activePage' => 'transaksi',
])
@section('content')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Data Transaksi</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Data Proses</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Transaksi</li>
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
                        <a href="/admin/transaksi/edit/{{ $transaksi->id }}" class="edit-avatar"><i
                                class="fa fa-pencil"></i></a>
                        <img src="{{ url('assets-admin/vendors/images/checklist.png') }}" alt=""
                            class="avatar-photo"
                            style="width: 160px; height: 160px; object-fit: cover; object-position: center;" />
                    </div>
                    <div class="profile-info">
                        <h5 class="mb-20 h5 text-blue">Detail Transaksi</h5>
                        <ul>
                            <li>
                                <span>Nomor Transaksi :</span>
                                #BLZ{{ date('dmY', strtotime($transaksi->tanggal)) }}{{ $transaksi->id }}
                            </li>
                            <li>
                                <span>Tanggal Transaksi :</span>
                                {{ date('d M Y', strtotime($transaksi->tanggal)) }}
                            </li>
                            <li>
                                <span>Pukul Transaksi :</span>
                                {{ $transaksi->pukul }} WIB
                            </li>
                            <li>
                                <span>Contact Customer :</span>
                                {{ $transaksi->contact ?? '-' }}
                            </li>
                            <li>
                                <span>Alamat Customer :</span>
                                {{ $transaksi->alamat ?? '-' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 mb-30">
                <div class="pd-20 card-box height-100-p">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form action="/admin/transaksi/detail/create/{{ $transaksi->id }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jenis Harga</label>
                                    <select class="form-control" id="id_jenis" name="id_jenis">
                                        <option value="1">Harga Biasa</option>
                                        <option value="2">Harga Kampas</option>
                                        <option value="3">Harga Khusus</option>
                                        <option value="4">Harga Custom</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7" id="cari_barang">
                                <div class="form-group">
                                    <label>Cari Barang</label>
                                    <select class="form-control select2" id="id_barang" name="id_barang">
                                        <option value="">-- Cari Barang --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" style="display: none;">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" name="nama" class="form-control"
                                        placeholder="Nama Barang ....." oninput="this.value = this.value.toUpperCase();">
                                </div>
                            </div>

                            <div class="col-md-2" style="display: none;">
                                <div class="form-group">
                                    <label>Harga Barang</label>
                                    <input type="text" name="harga" class="form-control"
                                        placeholder="Harga Barang ....." oninput="formatNumberInput(this)" id="harga">
                                </div>
                            </div>

                            <div class="col-md-2" style="display: none;">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <select class="form-control select2" name="satuan">
                                        @foreach ($satuan as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="text" name="jumlah" required class="form-control"
                                        placeholder="Jumlah ....." oninput="formatNumberInput(this)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control"
                                        placeholder="Masukkan Keterangan ....." oninput="capitalizeWords(this)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Diskon</label>
                                    <input type="text" name="diskon" id="diskon" required class="form-control"
                                        placeholder="Diskon ....." oninput="formatNumberInput(this)" value="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Harga</label>
                                    <input type="text" name="total" id="total" required class="form-control"
                                        placeholder="Total Harga ....." oninput="formatNumberInput(this)">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span>
                            Tambah Data</button>
                    </form>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped data-table hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th width="5%" class="text-center align-middle">#</th>
                                    <th class="align-middle">Nama Barang</th>
                                    <th class="align-middle">Jumlah</th>
                                    <th class="text-center align-middle">Harga</th>
                                    <th class="text-center align-middle">Diskon</th>
                                    <th class="text-center align-middle" width="20%">Total Harga</th>
                                    <th class="table-plus datatable-nosort text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($detail_transaksi as $data)
                                    <?php
                                    $barang = DB::table('barang')->find($data->id_barang ?? '-');
                                    $satuan = DB::table('satuan')->find($barang->id_satuan ?? '-');
                                    ?>
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td width="25%">{{ $data->nama }}
                                            @if ($data->keterangan != '')
                                                <br><b>Keterangan : </b><i>{{ $data->keterangan }}</i>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $data->jumlah }} {{ $data->satuan ?? '' }}</td>
                                        <td width="15%">{{ 'Rp ' . number_format($data->harga, 0, ',', '.') }}</td>
                                        <td width="15%">{{ 'Rp ' . number_format($data->diskon, 0, ',', '.') }}</td>
                                        <td>{{ 'Rp ' . number_format($data->total, 0, ',', '.') }}</td>
                                        <td class="text-center" width="10%">
                                            @if ($transaksi->status != '1')
                                                <a href="/admin/transaksi/detail/edit/{{ $data->id }}"><button
                                                        class="btn btn-success btn-xs"><i class="fa fa-edit"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Edit Data"></i></button></a>
                                                <button class="btn btn-danger btn-xs" data-toggle="modal"
                                                    data-target="#data-{{ $data->id }}"><i class="fa fa-trash"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Delete Data"></i></button>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total Bayar</th>
                                    <th colspan="2">{{ 'Rp ' . number_format($transaksi->total, 0, ',', '.') }}</th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <th colspan="5">Total Bayar</th>
                                    <th colspan="2">{{ 'Rp ' . number_format($transaksi->total, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="5">Potongan</th>
                                    <th colspan="2">{{ 'Rp ' . number_format($transaksi->potongan, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="5">Bayar</th>
                                    <th colspan="2">{{ 'Rp ' . number_format($transaksi->bayar, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="5">Kembali</th>
                                    <th colspan="2">{{ 'Rp ' . number_format($transaksi->kembali, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Striped table End -->
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisSelect = document.getElementById('id_jenis');
            const cariBarangDiv = document.getElementById('cari_barang');
            const namaBarangDiv = document.querySelector('input[name="nama"]').closest('[class^="col-md"]');
            const hargaBarangDiv = document.querySelector('input[name="harga"]').closest('[class^="col-md"]');
            const satuanDiv = document.querySelector('select[name="satuan"]').closest('[class^="col-md"]');

            function toggleBarangFields() {
                if (jenisSelect.value === '4') {
                    cariBarangDiv.style.display = 'none';
                    namaBarangDiv.style.display = 'block';
                    hargaBarangDiv.style.display = 'block';
                    satuanDiv.style.display = 'block';
                } else {
                    cariBarangDiv.style.display = 'block';
                    namaBarangDiv.style.display = 'none';
                    hargaBarangDiv.style.display = 'none';
                    satuanDiv.style.display = 'none';
                }
            }

            // Jalankan saat load awal
            toggleBarangFields();

            // Jalankan saat ada perubahan pada select
            jenisSelect.addEventListener('change', toggleBarangFields);
        });
    </script>

    <script>
        function formatNumberInput(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = new Intl.NumberFormat('id-ID').format(value);
        }

        function parseFormattedNumber(str) {
            return parseInt(str.replace(/\D/g, '')) || 0;
        }
    </script>

    <script>
        $(document).ready(function() {
            // Inisialisasi select2
            $('#id_barang').select2({
                placeholder: '-- Cari Barang --',
                allowClear: true,
                ajax: {
                    url: '/admin/search-barang',
                    dataType: 'json',
                    delay: 300,
                    data: function(params) {
                        return {
                            q: params.term || '',
                            jenis: $('#id_jenis').val(),
                            cabang: cabangId
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(barang => ({
                                id: barang.id,
                                text: `${barang.nama} (${barang.stock} ${barang.nama_satuan}) | Rp ${Number(barang.harga).toLocaleString('id-ID')}`,
                                harga: barang.harga
                            }))
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });

            // Bersihkan barang saat jenis berubah
            $('#id_jenis').on('change', function() {
                $('#id_barang').val(null).trigger('change');
            });

            // Event barang dipilih
            $('#id_barang').on('select2:select', function(e) {
                const selectedData = e.params.data;
                const harga = selectedData.harga || 0;
                $('#harga').val(new Intl.NumberFormat('id-ID').format(harga));
                hitungTotal();
            });

            // Event perubahan input
            $('#harga, #diskon, input[name="jumlah"]').on('input', function() {
                hitungTotal();
            });

            function hitungTotal() {
                const harga = parseFormattedNumber($('#harga').val());
                const jumlah = parseFormattedNumber($('input[name="jumlah"]').val());
                const diskon = parseFormattedNumber($('#diskon').val());
                const total = (harga * jumlah) - diskon;

                $('#total').val(new Intl.NumberFormat('id-ID').format(total));
            }
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="hutang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">
                        Apakah Anda Yakin Menghutangkan Data Ini ?
                    </h2>
                    <hr>
                    <form action="/admin/transaksi/hutang/{{ $transaksi->id }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" style="font-size: 17px;">
                                    <label for="exampleInputUsername1">Nama Customer</label>
                                    <input class="form-control" value="{{ $transaksi->nama ?? '-' }}" readonly
                                        style="background-color: white;pointer-events: none;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="font-size: 17px;">
                                    <label for="exampleInputUsername1">Total Harga</label>
                                    <input class="form-control"
                                        value="{{ 'Rp ' . number_format($transaksi->total, 0, ',', '.') }}" readonly
                                        style="background-color: white;pointer-events: none;">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block">Ya</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"
                                    aria-label="Close">Tidak</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">
                        Apakah Anda Yakin Membayar Data Ini ?
                    </h2>
                    <hr>
                    <form action="/admin/transaksi/bayar/{{ $transaksi->id }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="font-size: 17px;">
                                    <label for="exampleInputUsername1">Nama Customer</label>
                                    <input class="form-control" value="{{ $transaksi->nama ?? '-' }}" readonly
                                        style="background-color: white;pointer-events: none;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="font-size: 17px;">
                                    <label for="exampleInputUsername1">Total Harga</label>
                                    <input class="form-control"
                                        value="{{ 'Rp ' . number_format($transaksi->total, 0, ',', '.') }}" readonly
                                        style="background-color: white;pointer-events: none;">
                                    <input type="hidden" name="total_harga" id="total_harga" required
                                        value="{{ $transaksi->total }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="font-size: 17px;">
                                    <label for="exampleInputUsername1">Potongan</label>
                                    <input type="text" name="potongan" id="potongan" required class="form-control"
                                        placeholder="Potongan ....." oninput="formatNumberInput(this)" value="0">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" style="font-size: 17px;">
                                    <label for="total_pembayaran">Total Pembayaran</label>
                                    <input type="text" id="total_pembayaran_display" class="form-control" readonly>
                                    <input type="hidden" name="total_pembayaran" id="total_pembayaran">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="font-size: 17px;">
                                    <label for="exampleInputUsername1">Nominal Yang Dibayar</label>
                                    <input type="text" name="bayar" id="bayar" required class="form-control"
                                        placeholder="Bayar ....." oninput="formatNumberInput(this)" value="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="font-size: 17px;">
                                    <label for="exampleInputUsername1">Metode Pembayaran</label>
                                    <select class="form-control" name="id_metode" required>
                                        <option value="">-- Pilih Metode Pembayaran --</option>
                                        @foreach ($metode as $data2)
                                            <option value="{{ $data2->id }}">{{ $data2->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" style="font-size: 17px;">
                                    <label for="kembali">Kembalian</label>
                                    <input type="text" id="kembali_display" class="form-control" readonly>
                                    <input type="hidden" name="kembali" id="kembali">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <button type="submit" id="btnBayar"
                                    class="btn btn-primary btn-block d-none">Bayar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalHargaInput = document.getElementById('total_harga');
            const potonganInput = document.getElementById('potongan');
            const totalPembayaranDisplay = document.getElementById('total_pembayaran_display');
            const totalPembayaranInput = document.getElementById('total_pembayaran');
            const bayarInput = document.getElementById('bayar');
            const kembaliDisplay = document.getElementById('kembali_display');
            const kembaliInput = document.getElementById('kembali');
            const btnBayar = document.getElementById('btnBayar');

            function parseNumber(str) {
                return parseInt(str.replace(/\D/g, '')) || 0;
            }

            function formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            }

            function formatNumberInput(el) {
                const value = parseNumber(el.value);
                el.value = formatNumber(value);
            }

            function hitungPembayaran() {
                const totalHarga = parseNumber(totalHargaInput.value);
                const potongan = parseNumber(potonganInput.value);
                const bayar = parseNumber(bayarInput.value);

                const totalPembayaran = totalHarga - potongan;
                const kembali = bayar - totalPembayaran;

                // Update hidden input untuk dikirim ke server
                totalPembayaranInput.value = totalPembayaran;
                kembaliInput.value = kembali > 0 ? kembali : 0;

                // Update tampilan
                totalPembayaranDisplay.value = formatNumber(totalPembayaran);
                kembaliDisplay.value = formatNumber(kembali > 0 ? kembali : 0);

                // Kontrol tombol bayar
                if (bayar >= totalPembayaran && totalPembayaran > 0) {
                    btnBayar.classList.remove('d-none'); // tampilkan tombol bayar
                } else {
                    btnBayar.classList.add('d-none'); // sembunyikan tombol bayar
                }
            }

            // Event listener
            potonganInput.addEventListener('input', function() {
                formatNumberInput(this);
                hitungPembayaran();
            });

            bayarInput.addEventListener('input', function() {
                formatNumberInput(this);
                hitungPembayaran();
            });

            // Jalankan saat halaman pertama kali load
            hitungPembayaran();
        });
    </script>

    <script>
        function formatNumberInput(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = new Intl.NumberFormat('id-ID').format(value);
        }
    </script>

    @foreach ($detail_transaksi as $data)
        <?php
        $barang = DB::table('barang')->find($data->id_barang);
        ?>
        <div class="modal fade" id="data-{{ $data->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2 class="text-center">
                            Apakah Anda Yakin Menghapus Data Ini ?
                        </h2>
                        <hr>
                        <div class="form-group" style="font-size: 17px;">
                            <label for="exampleInputUsername1">Nama Barang</label>
                            <input class="form-control" value="{{ $data->nama ?? '-' }}" readonly
                                style="background-color: white;pointer-events: none;">
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="/admin/transaksi/detail/delete/{{ $data->id }}"
                                    style="text-decoration: none;">
                                    <button type="button" class="btn btn-primary btn-block">Ya</button>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"
                                    aria-label="Close">Tidak</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function capitalizeWords(input) {
            input.value = input.value.replace(/\b\w/g, function(char) {
                return char.toUpperCase();
            });
        }
    </script>
@endsection
