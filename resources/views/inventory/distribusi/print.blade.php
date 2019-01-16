<style type="text/css">
	.center{
		margin-left: 25%;
		margin-right: 25%;
	}

	.parallelogram {
	   height: 35px;
	   width: 100%;
	   border: 2px solid #8C8C8C;
	   -webkit-transform: skew(-20deg); 
	   -moz-transform: skew(-20deg); 
	   -o-transform: skew(-20deg);
	   transform: skew(-20deg);
	}

	.parallelogram > label {
		font-size: 16px;
		padding-top: 4px;
		padding-left: 10px;
		font-family: Arial, Helvetica, sans-serif;
		font-weight: bold;
	}

	.table-bukti {
		margin-left: auto;
		margin-right: auto;
	}

	.table-bukti td {
		padding: 15px;
    	text-align: left;
		font-size: 14px;
	}

	table.table-barang {
		border-collapse: collapse;
		border-style: solid;
		border: 1px solid !important;
		width: 100%;
		border-width: 1px;
		font-size: 12px;
	}

	table.table-barang th {
		padding: 15px;
    	text-align: center;
    	border-width: 1px;
    	border-style: solid;
    	border-color: black;
    	background-color: #dedede;
		font-size: 12px;
	}

	table.table-barang td {
		padding: 15px;
    	text-align: left;
    	border-width: 1px;
    	border-style: solid;
    	border-color: black;
		font-size: 12px;
	}
</style>

<?php
	function tgl_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun
	 
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Distribusi Barang</title>
	<link rel="shortcut icon" href="{{ asset('template_asset/img/favicon/favicon.ico') }}" type="image/x-icon">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
</head>
<body>
	{{-- <img src="{{ asset('template_asset/img/hsj.png') }}" width="100%"> --}}
	<h2 style="margin-top: 20px; font-size: 16px;"><strong><center>BUKTI PENGELUARAN BARANG</center></strong></h2>
	<h3 style="margin-top: 20px; font-size: 14px;"><strong><center>{{ strtoupper($from->c_name) }}</center></strong></h3>
	<h5 style="margin-top: 20px; font-size: 14px;"><strong><center>{{ strtoupper($from->c_address) }}</center></strong></h5>
	<table class="table-bukti" style="margin-top: 40px;">
		<tr>
			<td>Nota</td>
			<td class="text-center">:</td>
			<td><strong>{{ $datas[0]->nota }}</strong></td>
			<td>Tanggal</td>
			<td class="text-center">:</td>
			<td><strong>{{ date('d-m-Y H:m:sa', strtotime($datas[0]->tanggal)) }}</strong></td>
		</tr>
		<tr>
			<td>Dari</td>
			<td class="text-center">:</td>
			<td><strong>{{ $from->c_name }}</strong></td>
			<td>Tujuan</td>
			<td class="text-center">:</td>
			<td><strong>{{ $datas[0]->tujuan }}</strong></td>
		</tr>
	</table>
	<table class="table-barang" style="margin-top: 10px;">
		<thead>
			<tr>
				<th class="text-center">NAMA BARANG</th>
				<th class="text-center">QTY</th>
			</tr>
		</thead>
		<tbody>
			@foreach($datas as $data)
			<tr>
				<td>{{ $data->nama_barang }}</td>
				<td><center>{{ $data->qty }}</center></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<table style="width: 100%; margin-top: 30px;">
		<tr>
			<td class="text-center">Yang Mengeluarkan,</td>
		</tr>
		<tr>
			<td style="padding-top: 100px; padding-left: 10%; padding-right: 10%;"><strong>{{ $datas[0]->petugas }}</strong></td>
		</tr>
	</table>

</body>
</html>
<script type="text/javascript">
	window.print();
</script>