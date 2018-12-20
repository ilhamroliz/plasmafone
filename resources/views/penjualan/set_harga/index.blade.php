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

				<!-- LIST GROUP MEMBER -->
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
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
									<form id="form_gp">
										<div class="col-md-9 no-padding">
											<input type="text" class="form-control">
										</div>
										<div class="col-md-3">
											<button class="btn btn-success"><i class="fa fa-plus"></i></button>
										</div>
									</form>
								</div>
								@endif

								<table id="group_member" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
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
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

						<header>

						</header>

						<div>
							<div class="widget-body no-padding">
								<div class="tab-content padding-10">
                                    
									<div class="tab-pane fade in active" id="hr1">
										<table id="dt_harga" class="table table-striped table-bordered table-hover" width="100%">

											<thead>		
												<tr>
													<th width="60%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
                                                    <th width="25%"><i class="fa fa-fw fa-dollar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Harga</th>                                                 
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

			<!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Form Setting Harga</h4>
                        </div>
                        <div class="modal-body no-padding">

                            <form id="form-harga" class="smart-form">
                                <input type="hidden" name="id" id="id">

                                <fieldset>
                                    <section>
                                        <div class="row">
                                            <label class="label col col-3">Nama Barang</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="nama" id="nama">
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                    <section>
                                        <div class="row">
                                            <label class="label col col-3">Tipe Penjualan</label>
                                            <div class="col col-8 has-feedback">
                                                <label class="input">
                                                    <select class="form-control" name="tipe" id="tipe">
                                                        <option value="1">Grosir 1</option>
                                                        <option value="2">Grosir 2</option>
                                                        <option value="3">Grosir 3</option>
                                                        <option value="4">Retail</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                    <section>
                                        <div class="row">
                                            <label class="label col col-3">Harga Barang</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="harga" id="harga">
                                                </label>
                                            </div>
                                        </div>
                                    </section>

                                </fieldset>
                                
                                <footer>
                                    <button type="button" class="btn btn-primary" id="submit"><i class="fa fa-floppy-o"></i>
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

		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Mengambil Data...');
		
		var baseUrl = '{{ url('/') }}';
		var table = $('#dt_harga').DataTable();
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
			"ajax": "{{ route('penjualan.getdatagroup') }}",
			"columns":[
				// {"data": "DT_RowIndex"},
				{"data": "group_name"}
			],
			"autoWidth" : true,
			"searching" : false,
			"paging"	: false,
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
	
			$('#showdata').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil Data...');
			table.fnDestroy();

			$('#dt_harga').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ url('/penjualan/set-harga/get-data-harga') }}/"+id,
				"columns":[
					{"data": "i_nama"},
					{"data": "gp_price"},
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
			// table.draw(false);

			$('#overlay').fadeOut(200);
		}

		/* END BASIC */

		function refresh_tab(){
		    aktif.api().ajax.reload();
		}

		function edit(id){

			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil data...');

			var status;

			axios.get(baseUrl+'/penjualan/set-harga/edit/'+id).then(response => {

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

			        $("#harga").maskMoney({thousands:'.', precision: 0});
					$('#id').val(response.data.data.i_id);
					$('#nama').val(response.data.data.i_nama);
					$('#overlay').fadeOut(200);
					$('#myModal').modal('show');

				}
			});

		}

	</script>
@endsection