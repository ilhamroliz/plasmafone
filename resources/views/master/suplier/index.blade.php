@extends('main')

@section('title', 'Master Supplier')

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
			<li>Home</li><li>Data Master</li><li>Master Supplier</li>
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

					Data Master <span><i class="fa fa-angle-double-right"></i> Master Supplier </span>

				</h1>

			</div>

			@if(Access::checkAkses(46, 'insert') == true)

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/master/supplier/add') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>

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

						<div>
							
							<div class="widget-body no-padding">

								<div class="tab-content padding-10">

									<div class="tab-pane fade in active" id="hr1">

										<table id="dt_active" class="table table-striped table-bordered table-hover" width="100%">

											<thead>		

												<tr>

													<th data-hide="phone" data-class="expand"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Perusahaan</th>

													<th><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Suplier</th>

													<th width="15%"><i class="fa fa-fw fa-phone txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No.Telephone</th>

													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Limit</th>

													<th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>

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

													<th data-hide="phone" data-class="expand"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Perusahaan</th>

													<th><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Suplier</th>

													<th width="15%"><i class="fa fa-fw fa-phone txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No.Telephone</th>

													<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Limit</th>

													<th width="15%"><i class="fa fa-fw fa-check-square-o txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Status</th>

													<th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>

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

												<th data-hide="phone" data-class="expand"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Perusahaan</th>

												<th><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Suplier</th>

												<th width="15%"><i class="fa fa-fw fa-phone txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No.Telephone</th>

												<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Limit</th>

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

						<h4 class="modal-title" id="myModalLabel">Detail Supplier</h4>

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
														<td><strong>Perusahaan</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_perusahaan"></td>
													</tr>

													<tr class="danger">
														<td><strong>Supplier</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_supplier"></td>
													</tr>

													<tr class="warning">
														<td><strong>Telephone</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_telephone"></td>
													</tr>

													<tr class="info">
														<td><strong>Fax</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_fax"></td>
													</tr>

													<tr class="success">
														<td><strong>Limit</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_limit"></td>
													</tr>

													<tr class="danger">
														<td><strong>Alamat</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_alamat"></td>
													</tr>

													<tr class="warning">
														<td><strong>Keterangan</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_keterangan"></td>
													</tr>

													<tr class="info">
														<td><strong>Status</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_status"></td>
													</tr>

													<tr class="success">
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

	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')

	<script type="text/javascript">
		var aktif, semua, inaktif;
		$(document).ready(function(){
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
						"aasorting" : [], 
						"ajax": "{{ route('supplier.getdataactive') }}",
						"columns":[
							{"data": "s_company"},
							{"data": "s_name"},
							{"data": "s_phone"},
							{"data": "limit"},
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

				setTimeout(function () {

					semua = $('#dt_all').dataTable({
						"processing": true,
						"serverSide": true,
						"ajax": "{{ route('supplier.getdataall') }}",
						"columns":[
							{"data": "s_company"},
							{"data": "s_name"},
							{"data": "s_phone"},
							{"data": "limit"},
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
						"ajax": "{{ route('supplier.getdatanonactive') }}",
						"columns":[
							{"data": "s_company"},
							{"data": "s_name"},
							{"data": "s_phone"},
							{"data": "limit"},
							{"data": "aksi"}
						],
						"autoWidth" : true,
						"language" : dataTableLanguage,
						"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
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

					$('#overlay').fadeOut(200);

				}, 1500);
	
			/* END BASIC */
		})

		function refresh_tab(){
		    aktif.api().ajax.reload();
		    semua.api().ajax.reload();
		    inaktif.api().ajax.reload();
		}

		function edit(val){

			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Memproses...');

			window.location = baseUrl+'/master/supplier/edit/'+val;

		}

		function detail(id){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil data...');

			var status;

			axios.get(baseUrl+'/master/supplier/detail/'+id).then(response => {

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

					$('#title_detail').html('<strong>Detail Supplier "'+response.data.data.s_name+'"</strong>');
					$('#dt_perusahaan').text(response.data.data.s_company);
					$('#dt_supplier').text(response.data.data.s_name);
					$('#dt_telephone').text(response.data.data.s_phone);
					$('#dt_fax').text(response.data.data.s_fax);
					$('#dt_alamat').text(response.data.data.s_address);
					$('#dt_keterangan').text(response.data.data.s_note);

					var limit = response.data.data.s_limit,
						iLimit = limit + '',
						i = parseFloat(iLimit.match(/\d+\.\d{2}/)),
						dec = limit.split(".");

					if(response.data.data.s_isactive == "Y"){

						status = "AKTIF";

					}else{

						status = "NON AKTIF";

					}

					$('#dt_status').text(status);
					$('#dt_limit').text(formatRupiah(i, "Rp", dec[1]));
					$('#dt_created').text(response.data.data.s_insert);
					$('#overlay').fadeOut(200);
					$('#myModal').modal('show');

				}
					
			})
		}

		function statusactive(id, name){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan mengaktifkan data supplier <i>"'+name+'"</i>',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/supplier/active/'+id).then((response) => {

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
								content : 'Data supplier <i>"'+name+'"</i> berhasil diaktifkan...!',
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
				content : 'Apakah Anda yakin akan menonaktifkan data supplier <i>"'+name+'"</i>',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/supplier/nonactive/'+id).then((response) => {

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
								content : 'Data supplier <i>"'+name+'"</i> berhasil dinonaktifkan...!',
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

		function formatRupiah(angka, prefix, dec)
		{
			var number_string = angka.toString(),
			split	= number_string.split(','),
			sisa 	= split[0].length % 3,
			rupiah 	= split[0].substr(0, sisa),
			ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);

			if (ribuan) {

				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.') + "," + dec;

			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			
			return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
		}

	</script>

@endsection