<!DOCTYPE html>
<html>
<head>
	<title>Konfirmasi Pembelian_<?php echo date('YmdHms'); ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- FAVICONS -->
	<link rel="shortcut icon" href="{{ asset('template_asset/img/favicon/favicon.ico') }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('template_asset/img/favicon/favicon.ico') }}" type="image/x-icon">
</head>
<style type="text/css">
	*{
		font-size: 12px;
	}
	.s16{
		font-size: 14px !important;
	}
	.div-width{
		margin: auto;
		width: 95vw;
	}
	.underline{
		text-decoration: underline;
	}
	.italic{
		font-style: italic;
	}
	.bold{
		font-weight: bold;
	}
	.text-center{
		text-align: center;
	}
	.text-right{
		text-align: right;
	}
	.border-none-right{
		border-right: hidden;
	}
	.border-none-left{
		border-left:hidden;
	}
	.border-none-top{
		border-top: hidden;
	}
	.border-none-bottom{
		border-bottom: hidden;
	}
	.border-none-all{
		border: hidden;
	}
	.float-left{
		float: left;
	}
	.float-right{
		float: right;
	}
	.top{
		vertical-align: text-top;
	}
	.vertical-baseline{
		vertical-align: baseline;
	}
	.bottom{
		vertical-align: text-bottom;
	}
	.ttd{
		top: 0;
		position: absolute;
	}
	.relative{
		position: relative;
	}
	.absolute{
		position: absolute;
	}
	.empty{
		height: 15px;
	}
	/*table,td{
		border:1px solid black;
	}*/
	table{
		border-collapse: collapse;
	}
	table.border-none ,.border-none td, .border-none tr{
		border:none !important;
	}
	@page{
		size: landscape;
		margin: 0;
	}
	.div-page-break{
		page-break-after: always;
	}
	.border-hidden tr, .border-hidden td{
		border: hidden;
	}
</style>
<style type="text/css">
	@page { margin: 10px; }

	table{
		color: #333;
	}

	#bd{
		background: #555;
	}

	.page_break { page-break-before: always; }

	.page-number:after { content: counter(page); }

	#table-data{
		font-size: 8pt;
		margin-top: 10px;
		border: 1px solid #555;
		color: #222;
	}
	#table-data th{
		text-align: center;
		border: 1px solid #aaa;
		border-collapse: collapse;
		background: #ccc;
		padding: 5px;
	}

	#table-data td{
		border-right: 1px solid #555;
		padding: 5px;
	}

	#table-data td.currency{
		text-align: right;
		padding-right: 5px;
	}

	#table-data td.no-border{
		border: 0px;
	}

	#table-data td.total{
		background: #ccc;
		padding: 5px;
		font-weight: bold;
	}

	#table-data td.total.not-same{
		color: red !important;
		-webkit-print-color-adjust: exact;
	}

	#navigation ul{
		float: right;
		padding-right: 110px;
	}

	#navigation ul li{
		color: #fff;
		list-style-type: none;
		display: inline-block;
		margin-left: 40px;
	}

	#navigation ul li i{ 
		font-size: 15pt;
		margin-top: 10px;
	}

	#form-table{
		font-size: 8pt;
	}

	#form-table td{
		padding: 5px 0px;
	}

	#form-table .form-control{
		height: 30px;
		width: 90%;
		font-size: 8pt;
	}
	.ttd{
		right: 0;
		margin-top: 250px;
		margin-right: 50px;
	}
	.name{
		margin-top: 100px;
		border-top: 1px solid;
	}
	.center{
		text-align: center;
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
<body>
	<div class="div-width">
		<div class="div-page-break">
			<!-- <h1 class="s16">TAMMA ROBAH INDONESIA</h1> -->
			<table width="100%" border="0" style="border-bottom: 1px solid #333;" id="contentnya">
				<thead>
					<tr>
						<th style="text-align: left; font-size: 14pt; font-weight: 600">Konfirmasi Pembelian </th>
					</tr>

					<tr>
						<th style="text-align: left; font-size: 12pt; font-weight: 500">PlasmaPhone</th>
					</tr>

					<tr>
						<th style="text-align: left; font-size: 8pt; font-weight: 500; padding-bottom: 10px;">Telp: 0987654321</th>
					</tr>
				</thead>
			</table>

			<table width="100%" border="0" style="font-size: 8pt;">
				<thead>
					<tr>
						<td style="text-align: left; padding-top: 5px;">
							Surabaya, <?php echo tgl_indo(date('Y-m-d')); ?>
						</td>

					</tr>
				</thead>
			</table>

			<table id="table-data" width="100%" border="0">
				<thead>
					<tr>
						<th>Request Order</th>
						<th>Request Nomor</th>
						<th>Cabang</th>
						<th>Kode Barang</th>
						<th>Kuantitas</th>
						<th>Kuantitas Approval</th>
						<th>Status</th>
						<th>Supplier</th>
					</tr>
				</thead>
				<tbody>
					
					@foreach($data_order as $order)
					<tr>
						<td>{{ $order->rdt_request }}</td>
						<td>{{ $order->rdt_no }}</td>
						<td>{{ $order->c_nama }}</td>
						<td>{{ $order->rdt_kode_barang }}</td>
						<td class="center">{{ $order->rdt_kuantitas }}</td>
						<td class="center">{{ $order->rdt_kuantitas_approv }}</td>
						<td>{{ $order->rdt_status }}</td>
						<td>{{ $order->s_company }}</td>
					</tr>
					@endforeach

					<tr>
						<td style="background: #f1f1f1;">&nbsp;</td>
						<td style="background: #f1f1f1;">&nbsp;</td>
						<td style="background: #f1f1f1;">&nbsp;</td>
						<td style="background: #f1f1f1;">&nbsp;</td>
						<td style="background: #f1f1f1;">&nbsp;</td>
						<td style="background: #f1f1f1;">&nbsp;</td>
						<td style="background: #f1f1f1;">&nbsp;</td>
						<td style="background: #f1f1f1;">&nbsp;</td>
					</tr>
				</tbody>
			</table>

			<table width="25%" border="0" style="float: right; margin-top: 75px;" id="contentnya">
				<thead>
					<tr>
						<th style="float: right; text-align: left; font-size: 12pt; font-weight: 500">Surabaya, <?php echo tgl_indo(date('Y-m-d')); ?></th>
					</tr>

					<tr>
						<th style="padding-top: 10px; text-align: left; font-size: 12pt; font-weight: 500">Mengetahui,</th>
					</tr>

					<tr>
						<th style="text-align: left; font-size: 12pt; font-weight: 500; padding-bottom: 10px; padding-top: 100px;"><span style="border-top: 1px solid; font-size: 12pt;">Ka. Bagian Keuangan</span></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</body>
</html>