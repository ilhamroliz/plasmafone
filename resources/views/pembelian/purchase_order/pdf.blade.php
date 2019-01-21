<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order_<?php echo date('YmdHms'); ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- FAVICONS -->
	<link rel="shortcut icon" href="{{ asset('template_asset/img/favicon/favicon.ico') }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('template_asset/img/favicon/favicon.ico') }}" type="image/x-icon">

	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/plugins/font-awesome_4_7/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

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

	.dl{
		width: 35px;
	}
	.dl:hover{
		background-color: #555;
	}

	.pr{
		width: 35px;
	}
	.pr:hover{
		background-color: #555;
	}
	.ttd{
		float: right;
		margin-top: 50px;
	}
	.name{
		margin-top: 100px;
		border-top: 1px solid;
	}
	.center{
		text-align: center;
	}

	.text-right{
		text-align: right;
	}

	.text-bold{
		font-weight: bold;
	}
</style>

<style type="text/css" media="print">
@page { size: landscape; }
#bd {
	background: #fff;
	-webkit-print-color-adjust: exact;
}
#navigation{
	display: none;
}

#contentnya{
	margin-top: -80px;
}

#table-data td.total{
	background-color: #ccc !important;
	-webkit-print-color-adjust: exact;
}

#table-data td.not-same{
	color: red !important;
	-webkit-print-color-adjust: exact;
}

.page-break { display: block; page-break-before: always; }
</style>
</head>
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

function rupiah($angka){

	$hasil_rupiah = "Rp" . number_format($angka,2,',','.');
	return $hasil_rupiah;
	
}
?>
<body id="bd">

	<div class="col-md-12" id="navigation" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; position: fixed; z-index: 2;">
		<div class="row">
			<div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px; font-size: 15pt;">
				PlasmaPhone
			</div>
			<div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
				<ul>
					<li class="dl"><a href="{{ url('/pembelian/purchase-order/generate-pdf/'.$id) }}" target="self" style="color: #FFF;"><i class="fa fa-download" style="cursor: pointer; padding-bottom: 7px; padding-left: 7px; padding-right: 7px;" id="download" data-toggle="tooltip" data-placement="center" title="Download Laporan"></i></a></li>
					<!-- <li class="pr"><i class="fa fa-print" style="cursor: pointer; padding-bottom: 7px; padding-left: 7px; padding-right: 7px;" id="print" data-toggle="tooltip" data-placement="center" title="Print Laporan"></i></li> -->
				</ul>
			</div>
		</div>
	</div>

	<div id="pdfrender">
		<div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">

			<table width="100%" border="0" style="border-bottom: 1px solid #333;" id="contentnya">
				<thead>
					<tr>
						<th style="text-align: left; font-size: 14pt; font-weight: 600">Purchase Order </th>
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

			<table width="100%" style="font-size: 8pt; margin-top: 10px;">
				<tr>
					<td style="padding: 5px;">Kepada</td>
					<td style="padding: 5px;"><center>:</center></td>
					<td width="30%" style="padding: 5px;">{{ $data_purchase[0]->s_company }}</td>
				</tr>
				<tr>
					<td style="padding: 5px;">No. Telp</td>
					<td style="padding: 5px;"><center>:</center></td>
					<td style="padding: 5px;">{{ $data_purchase[0]->s_phone }}</td>
					<td style="padding: 5px;">Tanggal</td>
					<td style="padding: 5px;"><center>:</center></td>
					<td style="padding: 5px;"><?php echo tgl_indo(date('Y-m-d')); ?></td>
				</tr>
				<tr>
					<td style="padding: 5px;">Alamat</td>
					<td style="padding: 5px;"><center>:</center></td>
					<td style="padding: 5px;">{{ $data_purchase[0]->s_address }}</td>
					<td style="padding: 5px;">Kirim Ke</td>
					<td style="padding: 5px;"><center>:</center></td>
					<td style="padding: 5px;">CV. Plasmaphone Sebar Barokah</td>
				</tr>
			</table>

			<table id="table-data" width="100%" border="0">
				<thead>
					<tr>
						<th>PO. Nomer</th>
						<th>Cabang/Outlet</th>
						<th>Kode Barang</th>
						<th>Kuantitas</th>
						<th>Harga Satuan</th>
						<th>Total Harga</th>
						<th>Total Bayar</th>
					</tr>
				</thead>
				<tbody>
					
					@foreach($data_purchase as $purchase)
					<tr>
						<td>{{ $purchase->po_no }}</td>
						<td>{{ $purchase->c_nama }}</td>
						<td>{{ $purchase->podt_kode_barang }}</td>
						<td class="center">{{ $purchase->podt_kuantitas }}</td>
						<td class="text-right">{{ rupiah($purchase->podt_harga_satuan) }}</td>
						<td class="text-right">{{ rupiah($purchase->po_total_harga) }}</td>
						<td class="text-right">{{ rupiah($purchase->po_total_bayar) }}</td>
					</tr>
					@endforeach

					<tr>
						<td style="background: #f1f1f1;" colspan="6" align="center" class="text-bold">Jumlah</td>
						<td style="background: #f1f1f1;" class="text-right">{{ rupiah($jumlah) }}</td>
					</tr>
				</tbody>
			</table>

			<table style="margin-top: 40px; width: 100%; margin-left: 100px;">
				<tr>
					<td style="width: 33.34%">Received by,</td>
					<td style="width: 33.34%">Prepared by,</td>
					<td style="width: 33.34%">Approved by,</td>
				</tr>
			</table>

			<table style="margin-top: 150px; width: 100%; margin-left: 10px; margin-right: 10px; margin-bottom: 30px;">
				<tr>
					<td style="width: 33.34%; padding-left: 10px; padding-right: 10px;"><p style="border-top: 1px solid; text-align: center">Official Stamp & Signature</p></td>
					<td style="width: 33.34%; padding-left: 10px; padding-right: 10px;"><p style="border-top: 1px solid; text-align: center">Purchasing</p></td>
					<td style="width: 33.34%;  padding-left: 10px; padding-right: 10px;"><p style="border-top: 1px solid; text-align: center">Director</p></td>
				</tr>
			</table>

			<!-- <div class="ttd">
				<p>Surabaya, <?php echo tgl_indo(date('Y-m-d')); ?></p>
				<p>Mengetahui,</p>
				<p class="name">Ka. Bagian Keuangan</p>
			</div> -->
		</div>
	</div>

</body>
</html>
<script src="{{ asset('template_asset/js/libs/jquery-2.1.1.min.js') }}"></script>
<script src="{{ asset('template_asset/js/libs/jquery-ui-1.10.3.min.js') }}"></script>
