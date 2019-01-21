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
									<a data-toggle="tab" href="#hr1"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> Active</span></a>
                                </li>

								<li>
                                    <a data-toggle="tab" href="#hr2"> <i style="color: #A90329;" class="fa fa-lg fa-minus-square"></i> <span class="hidden-mobile hidden-tablet"> Nonactive </span> </a>
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
                                                @if(Auth::user()->m_comp == "PF00000001")
                                                <input type="hidden" id="msCompId" name="msCompId">
                                                <input type="text" class="form-control" id="msCompName" placeholder="Masukkan Lokasi Barang" style="text-transform:uppercase">
                                                @else
                                                <input type="hidden" id="msCompId" name="msCompId" value="{{ Auth::user()->m_comp }}">
                                                <input type="text" class="form-control msCompName" value="{{ $getCN->c_name }}" readonly>
                                                @endif
											</div>
										</div>

										<div class="col-md-1">
											<a class="btn btn-primary" onclick="cariMS()" style="width:100%"><i class="fa fa-search"></i></a>
										</div>
									</div>
								</form>

                                <div class="tab-content padding-10">

                                    <div class="tab-pane fade in active" id="hr1">
										<table id="activeTable" class="table table-striped table-bordered table-hover activeTable" width="100%">

											<thead>
												<tr>
													<th style="width: 30%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Lokasi Barang</th>
                                                    <th style="width: 35%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
													<th style="width: 20%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Minimum Stock</th>
													<th style="width: 15%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="activeshowdata">
											</tbody>

                                        </table>
                                    </div>

                                    <div class="tab-pane fade" id="hr2">

                                        <table id="nonactiveTable" class="table table-striped table-bordered table-hover nonactiveTable" width="100%">

											<thead>
												<tr>
													<th style="width: 30%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Lokasi Barang</th>
                                                    <th style="width: 35%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
													<th style="width: 20%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Minimum Stock</th>
													<th style="width: 15%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
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



		<!-- Modal untuk Detil Opname Barang -->
		<div class="modal fade" id="detilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Detail Opname Barang Pusat</h4>

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

											<div class="col-md-12 padding-top-10 ">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>No. Nota</strong></label>
													<label class="col-md-1">:</label>
													<label class="col-md-8" id="obNota"></label>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>Lokasi Barang</strong></label>
													<label class="col-md-1">:</label>
													<div class="col-md-8">
														<label id="obCabang"></label>
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>Nama Barang</strong></label>
													<label class="col-md-1">:</label>
													<div class="col-md-8">
														<label id="obBarang"></label>
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>Qty Sistem</strong></label>
													<label class="col-md-1">:</label>
													<div class="col-md-8">
														<label id="obQtyS"></label>
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>Qty Real</strong></label>
													<label class="col-md-1">:</label>
													<div class="col-md-8">
														<label id="obQtyR"></label>
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>AKSI</strong></label>
													<label class="col-md-1">:</label>
													<div class="col-md-8">
														<label id="obAksi"></label>
													</div>
												</div>
											</div>

										</div>

										<!-- Tabel untuk detil opname barang-->
										<!-- TABEL C-->
										<div class="col-md-12">
											<table
												id="dobCTable"
												class="table table-striped table-bordered table-hover margin-top-10"
												style="display:none; margin-top: 20px;">

												<thead id="dobCHead">
													<th>No.</th>
													<th>Kode Spesifik</th>
												</thead>

												<tbody id="dobCBody">
												</tbody>

											</table>
										</div>

										{{-- <!-- TABEL E-->
										<table
											id="dobETable"
											class="table table-striped table-bordered table-hover margin-top-10"
											style="display:none; margin-top: 20px">

											<thead id="dobEHead">
												<th style="width: 15%">No.</th>
												<th style="width: 50%">Tanggal Kadaluarsa</th>
												<th style="width: 35%">Qty</th>
											</thead>

											<tbody id="dobEBody">
											</tbody>

										</table>

										<!-- TABEL CE-->
										<table
											id="dobCETable"
											class="table table-striped table-bordered table-hover margin-top-10"
											style=" margin-top: 20px">

											<thead id="dobCEHead">
												<th style="width: 15%">No.</th>
												<th style="width: 45%">Kode Spesifik</th>
												<th style="wdith: 40%">Tanggal Kadaluarsa</th>
											</thead>

											<tbody id="dobCEBody">
											</tbody>

										</table> --}}

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
									<input type="hidden" id="idComp" name="idComp" value="{{Auth::user()->m_comp}}">
									<input type="text" class="form-control" id="nameComp" name="nameComp" value="Plasmafone Pusat" style="text-transform: uppercase" readonly>
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
        var appr, pend;
		var aTab, naTab;
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
                get_active();
			}, 500);

			setTimeout(function () {
                get_nonactive();
			}, 1000);

		});

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

			if($('#hr2').hasClass("active") == true){

				$('#apprTable').DataTable().destroy();

				$('#apprTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/inventory/opname-barang/pencarian') }}"+"?x=a&awal="+awal+"&akhir="+akhir+'&ii='+idItem+'&ic='+idComp,
					"columns":[
						{"data": "o_reff"},
						{"data": "o_date"},
						{"data": "c_name"},
						{"data": "i_nama"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#apprTable'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			}else if($('#hr1').hasClass("active") == true){

				$('#pendTable').DataTable().destroy();

				$('#pendTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/inventory/opname-barang/pencarian') }}"+"?x=p&awal="+awal+"&akhir="+akhir+'&ii='+idItem+'&ic='+idComp,
					"columns":[
						{"data": "o_reff"},
						{"data": "o_date"},
						{"data": "c_name"},
						{"data": "i_nama"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#pendTable'), breakpointDefinition);
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

        }

		function approve(id){

			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Menyimpan Perubahan Data...');

			axios.get(baseUrl+'/man-penjualan/rencana-penjualan/approve'+'/'+id).then((response) => {

				if(response.data.status == 'apprSukses'){
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Berhasil",
						content : 'Approval Berhasil Dilakukan !',
						color : "#739E73",
						timeout: 4000,
						icon : "fa fa-check bounce animated"
					});
					location.reload();
				}else{
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Maaf, Approval Gagal Dilakukan ",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});
				}

			})

		}

    </script>
@endsection
