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
			<li>Home</li><li>Manajemen Penjualan</li><li>Rencana Pembelian Barang</li>
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
                    Manajemen Penjualan <span><i class="fa fa-angle-double-right"></i> Pembuatan Rencana Penjualan </span>
                </h1>
            </div>

            @if(Plasma::checkAkses(26, 'insert') == true)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right padding-top-10">
                <button class="btn btn-success" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;Tambah Rencana Penjualan</button>
            </div>
            @endif

        </div>

        <section id="widget-grid" class="">

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                        
                        <header>
							<ul id="widget-tab-1" class="nav nav-tabs pull-left">
								<li class="active">
									<a data-toggle="tab" href="#hr1"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> Approved </span> </a>
								</li>

								<li>
									<a data-toggle="tab" href="#hr2"> <i style="color: #C79121;" class="fa fa-lg fa-align-justify"></i> <span class="hidden-mobile hidden-tablet"> Pending </span></a>
								</li>
							</ul>
                        </header>

                        <div>
                            <div class="widget-body no-padding">

                                <div class="col-md-12 no-padding padding-top-15">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" id="month-picker" name="month-picker" class="form-control" placeholder="MASUKKAN BULAN">                                       
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" id="irpCompId" name="irpCompId">
                                            <input type="text" class="form-control irpCompName" placeholder="Masukkan Nama Cabang" style="text-transform: uppercase">                                       
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <a class="btn btn-primary" onclick="search()"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>

                                <div class="tab-content padding-10">

                                    <div class="tab-pane fade in active" id="hr1">
										<table id="apprTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
													<th style="width: 20%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th style="width: 40%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Cabang</th>
													<th style="width: 20%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Update</th>
													<th style="width: 20%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody>
											</tbody>

										</table>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="hr2">
										<table id="pendTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
													<th style="width: 20%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th style="width: 40%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Cabang</th>
													<th style="width: 20%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Update</th>
													<th style="width: 20%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody>
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
<script src="{{ asset('template_asset/js/MonthPicker.js') }}"></script>
    <script type="text/javascript">
        var appr, pend;

        $(document).ready(function(){
            $('#month-picker').MonthPicker({
                Button: false
            });

            $('.irpCompName').autocomplete({
                source: baseUrl+'/man-penjualan/rencana-penjualan/auto-comp',
                minLength: 2,
                select: function(event, data){
                    $('#irpCompId').val(data.item.id);
                }
            })

            setTimeout(function () {

			appr = $('#apprTable').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ url('/man-penjualan/rencana-penjualan/getApproved') }}",
				"columns":[
					{"data": "sp_nota"},
					{"data": "c_name"},
					{"data": "sp_update"},
					{"data": "aksi"}
				],
				"autoWidth" : true,
				"language" : dataTableLanguage,
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#apprTable'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});

		}, 500);

		setTimeout(function () {

			pend = $('#pendTable').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ url('/man-penjualan/rencana-penjualan/getPending') }}",
				"columns":[
					{"data": "sp_nota"},
					{"data": "c_name"},
					{"data": "sp_update"},
					{"data": "aksi"}
				],
				"autoWidth" : true,
				"language" : dataTableLanguage,
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#pendTable'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});

		}, 1000);
        });

        function tambah(){
            location.href = ('{{ url('/man-penjualan/rencana-penjualan/add') }}');
        }

        function edit(id){
            location.href = ('{{ url('/man-penjualan/rencana-penjualan/edit') }}/'+id);
        }
    </script>
@endsection