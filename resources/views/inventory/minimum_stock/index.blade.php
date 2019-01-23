@extends('main')

@section('title', 'Pembuatan Rencana Penjualan')

@section('extra_style')
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/MonthPicker.css') }}">
	<style>

	</style>
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
			<li>Home</li><li>Inventory</li><li>Manajemen Minimum Stock</li>
		</ol>

	</div>
	<!-- END RIBBON -->
@endsection

@section('main_content')
    <div id="content">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-cube"></i>
                    Inventory <span><i class="fa fa-angle-double-right"></i> Manajemen Minimum Stock </span>
                </h1>
            </div>

            @if(Plasma::checkAkses(11, 'insert') == true)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right padding-top-10">
                <button class="btn btn-success" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;Tambah Minimum Stock</button>
            </div>
            @endif

        </div>

        <section id="widget-grid" class="">

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

                        <header>
							<ul id="widget-tab-1" class="nav nav-tabs pull-left">
								<li class="active">
									<a data-toggle="tab" href="#hr1"> <i style="color: #C79121;" class="fa fa-lg fa-warning"></i> <span class="hidden-mobile hidden-tablet"> Warning</span></a>
								</li>		

								<li>
									<a data-toggle="tab" href="#hr2"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> Active</span></a>
                                </li>

								<li>
                                    <a data-toggle="tab" href="#hr3"> <i style="color: #A90329;" class="fa fa-lg fa-minus-square"></i> <span class="hidden-mobile hidden-tablet"> Nonactive </span> </a>
								</li>
							</ul>
                        </header>

                        <div>
                            <div class="widget-body no-padding">
								<form id="cariMPForm">
									<div class="col-md-12 no-padding padding-top-15">

										<div class="col-md-4">
											<div class="form-group">
												<input type="hidden" id="msItemId" name="msItemId">
												<input type="text" class="form-control" id="msItemName" placeholder="Masukkan Nama Barang" style="text-transform: uppercase">
											</div>
                                        </div>

                                        <div class="col-md-4">
											<div class="form-group">
                                                <input type="hidden" id="msCompId" name="msCompId">
                                                <input type="text" class="form-control" id="msCompName" placeholder="Masukkan Lokasi Barang" style="text-transform:uppercase">
											</div>
										</div>

										<div class="col-md-1">
											<a class="btn btn-primary" onclick="cariMS()" style="width:100%"><i class="fa fa-search"></i></a>
										</div>
									</div>
								</form>

                                <div class="tab-content padding-10">

									<div class="tab-pane fade in active" id="hr1">
										<table id="warningTable" class="table table-striped table-bordered table-hover warningTable" width="100%">

											<thead>
												<tr>
													<th width="30%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Lokasi Barang</th>
                                                    <th width="30%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
													<th width="15%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Minimum Stock</th>
													<th width="15%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Qty Stock</th>
													<th width="10%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="warningshowdata">
											</tbody>

										</table>
									</div>

                                    <div class="tab-pane fade" id="hr2">
										<table id="activeTable" class="table table-striped table-bordered table-hover activeTable" width="100%">

											<thead>
												<tr>
													<th width="30%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Lokasi Barang</th>
                                                    <th width="30%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
													<th width="15%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Minimum Stock</th>
													<th width="15%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Qty Stock</th>
													<th width="10%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="activeshowdata">
											</tbody>

                                        </table>
                                    </div>

                                    <div class="tab-pane fade" id="hr3">

                                        <table id="nonactiveTable" class="table table-striped table-bordered table-hover nonactiveTable" width="100%">

											<thead>
												<tr>
													<th width="30%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Lokasi Barang</th>
                                                    <th width="30%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
													<th width="15%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Minimum Stock</th>
													<th width="15%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Qty Stock</th>
													<th width="10%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="nonactiveshowdata">
											</tbody>

										</table>
									</div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>


		<!-- Modal untuk Form Edit Opname -->
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ui-front" id="modalWidth">
				<div class="modal-content" >
					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Form Tambah Data Minimum Stock</h4>

					</div>

					<div class="modal-body">
                        <div class="row">
							<form id="formOsTambah">
							<input type="hidden" id="idEMS">

							<div class="col-md-12 margin-bottom-5 no-padding">
                                <label class="col-md-3">Lokasi Barang</label>
                                <div class="col-md-9">
									<input type="hidden" id="editIdComp">
									<input type="text" class="form-control" id="editNameComp" style="text-transform: uppercase" readonly>
								</div>
							</div>

                            <div class="col-md-12 margin-bottom-5 no-padding">
                                <label class="col-md-3">Nama Barang</label>
								<div class="col-md-9">
                                    <input type="hidden" id="editIdItem">
                                    <input type="text" class="form-control" id="editNameItem" style="text-transform: uppercase" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <label class="col-md-3">Stock Minimum</label>
								<div class="col-md-9">
                                    <input type="text" class="form-control" id="editMinStock" placeholder="Masukkan Nilai Minimum Stock">
                                </div>
                            </div>
                        </div>

                        <div
                            id="divBtnAksi"
                            class="row form-actions"
                            style="border-top: 1px solid black">

                            <a class="btn btn-primary" onclick="simpanEMS()"><i class="fa fa-floppy-o"></i>&nbsp;Simpan</a>
                        </div>

					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

        <!-- Modal untuk Form Tambah Opname -->
		<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ui-front" id="modalWidth">
				<div class="modal-content" >
					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Form Tambah Data Minimum Stock</h4>

					</div>

					<div class="modal-body">
                        <div class="row">
							<form id="formOsTambah">

							<div class="col-md-12 margin-bottom-5 no-padding">
                                <label class="col-md-3">Lokasi Barang</label>
                                <div class="col-md-9">
									<input type="hidden" id="idComp" name="idComp">
									<input type="text" class="form-control" id="nameComp" name="nameComp" placeholder="Masukkan Lokasi Barang" style="text-transform: uppercase">
								</div>
							</div>

                            <div class="col-md-12 margin-bottom-5 no-padding">
                                <label class="col-md-3">Nama Barang</label>
								<div class="col-md-9">
                                    <input type="hidden" id="idItem" name="idItem">
                                    <input type="text" class="form-control" id="nameItem" name="nameItem" placeholder="Masukkan Nama Item" style="text-transform: uppercase">
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <label class="col-md-3">Stock Minimum</label>
								<div class="col-md-9">
                                    <input type="text" class="form-control" id="minStock" name="minStock" placeholder="Masukkan Nilai Minimum Stock">
                                </div>
                            </div>
                        </div>

                        <div
                            id="divBtnAksi"
                            class="row form-actions"
                            style="border-top: 1px solid black">

                            <a class="btn btn-primary" onclick="simpanMS()"><i class="fa fa-floppy-o"></i>&nbsp;Simpan</a>
                        </div>

					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

    </div>
@endsection

@section('extra_script')
<script src="{{ asset('template_asset/js/MonthPicker.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/accounting/accounting.js') }}"></script>

    <script type="text/javascript">
		var aTab, naTab, waTab;
		var idItem, idComp;

        $(document).ready(function(){

            $('#nameItem').autocomplete({
				// "option", "appendTo", ".eventInsForm",
                source: baseUrl+'/penjualan/pemesanan-barang/get-item',
                minLength: 2,
                select: function(event, data){
                    $('#idItem').val(data.item.id);
                }
			})

            $('#nameComp').autocomplete({
                source: baseUrl+'/man-penjualan/rencana-penjualan/auto-comp',
                minLength: 2,
                select: function(event, data){
                    $('#idComp').val(data.item.id);
                }
            })

			$('#msItemName').autocomplete({
				// "option", "appendTo", ".eventInsForm",
                source: baseUrl+'/penjualan/pemesanan-barang/get-item',
                minLength: 2,
                select: function(event, data){
                    $('#msItemId').val(data.item.id);
                }
            })

            $('#msCompName').autocomplete({
                source: baseUrl+'/man-penjualan/rencana-penjualan/auto-comp',
                minLength: 2,
                select: function(event, data){
                    $('#msCompId').val(data.item.id);
                }
            })


            setTimeout(function () {
                get_warning();
			}, 500);

			setTimeout(function () {
                get_active();
			}, 1000);

			setTimeout(function () {
                get_nonactive();
			}, 1500);

		});


		function get_warning(){

			waTab = $('#warningTable').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": "{{ url('/inventory/min-stock/get-warning') }}",
                "columns":[
                    {"data": "c_name"},
                    {"data": "i_nama"},
                    {"data": "s_min"},
                    {"data": "s_qty"},
                    {"data": "aksi"}
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#warningTable'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });

		}

        function get_active(){

            aTab = $('#activeTable').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": "{{ url('/inventory/min-stock/get-active') }}",
                "columns":[
                    {"data": "c_name"},
                    {"data": "i_nama"},
                    {"data": "s_min"},
                    {"data": "s_qty"},
					{"data": "aksi"}
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#activeTable'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
        }

        function get_nonactive(){
            naTab = $('#nonactiveTable').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": "{{ url('/inventory/min-stock/get-nonactive') }}",
                "columns":[
                    {"data": "c_name"},
                    {"data": "i_nama"},
                    {"data": "s_min"},
                    {"data": "s_qty"},
                    {"data": "aksi"}
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#nonactiveTable'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
        }


		function detail(id){
			axios.post(baseUrl+'/inventory/opname-barang/detail?id='+id).then((response) => {

				$('#obNota').html(response.data.data[0].o_reff);
				$('#obCabang').html(response.data.data[0].c_name);
				$('#obBarang').html(response.data.data[0].i_nama);
				if(response.data.data[0].o_action == 'REAL'){
					$('#obAksi').html('Menyesuaikan Qty Real')
				}else if(response.data.data[0].o_action == 'SYSTEM'){
					$('#obAksi').html('Menyesuaikan Qty System')
				}

				$qtyR = 0;
				$qtyS = 0;

				dobCTable.clear();

				for($ob = 0; $ob < response.data.data.length; $ob++){
					$qtyR = $qtyR + parseInt(response.data.data[$ob].od_qty_real);
					$qtyS = $qtyS + parseInt(response.data.data[$ob].od_qty_system);

					$sc = response.data.data[$ob].i_specificcode;
					$ex = response.data.data[$ob].i_expired;

					if($sc == 'Y' && $ex == 'N'){

						dobCTable.row.add([
							($ob+1),
							response.data.data[$ob].od_specificcode
						]).draw(false);

					}

				}
				$('#dobCTable').css("display", "block");

				$('#obQtyS').html($qtyS+' Unit');
				$('#obQtyR').html($qtyR+' Unit');

			})

			$('#detilModal').modal('show');
		}

		function cari2(){

			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mencari Data ...');

			var status;
			var awal = $('#tglAwal').val();
			var akhir = $('#tglAkhir').val();
			var idItem = $('#osItemId').val();
			var idComp = $('#osCompId').val();

			if($('#hr1').hasClass("active") == true){

				$('#warningTable').DataTable().destroy();

				$('#warningTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/inventory/opname-barang/pencarian') }}"+"?x=a&awal="+awal+"&akhir="+akhir+'&ii='+idItem+'&ic='+idComp,
					"columns":[
						{"data": "c_name"},
						{"data": "i_nama"},
						{"data": "s_min"},
						{"data": "s_qty"},
						{"data": "aksi"}
					],
					"autoWidth" : false,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#warningTable'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			}else if($('#hr2').hasClass("active") == true){

				$('#activeTable').DataTable().destroy();

				$('#activeTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/inventory/opname-barang/pencarian') }}"+"?x=p&awal="+awal+"&akhir="+akhir+'&ii='+idItem+'&ic='+idComp,
					"columns":[
						{"data": "c_name"},
						{"data": "i_nama"},
						{"data": "s_min"},
						{"data": "s_qty"},
						{"data": "aksi"}
					],
					"autoWidth" : false,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#activeTable'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			}else if($('#hr3').hasClass("active") == true){

				$('#nonactiveTable').DataTable().destroy();

				$('#nonactiveTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/inventory/opname-barang/pencarian') }}"+"?x=p&awal="+awal+"&akhir="+akhir+'&ii='+idItem+'&ic='+idComp,
					"columns":[
						{"data": "c_name"},
						{"data": "i_nama"},
						{"data": "s_min"},
						{"data": "s_qty"},
						{"data": "aksi"}
					],
					"autoWidth" : false,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#nonactiveTable'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			}
			$('#osItemId').val('');
			$('#osCompId').val('');
			$('#overlay').fadeOut(200);
		}

        function tambah(){
            $('#tambahModal').modal('show');
        }

		function simpanMS(){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Menyimpan Data...');

			var idItem = $('#idItem').val();
			var idComp = $('#idComp').val();
            var minStock = $('#minStock').val();

			axios.post(baseUrl+'/inventory/min-stock/tambah', {idItem: idItem, idComp: idComp, minStock: minStock}).then((response) => {

				if(response.data.status == 'msSukses'){

					waTab.destroy();
					get_warning();
                    naTab.destroy();
                    get_nonactive();
                    aTab.destroy();
                    get_active();

					$('#tambahModal').modal('hide');
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Berhasil",
						content : 'Data Minimum Stock Berhasil Disimpan...!',
						color : "#739E73",
						timeout: 4000,
						icon : "fa fa-check bounce animated"
					});

				}else{

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Maaf, Minimum Stock Gagal Disimpan ",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});

				}

			});
		}

        function edit(id){
			axios.get(baseUrl+'/inventory/min-stock/edit?id='+id).then((response) => {
				$('#editIdComp').val(response.data.data.s_position);
				$('#editNameComp').val(response.data.data.c_name);
				$('#editIdItem').val(response.data.data.s_item);
				$('#editNameItem').val(response.data.data.i_nama);
				$('#editMinStock').val(response.data.data.s_min);
				$('#idEMS').val(id);
			})
			$('#editModal').modal('show');
		}
		
		function simpanEMS(){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Menyimpan Data...');

			var id = $('#idEMS').val();
            var minStock = $('#editMinStock').val();

			axios.post(baseUrl+'/inventory/min-stock/edit', {id: id, minStock: minStock}).then((response) => {

				if(response.data.status == 'eSukses'){

					waTab.destroy();
					get_warning();
                    naTab.destroy();
                    get_nonactive();
                    aTab.destroy();
                    get_active();

					$('#editModal').modal('hide');
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Berhasil",
						content : 'Data Minimum Stock Berhasil Disimpan...!',
						color : "#739E73",
						timeout: 4000,
						icon : "fa fa-check bounce animated"
					});

				}else{

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Maaf, Minimum Stock Gagal Disimpan ",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});

				}

			});
		}

        function active(id){
			$.SmartMessageBox({
				title : "Pesan !",
				content : "Silahkan Masukkan Minimum Stock untuk mengaktifkan Stock Item ini",
				buttons : "[Aktifkan]",
				input : "text",
				placeholder : "Masukkan Minimum Stock"
			}, function(ButtonPress, Value) {

				$('#overlay').fadeIn(200);
				$('#load-status-text').text('Sedang Menyimpan Perubahan Data...');

				axios.post(baseUrl+'/inventory/min-stock/active', { min: Value, id: id}).then((response) => {
					
					if(response.data.status == 'saSukses'){

						waTab.destroy();
						get_warning();
						naTab.destroy();
						get_nonactive();
						aTab.destroy();
						get_active();

						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Berhasil",
							content : 'Stock Item Berhasil DiAktifkan !',
							color : "#739E73",
							timeout: 4000,
							icon : "fa fa-check bounce animated"
						});

					}else{

						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Gagal",
							content : "Maaf, Aktivasi Stock Item Gagal",
							color : "#A90329",
							timeout: 4000,
							icon : "fa fa-times bounce animated"
						});

					}
				})

			});
        }

        function nonactive(id){
            $.SmartMessageBox({
				title : "Pesan !",
				content : 'Apakah Anda yakin akan menonaktifkan Minimum Stock untuk item ini ?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menyimpan Perubahan Data...');

					axios.post(baseUrl+'/inventory/min-stock/nonactive', {id: id}).then((response) => {
						
						if(response.data.status == 'snSukses'){

							waTab.destroy();
							get_warning();
							naTab.destroy();
							get_nonactive();
							aTab.destroy();
							get_active();
					
							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Berhasil",
								content : 'Stock Item Berhasil DiNonaktifkan !',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else{

							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Maaf, Aktivasi Stock Item Gagal",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}
					})

                }
            })
        }

    </script>
@endsection
