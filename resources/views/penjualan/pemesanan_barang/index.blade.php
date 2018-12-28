@extends('main')

@section('title', 'Pemesanan Barang')
    
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
			<li>Home</li><li>Penjualan</li><li>Pemesanan Barang</li>
		</ol>

	</div>
	<!-- END RIBBON -->
@endsection

@section('main_content')
    
    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">

            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-handshake-o"></i>
                    Penjualan <span><i class="fa fa-angle-double-right"></i> Pemesanan Barang </span>
                </h1>
            </div>

            @if(Plasma::checkAkses(18, 'insert') == true)
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-align-right">
				<div class="page-title">
					<a href="{{ url('/penjualan/pemesanan-barang/tambah-pemesanan') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah Pemesanan</a>
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
									<a data-toggle="tab" href="#hr1"> <i style="color: #C79121;" class="fa fa-lg fa-rotate-right fa-spin"></i> <span class="hidden-mobile hidden-tablet"> Proses </span> </a>
								</li>

								<li>
									<a data-toggle="tab" href="#hr2"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> Selesai </span></a>
								</li>

								<li>
									<a data-toggle="tab" href="#hr3"> <i style="color: #A90329;" class="fa fa-lg fa-minus-square"></i> <span class="hidden-mobile hidden-tablet"> Batal </span></a>
								</li>

							</ul>
						</header>

						<div>
							<div class="widget-body no-padding">
								<div class="tab-content padding-10">
									<div class="tab-pane fade in active" id="hr1">
										<table id="dt_proses" class="table table-striped table-bordered table-hover" width="100%">

											<thead>		
												<tr>
													<th width="35%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Member</th>
													<th width="30%"><i class="fa fa-fw fa-phone txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th width="20%"data-hide="phone" data-class="expand"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Total Tagihan</th>
													<th width="15%" class="text-center" ><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody>
											</tbody>

										</table>
									</div>

									<div class="tab-pane fade" id="hr2">
										<table id="dt_selesai" class="table table-striped table-bordered table-hover" width="100%">

											<thead>		
												<tr>
													<th width="35%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Member</th>
													<th width="30%"><i class="fa fa-fw fa-phone txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th width="20%" data-hide="phone" data-class="expand"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Total Tagihan</th>
													<th width="15%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody>
											</tbody>

										</table>
									</div>

									<div class="tab-pane fade" id="hr3">
										<table id="dt_batal" class="table table-striped table-bordered table-hover" width="100%">

											<thead>		
												<tr>
													<th width="35%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Member</th>
													<th width="30%"><i class="fa fa-fw fa-phone txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th width="20%" data-hide="phone" data-class="expand"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Total Tagihan</th>
													<th width="15%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
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
            
            <!-- Modal untuk Detil Pemesanan -->
			<div class="modal fade" id="detilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>

							<h4 class="modal-title" id="myModalLabel">Detail Pemesanan Barang</h4>

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
															<td><strong>No. Nota</strong></td>
															<td><strong>:</strong></td>
															<td id="dt_nota"></td>
														</tr>

														<tr class="danger">
															<td><strong>Nama Member</strong></td>
															<td><strong>:</strong></td>
															<td id="dt_name"></td>
														</tr>

														<tr class="warning">
															<td><strong>Cabang</strong></td>
															<td><strong>:</strong></td>
															<td id="dt_cabang"></td>
														</tr>

														<tr class="info">
															<td><strong>Total Tagihan</strong></td>
															<td><strong>:</strong></td>
															<td id="dt_tagihan"></td>
														</tr>

														<tr class="danger">
															<td><strong>Total Pembayaran</strong></td>
															<td><strong>:</strong></td>
															<td id="dt_pembayaran"></td>
														</tr>

														<tr class="warning">
															<td><strong>Status</strong></td>
															<td><strong>:</strong></td>
															<td id="dt_status"></td>
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

<script type="text/javascript">
		var done, proses, cancel;

		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Menyiapkan...');
		
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

			proses = $('#dt_proses').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ url('/penjualan/pemesanan-barang/getdataproses') }}",
				"columns":[
					{"data": "m_name"},
					{"data": "i_nota"},
					{"data": "tagihan"},
					{"data": "aksi"}
				],
				"autoWidth" : true,
				"language" : dataTableLanguage,
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_proses'), breakpointDefinition);
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

			done = $('#dt_selesai').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ url('/penjualan/pemesanan-barang/getdatadone') }}",
				"columns":[
					{"data": "m_name"},
					{"data": "i_nota"},
					{"data": "tagihan"},
					{"data": "aksi"}
				],
				"autoWidth" : true,
				"language" : dataTableLanguage,
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_done'), breakpointDefinition);
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

			cancel = $('#dt_batal').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ url('/penjualan/pemesanan-barang/getdatacancel') }}",
				"columns":[
					{"data": "m_name"},
					{"data": "i_nota"},
					{"data": "tagihan"},
					{"data": "aksi"}
				],
				"autoWidth" : true,
				"language" : dataTableLanguage,
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_cancel'), breakpointDefinition);
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

		function refresh_tab(){
		    proses.api().ajax.reload();
		    done.api().ajax.reload();
		    batal.api().ajax.reload();
		}

		function tambah_pemesanan(){
			if($('#findMember').val() == ''){
				$.smallBox({
					title : "Gagal",
					content : "Maaf, tidak dapat menambahkan pemesanan jika member belum terdaftar!",
					color : "#A90329",
					timeout: 5000,
					icon : "fa fa-times bounce animated"
				});
			}else{
				$('#overlay').fadeIn(200);
				$('#load-status-text').text('Penyimpanan Data Group Sedang di Proses ...');

				axios.post(baseUrl+'/penjualan/pemesanan-barang/ft-pemesanan', $('#ftForm').serialize());
			}
		}

		function hapus(val){

			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan manghapus data pemesanan ini ?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menghapus...');

					axios.get(baseUrl+'/penjualan/pemesanan-barang/hapus/'+val).then((response) => {

						if (response.data.status == 'hpBerhasil') {

							$('#dt_proses').DataTable().destroy();
							$('#dt_proses').DataTable({
								"processing": true,
								"serverSide": true,
								"ajax": "{{ url('/penjualan/pemesanan-barang/getdataproses') }}",
								"columns":[
									{"data": "m_name"},
									{"data": "i_nota"},
									{"data": "tagihan"},
									{"data": "aksi"}
								],
								"autoWidth" : true,
								"language" : dataTableLanguage,
								"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
								"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
								"preDrawCallback" : function() {
									// Initialize the responsive datatables helper once.
									if (!responsiveHelper_dt_basic) {
										responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_proses'), breakpointDefinition);
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
							$.smallBox({
								title : "Berhasil",
								content : 'Data pemesanan <i>"'+response.data.name+'"</i> berhasil dihapus...!',
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

		function detail(id){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil data...');

			var status;

			axios.get(baseUrl+'/penjualan/pemesanan-barang/detail/'+id).then(response => {

                $('#title_detail').html('<strong>Detail Pemesanan Barang</strong>');
                $('#dt_nota').text(response.data.data.i_nota);
                $('#dt_name').text(response.data.data.m_name);
                $('#dt_cabang').text(response.data.data.c_name);
                $('#dt_tagihan').text(response.data.data.i_total_tagihan);
                $('#dt_pembayaran').text(response.data.data.i_total_pembayaran);
                $('#dt_status').text(response.data.data.i_status);					
                $('#overlay').fadeOut(200);
                $('#detilModal').modal('show');

			});
		}

	</script>
    
@endsection