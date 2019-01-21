@extends('main')

@section('title', 'Master Barang')

<?php 
	use App\Http\Controllers\PlasmafoneController as Access;

	function rupiah($angka){
		$hasil_rupiah = "Rp" . number_format($angka,2,',','.');
		return $hasil_rupiah;
	}
?>

@section('extra_style')
	<style type="text/css">
		.dataTables_length {
			float: right;
		}
		.dt-toolbar-footer > :last-child, .dt-toolbar > :last-child {
    		padding-right: 0 !important;
		}
		.col-sm-1.col-xs-12.hidden-xs {
		    padding: 0px;
		}
	</style>
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

			<li>Home</li><li>Data Master</li><li>Master Barang</li>

		</ol>
		<!-- end breadcrumb -->

	</div>
	<!-- END RIBBON -->
@endsection


@section('main_content')

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

				<h1 class="page-title txt-color-blueDark">

					<i class="fa-fw fa fa-asterisk"></i>

					Data Master <span><i class="fa fa-angle-double-right"></i> Master Barang </span>

				</h1>

			</div>

			@if(Access::checkAkses(45, 'insert') == true)
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<button class="btn btn-primary" id="btn_collapse" style="display: none"><i class="fa fa-search"></i>&nbsp;Tutup Pencarian</button>

					<button class="btn btn-primary" id="btn_cari"><i class="fa fa-search"></i>&nbsp;Cari</button>

					<a href="{{ url('/master/barang/add') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>

				</div>

			</div>
			@endif

		</div>

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<?php $mt = '20px'; ?>

			@if(Session::has('flash_message_success'))
				<?php $mt = '0px'; ?>
				<div class="col-md-12">
					<div class="alert alert-success alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
						{{ Session::get('flash_message_success') }} 
					</div>
				</div>
			@elseif(Session::has('flash_message_error'))
				<?php $mt = '0px'; ?>
				<div class="col-md-12">
					<div class="alert alert-danger alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
						{{ Session::get('flash_message_error') }}
					</div>
				</div>
			@endif

			<!-- row -->
			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="search_item" style="display: none">
					
					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

						<header>
							
							<h2><strong>Pencarian Barang</strong></h2>
							
						</header>

						<!-- widget div-->
						<div>
							
							<!-- widget content -->
							<div class="widget-body">

								<!-- widget body text-->
								
								<form id="form_search" class="form-horizontal" method="post">
									{{ csrf_field() }}

									<fieldset>

										<div class="row ">

											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">

													<label class="col-xs-3 col-lg-3 control-label text-left">Kelompok</label>

													<div class="col-xs-9 col-lg-9 inputGroupContainer">

														<div class="input-group" style="width: 100%">

															<input type="text" class="form-control" id="txtkelompok" name="txtkelompok" style="text-transform: uppercase" placeholder="Masukkan Kelompok">

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-3 col-lg-3 control-label text-left">Group</label>

													<div class="col-xs-9 col-lg-9 inputGroupContainer">

														<div class="input-group" style="width: 100%">

															<input type="text" class="form-control" id="txtgroup" name="txtgroup" style="text-transform: uppercase" placeholder="Masukkan Group">

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-3 col-lg-3 control-label text-left">Sub Group</label>

													<div class="col-xs-9 col-lg-9 inputGroupContainer">

														<div class="input-group" style="width: 100%">

															<input type="text" class="form-control" id="txtsubgroup" name="txtsubgroup" style="text-transform: uppercase" placeholder="Masukkan Sub Group">

														</div>

													</div>

												</div>

											</article>

											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">

													<label class="col-xs-3 col-lg-3 control-label text-left">Merk</label>

													<div class="col-xs-9 col-lg-9 inputGroupContainer">

														<div class="input-group" style="width: 100%">

															<input type="text" class="form-control" id="txtmerk" name="txtmerk" style="text-transform: uppercase" placeholder="Masukkan Merk">

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-3 col-lg-3 control-label text-left">Nama</label>

													<div class="col-xs-9 col-lg-9 inputGroupContainer">

														<div class="input-group" style="width: 100%">

															<input type="text" class="form-control" id="txtnama" name="txtnama" style="text-transform: uppercase" placeholder="Masukkan Nama Barang">

														</div>

													</div>

												</div>

												<div class="form-group">

													<div class="col-xs-9 col-lg-9 inputGroupContainer pull-right">

														<button class="btn btn-primary" id="btn_searchingitem" style="width: 100%"><i class="fa fa-search"></i>&nbsp;Cari</button>

													</div>

												</div>

											</article>

										</div>

									</fieldset>

								</form>
								
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

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="table_content">
					
					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

						<header>
							
							<ul id="widget-tab-1" class="nav nav-tabs pull-left">

								<li class="active" id="tab_aktif">

									<a data-toggle="tab" href="#hr1"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> Aktif </span> </a>

								</li>

								<li id="tab_semua">

									<a data-toggle="tab" href="#hr2"> <i style="color: #C79121;" class="fa fa-lg fa-align-justify"></i> <span class="hidden-mobile hidden-tablet"> Semua </span></a>

								</li>

								<li id="tab_nonaktif">

									<a data-toggle="tab" href="#hr3"> <i style="color: #A90329;" class="fa fa-lg fa-minus-square"></i> <span class="hidden-mobile hidden-tablet"> Non Aktif </span></a>

								</li>

								<li id="tab_pencarian" style="display: none">

									<a data-toggle="tab" href="#hr4"> <i style="color: #3276b1;" class="fa fa-lg fa-search"></i> <span class="hidden-mobile hidden-tablet"> Pencarian </span></a>

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

													<th width="30%"><i class="fa fa-fw fa-font txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Nama
													</th>

													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Kode
													</th>

													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Harga
													</th>

													<th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue hidden-md hidden-sm hidden-xs"></i>
														&nbsp;Aksi
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

													<th width="30%"><i class="fa fa-fw fa-font txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Nama
													</th>

													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Kode
													</th>

													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Harga
													</th>

													<th><i class="fa fa-fw fa-check-square-o txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Status</th>

													<th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue hidden-md hidden-sm hidden-xs"></i>
														&nbsp;Aksi
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

													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
														&nbsp;Harga
													</th>

													<th class="text-center" data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue hidden-md hidden-sm hidden-xs"></i>
														&nbsp;Aksi
													</th>

												</tr>

											</thead>

											<tbody>
												
											</tbody>

										</table>
																					
									</div>

									<div class="tab-pane fade" id="hr4">
										
										<table id="dt_pencarian" class="table table-striped table-bordered table-hover" width="100%">

											<thead>

											<tr>

												<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-star txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
													&nbsp;Merk
												</th>

												<th width="30%"><i class="fa fa-fw fa-font txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
													&nbsp;Nama
												</th>

												<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
													&nbsp;Kode
												</th>

												<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
													&nbsp;Harga
												</th>

												<th><i class="fa fa-fw fa-check-square-o txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Status</th>

												<th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue hidden-md hidden-sm hidden-xs"></i>
													&nbsp;Aksi
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

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Detail Barang</h4>

					</div>

					<div class="modal-body">

						<div style="margin-bottom: 15px;" class="preview thumbnail">

							<img id="dt_image" src="">

						</div>
		
						<div class="row">

							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget jarviswidget-color-greenLight" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

								<header>

									<span class="widget-icon"> <i class="fa fa-table"></i> </span>

									<h2 id="title_detail"></h2>

								</header>

								<!-- widget div-->
								<div>

									<!-- widget content -->
									<div class="widget-body no-padding">
										
										<div class="table-responsive">
											
											<table class="table">

												<tbody>

													<tr class="success">
														<td><strong>Kelompok</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_kelompok"></td>
													</tr>

													<tr class="danger">
														<td><strong>Group</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_group"></td>
													</tr>

													<tr class="warning">
														<td><strong>Sub Group</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_subgroup"></td>
													</tr>

													<tr class="info">
														<td><strong>Merk</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_merk"></td>
													</tr>

													<tr class="success">
														<td><strong>Nama</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_nama"></td>
													</tr>

													<tr class="danger">
														<td><strong>Spesifik Kode</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_specificcode"></td>
													</tr>

													<tr class="warning">
														<td><strong>Kode</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_code"></td>
													</tr>

													<tr class="info">
														<td><strong>Status</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_isactive"></td>
													</tr>

													<tr class="success">
														<td><strong>Min Stock</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_minstock"></td>
													</tr>

													<tr class="danger">
														<td><strong>Berat (Gram)</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_berat"></td>
													</tr>

													<tr class="warning">
														<td><strong>Harga</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_price"></td>
													</tr>

													<tr class="info">
														<td><strong>Dibuat</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_created"></td>
													</tr>

												</tbody>

											</table>
											
										</div>

									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
							<!-- end widget -->
						</div>
		
					</div>

				</div><!-- /.modal-content -->

			</div><!-- /.modal-dialog -->

		</div>
		<!-- /.modal -->

		<!-- Modal setting harga outlet -->
		<div class="modal fade" id="modalsetharga" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Pengaturan Harga Barang Peroutlet</h4>

					</div>

					<form method="post" action="">

					<div class="modal-body">
		
						<div class="row">

							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget jarviswidget-color-greenLight" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

								<header>

									<span class="widget-icon"> <i class="fa fa-table"></i> </span>

									<h2 id="name_barang"></h2>

								</header>

								<!-- widget div-->
								<div>

									<!-- widget content -->
									<div class="widget-body no-padding">
										
										<div class="table-responsive">
											
											<table class="table" id="tbl_setharga">

												<thead>

													<tr>

														<th> 
															&nbsp;Outlet
														</th>

														<th> 
															&nbsp;Harga
														</th>

													</tr>

												</thead>

												<tbody>

													<input type="hidden" name="item_id" class="item_id">
												
													
													
												</tbody>

											</table>
											
										</div>

									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
							<!-- end widget -->
						</div>
		
					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>&nbsp;Simpan</button>
					</div>

					</form>

				</div><!-- /.modal-content -->

			</div><!-- /.modal-dialog -->

		</div>
		<!-- /.modal setting harga -->

	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')

	<script type="text/javascript">
		var aktif, semua, inaktif;
		var baseUrl = '{{ url('/') }}';

		$(document).ready(function(){
			$(".harga-outlet").maskMoney({thousands:'.', precision: 0});

			// $('#tabs').tabs();

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
						{"data": "harga"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
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
					}
				});

			}, 10);

			setTimeout(function () {

				semua = $('#dt_all').dataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ route('barang.getdataall') }}",
					"columns":[
						{"data": "i_merk"},
						{"data": "i_nama"},
						{"data": "i_code"},
						{"data": "harga"},
						{"data": "active"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
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
					}
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
						{"data": "harga"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
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
					}
				});
			}, 1500);

			$('.harga-outlet').on('change paste keyup', function(e){
				$('.save').attr('data-harga', $(this).val());
			})

			$(".save").click(function(){
				$('#overlay').fadeIn(200);
				var op_item = $(this).data('item'), op_outlet = $(this).data('outlet'), op_harga = $(this).data('harga'), _token = "{{ csrf_token() }}", outletname = $(this).data('namaoutlet'), itemname = $(this).data('namaitem');
				var url = "{{ route('barang.setharga') }}";

				$.post( url, { _token: _token, item: op_item, outlet: op_outlet, harga: op_harga, namaoutlet: outletname, namaitem: itemname }, function(response){
					
					if (response.status == 'Access denied') {

						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
							color : "#A90329",
							timeout: 5000,
							icon : "fa fa-times bounce animated"
						});

					}else if (response.status == 'Failed') {

						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Gagal",
							content : 'Gagal mengatur harga peroutlet! "Terjadi kesalahan server" Mohon coba lagi...',
							color : "#A90329",
							timeout: 5000,
							icon : "fa fa-times bounce animated"
						});

					}else{
						
						$("#overlay").fadeOut(200);
						$.smallBox({
							title : "Berhasil",
							content : response.message,
							color : "#739E73",
							timeout: 5000,
							icon : "fa fa-check bounce animated"
						});

					}
				}, "json")
			})

			$('#btn_cari').click(function(){
				$('#search_item').show("slow");
				$('#btn_cari').hide();
				$('#btn_collapse').show();
			})

			$('#btn_collapse').click(function(){
				$("#txtkelompok").val('');
				$("#txtgroup").val('');
				$("#txtsubgroup").val('');
				$("#txtmerk").val('');
				$("#txtnama").val('');

				$('#search_item').hide(1000);
				$('#btn_cari').show();
				$('#btn_collapse').hide();

				$('#tab_aktif').addClass("active");
				$('#tab_semua').removeClass("active");
				$('#tab_nonaktif').removeClass("active");
				$('#tab_pencarian').removeClass("active");

				$('#hr1').addClass("in active");
				$('#hr2').removeClass("in active");
				$('#hr3').removeClass("in active");
				$('#hr4').removeClass("in active");

				$('#tab_pencarian').hide(1000);
			})

			$("#txtkelompok").autocomplete({
			source: baseUrl+'/master/barang/carikelompok',
				minLength: 1,
				select: function(event, data) {
					$('#txtkelompok').val(data.item.label);
				}
			});

			$("#txtgroup").autocomplete({
			source: baseUrl+'/master/barang/carigroup',
				minLength: 1,
				select: function(event, data) {
					$('#txtgroup').val(data.item.label);
				}
			});

			$("#txtsubgroup").autocomplete({
			source: baseUrl+'/master/barang/carisubgroup',
				minLength: 1,
				select: function(event, data) {
					$('#txtsubgroup').val(data.item.label);
				}
			});

			$("#txtmerk").autocomplete({
			source: baseUrl+'/master/barang/carimerk',
				minLength: 1,
				select: function(event, data) {
					$('#txtmerk').val(data.item.label);
				}
			});

			$("#txtnama").autocomplete({
			source: baseUrl+'/master/barang/carinama',
				minLength: 1,
				select: function(event, data) {
					$('#txtnama').val(data.item.label);
				}
			});

			function overlay()
			{
				$('#overlay').fadeIn(200);
				$('#load-status-text').text('Sedang Mencari...');
			}

			function out()
			{
				$('#overlay').fadeOut(200);
			}

			$("#btn_searchingitem").click(function(e){

				e.preventDefault();

				overlay();

				if ( $.fn.DataTable.isDataTable('#dt_pencarian') ) {
					$('#dt_pencarian').DataTable().destroy();
				}

				$('#dt_pencarian').dataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/master/barang/searchitem?') }}"+"kelompok="+$("#txtkelompok").val()+"&group="+$("#txtgroup").val()+"&subgroup="+$("#txtsubgroup").val()+"&merk="+$("#txtmerk").val()+"&nama="+$("#txtnama").val(),
					"columns":[
						{"data": "i_merk"},
						{"data": "i_nama"},
						{"data": "i_code"},
						{"data": "harga"},
						{"data": "active"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
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
					}
				});

				$('#tab_aktif').removeClass("active");
				$('#tab_semua').removeClass("active");
				$('#tab_nonaktif').removeClass("active");
				$('#tab_pencarian').addClass("active");

				$('#hr1').removeClass("in active");
				$('#hr2').removeClass("in active");
				$('#hr3').removeClass("in active");
				$('#hr4').addClass("in active");

				$('#tab_pencarian').show("slow");

				$('html, body').animate({ scrollTop: $('#table_content').offset().top }, 'slow');

				out();

			})

		})

		function refresh_tab(){
		    aktif.api().ajax.reload();
		    semua.api().ajax.reload();
		    inaktif.api().ajax.reload();
		}

		function statusactive(id, name){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan mengaktifkan data barang <i>"'+name+'"</i>',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/barang/active/'+id).then((response) => {

						if (response.data.status == 'Access denied') {

							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});

						}else if(response.data.status == 'berhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data barang <i>"'+name+'"</i> berhasil diaktifkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else if(response.data.status == 'tidak ada'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. Data yang ingin Anda aktifkan sudah tidak ada...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}else{
							$('#overlay').fadeOut(200);
							// console.log(response);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Gagal mengaktifkan data...! Coba lagi dengan mulai ulang halaman",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}

					}).catch((err) => {
						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Gagal mengaktifkan data...! Coba lagi dengan mulai ulang halaman",
							color : "#A90329",
							timeout: 4000,
							icon : "fa fa-times bounce animated"
						});
						
					}).then(function(){
						$('#overlay').fadeOut(200);
					})

				}
	
			});
		}

		function statusnonactive(id, name){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan menonaktifkan data barang <i>"'+name+'"</i>',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/barang/nonactive/'+id).then((response) => {

						if (response.data.status == 'Access denied') {

							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});

						}else if(response.data.status == 'berhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data barang <i>"'+name+'"</i> berhasil dinonaktifkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else if(response.data.status == 'tidak ada'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. Data yang ingin Anda nonaktifkan sudah tidak ada...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}else{
							$('#overlay').fadeOut(200);
							console.log(response);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Gagal menonaktifkan data...! Coba lagi dengan mulai ulang halaman",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}

					}).catch((err) => {
						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Gagal menonaktifkan data...! Coba lagi dengan mulai ulang halaman",
							color : "#A90329",
							timeout: 4000,
							icon : "fa fa-times bounce animated"
						});
						
					}).then(function(){
						$('#overlay').fadeOut(200);
					})

				}
	
			});
		}

		function edit(val){

			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Memproses...');

			window.location = baseUrl+'/master/barang/edit/'+val;

		}

		function setting(id, name){

			window.location.href = baseUrl+'/master/barang/getoutlet/'+id;
			
			// $('#overlay').fadeIn(200);
			// var url = "{{ route('barang.addoutletprice') }}", _token = "{{ csrf_token() }}", setharga = "";
			// if ( $.fn.DataTable.isDataTable('#tbl_setharga') ) {
			// 	$('#tbl_setharga').DataTable().destroy();
			// }

			// $('#tbl_setharga tbody').empty();

			// $.post(url, {_token: _token, itemid: id}, function(response){
			// 	console.log(response)
			// 	if (response.status == "Failed") {
			// 		$('#overlay').fadeOut(200);
			// 			$.smallBox({
			// 				title : "Gagal",
			// 				content : 'Gagal menyiapkan data! "Terjadi kesalahan server" Mohon coba lagi...',
			// 				color : "#A90329",
			// 				timeout: 5000,
			// 				icon : "fa fa-times bounce animated"
			// 			});
			// 	}

			// }, "json");

			// $.get("{{ url('/master/barang/getoutlet/') }}"+"/"+id, function(response){
			// 	console.log(response);
			// })
			
			// $('#tbl_setharga').dataTable({
			// 		"processing": true,
			// 		"serverSide": true,
			// 		"paging": false,
			// 		"scrollY": "250px",
  			// 		"scrollCollapse": true,
			// 		"ajax": "{{ url('master/barang/getoutlet/') }}"+"/"+id,
			// 		"columns":[
			// 			{"data": "c_name"},
			// 			{"data": "harga"}
			// 		],
			// 		"autoWidth" : true,
			// 		"language" : dataTableLanguage,
			// 		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
			// 		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
			// 		"preDrawCallback" : function() {
			// 			// Initialize the responsive datatables helper once.
			// 			if (!responsiveHelper_dt_basic) {
			// 				responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#tbl_setharga'), breakpointDefinition);
			// 			}
			// 		},
			// 		"rowCallback" : function(nRow) {
			// 			responsiveHelper_dt_basic.createExpandIcon(nRow);
			// 		},
			// 		"drawCallback" : function(oSettings) {
			// 			responsiveHelper_dt_basic.respond();
			// 		}
			// 	});

			// $('.item_id').val(id);
			// $('.save').attr('data-item', id);
			// $('.save').attr('data-namaitem', name);
			// $('#name_barang').html('<strong><i>"'+name+'"</i></strong>');
			// $('#modalsetharga').modal('show');
			// $('#overlay').fadeOut(200);
		}

		function detail(id){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil data...');

			var spesifik, status;

			axios.get(baseUrl+'/master/barang/detail/'+id).then(response => {
				
				if (response.data.status == 'Access denied') {

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
						color : "#A90329",
						timeout: 5000,
						icon : "fa fa-times bounce animated"
					});

				} else {

					if (response.data.data.i_img == "") {

						$('img#dt_image').attr("src", "{{asset('img/image-not-found.png')}}");

					}else{

						$('img#dt_image').attr("src", "{{asset('img/items/')}}"+"/"+response.data.data.i_img);

					}

					$('#title_detail').html('<strong>Detail Barang "'+response.data.data.i_nama+'"</strong>');
					$('#dt_kelompok').text(response.data.data.i_kelompok);
					$('#dt_group').text(response.data.data.i_group);
					$('#dt_subgroup').text(response.data.data.i_sub_group);
					$('#dt_merk').text(response.data.data.i_merk);
					$('#dt_nama').text(response.data.data.i_nama);

					if(response.data.data.i_specificcode == "Y"){

						spesifik = "YA";

					}else{

						spesifik = "TIDAK";

					}

					$('#dt_specificcode').text(spesifik);
					$('#dt_code').text(response.data.data.i_code);

					if(response.data.data.i_isactive == "Y"){

						status = "AKTIF";

					}else{

						status = "NON AKTIF";

					}

					$('#dt_isactive').text(status);
					$('#dt_minstock').text(response.data.data.i_minstock);
					$('#dt_berat').text(response.data.data.i_berat);

					var harga = response.data.data.i_price,
						iHarga = harga + '',
						i = parseFloat(iHarga.match(/\d+\.\d{2}/)),
						dec = harga.split(".");

					$('#dt_price').text(formatRupiah2(i, "Rp", dec[1]));
					$('#dt_created').text(response.data.data.dibuat);
					$('#overlay').fadeOut(200);
					$('#myModal').modal('show');

				}

			})
		}

		function formatRupiah2(angka, prefix = undefined)
		{
			var number_string = angka.toString(),
				split	= number_string.split(','),
				sisa 	= split[0].length % 3,
				rupiah 	= split[0].substr(0, sisa),
				ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
				
			if (ribuan) {
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
			
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

		function formatRupiah(angka, prefix = undefined)
		{
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
				split	= number_string.split(','),
				sisa 	= split[0].length % 3,
				rupiah 	= split[0].substr(0, sisa),
				ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
				
			if (ribuan) {
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
			
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

		function isNumberKey(evt)
		{
		    var charCode = (evt.which) ? evt.which : evt.keyCode;
		    if (charCode > 31 && (charCode < 48 || charCode > 57))
		        return false;
		    return true;
		}

		function validate(evt) {
			var theEvent = evt || window.event;

			// Handle paste
			if (theEvent.type === 'paste') {
				key = event.clipboardData.getData('text/plain');
			} else {
			// Handle key press
				var key = theEvent.keyCode || theEvent.which;
				key = String.fromCharCode(key);
			}
			var regex = /[0-9]|\./;
			if( !regex.test(key) ) {
				theEvent.returnValue = false;
				if(theEvent.preventDefault) theEvent.preventDefault();
			}
		}

		$('.harga-outlet').keyup(function(e){
			alert("ok");
			// $(this).val(formatRupiah(this.value, ''));
		})
	</script>

@endsection
