<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pemasukan Bulan {{ $formattedBulan }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="shortcut icon" href="favicon.ico" />
    <style>
        .footer {
            position: fixed;
            bottom: -50px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            line-height: 35px;
        }
    </style>
</head>

<body>
    <div style="margin-top:-30px; margin-bottom:0px">
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <!-- <td width="15%" class="text-center">
                    <img src="{{ public_path('assets-admin/src/images/logo-ayam.png') }}" width="100%">
                </td> -->
                <td class="text-center">
                    <p style="font-size:18px;font-weight: bold;font-family: 'Arial', sans-serif;">
                        <span style="font-size:30px">TOKO SYUKURILAH</span><br>
                        <span style="font-size:13px; line-height:1.2; display:block; margin-bottom:5px;">
                            Jorong Rajawali, Lintau Buo, Tanah Datar, Sumatera Barat <br>
                            &nbsp;<img src="{{ public_path('assets-admin/vendors/images/old-typical-phone.png') }}"
                                width="15px" style="vertical-align: middle;">&nbsp;
                            Telp. 0813-7849-4337 Kode Pos 25513<br>
                        </span>
                    </p>
                </td>
            </tr>
        </table>
        <hr style="border: 1px solid #000; margin-top: -5px; margin-bottom: 10px;">
        <hr style="border: 2px solid #000; margin-top: -15px; margin-bottom: 10px;">
        <p style="font-size:18px; font-family: 'Arial', sans-serif;font-weight: bold;text-align: center;"><u
                style="border-bottom: 2px solid #000;">LAPORAN DATA PEMASUKAN BULAN
                {{ strtoupper($formattedBulan) }}</u></p>
        <table border="1" cellpadding="3" cellspacing="0" width="100%"
            style="font-size:13px; font-family: 'Arial', sans-serif;">
            <thead>
                <tr style="background-color: #1b00ff; color: white;">
                    <th class="text-center" width="5%">#</th>
                    <th width="15%">Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Exp Date</th>
                    <th class="text-center" width="20%">Metode Pemasukan</th>
                    <th class="text-center" width="20%">Total</th>
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
                        <td>{{ ucwords(strtolower($data->exp_date)) }}</td>
                        <td class="text-center">{{ $data->nama_metode ?? '-' }}</td>
                        <td>{{ 'Rp ' . number_format($data->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="background-color: #1b00ff; color: white;">Total Pemasukan</th>
                    <th style="background-color: #1b00ff; color: white;">
                        {{ 'Rp ' . number_format($total ?? '0', 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
        <table border="0" cellpadding="2" cellspacing="0" width="100%"
            style="font-size:14px; font-family: 'Arial', sans-serif;">
            <tr>
                <td width="50%" class="text-center"></td>
                <td width="50%" class="text-center">
                    <span style="margin-top: 10px;"><br>Lintau Buo,
                     {{\Carbon\Carbon::parse(date('Y-m-d'))->locale('id')->translatedFormat('d F Y')}}
                       <!-- {{ \Carbon\Carbon::parse(now('Asia/Jakarta'))->locale('id')->translatedFormat('d F Y') }} -->
                        <!-- <br>Owner
                        Toko Syukurilah</span><br>
                    <img style="margin:10px 0px 10px 0px"
                        src="http://api.qrserver.com/v1/create-qr-code/?size=75x75&data=Maya "><br>
                    <span style="font-weight: bold;">Owner</span><br> -->
                </td>
            </tr>
        </table>
    </div>
    <div class="footer">
        <span style="font-size:12px; font-family: 'Arial', sans-serif;color:#a6a4a1">Dokumen ini dicetak dan
            ditandatangani melalui Website haqqgroup.com
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
