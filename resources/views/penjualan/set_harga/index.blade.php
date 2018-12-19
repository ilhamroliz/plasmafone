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
													<th><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
                                                    <th width="15%"><i class="fa fa-fw fa-dollar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Harga Grosir 1</th>
													<th width="15%"><i class="fa fa-fw fa-dollar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Harga Grosir 2</th>
													<th width="15%"><i class="fa fa-fw fa-dollar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Harga Grosir 3</th>
													<th width="15%"><i class="fa fa-fw fa-dollar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Harga Retail</th>                                                    
													<th class="text-center" width="10%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
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
					"ajax": "{{ route('penjualan.getdataharga') }}",
					"columns":[
						{"data": "i_nama"},
						{"data": "i_price_1"},
                        {"data": "i_price_2"},
                        {"data": "i_price_3"},
                        {"data": "i_price_4"},
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

                $('#overlay').fadeOut(200);

			}, 1000);

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

		$('#submit').click(function(evt){

			evt.preventDefault();

			var btn = $('#submit');
			btn.attr('disabled', 'disabled');
			btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Proses...');

			$('#overlay').fadeIn(200);
		    $('#load-status-text').text('Sedang Menyiapkan...');

			axios.post(baseUrl+'/penjualan/set-harga/edit/'+ $('#id').val(), $('#form-harga').serialize()).then((response) => {

				if (response.data.status == 'ditolak') {

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
						color : "#A90329",
						timeout: 5000,
						icon : "fa fa-times bounce animated"
					});

				}else if(response.data.status == 'setberhasil'){

                    $('#myModal').modal('hide');
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Berhasil",
						content : 'Set harga berhasil dilakukan...!',
						color : "#739E73",
						timeout: 4000,
						icon : "fa fa-check bounce animated"
					});

				}else if(response.data.status == 'tidak ada'){

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Data yang ingin Anda ubah sudah tidak ada...!",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});

				}else{

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Gagal mengedit data...! Coba lagi dengan mulai ulang halaman",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});

				}

			}).catch((err) => {

				$('#overlay').fadeOut(200);
				$.smallBox({
					title : "Gagal",
					content : "Upsss. Gagal mengedit data...! Coba lagi dengan mulai ulang halaman",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});
				
			}).then(function(){

				btn.removeAttr('disabled');
				btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Simpan');
				$('#overlay').fadeOut(200);
			});
		});
	</script>
@endsection