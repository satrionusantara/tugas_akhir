<!DOCTYPE html>
<html>
<head>
    <title>NOTA PEMBELIAN {{ strtoupper($transaksi->nama) }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
			<td width="15%" class="text-center">
				<img src="{{ url('assets-admin/vendors/images/blazer.png') }}" width="75%">
			</td>
			<td class="text-left">
				<p style="font-size:18px;font-weight: bold;font-family: 'Arial', sans-serif;">
					<span style="font-size:30px;">Blazer Elektronik</span>
					    @if($transaksi->keterangan == 'INVOICE')
					    <span style="margin-left:265px;color: #1b00ff;vertical-align:middle">#{{$transaksi->keterangan ?? ''}}</span>
					    @elseif($transaksi->keterangan == 'NOTA TITIPAN BARANG')
					    <span style="margin-left:125px;color: #1b00ff;vertical-align:middle">#{{$transaksi->keterangan ?? ''}}</span>
					    @endif
					    <br>
					<span style="font-size:13px; line-height:1.2; display:block; margin-bottom:5px;">
					    Jl. Raya Setangkai, Simpang Kulit Manis, Taluk, Lintau Buo<br>
					    Tanah Datar, Sumatera Barat &nbsp;<img src="{{ url('assets-admin/vendors/images/old-typical-phone.png') }}" width="15px" style="vertical-align: middle;">&nbsp; 
					    Telp. +62 852-6362-0050 | Kode Pos 27292<br>
					    Website: blazerelektronik.com - email: info@blazerelektronik.com
					</span>
				</p>
			</td>
		</tr>
	</table>
	<hr style="border: 1px solid #000; margin-top: -5px; margin-bottom: 10px;">
	<hr style="border: 2px solid #000; margin-top: -15px; margin-bottom: 10px;">
	<table border="0" cellpadding="2" cellspacing="0" width="100%" style="font-size:11px; font-family: 'Arial', sans-serif; font-weight: bold">
	    <tr>
	        <td width="18%">Nama Customer</td>
	        <td width="1%"> : </td>
	        <td>{{ ucwords(strtolower($transaksi->nama)) }}</td>
	        <td width="15%"></td>
	        <td width="20%">Tangal Transaksi</td>
	        <td width="1%"> : </td>
	        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->locale('id')->translatedFormat('d F Y') }} {{$transaksi->pukul}} WIB</td>
	    </tr>
	    <tr>
	        <td>Contact Customer</td>
	        <td> : </td>
	        <td>{{$transaksi->contact ?? '-'}}</td>
	        <td></td>
	        <td>Metode Pembayaran</td>
	        <td> : </td>
	        <td>{{$metode->nama ?? '-'}}</td>
	    </tr>
	    <tr>
	        <td>Alamat Customer</td>
	        <td> : </td>
	        <td>{{$transaksi->alamat ?? '-'}}</td>
	        <td></td>
	        <td>Status Pembayaran</td>
	        <td> : </td>
	        <td>
	            @if($transaksi->status == '0')
	                Belum Bayar
	            @elseif($transaksi->status == '1')
	                Lunas
	            @else
	                Hutang ({{ \Carbon\Carbon::parse($transaksi->tanggal_pelunasan)->locale('id')->translatedFormat('d F Y') }})
	            @endif
	        </td>
	    </tr>
	</table>
	<table border="1" cellpadding="3" cellspacing="0" width="100%" style="font-size:9px; font-family: 'Arial', sans-serif; margin-top:10px">
		<thead>
			<tr style="background-color: #1b00ff; color: white;">
	          <th class="text-center" width="5%">#</th>
              <th>NAMA BARANG</th>
              <th class="text-center">JUMLAH</th>
              <th class="text-center">HARGA</th>
              <th class="text-center">DISKON</th>
              <th class="text-center">TOTAL</th>
	        </tr>
	    </thead>
	    <tbody>
            <?php $no = 1; ?>
            @foreach($detail_transaksi as $data)
            <?php
               $barang = DB::table('barang')->find($data->id_barang ?? '-');
               $satuan = DB::table('satuan')->find($barang->id_satuan ?? '-');
            ?>
            <tr>
               <td class="text-center"><b>{{$no++}}</b></td>
               <td width="35%"><b>{{ strtoupper($data->nama) }}</b></td>
                  @if($data->keterangan != "")
                  <br><b>Keterangan : </b><i>{{$data->keterangan}}</i>
                  @endif
               </td>
               <td class="text-center" width="8%"><b>{{$data->jumlah}} {{$data->satuan ?? ''}}</b></td>
               <td width="15%"><b>{{ 'Rp ' . number_format($data->harga, 0, ',', '.') }}</b></td>
               <td width="10%"><b>{{ 'Rp ' . number_format($data->diskon, 0, ',', '.') }}</b></td>
               <td width="15%"><b>{{ 'Rp ' . number_format($data->total, 0, ',', '.') }}</b></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="font-size:11px; font-family: 'Arial', sans-serif;">
                <th colspan="5">TOTAL BAYAR</th>
                <th>{{ 'Rp ' . number_format($transaksi->total, 0, ',', '.') }}</th>
            </tr>
            <?php
                $sisa_hutang = DB::table('piutang')->where('contact',$transaksi->contact)->sum('total');
                $pembayaran = DB::table('piutang')
                    ->join('detail_piutang', 'detail_piutang.id_piutang', '=', 'piutang.id')
                    ->where('piutang.contact', $transaksi->contact)
                    ->sum('detail_piutang.total');

                if($sisa_hutang == '0'){
                    $sisa = 0;
                } else {
                    $sisa = ($sisa_hutang - $pembayaran) - $transaksi->total;
                }
                $total_tagihan = $sisa + $transaksi->total;
            ?>
            @if($sisa_hutang != '0')
            <tr style="font-size:11px; font-family: 'Arial', sans-serif;">
                <th colspan="5">SISA HUTANG LAMA</th>
                <th>{{ 'Rp ' . number_format($sisa, 0, ',', '.') }}</th>
            </tr>
            <tr style="font-size:11px; font-family: 'Arial', sans-serif;"> 
                <th colspan="5">TOTAL TAGIHAN</th>
                <th>{{ 'Rp ' . number_format($total_tagihan, 0, ',', '.') }}</th>
            </tr>
            @endif
            <!--@if($transaksi->status == '1')-->
            <!--<tr>-->
            <!--    <th colspan="5">Potongan</th>-->
            <!--    <th>{{ 'Rp ' . number_format($transaksi->potongan, 0, ',', '.') }}</th>-->
            <!--</tr>-->
            <!--<tr>-->
            <!--    <th colspan="5">Bayar</th>-->
            <!--    <th>{{ 'Rp ' . number_format($transaksi->bayar, 0, ',', '.') }}</th>-->
            <!--</tr>-->
            <!--<tr>-->
            <!--    <th colspan="5">Kembali</th>-->
            <!--    <th>{{ 'Rp ' . number_format($transaksi->kembali, 0, ',', '.') }}</th>-->
            <!--</tr>-->
            <!--@endif-->
        </tfoot>
	</table>
	<b style="font-size:11px; font-family: 'Arial', sans-serif;"><em>Terbilang : {{ ucfirst(terbilang($total_tagihan)) }} Rupiah</em></b>
    <table border="1" cellpadding="3" cellspacing="0" width="100%" style="font-size:9px; font-family: 'Arial', sans-serif; margin-top:10px">
        <tr>
            <th colspan="5" height="20px"></th>
            <th width="17%"></th>
        </tr>
        <tr>
            <th colspan="5" height="20px"></th>
            <th></th>
        </tr>
        <tr>
            <th colspan="5" height="20px"></th>
            <th></th>
        </tr>
    </table>
	<?php
	function terbilang($angka) {
        $angka = abs($angka);
        $baca = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $terbilang = "";
    
        if ($angka < 12) {
            $terbilang = " " . $baca[$angka];
        } elseif ($angka < 20) {
            $terbilang = terbilang($angka - 10) . " Belas ";
        } elseif ($angka < 100) {
            $terbilang = terbilang($angka / 10) . " Puluh " . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = " Seratus" . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = terbilang($angka / 100) . " Ratus " . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = " Seribu" . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = terbilang($angka / 1000) . " Ribu " . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = terbilang($angka / 1000000) . " Juta " . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $terbilang = terbilang($angka / 1000000000) . " Miliar " . terbilang(fmod($angka, 1000000000));
        } else {
            $terbilang = "Angka terlalu besar";
        }
    
        return trim($terbilang);
    }
	?>  
	<table border="0" cellpadding="2" cellspacing="0" width="100%" style="font-size:12px; font-family: 'Arial', sans-serif;">
        <tr>
            <!-- Terbilang dan Info Rekening -->
            <td width="40%" class="text-left align-top" style="vertical-align: top;">
                <!-- Kartu Informasi Rekening -->
                <br>
                <div style="margin-top: 10px; border: 1px solid #ccc; padding: 8px; border-radius: 8px; font-size: 12px;">
                    <div style="margin-bottom: 8px;">
                        <b>Rekening BRI</b><br>
                        <b>541801000309509</b><br>
                        <b>a.n. Yoswanto</b>
                    </div>
                    <div>
                        <b>Rekening Nagari</b><br>
                        <b>20000210022681</b><br>
                        <b>a.n. Yoswanto</b>
                    </div>
                </div>
            </td>
        
            <!-- Penerima -->
            <td width="30%" class="text-center align-top" style="vertical-align: top;">
                <div style="margin-top: 10px;">
                    <span></span><br>
                    <b>Penerima</b><br>
                    <div style="margin-top:95px"></div>
                    <span style="font-weight: bold;">(_______________________)</span>
                </div>
            </td>
        
            <!-- TTD Pemilik -->
            <td width="30%" class="text-center align-top" style="vertical-align: top;">
                <div style="margin-top: 10px;">
                    <span>Lintau, {{ \Carbon\Carbon::parse(date('Y-m-d'))->locale('id')->translatedFormat('d F Y') }}</span><br>
                    <b>Owner Blazer Elektronik</b><br>
                    <img src="http://api.qrserver.com/v1/create-qr-code/?size=75x75&data=https://g.co/kgs/79K9c8c" alt="QR Code" style="margin:10px 0;" /><br>
                    <span style="font-weight: bold;">Yoswanto</span>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="footer">
        <span style="font-size:12px; font-family: 'Arial', sans-serif;color:#a6a4a1">Dokumen ini dicetak dan ditandatangani melalui Website blazerelektronik.com
</div>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>