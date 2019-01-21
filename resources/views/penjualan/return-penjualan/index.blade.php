@extends('main')

@section('title', 'Return Penjualan')

@section('extra_style')

@endsection

<?php 
use App\Http\Controllers\PlasmafoneController as Access;
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
			<li>Home</li><li>Penjualan</li><li>Return Penjualan</li>
		</ol>

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

					Penjualan <span><i class="fa fa-angle-double-right"></i> Return Penjualan </span>

				</h1>

			</div>

			@if(Access::checkAkses(48, 'insert') == true)
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/master/outlet/add') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>

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

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

						<div>
							
							<div class="widget-body no-padding">

								<table id="dt_active" class="table table-striped table-bordered table-hover" width="100%">

                                    <thead>		

                                        <tr>

                                            <th><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Outlet</th>

                                            <th width="15%"><i class="fa fa-fw fa-phone txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No.Telephone</th>

                                            <th data-hide="phone" data-class="expand"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Alamat</th>

                                            <th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>

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

			<!-- end row -->

			<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Detail Outlet</h4>

					</div>

					<div class="modal-body">
		
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
														<td><strong>Kode Outlet</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_code"></td>
													</tr>

													<tr class="danger">
														<td><strong>Nama Outlet</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_name"></td>
													</tr>

													<tr class="warning">
														<td><strong>Telephone</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_phone"></td>
													</tr>

													<tr class="info">
														<td><strong>Alamat</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_address"></td>
													</tr>

													<tr class="success">
														<td><strong>Keterangan</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_note"></td>
													</tr>

													<tr class="danger">
														<td><strong>Status</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_isactive"></td>
													</tr>

													<tr class="warning">
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
		var aktif;

		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Menyiapkan...');

		
		var baseUrl = '{{ url('/') }}';

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
					"orderable": false,
					"ajax": "{{ route('outlet.getdataactive') }}",
					"columns":[
						{"data": "c_name"},
						{"data": "c_tlp"},
						{"data": "c_address"},
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

			}, 500);

		/* END BASIC */

		function refresh_tab(){
		    aktif.api().ajax.reload();
		}

		

		function edit(val){

			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Memproses...');

			window.location = baseUrl+'/master/outlet/edit/'+val;

		}

		function detail(id){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil data...');

			var status;

			axios.get(baseUrl+'/master/outlet/detail/'+id).then(response => {

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

					$('#title_detail').html('<strong>Detail Outlet "'+response.data.data.c_name+'"</strong>');
					$('#dt_code').text(response.data.data.c_id);
					$('#dt_name').text(response.data.data.c_name);
					$('#dt_phone').text(response.data.data.c_tlp);
					$('#dt_address').text(response.data.data.c_address);
					$('#dt_note').text(response.data.data.c_note);

					if(response.data.data.c_isactive == "Y"){

						status = "AKTIF";

					}else{

						status = "NON AKTIF";

					}

					$('#dt_isactive').text(status);
					$('#dt_created').text(response.data.data.created_at);
					$('#overlay').fadeOut(200);
					$('#myModal').modal('show');

				}

			})
		}

		function statusactive(id, name){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan mengaktifkan data outlet <i>"'+name+'"</i>?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/outlet/active/'+id).then((response) => {

						if (response.data.status == 'Access denied') {

							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});

						} else if(response.data.status == 'berhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data outlet berhasil diaktifkan...!',
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
				content : 'Apakah Anda yakin akan menonaktifkan data outlet <i>"'+name+'"</i>?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/outlet/nonactive/'+id).then((response) => {

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
								content : 'Data outlet berhasil dinonaktifkan...!',
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

	</script>

@endsection