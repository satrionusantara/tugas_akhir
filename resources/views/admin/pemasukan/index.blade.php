@extends('admin.layouts.app', [
    'activePage' => 'pemasukan',
])
@section('content')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Data Pemasukan</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Data Input</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Pemasukan</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="form-group mb-0 ml-2">
                            <input type="month" required class="form-control"
                                onchange="location = '/admin/pemasukan/filter/'+this.value;" name="bln"
                                value="{{ $bln }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Striped table start -->
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <div class="pull-left">
                    <h2 class="text-primary h2"><i class="icon-copy dw dw-list"></i> List Data Pemasukan</h2>
                </div>
                <div class="pull-right">
                    <a href="/admin/pemasukan/cetak/{{ $bln }}" target="_blank" class="btn btn-dark btn-sm"><i
                            class="fa fa-print"></i> Cetak Data</a>
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
                        <th class="text-center">#</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Exp Date</th>
                        <th class="text-center">Metode Pembayaran</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    $total = 0; ?>
                    @foreach ($pemasukan as $data)
                        <?php
                        $metode = DB::table('metode')->find($data->id_metode);
                        $total += $data->total;
                        ?>
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ date('d M Y', strtotime($data->tanggal)) }}</td>
                            <td>{{ ucwords(strtolower($data->nama_barang)) }}</td>
                            <td>{{ $data->exp_date }}</td>
                            <td class="text-center">{{ $data->nama_metode ?? '-' }}</td>
                            <td>{{ 'Rp ' . number_format($data->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">Total Pemasukan</th>
                        <th>{{ 'Rp ' . number_format($total ?? '0', 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- Striped table End -->
    </div>
@endsection
