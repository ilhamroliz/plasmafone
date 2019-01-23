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

					<i class="fa-fw fa fa-lg fa-handshake-o"></i>

					Penjualan <span><i class="fa fa-angle-double-right"></i> Setting Harga Group</span>

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

				<!-- LIST GROUP MEMBER -->
				<div class="col-xs-12 col-sm-4 col-md-4">
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-0" 
							data-widget-colorbutton="false"	
							data-widget-editbutton="false"
							data-widget-togglebutton="false"
							data-widget-deletebutton="false"
							data-widget-fullscreenbutton="false"
							data-widget-custombutton="false"
							data-widget-sortable="false"> 
						
						<header>
							<h2><strong>Group Member</strong></h2>											
						</header>

						<!-- widget div-->
						<div>	
							<!-- widget content -->
							<div class="widget-body">
								<div class="tab-content">

								@if(Plasma::checkAkses(15, 'insert') == true)
								<div class="form-group">
									<button style="width: 100%" class="btn btn-success text-center" onclick="tambah_group()">
										<i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah
									</button>
								</div>
								@endif

								<table id="group_member" class="table table-striped table-bordered table-hover" width="100%" style="cursor: pointer">
									<thead>
										<tr>
											<th class="text-center" >No</th>
											<th class="text-center" >Grup Member</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>

								</div>
							</div>
							<!-- end widget content -->									
						</div>
						<!-- end widget div -->								
					</div>
					<!-- end widget -->
				</div>
				<!-- End LIST GROUP MEMBER -->

				<!-- Tabel Item for @ GROUP MEMBER -->
				<div class="col-xs-12 col-sm-8 col-md-8">
					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

						<header>

						</header>

						<div>
							<div class="widget-body no-padding">
								<div class="tab-content padding-10">

									<div id="title_table" style="width: 100%; padding-bottom: 20px; padding-top: 10px">
										
									</div>

									<div id="thFormDiv" class="form-group">
										
									</div>
                                    
									<div class="tab-pane fade in active" id="hr1">
										<table id="dt_harga" class="table table-striped table-bordered table-hover" width="100%">

											<thead>		
												<tr>
													<th width="8%">No</th>
													<th width="57%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
                                                    <th width="20%"><i class="fa fa-fw fa-dollar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Harga</th>                                                 
													<th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="show-harga">
											</tbody>

										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Tabel Item for @ GROUP MEMBER -->			
			<!-- end row -->


			<!-- Modal Untuk Tambah Group -->
            <div class="modal fade" id="tgModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4><strong>Form Tambah Group</strong></h4>
                        </div>
                        <div class="modal-body no-padding">

                            <form id="ft-group" class="smart-form">
                                <input type="hidden" name="id" id="id">

                                <fieldset>

                                    <section>
                                        <div class="row">
                                            <label class="label col col-3">Nama Group</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="namaGroup" id="namaGroup" style="text-transform: uppercase" required>
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                </fieldset>
                                
                                <footer>
                                    <button type="button" class="btn btn-primary" onclick="tgSubmit()"><i class="fa fa-floppy-o"></i>
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
            </div><!-- Akhir Modal untuk Tambah Group /.modal -->

			<!-- Modal untuk Edit Group -->
            <div class="modal fade" id="egModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4><strong>Form Edit Group</strong></h4>
                        </div>
                        <div class="modal-body no-padding">

                            <form id="egForm" class="smart-form">
                                <input type="hidden" name="egId" id="egId">

                                <fieldset>
                                    <section>
                                        <div class="row">
                                            <label class="label col col-3">Nama Group</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="egNama" id="egNama" style="text-transform: uppercase" required>
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                </fieldset>
                                
                                <footer>
                                    <button type="button" class="btn btn-primary" onclick="egSubmit()"><i class="fa fa-floppy-o"></i>
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
			

			<!-- Modal untuk Edit Harga -->
            <div class="modal fade" id="ehModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4><strong>Form Edit Harga</strong></h4>
                        </div>
                        <div class="modal-body no-padding">

                            <form id="ehForm" class="smart-form">
								<input type="hidden" name="ehGroupId" id="ehGroupId">
                                <input type="hidden" name="ehItemId" id="ehItemId">
								
                                <fieldset>
                                    <section>
                                        <div class="row">
                                            <label class="label col col-3">Nama Barang</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="ehItemNama" id="ehItemNama" readonly>
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                    <section>
                                        <div class="row">
                                            <label class="label col col-3">Group Member</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="ehGroupNama" id="ehGroupNama" readonly>                                                    
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                    <section>
                                        <div class="row">
                                            <label class="label col col-3">Harga Barang</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="ehHarga" id="ehHarga">
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                </fieldset>
                                
                                <footer>
                                    <button type="button" class="btn btn-primary" onclick="ehSubmit()"><i class="fa fa-floppy-o"></i>
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

	<script type="text/javascript">

		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Mengambil Data...');

		function getData(data){
			$('#thItemId').val(data.id);
		}
		
		$('#dt_harga').DataTable();
		$('#show-harga').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');

		/* BASIC ;*/
		var responsiveHelper_dt_basic = undefined;
		var responsiveHelper_datatable_fixed_column = undefined;
		var responsiveHelper_datatable_col_reorder = undefined;
		var responsiveHelper_datatable_tabletools = undefined;
		
		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		$('#group_member').dataTable({
			"processing": true,
			"serverSide": true,
			"searching": true,
			"ajax": "{{ route('penjualan.getdatagroup') }}",
			"columns":[
				{"data": "DT_RowIndex"},
				{"data": "group_name"}
			],
			"autoWidth" : true,
			"paging"	: false,
			"info"	: false,
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-12'f>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#group_member'), breakpointDefinition);
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

		function show(id){
	
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil Data...');
			$('#dt_harga').DataTable().destroy();
			
			$('#dt_harga').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ url('/penjualan/set-harga/get-data-harga')}}/"+id,
				"columns":[
					{"data": "DT_RowIndex"},
					{"data": "i_nama"},
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
						responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_harga'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_dt_basic.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_dt_basic.respond();
				}
			});
			
			axios.get(baseUrl+'/penjualan/set-harga/get-data-gp-non/'+id).then(response => {

				$('#title_table').html('<h4 style="float: left"><strong>'+response.data.name+'</strong></h4>&nbsp;<a onclick="edit_group('+response.data.id+')"><i class="fa fa-pencil"></i></a>&nbsp;<a onclick="hapus_group('+response.data.id+')"><i class="fa fa-close"></i></a>');
				@if(Plasma::checkAkses(15, 'insert') == true){
					$('#thFormDiv').html('<form id="thForm"><input type="hidden" id="thGroupId" name="thGroupId"><input type="hidden" id="thItemId" name="thItemId"><input style="width: 50%; margin-right: 10px; float: left" class="form-control" type="text" id="thItemNama" name="thItemNama" placeholder="Nama Barang" required><input style="width: 30%; margin-right: 10px; float: left" class="form-control" type="text" id="thHarga" data-thousands="." data-decimal="," name="thHarga" placeholder="Harga Barang" required><button type="button" style="width: 17%" class="btn btn-success" onclick="thSubmit()"><i class="fa fa-plus">&nbsp;Tambah</i></button></form>')					
					$('#thGroupId').val(response.data.id);
					$( "#thItemNama" ).autocomplete({
						source: baseUrl+'/penjualan/set-harga/cariItem',
						minLength: 2,
						select: function(event, data) {
							getData(data.item);
						}
					});
					$("#thHarga").maskMoney({
						precision: 0
					});
				}
				@endif
				$('#egNama').val(response.data.name);

				$('#egNama').val(response.data.name);				
				$('#ehGroupNama').val(response.data.name);
				$('#ehGroupId').val(response.data.id);

			});
			$('#overlay').fadeOut(200);
		}

		function tambah_group(){
			$('#tgModal').modal('show');
		}

		function edit_group(id){
			$('#egId').val(id);
			$('#egModal').modal('show');
		}

		function edit_harga(id){
			$('#ehItemId').val(id);
			
			axios.get(baseUrl+'/penjualan/set-harga/editHarga?id='+id+'&g='+$('#thGroupId').val()).then((response) => {
				
				$groupId = $('#thGroupId').val();
				$('#ehGroupId').val($groupId);
				$('#ehGroupNama').val(response.data.fields.g_name);
				$('#ehItemNama').val(response.data.fields.i_nama);
				$('#ehHarga').val(response.data.price).maskMoney({precision: 0});

				$('#ehModal').modal('show');
			});
		}

		function hapus_group(val){

			$.SmartMessageBox({
				title : "PERHATIAN !",
				content : 'Apakah Anda yakin akan manghapus data group ini ?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menghapus Data...');

					axios.get(baseUrl+'/penjualan/set-harga/hapusGroup/'+val).then((response) => {

						if(response.data.status == 'hgBerhasil'){

							$('#group_member').DataTable().destroy();
							$('#group_member').DataTable({
								"processing": true,
								"serverSide": true,
								"ajax": "{{ route('penjualan.getdatagroup') }}",
								"columns":[
									{"data": "DT_RowIndex"},
									{"data": "group_name"}
								],
								"autoWidth" : true,
								"searching" : false,
								"paging"	: false,
								"info"	: false,
								"preDrawCallback" : function() {
									// Initialize the responsive datatables helper once.
									if (!responsiveHelper_dt_basic) {
										responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#group_member'), breakpointDefinition);
									}
								},
								"rowCallback" : function(nRow) {
									responsiveHelper_dt_basic.createExpandIcon(nRow);
								},
								"drawCallback" : function(oSettings) {
									responsiveHelper_dt_basic.respond();
								}
							});

							$('#dt_harga').DataTable().destroy();
							$('#dt_harga').DataTable();
							$('#show-harga').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');
							$('#title_table').html('<h4 style="float: left"></h4>');

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data group <i>"'+response.data.name+'"</i> berhasil dihapus...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else if(response.data.status == 'hgDigunakan'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Maaf, Group tidak dapat dihapus, Group ini sedang digunakan...!",
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
						$('#overlay').fadeOut(200);
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

		function hapus_harga(id){

			$.SmartMessageBox({
				title : "PERHATIAN !",
				content : 'Apakah Anda yakin akan manghapus data harga barang ini ?"</i>',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menghapus Data Harga...');

					axios.get(baseUrl+'/penjualan/set-harga/hapusHarga?group='+$('#thGroupId').val()+'&item='+id).then((response) => {

						if(response.data.status == 'hhBerhasil'){

							$('#dt_harga').DataTable().destroy();
							$('#dt_harga').DataTable({
								"processing": true,
								"serverSide": true,
								"ajax": "{{ url('/penjualan/set-harga/get-data-harga')}}/"+$('#thGroupId').val(),
								"columns":[									
									{"data": "DT_RowIndex"},
									{"data": "i_nama"},
									{"data": "harga"},
									{"data": "aksi"}
								],
								"autoWidth" : true,
								"preDrawCallback" : function() {
									// Initialize the responsive datatables helper once.
									if (!responsiveHelper_dt_basic) {
										responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#group_member'), breakpointDefinition);
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
								content : 'Data harg barang <i>"'+response.data.item+'" ('+response.data.group+')</i> berhasil dihapus...!',
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
						$('#overlay').fadeOut(200);
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

		function refresh_tab(){
		    aktif.api().ajax.reload();
		}

		function tgSubmit(){

			// --- AXIOS USE ----//
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Penyimpanan Data Group Sedang di Proses ...');

			axios.post(baseUrl+'/penjualan/set-harga/addGroup', $('#ft-group').serialize())
			    .then((response) => {

			        if(response.data.status == 'sukses'){
						$('#tgModal').modal('hide');
						$('#group_member').DataTable().destroy();
						$('#group_member').DataTable({
							"processing": true,
							"serverSide": true,
							"ajax": "{{ route('penjualan.getdatagroup') }}",
							"columns":[
								{"data": "DT_RowIndex", "name": "DT_RowIndex"},
								{"data": "group_name"}
							],
							"autoWidth" : true,
							"searching" : false,
							"paging"	: false,
							"info"		: false,
							"preDrawCallback" : function() {
								// Initialize the responsive datatables helper once.
								if (!responsiveHelper_dt_basic) {
									responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#group_member'), breakpointDefinition);
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
			                title : "SUKSES",
			                content : "Data Group berhasil ditambahkan",
			                color : "#739E73",
			                iconSmall : "fa fa-check animated",
			                timeout : 3000
			            });
			            
			        }else if(response.data.status == 'tgAda'){
			            $('#overlay').fadeOut(200);
			            $.smallBox({
			                title : "GAGAL",
			                content : "Data Group <i>"+response.data.name+"</i> sudah ada !",
			                color : "#C46A69",
			                iconSmall : "fa fa-times animated",
			                timeout : 3000
			            });
			        }else if(response.data.status == 'tgGagal'){
			            $('#overlay').fadeOut(200);
			            $.smallBox({
			                title : "GAGAL",
			                content : "Data Group gagal ditambahkan",
			                color : "#C46A69",
			                iconSmall : "fa fa-times animated",
			                timeout : 3000
			            });
			        }
			});
		}

		function thSubmit(){
			// --- AXIOS USE ----//
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Penyimpanan Data Harga Sedang di Proses ...');

			if($('#thItemNama').val() == ''){
				$('#overlay').fadeOut(200);
				$.smallBox({
					title : "Perhatian !",
					content : "Mohon Lengkapi Data Item Terlebih Dahulu !",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});
				return false;
			}

			if($('#thHarga').val() == ''){
				$('#overlay').fadeOut(200);
				$.smallBox({
					title : "Perhatian !",
					content : "Mohon Lengkapi Harga Item Terlebih Dahulu !",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});
				return false;
			}

			axios.post(baseUrl+'/penjualan/set-harga/addHarga', $('#thForm').serialize())
			    .then((response) => {

			        if(response.data.status == 'thBerhasil'){

						$('#dt_harga').DataTable().destroy();
						$('#dt_harga').DataTable({
							"processing": true,
							"serverSide": true,
							"ajax": "{{ url('/penjualan/set-harga/get-data-harga')}}/"+response.data.id,
							"columns":[
								
								{"data": "DT_RowIndex"},
								{"data": "i_nama"},
								{"data": "harga"},
								{"data": "aksi"}
							],
							"autoWidth" : true,
							"preDrawCallback" : function() {
								// Initialize the responsive datatables helper once.
								if (!responsiveHelper_dt_basic) {
									responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#group_member'), breakpointDefinition);
								}
							},
							"rowCallback" : function(nRow) {
								responsiveHelper_dt_basic.createExpandIcon(nRow);
							},
							"drawCallback" : function(oSettings) {
								responsiveHelper_dt_basic.respond();
							}
						});

						$('#thItemId').val('');
						$('#thItemNama').val('');
						$('#thHarga').val('');

			            $('#overlay').fadeOut(200);
			            $.smallBox({
			                title : "SUKSES",
			                content : "Data Harga berhasil ditambahkan",
			                color : "#739E73",
			                iconSmall : "fa fa-check animated",
			                timeout : 3000
			            });
			            
			        }else if(response.data.status == 'thAda'){
			            $('#overlay').fadeOut(200);
			            $.smallBox({
			                title : "GAGAL",
			                content : "Data Harga Item <i>"+response.data.name+"</i> pada group ini sudah ada !",
			                color : "#C46A69",
			                iconSmall : "fa fa-times animated",
			                timeout : 3000
			            });

			        }else if(response.data.status == 'thGagal'){
			            $('#overlay').fadeOut(200);
			            $.smallBox({
			                title : "GAGAL",
			                content : "Data Group gagal ditambahkan",
			                color : "#C46A69",
			                iconSmall : "fa fa-times animated",
			                timeout : 3000
			            });
			        }
			});
		}

		function egSubmit(){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengubah Data ...');

			axios.post(baseUrl+'/penjualan/set-harga/editGroup', $('#egForm').serialize()).then(response => {

				if (response.data.status == 'berhasil') {

					$('#egModal').modal('hide');
					$('#group_member').DataTable().destroy();
					$('#group_member').DataTable({
						"processing": true,
						"serverSide": true,
						"ajax": "{{ route('penjualan.getdatagroup') }}",
						"columns":[
							{"data": "DT_RowIndex"},
							{"data": "group_name"}
						],
						"autoWidth" : true,
						"searching" : false,
						"paging"	: false,
						"info"	: false,
						"preDrawCallback" : function() {
							// Initialize the responsive datatables helper once.
							if (!responsiveHelper_dt_basic) {
								responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#group_member'), breakpointDefinition);
							}
						},
						"rowCallback" : function(nRow) {
							responsiveHelper_dt_basic.createExpandIcon(nRow);
						},
						"drawCallback" : function(oSettings) {
							responsiveHelper_dt_basic.respond();
						}
					});

					axios.get(baseUrl+'/penjualan/set-harga/get-data-gp-non/'+$('#egId').val()).then(response => {

						$('#title_table').html('<h4 style="float: left"><strong>'+response.data.name+'</strong></h4>&nbsp;<a onclick="edit_group('+response.data.id+')"><i class="fa fa-pencil"></i></a>&nbsp;<a onclick="hapus_group('+response.data.id+')"><i class="fa fa-close"></i></a>');

					})

					$('#overlay').fadeOut(200);
			            $.smallBox({
			                title : "SUKSES",
			                content : "Data Group berhasil diubah !",
			                color : "#739E73",
			                iconSmall : "fa fa-check animated",
			                timeout : 3000
			            });

				}else if(response.data.status == 'ditolak'){

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Anda tidak diizinkan untuk mengubah data ini",
						color : "#A90329",
						timeout: 5000,
						icon : "fa fa-times bounce animated"
					});

				}else if(response.data.status == 'gagal'){
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "GAGAL",
						content : "Data Group gagal diubah !",
						color : "#C46A69",
						iconSmall : "fa fa-times animated",
						timeout : 3000
					});
				}
			});
		}

		function ehSubmit(){
			// --- AXIOS USE ----//
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Penyimpanan Data Harga Sedang di Proses ...');

			axios.post(baseUrl+'/penjualan/set-harga/editHarga', $('#ehForm').serialize())
			    .then((response) => {

			        if(response.data.status == 'ehBerhasil'){
						$('#ehModal').modal('hide');

						$('#dt_harga').DataTable().destroy();
						$('#dt_harga').DataTable({
							"processing": true,
							"serverSide": true,
							"ajax": "{{ url('/penjualan/set-harga/get-data-harga')}}/"+response.data.id,
							"columns":[
								
								{"data": "DT_RowIndex"},
								{"data": "i_nama"},
								{"data": "harga"},
								{"data": "aksi"}
							],
							"autoWidth" : true,
							"preDrawCallback" : function() {
								// Initialize the responsive datatables helper once.
								if (!responsiveHelper_dt_basic) {
									responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#group_member'), breakpointDefinition);
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
			                title : "SUKSES",
			                content : "Data Harga <i>"+response.data.item+"</i>berhasil diubah ..",
			                color : "#739E73",
			                iconSmall : "fa fa-check animated",
			                timeout : 3000
			            });
			            
			        }else if(response.data.status == 'ehGagal'){
			            $('#overlay').fadeOut(200);
			            $.smallBox({
			                title : "GAGAL",
			                content : "Data Group gagal diubah",
			                color : "#C46A69",
			                iconSmall : "fa fa-times animated",
			                timeout : 3000
			            });
			        }
			});
		}

	</script>
@endsection
