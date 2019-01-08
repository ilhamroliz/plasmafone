<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=1024">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Laporan Detail Analisa Umur Piutang</title>

	<link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/dboard/logo/faveicon.png') }}"/>
	<link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

	<style>

	@page { margin: 10px; }

	.page_break { page-break-before: always; }

	.page-number:after { content: counter(page); }

	#table-data{
		font-size: 8pt;
		margin-top: 10px;
		border: 1px solid #555;
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
		vertical-align: top;
	}

	#table-data td.currency{
		text-align: right;
		padding-right: 5px;
	}

	#table-data td.no-border{
		border: 0px;
	}

	#table-data td.total{
		background: #fff;
		padding: 5px;
		font-weight: normal;
	}

	#table-data td.total.not-same{
		color: red !important;
		-webkit-print-color-adjust: exact;
	}

	.table-saldo{
		margin-top: 5px;
	}

	.table-saldo td{
		text-align: right;
		font-weight: 400;
		font-style: italic;
		padding: 7px 20px 7px 0px;
		border-top: 0px solid #efefef;
		font-size: 10pt;
		color: white;
		color: #555;
	}

	.table_total{
		font-size: 0.8em;
		margin-top: 5px;
		font-weight: bold;
	}

	.table_total td{
		border: 1px solid #aaa;
		border-collapse: collapse;
		background: #ccc;
		padding: 5px 0px;
		padding-right: 3px;
	}

	.table-info{
		margin-bottom: 45px;
		font-size: 7pt;
		margin-top: 5px;
	}

	#navigation ul{
		float: right;
		padding-right: 110px;
	}

	#navigation ul li{
		color: #fff;
		font-size: 15pt;
		list-style-type: none;
		display: inline-block;
		margin-left: 40px;
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

</style>

<style type="text/css" media="print">
@page { size: landscape; }
#navigation{
	display: none;
}

#table-data td.total{
	background-color: #fff !important;
	-webkit-print-color-adjust: exact;
}

#table-data td.not-same{
	color: red !important;
	-webkit-print-color-adjust: exact;
}

.page-break { display: block; page-break-before: always; }
</style>

</head>

<body style="background: #555;">

	<div class="col-md-12" id="navigation" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; position: fixed; z-index: 2;">
		<div class="row">
			<div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px;">
				PLASMAFONE
			</div>
			<div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
				<ul>
					<li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">

		<table width="100%" border="0" style="border-bottom: 1px solid #333;">
			<thead>
				<tr>
					<th style="text-align: left; font-size: 14pt; font-weight: 600">PT Jawa Pratama Mandiri  </th>
				</tr>

				<tr>
					<th style="text-align: left; font-size: 12pt; font-weight: 500">Laporan Detail Analisa Umur Piutang (Dasar Kode Supplier)</th>
				</tr>

				<tr>
					<th style="text-align: left; font-size: 8pt; font-weight: 500; padding-bottom: 10px;">Periode : </th>
				</tr>
			</thead>
		</table>

		<table id="table-data" class="table_neraca tree" border="0" width="100%">
			<thead>
				<tr>
					<th width="13%">No.Bukti</th>
					<th width="8%">Tanggal</th>
					<th width="8%">Jatuh Tempo</th>
					<th width="10%">Jumlah Faktur</th>
					<th width="10%">TerBayar</th>
					<th width="10%">Sisa Faktur</th>
					<th width="6%">Umur</th>
					<th width="10%">Belum Jatuh Tempo</th>
					<th width="10%">Umur 0 s/d 30</th>
					<th width="10%">Umur 31 s/d 60</th>
					<th width="10%">Umur 61 s/d 90</th>
					<th width="10%">Umur 91 s/d 120</th>
					<th width="10%">Umur 121 s/d 180</th>
				</tr>
			</thead>

			<tbody>
				@foreach($customers as $index => $customer)
					<tr>
						<td colspan="13" >Customer : {{ $customer[0] }} &nbsp; {{ $customer[1] }}</td>
					</tr>
							
						<tr>
							<td></td>
							<td></td>
							<td></td>
							
							<td align="right">
								<input type="hidden" value="" name="" class="">
								
							</td>
							<td align="right">
								<input type="hidden" name="" class="" value="">
								
							</td>
							<td class="total" align="right"></td>
						</tr>
						
					<tr style="border-bottom: 1px solid;">
						<input type="hidden" name="" class="">
						<input type="hidden" name="" class="">
						<td colspan="3" align="center" style="background-color: #ccc; font-weight: bold;">Total</td>
						<td align="right" style="background-color: #ccc; font-weight: bold;" class="">
							
						</td>
						<td align="right" style="background-color: #ccc; font-weight: bold;" class="">
							
						</td>
						<td align="right" class="" style="background-color: #ccc; font-weight: bold;"></td>
						<td align="right" class="" style="background-color: #ccc; font-weight: bold;"></td>
						<td align="right" class="" style="background-color: #ccc; font-weight: bold;"></td>
						<td align="right" class="" style="background-color: #ccc; font-weight: bold;"></td>
						<td align="right" class="" style="background-color: #ccc; font-weight: bold;"></td>
						<td align="right" class="" style="background-color: #ccc; font-weight: bold;"></td>
						<td align="right" class="" style="background-color: #ccc; font-weight: bold;"></td>
						<td align="right" class="" style="background-color: #ccc; font-weight: bold;"></td>
					</tr>
				@endforeach
				<tr style="border-top: 1px solid;">
					<td colspan="3" align="center" style="background-color: #ccc; font-weight: bold;">
						Grand Total
					</td>
					<td align="right" class="grand-total-debit" style="background-color: #ccc; font-weight: bold;">
						
					</td>
					<td align="right" class="grand-total-kredit" style="background-color: #ccc; font-weight: bold;">
						
					</td>
					<td align="right" class="grand-total-saldo" style="background-color: #ccc; font-weight: bold;">
						
					</td>
					<td align="right" class="grand-total-saldo" style="background-color: #ccc; font-weight: bold;">
						
					</td>
					<td align="right" class="grand-total-saldo" style="background-color: #ccc; font-weight: bold;">
						
					</td>
					<td align="right" class="grand-total-saldo" style="background-color: #ccc; font-weight: bold;">
						
					</td>
					<td align="right" class="grand-total-saldo" style="background-color: #ccc; font-weight: bold;">
						
					</td>
					<td align="right" class="grand-total-saldo" style="background-color: #ccc; font-weight: bold;">
						
					</td>
					<td align="right" class="grand-total-saldo" style="background-color: #ccc; font-weight: bold;">
						
					</td>
					<td align="right" class="grand-total-saldo" style="background-color: #ccc; font-weight: bold;">
						
					</td>
				</tr>
			</tbody>
		</table>

		<table class="table_total tree" border="0" width="100%">
			<tbody>
				
			</tbody>
		</table>

		
		<table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
			<thead>
				<tr>

				</tr>
			</thead>
		</table>

	</div>


	<script type="text/javascript">

		$(function(){

			$('[data-toggle="tooltip"]').tooltip({container : 'body'});

			baseUrl = '{{ url('/') }}';

		     $('#print').click(function(evt){
		     	evt.preventDefault();

		     	window.print();
		     })

		 })
		</script>
	</body>
	</html>