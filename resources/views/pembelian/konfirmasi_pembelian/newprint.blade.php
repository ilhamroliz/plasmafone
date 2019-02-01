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
?>
<body id="bd">

	<div class="col-md-12" id="navigation" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; position: fixed; z-index: 2;">
		<div class="row">
			<div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px; font-size: 15pt;">
				PlasmaPhone
			</div>
			<div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
				<ul>
					<li class="pr"><i class="fa fa-print" style="cursor: pointer; padding-bottom: 7px; padding-left: 7px; padding-right: 7px;" id="print" data-toggle="tooltip" data-placement="center" title="Print Laporan"></i></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">

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
				</tr>
			</thead>
			<tbody>

				@foreach($printPDF as $print)
				<tr>
					<td>{{ $print->pcd_purchaseconfirm }}</td>
					<td>{{ $print->pcd_detailid }}</td>
					<td>{{ $print->pcd_item }}</td>
					<td>{{ $print->pcd_qty }}</td>
				</tr>
				@endforeach

				<tr>
					<td style="background: #f1f1f1;">&nbsp;</td>
					<td style="background: #f1f1f1;">&nbsp;</td>
					<td class="currency total "></td>
					<td class="currency total no-border "></td>
				</tr>
			</tbody>
		</table>

		<table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
			<thead>
				<tr>
					<th width="8%"></th>
					<th width="12%"></th>
					<th width="8%"></th>
					<th></th>
					<th width="11%" style="text-align: right; padding: 7px 5px; border-bottom: 1px solid #999;"></th>
					<th width="11%" style="text-align: right; padding: 7px 5px; border-bottom: 1px solid #999;"></th>
				</tr>
			</thead>
		</table>

		<table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
			<thead>
				<tr>

				</tr>
			</thead>
		</table>
		<div class="ttd">
			<p>Surabaya, <?php echo tgl_indo(date('Y-m-d')); ?></p>
			<p>Mengetahui,</p>
			<p class="name">Ka. Bagian Keuangan</p>
		</div>
	</div>

</body>
</html>
<script src="{{ asset('template_asset/js/libs/jquery-2.1.1.min.js') }}"></script>
<script src="{{ asset('template_asset/js/libs/jquery-ui-1.10.3.min.js') }}"></script>

<script type="text/javascript">
	// modal_jurnal

  // modal_jurnal end

  $('#print').click(function(evt){
  	evt.preventDefault();

  	window.print();
  })
</script>