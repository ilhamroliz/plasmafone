<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laporan Hutang</title>
        
		<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/bootstrap_4_1_3/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/font-awesome_4_7_0/css/font-awesome.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/css/style.css') }}">
  		<link rel="stylesheet" type="text/css" href="{{asset('modul_keuangan/js/vendors/ez_popup_v_1_1/ez.popup.css')}}">
    	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/select2/dist/css/select2.min.css') }}">
    	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/datepicker/dist/datepicker.min.css') }}">
    	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">

		<style>

			body{
				background: rgba(0,0,0, 0.5);
			}

			/*.bs-datepicker-container { z-index: 3000; }*/

			.lds-dual-ring {
			  display: inline-block;
			  width: 64px;
			  height: 64px;
			}
			.lds-dual-ring:after {
			  content: " ";
			  display: block;
			  width: 46px;
			  height: 46px;
			  margin: 1px;
			  border-radius: 50%;
			  border: 5px solid #dfc;
			  border-color: #dfc transparent #dfc transparent;
			  animation: lds-dual-ring 1.2s linear infinite;
			}
			@keyframes lds-dual-ring {
			  0% {
			    transform: rotate(0deg);
			  }
			  100% {
			    transform: rotate(360deg);
			  }
			}

		    .navbar-brand {
		    	padding-left: 30px;
		    }

		    .navbar-nav {
		      flex-direction: row;
		      padding-right: 40px; 
		    }
		    
		    .nav-link {
		      padding-right: .5rem !important;
		      padding-left: .5rem !important;
		    }
		    
		    /* Fixes dropdown menus placed on the right side */
		    .ml-auto .dropdown-menu {
		      left: auto !important;
		      right: 0px;
		    }

		    .nav-item{
		    	color: white;
		    }

		    .navbar-nav li{
		        border-left: 1px solid rgba(255, 255, 255, 0.1);
		        padding: 0px 25px;
		        cursor: pointer;
		    }

		    .navbar-nav li:last-child{
		    	border-right: 1px solid rgba(255, 255, 255, 0.1);
		    }

		    .ctn-nav {
		    	background: rgba(0,0,0, 0.7);
		    	position: fixed;
		    	bottom: 1.5em;
		    	z-index: 1000;
		    	font-size: 10pt;
		    	box-shadow: 0px 0px 10px #aaa;
		    	border-radius: 10px
		    }

		    #title-table{
		    	padding: 0px;
		    }

		    #table-data{
		    	font-size: 9pt;
		    }

		    #table-data td{
		    	padding: 5px 10px;
		    	border: 1px solid #eee;
		    }

		    #table-data th{
		    	padding: 5px 10px;
		    	background-color: #0099CC;
		    	color: white;
		    	border: 1px solid white;
		    	vertical-align: middle;
		    }

		    #table-data td.head{
		    	border: 1px solid #0099CC;
		    	background: #0099CC;
		    	color: white;
		    	font-weight: bold;
		    }

		    #table-data td.sub-head{
		    	border: 1px solid #0099CC;
		    	color: #333;
		    	font-weight: bold;
		    	text-align: center;
		    }

		    #table-data td.divide{
		    	background-color: #eee;
		    }

		    #contentnya{
	          width: 100%;
	          padding: 0px 20px;
	          background: white;
	          min-height: 700px;
	          border-radius: 2px;
	          margin: 0 auto;
	        }

		</style>

		<style type="text/css" media="print">
          @page { size: landscape; }
          nav{
            display: none;
          }

          .ctn-nav{
          	display: none;
          }

          #contentnya{
          	width: 100%;
          	padding: 0px;
          	margin-top: -50px;
          }

          #table-data th{
             background-color: #0099CC !important;
             color: white;
             -webkit-print-color-adjust: exact;
          }

          #table-data tfoot td{
             background-color: #eee !important;
             -webkit-print-color-adjust: exact;
          }

          #table-data th.sharpen{
          	background-color: white !important;
             -webkit-print-color-adjust: exact;
          }

          #table-data td.divide{
             background-color: #eee !important;
             -webkit-print-color-adjust: exact;
          }

          .page-break { display: block; page-break-before: always; }
      	</style>
	</head>

	<body>
		<div id="vue-element">
			<div class="container-fluid" style="background: none; margin-top: 40px; padding: 10px 30px;">
				<div id="contentnya">

					<?php 
						$tanggal_1 = explode('/', $_GET['d1'])[0].' '.switchBulan(explode('/', $_GET['d1'])[1]).' '.explode('/', $_GET['d1'])[2];
						$type = ($_GET['type'] == "Hutang_Supplier") ? 'Supplier' : 'Karyawan';
					?>					

					{{-- Judul Kop --}}

						<table width="100%" border="0" style="border-bottom: 1px solid #333;">
				          <thead>
				            <tr>
				              <th style="text-align: left; font-size: 14pt; font-weight: 600; padding-top: 10px;" colspan="2">Laporan Hutang {{ $type }} ({{ $_GET['jenis'] }})</th>
				            </tr>

				            <tr>
				              <th style="text-align: left; font-size: 12pt; font-weight: 500" colspan="2">{{ jurnal()->companyName }}</th>
				            </tr>

				            <tr>
				              <th style="text-align: left; font-size: 8pt; font-weight: 500; padding-bottom: 10px;">(Angka Disajikan Dalam Rupiah, Kecuali Dinyatakan Lain)</th>

				              <th class="text-right" style="font-size: 8pt; font-weight: normal;">
				              	<b>Per Tanggal {{ $tanggal_1 }}</b>
				              </th>
				            </tr>
				          </thead>
				        </table>

				    {{-- End Judul Kop --}}

			    	<div style="padding-top: 20px;">

			    		@if($_GET['jenis'] == 'rekap')
							<table class="table" id="table-data">

								<thead>
									<tr>
										<th rowspan="2" width="2%">No</th>
										<th rowspan="2" width="22%">Nama Kreditur</th>
										<th rowspan="2" width="12%">Jumlah Hutang</th>
										<th rowspan="2" width="12%">Belum Jatuh Tempo</th>
										<th colspan="4">Sudah Jatuh Tempo</th>
									</tr>

									<tr>
										<th width="12%">0 - 30 Hari</th>
										<th width="12%">30 - 60 Hari</th>
										<th width="12%">60 - 90 Hari</th>
										<th width="12%">> 90 Hari</th>
									</tr>
								</thead>

								<tbody>
									<?php 
										$gtHutang = $gtBelumJatuhTempo = $gtFirst = $gtSecond = $gtThird = $gtFourth = 0;
									?>

									@foreach($data as $key => $data)
										<tr>
											<td style="text-align: center;">{{ ($key+1) }}</td>
											<td>{{ ($data['nama_supplier']) }}</td>
											<td style="text-align: right; font-weight: 600;">{{ number_format($data['total_hutang'], 2) }}</td>
											<td style="text-align: right; font-weight: 600; color: #007E33;">{{ number_format($data['belum_jatuh_tempo'], 2) }}</td>
											<td style="text-align: right; font-weight: 600; color: #CC0000;">{{ number_format($data['first'], 2) }}</td>
											<td style="text-align: right; font-weight: bo600l600d; color: #CC0000;">{{ number_format($data['second'], 2) }}</td>
											<td style="text-align: right; font-weight: 600; color: #CC0000;">{{ number_format($data['third'], 2) }}</td>
											<td style="text-align: right; font-weight: 600; color: #CC0000;">{{ number_format($data['fourth'], 2) }}</td>
										</tr>

										<?php
											$gtHutang += $data['total_hutang'];
											$gtBelumJatuhTempo += $data['belum_jatuh_tempo'];
											$gtFirst += $data['first'];
											$gtSecond += $data['second'];
											$gtThird += $data['third'];
											$gtFourth += $data['fourth'];
										?>
									@endforeach
									
								</tbody>

							</table>

							<table class="table" id="table-data" style="margin-top: 50px;">
								<thead>
									<tr>
										<th width="25%" colspan="2" style="text-align: center;">Total Seluruh Hutang</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtHutang, 2) }}
										</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtBelumJatuhTempo, 2) }}
										</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtFirst, 2) }}
										</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtSecond, 2) }}
										</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtThird, 2) }}
										</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtFourth, 2) }}
										</th>
									</tr>
								</thead>
							</table>
						@else

							<?php 
								$gtBelumJatuhTempo = $gtFirst = $gtSecond = $gtThird = $gtFourth = 0;
							?>

							@foreach($data as $key => $parrent)
								<?php 
									$margin = ($key != 0) ? '30px;' : '';
									$totBelumjatuhTempo = $totFirst = $totSecond = $totThird = $totFourth = 0; 
								?>

								<table class="table" id="table-data" style="margin-top: {{ $margin  }}">
									<thead>
										<tr>
											<th class="sharpen" colspan="9" style="background-color: white; border: 0px; color: #00695c; font-size: 12pt; padding-bottom: 10px;">
												| {{ $parrent['nama_supplier'] }} |
											</th>
										</tr>
										<tr>
											<th width="2%">No</th>
											<th width="12%">Tanggal</th>
											<th width="12%">Tanggal Jatuh Tempo</th>
											<th width="14%">Nomor Referensi</th>
											<th width="12%">Belum Jatuh Tempo</th>
											<th width="12%">0 - 30 Hari</th>
											<th width="12%">30 - 60 Hari</th>
											<th width="12%">60 - 90 Hari</th>
											<th width="12%">> 90 Hari</th>
										</tr>
									</thead>

									<tbody>
										@foreach($parrent['detail'] as $index => $detail)
											<tr>
												<td style="text-align: center;">{{ $index+1 }}</td>
												<td style="text-align: center;">
													{{ date('d/m/Y', strtotime($detail['tanggal'])) }}
												</td>
												<td style="text-align: center;">
													{{ date('d/m/Y', strtotime($detail['jatuh_tempo'])) }}
												</td>
												<td style="text-align: center;">
													{{ $detail['nomor_referensi'] }}
												</td>
												<td style="text-align: right; font-weight: 600;">
													{{ number_format($detail['belum_jatuh_tempo'], 2) }}
												</td>
												<td style="text-align: right; font-weight: 600;">
													{{ number_format($detail['first'], 2) }}
												</td>
												<td style="text-align: right; font-weight: 600;">
													{{ number_format($detail['second'], 2) }}
												</td>
												<td style="text-align: right; font-weight: 600;">
													{{ number_format($detail['third'], 2) }}
												</td>
												<td style="text-align: right; font-weight: 600;">
													{{ number_format($detail['fourth'], 2) }}
												</td>
											</tr>

											<?php 
												$totBelumjatuhTempo += $detail['belum_jatuh_tempo'];
												$totFirst += $detail['first'];
												$totSecond += $detail['second'];
												$totThird += $detail['third'];
												$totFourth += $detail['fourth'];
											?>
										@endforeach
									</tbody>

									<tfoot>
										<tr>
											<td colspan="4" style="font-weight: 600; text-align: center; background-color: #eee; border: 1px solid #ffffff;">
												Saldo {{ $parrent['nama_supplier'] }}
											</td>
											<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c;">
												{{ number_format($totBelumjatuhTempo, 2) }}
											</td>
											<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c;">
												{{ number_format($totFirst, 2) }}
											</td>
											<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c;">
												{{ number_format($totSecond, 2) }}
											</td>
											<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c;">
												{{ number_format($totThird, 2) }}
											</td>
											<td style="font-weight: 600; text-align: right; background-color: #eee; border: 1px solid #ffffff; color: #00695c;">
												{{ number_format($totFourth, 2) }}
											</td>
										</tr>
									</tfoot>
								</table>

								<?php
									$gtBelumJatuhTempo += $totBelumjatuhTempo;
									$gtFourth += $totFourth;
									$gtSecond += $totSecond;
									$gtThird += $totThird;
									$gtFourth += $totFourth;
								?>
							@endforeach

							<table class="table" id="table-data" style="margin-top: 50px;">
								<thead>
									<tr>
										<th colspan="4" style="text-align: center;">Total Seluruh Kreditur</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtBelumJatuhTempo, 2) }}
										</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtFirst, 2) }}
										</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtSecond, 2) }}
										</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtThird, 2) }}
										</th>
										<th width="12%" style="text-align: right;">
											{{ number_format($gtFourth, 2) }}
										</th>
									</tr>
								</thead>
							</table>
						@endif
					</div>
				</div>
			</div>
		</div>

		<script src="{{ asset('modul_keuangan/js/jquery_3_3_1.min.js') }}"></script>
		<script src="{{ asset('modul_keuangan/bootstrap_4_1_3/js/bootstrap.min.js') }}"></script>
		<script src="{{asset('modul_keuangan/js/vendors/ez_popup_v_1_1/ez.popup.js')}}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/axios_0_18_0/axios.min.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/select2/dist/js/select2.min.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/datepicker/dist/datepicker.min.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.js') }}"></script>

    	<script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/vue_2_x.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/select.component.js') }}"></script>
    	<script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/datepicker.component.js') }}"></script>

    	<script type="text/javascript">
    		// window.print();
    	</script>
	</body>
</html>
