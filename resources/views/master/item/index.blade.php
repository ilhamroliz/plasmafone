@extends('main')

@section('title', 'Master Barang')


@section('extra_style')

@endsection


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
			<li>Home</li><li>Master</li><li>Barang</li>
		</ol>
		<!-- end breadcrumb -->

	</div>
	<!-- END RIBBON -->
@endsection


@section('main_content')

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row hidden-mobile">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-asterisk"></i> 
					Master <span>>
					Barang </span></h1>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">
				<div class="page-title">
					<a href="{{ url('/master/barang/add') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>
				</div>
			</div>
		</div>

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<?php $mt = '20px'; ?>

			@if(Session::has('flash_message_success'))
				<?php $mt = '0px'; ?>
				<div class="col-md-8" style="margin-top: 20px;">
					<div class="alert alert-success alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
						{{ Session::get('flash_message_success') }} 
					</div>
				</div>
			@elseif(Session::has('flash_message_error'))
				<?php $mt = '0px'; ?>
				<div class="col-md-8" style="margin-top: 20px;">
					<div class="alert alert-danger alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
						{{ Session::get('flash_message_error') }}
					</div>
				</div>
			@endif

			<!-- row -->
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

						<header>
							
							<ul id="widget-tab-1" class="nav nav-tabs pull-left">

								<li class="active">

									<a data-toggle="tab" href="#hr1"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> Aktif </span> </a>

								</li>

								<li>
									<a data-toggle="tab" href="#hr2"> <i style="color: #C79121;" class="fa fa-lg fa-align-justify"></i> <span class="hidden-mobile hidden-tablet"> Semua </span></a>
								</li>

								<li>
									<a data-toggle="tab" href="#hr3"> <i style="color: #A90329;" class="fa fa-lg fa-minus-square"></i> <span class="hidden-mobile hidden-tablet"> Non Aktif </span></a>
								</li>

							</ul>	
							
						</header>

						<!-- widget div-->
						<div>
							
							<!-- widget content -->
							<div class="widget-body no-padding">

								<!-- widget body text-->
								
								<div class="tab-content padding-10">
									<div class="tab-pane fade in active" id="hr1">
										
										<table id="dt_active" class="table table-striped table-bordered table-hover" width="100%">
											<thead>			                
												<tr>
													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-star txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Merk
													</th>
													<th data-hide="phone,tablet" width="30%"><i class="fa fa-fw fa-font txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Nama
													</th>
													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Kode
													</th>
													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-balance-scale txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Berat (Gram)
													</th>
													<th class="text-center" data-hide="phone,tablet" width="15%"> 
														Aksi
													</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
										
									</div>
									<div class="tab-pane fade" id="hr2">
										
										<table id="dt_all" class="table table-striped table-bordered table-hover" width="100%">
											<thead>			                
												<tr>
													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-star txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Merk
													</th>
													<th data-hide="phone,tablet" width="30%"><i class="fa fa-fw fa-font txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Nama
													</th>
													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Kode
													</th>
													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-balance-scale txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Berat (Gram)
													</th>
													<th class="text-center" data-hide="phone,tablet" width="15%"> 
														Aksi
													</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>

									</div>
									<div class="tab-pane fade" id="hr3">
										
										<table id="dt_inactive" class="table table-striped table-bordered table-hover" width="100%">
											<thead>			                
												<tr>
													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-star txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Merk
													</th>
													<th data-hide="phone,tablet" width="30%"><i class="fa fa-fw fa-font txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Nama
													</th>
													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Kode
													</th>
													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-balance-scale txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Berat (Gram)
													</th>
													<th class="text-center" data-hide="phone,tablet" width="15%"> 
														Aksi
													</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
																					
									</div>
								</div>
								
								<!-- end widget body text-->
								
								<!-- widget footer -->
								<div class="widget-footer text-right">
									
									
								</div>
								<!-- end widget footer -->
								
							</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
							
					</div>
				</div>
			</div>

			<!-- end row -->

			<!-- row -->

			<div class="row">

			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')
	
<!-- PAGE RELATED PLUGIN(S) -->
	<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>

	<script type="text/javascript">
		var aktif, semua, inaktif;
		$(document).ready(function(){
			$('#tabs').tabs();
			let selected = [];

			/* BASIC ;*/
			var responsiveHelper_dt_basic = undefined;
			var responsiveHelper_datatable_fixed_column = undefined;
			var responsiveHelper_datatable_col_reorder = undefined;
			var responsiveHelper_datatable_tabletools = undefined;

			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

			setTimeout(function () {
				aktif = $('#dt_active').dataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ route('barang.getdataactive') }}",
					"columns":[
						{"data": "i_merk"},
						{"data": "i_nama"},
						{"data": "i_code"},
						{"data": "i_berat"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-11'f><'col-sm-1 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth" : true,
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_active'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					},
					
				});
			}, 500);

			setTimeout(function () {
				semua = $('#dt_all').dataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ route('barang.getdataall') }}",
					"columns":[
						{"data": "i_merk"},
						{"data": "i_nama"},
						{"data": "i_code"},
						{"data": "i_berat"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-11'f><'col-sm-1 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth" : true,
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_all'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					},
				});
			}, 1000);

			setTimeout(function () {
				inaktif = $('#dt_inactive').dataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ route('barang.getdatanonactive') }}",
					"columns":[
						{"data": "i_merk"},
						{"data": "i_nama"},
						{"data": "i_code"},
						{"data": "i_berat"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-11'f><'col-sm-1 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth" : true,
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_inactive'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					},
				});
			}, 1500);

			// edit 1 click

			
		})

		function edit(val){
			return alert(val);
			// evt.preventDefault(); context = $(this);

			// window.location = baseUrl+'/master/barang/edit?id='+context.data('id');
		}
	</script>

@endsection