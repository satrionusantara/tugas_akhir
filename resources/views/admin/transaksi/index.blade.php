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
                <div class="col-md-6 col-sm-12 text-right">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="form-group  ml-2 mb-0">
                            <input type="date" class="form-control" max="date('Y-m-d')"
                                onchange="location = '/admin/transaksi/filter/'+this.value;" value="{{ $tgl }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Striped table start -->
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <div class="pull-left">
                    <h2 class="text-primary h2"><i class="icon-copy dw dw-list"></i> List Data Transaksi</h2>
                </div>
                <div class="pull-right">
                    <a href="/admin/transaksi/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Data</a>
                </div>
            </div>
            <hr style="margin-top: 0px;">
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
            <table class="table table-striped table-bordered data-table hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="5%">#</th>
                        <th>Nomor Nota</th>
                        <th>Tanggal</th>
                        <th>Pukul</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Exp Date</th>
                        <th>Harga</th>
                        <th>Bayar</th>
                        <!-- <th>Kembalian</th> -->
                        <th>Metode</th>
                        <th class="table-plus datatable-nosort text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    $total = 0; ?>
                    @foreach ($transaksi as $data)
                        <?php $total += $data->total ?? 0; ?>
                       <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $data->nomor_nota ?? '-' }}</td>
                    <td>{{ date('d M Y', strtotime($data->tanggal)) }}</td>
                    <td>{{ $data->pukul ?? '-' }}</td>
                    <td>{{ $data->nama_barang ?? '-' }}</td>
                    <td>{{ $data->jumlah }} {{$data->nama_satuan}}</td>
                    <td>{{ $data->exp_date ?? '-' }}</td>
                    <td class="text-left">{{ 'Rp ' . number_format($data->total ?? 0, 0, ',', '.') }}</td>
                    <td class="text-left">{{ 'Rp ' . number_format($data->bayar ?? 0, 0, ',', '.') }}</td>
                    <!-- <td class="text-left">{{ 'Rp ' . number_format($data->kembali ?? 0, 0, ',', '.') }}</td> -->
                    <td>{{ $data->metode_pembayaran ?? '-' }}</td>
                    
                    {{-- Tambahkan tombol cetak --}}
                    <td class="text-center">
                        <a href="{{ url('/admin/transaksi/cetak/' . $data->id) }}" target="_blank">
                            <button class="btn btn-primary btn-xs">
                                <i class="fa fa-print" data-toggle="tooltip" data-placement="top" title="Cetak Struk"></i>
                            </button>
                        </a>
                    </td>
                </tr>

                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-primary text-white">
                        <th colspan="10">Total Transaksi Keseluruhan</th>
                        <th class="text-left" colspan="1">{{ 'Rp ' . number_format($total ?? 0, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- Striped table End -->
    </div>
    <!-- Modal -->
    @foreach ($transaksi as $data)
        <div class="modal fade" id="data-{{ $data->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h2 class="text-center">
                            Apakah Anda Yakin Menghapus Data Ini ?
                        </h2>
                        <hr>
                        {{-- <div class="form-group" style="font-size: 17px;">
                            <label for="exampleInputUsername1">Nama Customer</label>
                            <input class="form-control" value="{{ $data->nama }}" readonly
                                style="background-color: white;pointer-events: none;">
                        </div> --}}
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="/admin/transaksi/delete/{{ $data->id }}" style="text-decoration: none;">
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
@endsection
