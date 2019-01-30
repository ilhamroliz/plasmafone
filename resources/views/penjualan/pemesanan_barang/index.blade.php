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
									<a data-toggle="tab" href="#hr2"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> History </span></a>
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
													<th width="55%"><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Barang</th>
													<th width="25%"><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Jumlah Barang</th>
													<th width="20%" class="text-center" ><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody>
											</tbody>

										</table>
									</div>

									<div class="tab-pane fade" id="hr2">
										<div class="row form-group">
											<div class="col-lg-12 col-md-12 col-sm-12">
												<div class="col-md-4">
		
													<div>
														<div class="input-group input-daterange" id="date-range">
															<input type="text" class="form-control" id="tgl_awal" name="tgl_awal"  placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
															<span class="input-group-addon bg-custom text-white b-0">to</span>
															<input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir"  placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">
														</div>
													</div>
		
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<input type="text" id="search" class="form-control" name="search" placeholder="Masukkan No.Nota" style="width: 100%; float: left">
													</div>
												</div>
												<div class="col-md-5">
													<div class="form-group">
														<input type="hidden" name="idMember" id="idMember">
														<input type="text" id="namaMember" class="form-control" name="namaMember" placeholder="Masukkan Nama User" style="width: 80%; float: left">
		
														<button type="button" class="btn btn-primary btn-sm icon-btn ml-2" onclick="cariHistory()" style="width: 10%; margin-left: 5%">
															<i class="fa fa-search"></i>
														</button>
													</div>
												</div>
											</div>
										</div>

										<table id="dt_history" class="table table-striped table-bordered table-hover" width="100%">

											<thead>		
												<tr>
													<th width="15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th width="20%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Cabang</th>
													<th width="25%"><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Member</th>
													<th width="25%"><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Sales</th>
													<th width="15%" class="text-center" ><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
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

												{{-- <div class="row no-padding"> --}}
													<div class="col-md-12 padding-top-10 ">
														<div class="form-group">
															<label class="col-md-3" style="float:left"><strong>No. Nota</strong></label>
															<label class="col-md-1">:</label>
															<label class="col-md-8" id="dmNoNota"></label>
														</div>

														<div class="form-group">
															<label class="col-md-3" style="float:left"><strong>Nama Member</strong></label>
															<label class="col-md-1">:</label>
															<div class="col-md-8">
																<label id="dmNamaMember"></label>
															</div>
														</div>

														<div class="form-group">
															<label class="col-md-3" style="float:left"><strong>ID. Member</strong></label>
															<label class="col-md-1">:</label>
															<label class="col-md-8" id="dmIdMember"></label>
														</div>

														<div class="form-group">
															<label class="col-md-3" style="float:left"><strong>Telp Member</strong></label>
															<label class="col-md-1">:</label>
															<label class="col-md-8" id="dmTelpMember"></label>
														</div>

														<div class="form-group">
															<label class="col-md-3" style="float:left"><strong>Cabang</strong></label>
															<label class="col-md-1">:</label>
															<label class="col-md-8" id="dmCabang"></label>
														</div>

														<div class="form-group">
															<label class="col-md-3" style="float:left"><strong>Nama Sales</strong></label>
															<label class="col-md-1">:</label>
															<label class="col-md-8" id="dmNamaSales"></label>
														</div>
														
													</div>

													<table id="dt_detail" class="table table-striped table-bordered table-hover">
														<thead>		
															<tr>
																<th width="10%">&nbsp;No.</th>
																<th width="60%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
																<th width="30%"><i class="fa fa-fw fa-cart-arrow-down txt-color-blue"></i>&nbsp;Jumlah Unit</th>
															</tr>
														</thead>

														<tbody>
														</tbody>

													</table>


												{{-- </div> --}}
																	
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
<script src="{{ asset('template_asset/js/plugin/accounting/accounting.js') }}"></script>

<script type="text/javascript">
		var proses, history;

		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Menyiapkan...');

		$('#dt_detail').DataTable();
		
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
					{"data": "i_nama"},
					{"data": "qty"},
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

			history = $('#dt_history').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ url('/penjualan/pemesanan-barang/gethistory') }}",
				"columns":[
					{"data": "i_nota"},
					{"data": "c_name"},
					{"data": "m_name"},
					{"data": "sales"},
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

			$('#overlay').fadeOut(200);

		}, 1000);

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
									{"data": "i_nota"},
									{"data": "c_name"},
									{"data": "m_name"},
									{"data": "sales"},
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

			var tagihan;
			var pembayaran;

			axios.get(baseUrl+'/penjualan/pemesanan-barang/detail/'+id).then(response => {

                $('#title_detail').html('<strong>Detail Pemesanan Barang</strong>');

                $('#dmNoNota').text(response.data.data.i_nota);
                $('#dmNamaMember').text(response.data.data.m_name);
				$('#dmIdMember').text(response.data.data.m_idmember);
				$('#dmTelpMember').text(response.data.data.m_telp);
				$('#dmCabang').text(response.data.data.c_name);
				$('#dmNamaSales').text(response.data.data.sales);				

			});

			$('#dt_detail').DataTable().destroy();
			$('#dt_detail').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ url('/penjualan/pemesanan-barang/detail-dt') }}/"+id,
				"columns":[
					{"data": "DT_RowIndex"},
					{"data": "i_nama"},
					{"data": "qty"}
				],
				"searching" : false,
				"paging" : false,
				"info" : false,
				"autoWidth" : true,
				"language" : dataTableLanguage,
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_dt_basic) {
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_detail'), breakpointDefinition);
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
            $('#detilModal').modal('show');
		}

	</script>
    
@endsection