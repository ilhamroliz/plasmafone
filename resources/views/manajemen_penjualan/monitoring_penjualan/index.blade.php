@extends('main')

@section('title', 'Pembuatan Rencana Penjualan')

@section('extra_style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/MonthPicker.css') }}">
@endsection

<?php
use App\Http\Controllers\PlasmafoneController as Plasma;
?>

@section('ribbon')
	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment">
			<span id="refresh" class="btn btn-ribbon" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Refresh Halaman? Semua Perubahan Yang Belum Tersimpan Akan Hilang.." data-html="true" onclick="location.reload()">
				<i class="fa fa-refresh"></i>
			</span>
		</span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>Home</li><li>Manajemen Penjualan</li><li>Monitoring Penjualan</li>
		</ol>

	</div>
	<!-- END RIBBON -->
@endsection

@section('main_content')

    <div id="content">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-sliders"></i>
                    Manajemen Penjualan <span><i class="fa fa-angle-double-right"></i> Monitoring Penjualan </span>
                </h1>
            </div>

        </div>

        <section id="widget-grid" class="">

            <div class="row">

                <!-- Table untuk || Penjualan Realtime ||
                    Penjualan yang ditampilkan hanya penjualan HARI INI
                -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="jarviswidget" id="wid-id-11"
                        data-widget-editbutton="false"
                        data-widget-colorbutton="false"
                        data-widget-deletebutton="false">

                        <header>
                            <h2><strong>Data Penjualan Realtime</strong></h2>
                        </header>

                        <div>
                            <div class="widget-body no-padding">

                                <div class="tab-content padding-10">

                                    <div class="tab-pane fade in active" id="hr1">
										<table id="realtimeTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
                                                    <th style="width: 15%"><i class="fa fa-fw fa-calendar-times-o txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal</th>
                                                    <th style="width: 15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
                                                    <th style="width: 20%"><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Member</th>
                                                    <th style="width: 20%"><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Sales</th>
                                                    <th style="width: 20%"><i class="fa fa-fw fa-dollar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Total Harga</th>
													<th style="width: 10%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>
                                            <form id="countForm">
                                                <input type="hidden" id="hiddenCount" name="hiddenCount">
                                            </form>
											<tbody id="apprshowdata">
											</tbody>

										</table>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Table untuk || Realisasi Penjualan ||
                    Setiap Row menampilkan Target Capaian Setiap Outlet untuk Setiap Item
                -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="jarviswidget" id="wid-id-11"
                        data-widget-editbutton="false"
                        data-widget-colorbutton="false"
                        data-widget-deletebutton="false">

                        <header>
                            <h2><strong>Data Realisasi Penjualan</strong></h2>
                        </header>

                        <div>
                            <div class="widget-body no-padding">
								<form id="cariMPForm">
									<div class="col-md-12 no-padding padding-top-15">
										<div class="col-md-4">

                                            <div>
                                                <div class="input-group input-daterange date-range">
                                                    <input type="text" class="form-control" id="tglAwal" name="tglAwal" value="{{ $startDate }}" placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
                                                    <span class="input-group-addon bg-custom text-white b-0">to</span>
                                                    <input type="text" class="form-control" id="tglAkhir" name="tglAkhir" value="{{ $endDate }}" placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">
                                                </div>
                                            </div>

										</div>

										<div class="col-md-4">
											<div class="form-group">
												<input type="hidden" id="mpCompId" name="mpCompId">
												<input type="text" class="form-control mpCompName" placeholder="Masukkan Nama Cabang" style="text-transform: uppercase">
											</div>
										</div>

										<div class="col-md-1">
											<a class="btn btn-primary" onclick="cari()"><i class="fa fa-search"></i></a>
										</div>
									</div>
								</form>

                                <div class="tab-content padding-10">

                                    <div class="tab-pane fade in active" id="hr1">
										<table id="realisasiTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
                                                    <th style="width: 15%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Outlet</th>
                                                    <th style="width: 15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
                                                    <th style="width: 30%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
                                                    <th style="width: 13%"><i class="fa fa-fw fa-list txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Rencana Penjualan</th>
                                                    <th style="width: 13%"><i class="fa fa-fw fa-shopping-basket txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Realisasi Penjualan</th>
                                                    <th style="width: 13%"><i class="fa fa-fw fa-crosshairs txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Target Sisa</th>
												</tr>
											</thead>
                                            <form id="countForm">
                                                <input type="hidden" id="hiddenCount" name="hiddenCount">
                                            </form>
											<tbody id="relShowdata">
											</tbody>

										</table>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Table Untuk || Best Outlet ||
                    Berdasarkan Sum/ Total QTY yang terjual, serta Omset dan Laba yang didapatkan
                -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="jarviswidget" id="wid-id-11"
                        data-widget-editbutton="false"
                        data-widget-colorbutton="false"
                        data-widget-deletebutton="false">

                        <header>
                            <h2><strong>Data Outlet Terbaik</strong></h2>
                        </header>

                        <div>
                            <div class="widget-body no-padding">

                                <form id="cariOTForm">
									<div class="col-md-12 no-padding padding-top-15">
										<div class="col-md-4">

                                            <div>
                                                <div class="input-group input-daterange date-range">
                                                    <input type="text" class="form-control" id="tglAwalOT" name="tglAwalOT" value="{{ $startDate }}" placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
                                                    <span class="input-group-addon bg-custom text-white b-0">to</span>
                                                    <input type="text" class="form-control" id="tglAkhirOT" name="tglAkhirOT" value="{{ $endDate }}" placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">
                                                </div>
                                            </div>

										</div>

										<div class="col-md-1">
											<a class="btn btn-primary" onclick="cariOT()"><i class="fa fa-search"></i></a>
										</div>
									</div>
								</form>

                                <div class="tab-content padding-10">

                                    <div class="tab-pane fade in active" id="hr1">
										<table id="outletTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
                                                    <th style="width: 40%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Outlet</th>
                                                    <th style="width: 20%"><i class="fa fa-fw fa-shopping-basket txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Total Penjualan (QTY)</th>
                                                    <th style="width: 20%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Total Omset</th>
                                                    <th style="width: 20%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Total Laba</th>
												</tr>
											</thead>
                                            <form id="countForm">
                                                <input type="hidden" id="hiddenCount" name="hiddenCount">
                                            </form>
											<tbody id="outShowdata">
											</tbody>

										</table>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>
@endsection

@section('extra_script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#realtimeTable').DataTable({
                "language" : dataTableLanguage
            });

            $('#realisasiTable').DataTable({
                "language" : dataTableLanguage
            });

            $('#outletTable').DataTable({
                "language" : dataTableLanguage,
                "order" : []
            });

            $( ".mpCompName" ).autocomplete({
				source: baseUrl+'/man-penjualan/rencana-penjualan/auto-comp',
				minLength: 2,
				select: function(event, data) {
					$('#mpCompId').val(data.item.id);
				}
			});

            $( ".date-range" ).datepicker({
                language: "id",
                format: 'dd/mm/yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true,
                todayHighlight: true
            });

            // setInterval(function() {

                // axios.post(baseUrl+'/man-penjualan/monitoring-penjualan/realtime', $('#countForm').serialize()).then((response) => {

                //     for(var i = 0; i < response.data.real.length; i++){
                //         $('#realtimeTable').DataTable().row.add([
                //             response.data.real[i].s_date,
                //             response.data.real[i].s_nota,
                //             response.data.real[i].m_name,
                //             response.data.real[i].c_name,
                //             '<div class="text-center"><button class="btn btn-circle btn-primary" onclick="detil('+response.data.real[i].s_id+')"><i class="glyphicon glyphicon-list"></i></button></div>'
                //         ]).draw(false);

                //         if(i == response.data.real.length){
                //             $('#hiddenCount').val(response.data.real[i].s_id);
                //         }
                //     }
                // });

                // $('#realtimeTable').DataTable().destroy();
                // $('#realtimeTable').DataTable({
				// 	"processing": true,
				// 	"serverSide": true,
				// 	"ajax": "{{ url('/man-penjualan/monitoring-penjualan/realtime') }}",
				// 	"columns":[
				// 		{"data": "s_date"},
				// 		{"data": "s_nota"},
				// 		{"data": "m_name"},
				// 		{"data": "c_name"},
				// 		{"data": "aksi"}
				// 	],
				// 	"autoWidth" : true,
				// 	"language" : dataTableLanguage,
				// 	"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
				// 	"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
				// 	"preDrawCallback" : function() {
				// 		// Initialize the responsive datatables helper once.
				// 		if (!responsiveHelper_dt_basic) {
				// 			responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#realtimeTable'), breakpointDefinition);
				// 		}
				// 	},
				// 	"rowCallback" : function(nRow) {
				// 		responsiveHelper_dt_basic.createExpandIcon(nRow);
				// 	},
				// 	"drawCallback" : function(oSettings) {
				// 		responsiveHelper_dt_basic.respond();
				// 	}
				// });
            // }, 5000);

            axios.post(baseUrl+'/man-penjualan/monitoring-penjualan/realisasi').then((response) => {

                for(var i = 0; i < response.data.data.length; i++){
                    $('#realisasiTable').DataTable().row.add([
                        response.data.data[i].c_name,
                        response.data.data[i].sp_nota,
                        response.data.data[i].i_nama,
                        '<div class="text-align-right">'+response.data.data[i].spd_qty+' Unit</div>',
                        '<div class="text-align-right">'+response.data.data[i].qty+' Unit</div>',
                        '<div class="text-align-right">'+(response.data.data[i].spd_qty - response.data.data[i].qty) +' Unit</div>'
                    ]).draw(false);
                }

            });

            axios.post(baseUrl+'/man-penjualan/monitoring-penjualan/outlet').then((response) => {

                for(var i = 0; i < response.data.data.length; i++){
                    $('#outletTable').DataTable().row.add([
                        response.data.data[i].c_name,
                        '<div class="text-align-right">'+response.data.data[i].qty+' Unit</div>',
                        '<div><span style="float: left">Rp. </span><span style="float: right">'+response.data.data[i].net+'</span></div>',
                        '<div><span style="float: left">Rp. </span><span style="float: right">'+0+'</span></div>'
                    ]).draw(false);
                }

            });

        })

        function cari(){
            axios.post(baseUrl+'/man-penjualan/monitoring-penjualan/realisasi', $('#cariMPForm').serialize()).then((response) => {
                $('#relShowdata').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');

                $('#realisasiTable').DataTable().clear();

                for(var i = 0; i < response.data.data.length; i++){
                    $('#realisasiTable').DataTable().row.add([
                        response.data.data[i].c_name,
                        response.data.data[i].sp_nota,
                        response.data.data[i].i_nama,
                        '<div class="text-align-right">'+response.data.data[i].spd_qty+' Unit</div>',
                        '<div class="text-align-right">'+response.data.data[i].qty+' Unit</div>',
                        '<div class="text-align-right">'+(response.data.data[i].spd_qty - response.data.data[i].qty) +' Unit</div>'
                    ]).draw(false);
                }

            })
        }

        function cariOT(){
            axios.post(baseUrl+'/man-penjualan/monitoring-penjualan/outlet', $('#cariOTForm').serialize()).then((response) => {
                $('#outShowdata').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');

                $('#outletTable').DataTable().clear();

                for(var i = 0; i < response.data.data.length; i++){
                    $('#outletTable').DataTable().row.add([
                        response.data.data[i].c_name,
                        '<div class="text-align-right">'+response.data.data[i].qty+' Unit</div>',
                        '<div><span style="float: left">Rp. </span><span style="float: right">'+response.data.data[i].net+'</span></div>',
                        '<div><span style="float: left">Rp. </span><span style="float: right">'+0+'</span></div>'
                    ]).draw(false);
                }

            })
        }
    </script>
@endsection
