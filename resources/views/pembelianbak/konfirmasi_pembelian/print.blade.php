<style type="text/css">
table {
	border-collapse: collapse;
	width: 100%;
}

th {
	height: 50px;
	font-size: 14px;
}

td {
	font-size: 12px;
}

table, th, td {
	border: 1px solid black;
	padding: 10px 10px 10px 10px;
}

tr:nth-child(even) {background-color: #f2f2f2;}

h2{
	text-align: center;
	margin-top: 30px;
	margin-bottom: 60px;
}

img{
	width: 100%;
}

.table-responsive{
	overflow-x:auto;
}

.ttd{
	float: right;
	margin-top: 50px;
}

.name{
	margin-top: 100px;
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
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Konfirmasi Pembelian_<?php echo date('YmdHms'); ?></title>
	<script type="text/javascript">
		window.print();
	</script>
</head>
<body>
	<img src="{{ asset('template_asset/img/hsj.png') }}">
	<h2>Konfirmasi Pembelian</h2>
	<table>
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
		</tbody>
	</table>
	<div class="ttd">
		<p>Surabaya, <?php echo tgl_indo(date('Y-m-d')); ?></p>
		<p class="name">Ka. Bagian Keuangan</p>
	</div>
</body>
</html>