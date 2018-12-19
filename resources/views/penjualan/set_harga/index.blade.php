@extends('main')

@section('title', 'Master Outlet')

@section('extra_style')

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
			<li>Home</li><li>Penjualan</li><li>Setting Harga</li>
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

					Penjualan <span><i class="fa fa-angle-double-right"></i> Setting Harga </span>

				</h1>

			</div>

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

							</ul>

						</header>

						<div>
							<div class="widget-body no-padding">
								<div class="tab-content padding-10">
                                    
									<div class="tab-pane fade in active" id="hr1">
										<table id="dt_active" class="table table-striped table-bordered table-hover" width="100%">

											<thead>		
												<tr>
													<th><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Member</th>
													<th width="15%"><i class="fa fa-fw fa-phone txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No.Telephone</th>
													<th data-hide="phone" data-class="expand"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Alamat</th>
													<th class="text-center" width="20%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
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

			<!-- Modal -->
            <div class="modal fade" id="modalPass" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Form Setting Harga</h4>
                        </div>
                        <div class="modal-body no-padding">

                            <form id="pass-form" class="smart-form">
                                <input type="hidden" name="id" id="id">

                                <fieldset>
                                    <section>
                                        <div class="row">
                                            <label class="label col col-4">Password Lama</label>
                                            <div class="col col-8 has-feedback">
                                                <label class="input">
                                                    <input type="password" name="passLama" id="passLama">
                                                    <i class="glyphicon glyphicon-eye-open form-control-feedback"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                    <section>
                                        <div class="row">
                                            <label class="label col col-4">Password Baru</label>
                                            <div class="col col-8 has-feedback">
                                                <label class="input">
                                                    <input type="password" name="passBaru" id="passBaru">
                                                    <i class="glyphicon glyphicon-eye-open form-control-feedback"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                    <section>
                                        <div class="row">
                                            <label class="label col col-4">Konfirmasi Password Baru</label>
                                            <div class="col col-8 has-feedback">
                                                <label class="input">
                                                    <input type="password" name="passconf" id="passconf">
                                                    <i class="glyphicon glyphicon-eye-open form-control-feedback"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                </fieldset>
                                
                                <footer>
                                    <button type="button" class="btn btn-primary" onclick="simpan_pass()"><i class="fa fa-floppy-o"></i>
                                        Simpan
                                    </button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        Kembali
                                    </button>

                                </footer>
                            </form>						
                                    

                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

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
					"ajax": "{{ route('member.getdataharga') }}",
					"columns":[
						{"data": "m_name"},
						{"data": "m_telp"},
						{"data": "m_address"},
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
		    semua.api().ajax.reload();
		    inaktif.api().ajax.reload();
		}

		function hapus(val){

			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan manghapus data member ini ?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menghapus...');

					axios.get(baseUrl+'/master/member/delete/'+val).then((response) => {

						if(response.data.status == 'hapusberhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data outlet <i>"'+response.data.name+'"</i> berhasil dihapus...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else if(response.data.status == 'tidak ada'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. Data yang ingin Anda hapus sudah tidak ada...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}else if(response.data.status == 'd_mem ada'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. Data yang ingin Anda hapus masih dipakai oleh member...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}else{
							$('#overlay').fadeOut(200);
							console.log(response);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Gagal menghapus data...! Coba lagi dengan mulai ulang halaman",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}

					}).catch((err) => {
						out();
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Gagal menghapus data...! Coba lagi dengan mulai ulang halaman",
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

			window.location = baseUrl+'/master/member/simpan-edit/'+val;

		}

		function detail(id){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil data...');

			var status;

			axios.get(baseUrl+'/master/member/detail/'+id).then(response => {

				if (response.data.status == 'ditolak') {

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
						color : "#A90329",
						timeout: 5000,
						icon : "fa fa-times bounce animated"
					});

				} else {

					$('#title_detail').html('<strong>Detail Member "'+response.data.data.m_name+'"</strong>');
					$('#dt_nik').text(response.data.data.m_nik);
					$('#dt_name').text(response.data.data.m_name);
					$('#dt_phone').text(response.data.data.m_telp);
					$('#dt_address').text(response.data.data.m_address);

					if(response.data.data.m_status == "AKTIF"){

						status = "AKTIF";

					}else{

						status = "NON AKTIF";

					}

					$('#dt_isactive').text(status);
					$('#dt_created').text(response.data.data.m_insert);
					$('#overlay').fadeOut(200);
					$('#myModal').modal('show');

				}

			});
		}

		function statusactive(id){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan mengaktifkan data member ini ? ',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/member/active/'+id).then((response) => {

						if (response.data.status == 'ditolak') {

							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});

						}else if(response.data.status == 'aktifberhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data member <i>"'+response.data.name+'"</i> berhasil diaktifkan...!',
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

		function statusnonactive(id){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan menonaktifkan data member ini ? ',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/member/nonactive/'+id).then((response) => {

						if (response.data.status == 'ditolak') {

							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});

						}else if(response.data.status == 'nonaktifberhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data member <i>"'+response.data.name+'"</i> berhasil dinonaktifkan...!',
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