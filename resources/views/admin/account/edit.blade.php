@extends('admin.layouts.app', [
    'activePage' => 'account',
])
@section('content')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Data Akun Kasir</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Data Input</a></li>
                            <li class="breadcrumb-item"><a href="/admin/account">Data Akun Kasir</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Data Akun Kasir</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Striped table start -->
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <div class="pull-left">
                    <h2 class="text-primary h2"><i class="icon-copy dw dw-edit-1"></i> Edit Data Akun Kasir</h2>
                </div>
                <div class="pull-right">
                    <a href="/admin/account" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
            <hr style="margin-top: 0px">
            <form action="/admin/account/update/{{ $account->id }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Account<span class="text-danger">*</span></label>
                            <input type="text" autofocus name="name" required class="form-control"
                                value="{{ $account->name }}" placeholder="Masukkan Nama Account .....">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Username Account<span class="text-danger">*</span></label>
                            <input type="text" name="username" required class="form-control"
                                value="{{ $account->username }}" placeholder="Masukkan Username Account .....">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span> Update
                    Data</button>
            </form>
        </div>
        <!-- Striped table End -->
    </div>
@endsection
