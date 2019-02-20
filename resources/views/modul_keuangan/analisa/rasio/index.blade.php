<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Analisa Rasio Keuangan</title>
        
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

		    #table-data td, #table-data th {
		    	padding: 5px 10px;
		    	border: 1px solid #cfcfcf;
		    }

		    #table-data th.head{
		    	font-weight: 800;
		    	font-size: 12pt;
		    	border: 0px;
		    	padding-left: 0px;
		    	padding-bottom: 0px;
		    	text-align: left;
		    	color: #444;
		    }

		    #table-data th.subHead{
		    	font-weight: 800;
		    	font-size: 9pt;
		    	border: 0px;
		    	padding-left: 0px;
		    	padding-bottom: 0px;
		    	text-align: left;
		    	color: #444;
		    	text-decoration: underline;
		    	font-style: italic;
		    }

		    #table-data th.subHead.chartLeft{
		     	padding: 0px 0px;
		     	width: 60%;
		    }

		    #table-data th.subHead.chartRight{
		     	vertical-align: top;
		     	background: none;
		     	text-decoration: none;
		     	width: 40%;
		     }

		    #table-data td{
		    	font-size: 8pt;
		    }

		    #table-data td.head{
		    	border: 1px solid white;
		    	background: #0099CC;
		    	color: white;
		    	font-weight: bold;
		    	text-align: center;
		    }

		    #table-data td.sub-head{
		    	border: 1px solid #0099CC;
		    	color: #333;
		    	font-weight: bold;
		    	text-align: center;
		    }

		    #contentnya{
	          width: 100%;
	          padding: 0px 20px;
	          background: white;
	          min-height: 550px;
	          border-radius: 2px;
	          margin: 0 auto;
	          padding-bottom: 20px;
	        }

		</style>

		<style type="text/css" media="print">
          @page { size: landscape; }

          body{
          	margin: 0mm;
          }
          nav{
            display: none;
          }

          #contentnya{
            margin-top: -80px;
            width: 100%;
           }

          #table-data th{
             background-color: #0099CC !important;
             color: white;
             -webkit-print-color-adjust: exact;
          }

          #table-data th.subHead, #table-data th.head{
             background-color:white !important;
             -webkit-print-color-adjust: exact;
          }

          #table-data th.subHead.divide{
          	display: none;
          }

          #table-data td.not-same{
             color: red !important;
             -webkit-print-color-adjust: exact;
          }

          .page-break { display: block; page-break-before: always; }
      </style>
	</head>

	<body>
		<div id="vue-element">
			<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="box-shadow: 0px 5px 10px #555;">
			    <a class="navbar-brand" href="{{ url('/') }}">{{ jurnal()->companyName }}</a>

			    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			      <span class="navbar-toggler-icon"></span>
			    </button>

			    <div class="collapse navbar-collapse" id="navbarCollapse">
			      <ul class="navbar-nav ml-auto">

			      	{{-- <li class="nav-item">
			      	  <a href="{{ route('laporan.keuangan.index') }}" style="color: #ffbb33;">
			          	<i class="fa fa-backward" title="Kembali Ke Menu Laporan"></i>
			          </a>
			        </li> --}}

			        <li class="nav-item">
			          	<i class="fa fa-print" title="Print Laporan" @click="print"></i>
			        </li>

			        {{-- <li class="nav-item dropdown" title="Download Laporan">
			          	<i class="fa fa-download" id="dropdownMenuButton" data-toggle="dropdown"></i>

			            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						    <a class="dropdown-item" href="#" style="font-size: 10pt;" @click='downloadPdf'>
						    	<i class="fa fa-file-pdf-o" style="font-weight: bold;"></i> &nbsp; Download PDF
						    </a>

						    <div class="dropdown-divider"></div>

						    <a class="dropdown-item" href="#" style="font-size: 10pt;" @click='downloadExcel'>
						    	<i class="fa fa-file-excel-o" style="font-weight: bold;"></i> &nbsp; Download Excel
						    </a>
					    </div>
			        </li> --}}

			        <li class="nav-item">
			          <i class="fa fa-sliders" title="Pengaturan Laporan" @click="showSetting"></i>
			        </li>

			      </ul>
			    </div>
			</nav>

			<div class="container-fluid" id="contentnya" style="background: none; margin-top: 70px; padding: 10px 30px;">
				<div id="contentnya">

					<?php 
						if($_GET['type'] == 'bulan')
							$tanggal_1 = explode('/', $_GET['d1'])[0];
					?>					

					{{-- Judul Kop --}}

						<table width="100%" border="0" style="border-bottom: 1px solid #333;">
				          <thead>
				            <tr>
				              <th style="text-align: left; font-size: 14pt; font-weight: 600; padding-top: 10px;" colspan="2">Analisa Rasio Keuangan <small>(Rekap)</small></th>
				            </tr>

				            <tr>
				              <th style="text-align: left; font-size: 12pt; font-weight: 500" colspan="2">{{ jurnal()->companyName }}</th>
				            </tr>

				            <tr>
				              <th style="text-align: left; font-size: 8pt; font-weight: 500; padding-bottom: 10px;">(Angka Disajikan Dalam Rupiah, Kecuali Dinyatakan Lain)</th>

				              <th class="text-right" style="font-size: 8pt; font-weight: normal;">
				              	<b>Periode {{ $tanggal_1 }}</b>
				              </th>
				            </tr>
				          </thead>
				        </table>

				    {{-- End Judul Kop --}}

				    <table class="table" id='table-data' style="margin-top: 15px;">
				    	<thead>
				    		<tr>
								<th class="head" colspan="13">
									<i class="fa fa-chevron-right"></i> &nbsp;Rasio Likuiditas (Liquidity ratio)</th>
							</tr>
				    	</thead>
				    </table>

			    	<div style="padding-top: 0px; padding-left: 20px;">
						<table class="table" id="table-data">
							<thead>
								<tr>
									<th width="16%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Keterangan</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Jan {{ $tanggal_1 }}</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Feb {{ $tanggal_1 }}</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Mar {{ $tanggal_1 }}</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Apr {{ $tanggal_1 }}</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Mei {{ $tanggal_1 }}</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Jun {{ $tanggal_1 }}</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Juli {{ $tanggal_1 }}</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Agu {{ $tanggal_1 }}</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Sep {{ $tanggal_1 }}</th>
									<th width="7%"style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Okt {{ $tanggal_1 }}</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Nov {{ $tanggal_1 }}</th>
									<th width="7%" style="text-align: center; border: 1px solid #eee; background-color: #0099CC; color: white;">Des {{ $tanggal_1 }}</th>
								</tr>
							</thead>
							
								<tbody>
									<tr>
										<td>Quick Ratio</td>
										
										<template v-for="stropper in dataPrint">
											<td v-for="(likuiditas, alpha) in stropper.likuiditas" :style="(likuiditas.onPeriode == 'false') ? 'text-align: center; background: #eee;' : 'text-align: center;'">@{{ likuiditas.quickRasio }}</td>
										</template>
									</tr>

									<tr>
										<td>Current Ratio</td>

										<template v-for="stropper in dataPrint">
											<td v-for="(likuiditas, alpha) in stropper.likuiditas" :style="(likuiditas.onPeriode == 'false') ? 'text-align: center; background: #eee;' : 'text-align: center;'">@{{ likuiditas.currentRasio }}</td>
										</template>
									</tr>
								</tbody>
						</table>

						<table class="table" id="table-data" style="margin-top: 20px;">
							<thead>
								<tr>
									<th class="subHead">
										<i class="fa fa-caret-right" style="font-size: 9pt;"></i> &nbsp;Grafik Rasio Likuiditas Tahun {{ $tanggal_1 }}
									</th>

									<th class="subHead divide"></th>
									<th class="subHead divide"></th>
									<th class="subHead divide"></th>
									<th class="subHead divide"></th>

									<th class="subHead">
										<i class="fa fa-caret-right" style="font-size: 9pt;"></i> &nbsp;Persentase Rasio Likuiditas Tahun {{ $tanggal_1 }}
									</th>
								</tr>

								<tr>
									<th class="subHead">
										<canvas id="canvas" height="150px;"></canvas>
									</th>

									<th class="subHead divide"></th>
									<th class="subHead divide"></th>
									<th class="subHead divide"></th>
									<th class="subHead divide"></th>

									<th class="subHead chartRight" style="text-decoration: none;">
										<table class="table" id="table-data" style="background: none">
											<thead>
												<tr>
													<th class="subHead" width="25%" style="padding-left: 20px; padding-top: 15px;">
														<span id="pie-chart-1"></span>
													</th>

													<th class="subHead" width="75%" style="text-align: left; vertical-align: top; padding-top: 20px; padding-left: 20px; text-decoration: none;">
														<i class="fa fa-circle" style="color: #4285F4;"></i> &nbsp;Current Ratio (30)
														<br><br>
														<i class="fa fa-circle" style="color: #ff4444;"></i> &nbsp;Quick Ratio (70)
													</th>
												</tr>

												<tr>
													<th class="subHead" colspan="2" style="padding-left: 0px; text-align: left; padding-top: 40px;">
														<i class="fa fa-caret-right" style="font-size: 9pt;"></i> &nbsp;Rata-Rata Nilai Rasio Likuiditas Tahun {{ $tanggal_1 }}
													</th>
												</tr>

												<tr>
													<th class="subHead" style="padding-top: 20px; font-size: 9pt; vertical-align: middle; text-align: left; text-decoration: none; color: #00695c; padding-left: 20px;">
														% Current Ratio
													</th>

													<th class="subHead" style="padding-top: 20px; font-size: 10pt; vertical-align: middle; text-align: center; text-decoration: none; color: #00695c;">
														0.22%
													</th>
												</tr>

												<tr>
													<th class="subHead" style="padding-top: 20px; font-size: 9pt; vertical-align: middle; text-align: left; text-decoration: none; color: #00695c; padding-left: 20px;">
														% Quick Ratio
													</th>

													<th class="subHead" style="padding-top: 20px; font-size: 10pt; vertical-align: middle; text-align: center; text-decoration: none; color: #00695c;">
														0.22%
													</th>
												</tr>
											</thead>
										</table>
									</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>

			<div class="ez-popup" id="loading-popup">
	            <div class="layout text-center" style="width: 50%; background: none; box-shadow: none; color: white; min-height: 0px; margin-top: 250px; border-radius: 2px;">
	                   <span style="font-size: 11pt; font-style: italic;">
	                   		<div class="lds-dual-ring" v-if="textLoading == 'Sedang Menyiapkan Laporan . Harap Tunggu...'"></div>
	                   		<i class="fa fa-frown-o" style="font-size: 42pt; margin-bottom: 20px;" v-if="textLoading != 'Sedang Menyiapkan Laporan . Harap Tunggu...'"></i>
	                   		<br>
	                   		@{{ textLoading }}
	                   	</span>
	            </div>
	        </div>

	        <div class="ez-popup" id="setting-popup">
	            <div class="layout" style="width: 35%; min-height: 150px;">
	                <div class="top-popup" style="background: none;">
	                    <span class="title">
	                        Setting Laporan Analisa
	                    </span>

	                    <span class="close"><i class="fa fa-times" style="font-size: 12pt; color: #CC0000"></i></span>
	                </div>
	                
	                <div class="content-popup">
	                	<form id="form-setting" method="get" action="{{ route('analisa.keuangan.cashflow') }}">
	                	<input type="hidden" readonly name="_token" value="{{ csrf_token() }}">
	                    <div class="col-md-12">

	                    	<div class="row mt-form">
	                            <div class="col-md-4">
	                                <label class="modul-keuangan">Type Analisa</label>
	                            </div>

	                            <div class="col-md-7">
	                            	<vue-select :name="'type'" :id="'type'" :options="typeLaporan" :styles="'width:100%'" @input="typeChange"></vue-select>
	                            </div>

	                        </div>

	                        <div class="row mt-form">
	                            <div class="col-md-4">
	                                <label class="modul-keuangan">Periode</label>
	                            </div>

	                            <div class="col-md-7" v-show="type == 'bulan'">
                    				<vue-datepicker :name="'d1'" :id="'d1'" :title="'Tidak Boleh Kosong'" :readonly="true" :placeholder="'Pilih Tanggal'" :format="'yyyy'" :styles="'font-size: 9pt;'"></vue-datepicker>
	                            </div>
	                        </div>

	                    </div>

	                    <div class="col-md-12" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px;">
	                    	<div class="row">
		                    	<div class="col-md-8" style="padding: 0px; padding-top: 5px; padding-left: 10px; color: #666;">
	                                <div class="loader" v-if="stat == 'loading'">
	                                   <div class="loading"></div> &nbsp; <span>@{{ statMessage }}</span>
	                                </div>
	                            </div>

		                    	<div class="col-md-4 text-right" style="padding: 0px;">
		                    		<button type="button" class="btn btn-info btn-sm" @click='prosesLaporan'>Proses</button>
		                    	</div>
		                    </div>
	                    </div>

	                    </form>
	                </div>
	            </div>
	        </div>

	        <iframe style="display: none;" id='pdfIframe' src=''/></iframe>
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
		<script src="{{ asset('modul_keuangan/js/vendors/chart_js_2_7_3/Chart.bundle.min.js') }}"></script>
		<script src="{{ asset('modul_keuangan/js/vendors/sparkline/sparkline.min.js') }}"></script>

    	<script type="text/javascript">

    		var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
				var config = {
					type: 'bar',
					data: {
						labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
						datasets: [

							{
								steppedLine: false,
								label: 'Quick Ratio',
								backgroundColor: '#ff4444',
								borderColor: '#ff4444',
								data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
								fill: false,
								showLine: true,
								pointRadius: 4,
								pointHoverRadius: 8
							},

							{
								steppedLine: true,
								label: 'Current Ratio',
								backgroundColor: '#4285F4',
								borderColor: '#4285F4',
								data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
								fill: false,
								showLine: false,
								pointRadius: 4,
								pointHoverRadius: 8,
							}
						]
					},
					options: {
						responsive: true,
						title: {
							display: false,
							text: 'Liquidity Ratio'
						},
						tooltips: {
							mode: 'index',
							intersect: false,
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Periode'
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Nilai'
								},
								ticks: {
									suggestedMin: 0,
									suggestedMax: 15,
								}
							}]
						},
						elements: {
							point: {
								pointStyle: 'rectRounded'
							}
						},
						legend: {
							display: true
						},
					}
				};

				Chart.plugins.register({
					afterDatasetsDraw: function(chart) {
						var ctx = chart.ctx;

						chart.data.datasets.forEach(function(dataset, i) {
							var meta = chart.getDatasetMeta(i);
							if (!meta.hidden) {
								meta.data.forEach(function(element, index) {
									// Draw the text in black, with the specified font
									ctx.fillStyle = '#2E2E2E';

									var fontSize = 11;
									var fontStyle = 'normal';
									var fontFamily = 'Helvetica Neue';
									ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

									// Just naively convert to string for now
									var dataString = dataset.data[index].toString();

									// Make sure alignment settings are correct
									ctx.textAlign = 'center';
									ctx.textBaseline = 'middle';

									var padding = 5;
									var position = element.tooltipPosition();
									ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
								});
							}
						});
					}
				});

				window.onload = function() {
					var ctx = document.getElementById('canvas').getContext('2d');
					window.myLine = new Chart(ctx, config);
					$("#pie-chart-1").sparkline([1,2], {
					    type: 'pie',
					    width: '100',
					    height: '100',
					    sliceColors: ['#4285F4', '#ff4444'],
					});
				};

			var app = 	new Vue({
			    			el: '#vue-element',
			    			data: {

			    				textLoading: "",
			    				statMessage: "Sedang Menyiapkan Laporan..",
			    				stat: "standby",
			    				url: new URL(window.location.href),

			    				firstElement: 0,
			    				dataPage: 1,
			    				pageNow: 0,
			    				rowsCount: 500,

			    				nextDisabled: false,
			    				previousDisabled: true,

			    				dataSource: [],
			    				dataPrint: [],
			    				dataLikuiditas: {},

			    				// setting
			    					type: 'bulan',
			    					kelompok: [],
			    					typeLaporan: [
				    					{
				    						id: 'bulan',
				    						text: 'Laporan Analisa Dalam Bulan',
				    					}
				    				],

				    				tampilan: [
				    					{
				    						id: 'tabular',
				    						text: 'Tampilan Table',
				    					},

				    					{
				    						id: 'menurun',
				    						text: 'Tampilan Menurun'
				    					}
				    				],
			    			},

			    			created: function(){
				                console.log('Initializing Vue');
				            },

				            mounted: function(){
				            	console.log('Vue Ready');
			                    // chartRegist();
				            	this.textLoading = "Sedang Menyiapkan Laporan . Harap Tunggu...";
				            	$('#loading-popup').ezPopup('show');

				            	$('#d1').val('{{ $_GET['d1'] }}');
				            	$('#type').val('{{ $_GET['type'] }}').trigger('change.select2');
				            	this.typeChange('{{ $_GET['type'] }}');

				            	that = this;

				            	axios.get('{{route('analisa.keuangan.rasio.data_resource')}}?'+that.url.searchParams)
			                            .then((response) => {

			                                if(response.data.data.length){
			                                	this.dataSource = response.data.data;
			                                	this.pageNow = 1;

			                                	if(this.dataSource.length / this.rowsCount < 1){
			                                		this.dataPage = Math.floor(this.dataSource.length / this.rowsCount) + 1;
			                                		// alert('a')
			                                	}else if((this.dataSource.length / this.rowsCount) % 1 == 0){
			                                		this.dataPage = Math.floor(this.dataSource.length / this.rowsCount);
			                                		// alert('b')
			                                	}else if(this.dataSource.length / this.rowsCount > 1){
			                                		this.dataPage = Math.floor(this.dataSource.length / this.rowsCount) + 1;
			                                		// alert('c')
			                                	}

			                                	if(this.pageNow == this.dataPage)
			                                		this.nextDisabled = true;

			                                }else{
			                                	this.pageNow = 1;
			                                }

			                                // if(response.data.kelompok.length){
			                                // 	this.kelompok = response.data.kelompok;
			                                // }

			                                $('#loading-popup').ezPopup('close');
			                            })
			                            .catch((e) => {
			                            	this.textLoading = "Data Laporan Bermasalah. Segera Hubungi Developer. message : "+e;
			                            })
				            },

				            computed: {
				            	detail: function(){
				            		that = this;
				            		var clock = []; grandAktiva = grandPasiva = 0; $a = 0;
				            		var level2Bucket = {}; level1Bucket = {OCF: 0, ICF: 0, FCF:0};
				            		var bucket = {};

				            		$.each(this.dataPrint, function(idx1, level_2){
				            			var level2 = 0;

				            			$.each(level_2.akun, function(idx2, akun){
				            				level2 += akun.saldo_akhir
				            			})

				            			level2Bucket['_'+level_2.hld_id] = level2

				            			level1Bucket[level_2.hld_cashflow] += level2;

				            		})

				            		bucket = {
				            			level1 : level1Bucket,
				            			level2 : level2Bucket,
				            			// grandAktiva : grandAktiva,
				            			// grandPasiva : grandPasiva
				            		}

				                	// console.log(bucket);
				                	return bucket;
				            	}
				            },

				            watch: {
				            	pageNow: function(){
				            		var dump = []; var c = [];

				            		for (i = this.firstElement; i < (this.firstElement + this.rowsCount); i++){
				            			if(i < this.dataSource.length){
				            				dump.push(this.dataSource[i]);
				            				c.push(i);
				            			}else{
				            				break;
				            			}
				            		}

				            		this.dataPrint = dump;
				            		// console.log(this.dataPrint);
				            	},

				            	dataSource: function(){

				            		that = this;
				            		quickRasio = []; currentRasio = [];

				            		$.each(this.dataSource[0].likuiditas, function(idex, alpha){
				            			quickRasio.push(parseFloat(alpha.quickRasio));
				            			currentRasio.push(parseFloat(alpha.currentRasio));
				            		})

				            		config.data.datasets[0].data = quickRasio;
				            		config.data.datasets[1].data = currentRasio;
									window.myLine.update();
				            	}
				            },

				            methods: {
				            	previousPage: function(){
				            		if(this.pageNow > 1){
				            			this.pageNow--;
				            			this.firstElement -= (this.rowsCount);

				            			this.previousDisabled = (this.pageNow == 1) ? true : false;
				            			this.nextDisabled = (this.pageNow == this.dataPage) ? true : false;
				            		}
				            	},

				            	nextPage: function(){
				            		if(this.pageNow < this.dataPage){
				            			this.pageNow++;
				            			this.firstElement += (this.rowsCount);

				            			this.nextDisabled = (this.pageNow == this.dataPage) ? true : false;
				            			this.previousDisabled = (this.pageNow == 1) ? true : false;
				            		}
				            	},

				            	showSetting: function(evt){
				            		evt.preventDefault();
				                	evt.stopImmediatePropagation();

				                	$('#setting-popup').ezPopup('show');
				            	},

				            	downloadPdf: function(evt){
				            		evt.preventDefault();
				                	evt.stopImmediatePropagation();

				                	$.toast({
									    text: "Sedang Mendownload Laporan PDF",
			                            showHideTransition: 'slide',
			                            position: 'bottom-right',
			                            icon: 'info',
			                            hideAfter: 10000,
			                            showHideTransition: 'slide',
			                            allowToastClose: false,
			                            stack: false
									});

				                    $('#pdfIframe').attr('src', '{{route('analisa.keuangan.cashflow.print.pdf')}}?'+that.url.searchParams)

				            	},

				            	downloadExcel: function(evt){
				            		evt.preventDefault();
				                	evt.stopImmediatePropagation();

				                	$.toast({
			                            text: "Sedang Mendownload Laporan EXCEL",
			                            showHideTransition: 'slide',
			                            position: 'bottom-right',
			                            icon: 'info',
			                            hideAfter: 10000,
			                            showHideTransition: 'slide',
			                            allowToastClose: false,
			                            stack: false
			                        });

			                        $('#pdfIframe').attr('src', '{{route('laporan.keuangan.arus_kas.print.excel')}}?'+that.url.searchParams)
				            	},

				            	print: function(evt){
				            		evt.preventDefault();
				            		evt.stopImmediatePropagation();

				            		$.toast({
			                            text: "Sedang Mencetak Laporan",
			                            showHideTransition: 'slide',
			                            position: 'bottom-right',
			                            icon: 'info',
			                            hideAfter: 8000,
			                            showHideTransition: 'slide',
			                            allowToastClose: false,
			                            stack: false
			                        });

			                        window.print();

				            		// $('#pdfIframe').attr('src', '{{route('analisa.keuangan.cashflow.print')}}?'+that.url.searchParams)
				            	},

				            	humanizePrice: function(alpha){
				            	  var kl = alpha.toString().replace('-', '');
				                  bilangan = kl;
				                  var commas = '00';


				                  if(bilangan.split('.').length > 1){
				                    commas = bilangan.split('.')[1];
				                    bilangan = bilangan.split('.')[0];
				                  }
				                  
				                  var number_string = bilangan.toString(),
				                    sisa  = number_string.length % 3,
				                    rupiah  = number_string.substr(0, sisa),
				                    ribuan  = number_string.substr(sisa).match(/\d{3}/g);
				                      
				                  if (ribuan) {
				                    separator = sisa ? ',' : '';
				                    rupiah += separator + ribuan.join(',');
				                  }

				                  // Cetak hasil
				                  return rupiah+'.'+commas; // Hasil: 23.456.789
				                },

				                humanizeDate(date){
				                	let d = date.split('-')[2]+'/'+date.split('-')[1]+'/'+date.split('-')[0];

				                	return d;
				                },

				                typeChange: function(e){
				                	this.type = e;
				                },

				                akunChange:function(e){
				                	var ak2 = $.grep(this.akun, function(alpha){ return alpha.id >= e });

				                	this.akun2 = ak2;
				                },

				                prosesLaporan: function(evt){
				                	evt.preventDefault();
				                	evt.stopImmediatePropagation();

				                	if(this.validate()){
				                		this.stat = 'loading';
				                		$('#form-setting').submit();
				                	}
				                },

				                validate: function(){
				                	if($('#d1').val() == '' || $('#d2').val() == ''){
				                		$.toast({
				                            text: "Harap Lengkapi Data Inputan",
				                            showHideTransition: 'slide',
				                            position: 'top-right',
				                            icon: 'error',
				                            hideAfter: false
				                        });

				                        return false;
				                	}

				                	return true;
				                },

				                getNamaKelompok: function(index){
				                	var idx = this.kelompok.findIndex(alpha => alpha.ak_kelompok == index);

				                	return this.kelompok[idx].ak_nama;
				                },
				            }
			    		})
    	</script>
	</body>
</html>
