@extends('main')

@section('title', 'Pembuatan Rencana Penjualan')

@section('extra_style')
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/MonthPicker.css') }}">
	<style>
		/* .ui-autocomplete-input {
			z-index: 9999;
		} */
		.ui-autocomplete { z-index:2147483647; }
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
			<li>Home</li><li>Inventory</li><li>Opname Barang Pusat</li>
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
                    Inventory <span><i class="fa fa-angle-double-right"></i> Opname Barang Pusat </span>
                </h1>
            </div>

            @if(Plasma::checkAkses(11, 'insert') == true)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right padding-top-10">
                <button class="btn btn-success" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;Tambah Opname Pusat</button>
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
									<a data-toggle="tab" href="#hr1"> <i style="color: #C79121;" class="fa fa-lg fa-align-justify"></i> <span class="hidden-mobile hidden-tablet"> Pending </span></a>                                
                                </li>

								<li>
                                    <a data-toggle="tab" href="#hr2"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> Approved </span> </a>
								</li>
							</ul>
                        </header>

                        <div>
                            <div class="widget-body no-padding">
								<form id="cariMPForm">
									<div class="col-md-12 no-padding padding-top-15">
										<div class="col-md-4">
											<div class="input-group" id="date-range" style="">
												<input type="text" class="form-control" id="tglAwal" name="tglAwal" value="" placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
												<span class="input-group-addon bg-custom text-white b-0">to</span>
												<input type="text" class="form-control" id="tglAkhir" name="tglAkhir" value="" placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<input type="hidden" id="osItemId" name="osItemId">
												<input type="text" class="form-control osItemName" placeholder="Masukkan Nama Barang" style="text-transform: uppercase">                                       
											</div>
                                        </div>
                                        
                                        <div class="col-md-3">
											<div class="form-group">
												<input type="hidden" id="osCompId" name="osCompId">
												<input type="text" class="form-control osCompName" placeholder="Masukkan Nama Cabang" style="text-transform: uppercase">                                       
											</div>
										</div>

										<div class="col-md-1">
											<a class="btn btn-primary" onclick="cari()" style="width:100%"><i class="fa fa-search"></i></a>
										</div>
									</div>
								</form>

                                <div class="tab-content padding-10">

                                    <div class="tab-pane fade in active" id="hr1">
										<table id="pendTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
													<th style="width: 15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th style="width: 15%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Opname</th>
                                                    <th style="width: 20%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Cabang</th>
													<th style="width: 35%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
													<th style="width: 15%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="pendshowdata">
											</tbody>

                                        </table>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="hr2">
                                        
                                        <table id="apprTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
													<th style="width: 15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th style="width: 15%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Opname</th>
                                                    <th style="width: 20%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Cabang</th>
													<th style="width: 35%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
													<th style="width: 15%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="apprshowdata">
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

						<h4 class="modal-title" id="myModalLabel">Detail Rencana Penjualan</h4>

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
														<label class="col-md-8" id="spNota"></label>
													</div>

													<div class="form-group">
														<label class="col-md-3" style="float:left"><strong>Nama Cabang</strong></label>
														<label class="col-md-1">:</label>
														<div class="col-md-8">
															<label id="spCabang"></label>
														</div>
													</div>													
												</div>

												<table id="drpTable" class="table table-striped table-bordered table-hover">
													<thead>		
														<tr>
															<th style="width: 10%">&nbsp;No.</th>
															<th style="width: 60%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
															<th style="width: 30%"><i class="fa fa-fw fa-cart-arrow-down txt-color-blue"></i>&nbsp;Jumlah Unit</th>
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


        
        <!-- Modal untuk Form Tambah Opname -->
		<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ui-front" id="modalWidth" style="width: 60%">
				<div class="modal-content">
					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Form Tambah Opname Barang Pusat</h4>

					</div>

					<div class="modal-body">
                        <div class="row no-padding margin-bottom-10 padding-bottom-10">
							<form id="formOsTambah">
							<div class="col-md-12 margin-bottom-5">
								<div class="col-md-7">
									<input type="hidden" id="idComp" name="idComp" value="{{Auth::user()->m_comp}}">
                                    <input type="text" class="form-control" id="nameComp" name="nameComp" value="Plasmafone Pusat" style="text-transform: uppercase" readonly>
                                </div>
							</div>
                            <div class="col-md-12">
                                <div class="col-md-7">
                                    <input type="hidden" id="idItem" name="idItem">
                                    <input type="text" class="form-control" id="nameItem" name="nameItem placeholder="Masukkan Nama Item" style="text-transform: uppercase">
                                </div>

                                <div class="col-md-1">
                                    <a class="btn btn-primary" onclick="cariTambah()"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                        </div>
						
                        <div 
                            id="divQtyHpp"
                            class="row no-padding margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15" 
                            style="border-top: 1px solid black; display: none">

                            <div class="col-md-12">
                                <div class="col-md-6 no-padding">
                                    <label class="col-md-4"><h4>Qty Sistem</h4></label>
                                    <div class="col-md-7 no-padding">
                                        <input type="text" class="form-control text-align-right" id="osQtyS" name="osQtyS" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 no-padding">
                                    <label class="col-md-4"><h4>Qty Real</h4></label>
                                    <div class="col-md-7 no-padding">
                                        <input type="text" class="form-control text-align-right" id="osQtyR" name="osQtyR">
                                    </div>                                    
                                </div>
                            </div>

                            <div class="col-md-12 padding-top-10">
                                <div class="col-md-6 no-padding">
                                    <label class="col-md-4"><h4>HPP</h4></label>
                                    <div class="col-md-7 no-padding">
                                        <input type="text" class="form-control text-align-right" id="osHpp" name="osHpp">
                                    </div>                                    
								</div>
								@if(Auth::user()->m_level < 5)
								<div class="col-md-6 no-padding" id="divAksi" style="display: none">
                                    <label class="col-md-4"><h4>AKSI</h4></label>
                                    <div class="col-md-7 no-padding">
                                        <select name="aksiSelect" id="aksiSelect" class="form-control">
											<option value="" selected disabled>== PILIH AKSI ==</option>
											<option value="1">Samakan dengan SISTEM</option>
											<option value="2">Samakan dengan REAL</option>
										</select>
                                    </div>                                    
								</div>
								@endif
							</div>
							
							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-4 no-padding">
									<div class="note">
										HPP Terakhir adalah Rp. <strong id="hppNote">9.000.000</strong>
									</div>
								</div>
                            </div>
                        </div>


                        <div
                            id="divTableExp"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions" 
                            style="border-top: 1px solid black; display: none; ">

                            <table id="expTable" class="table table-striped table-bordered table-hover expTable">
                                <thead>
                                    <tr>
                                        <th style="width: 25%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Jumlah Unit</th>
                                        <th style="width: 50%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Kadaluarsa</th>
                                        <th style="width: 25%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
                                    </tr>
                                </thead>

                                <tbody id="apprshowdata">
                                    <tr>
                                        <td>
											<input type="text" class="form-control qty" name="qty[]" style="width: 100%">
										</td>
                                        <td class="text-align-left">
											<select name="" id="" style="width: 20%; float: left" class="form-control">
												<option value="" selected disabled>TGL</option>
											</select>
											<select name="" id="" style="width: 40%; float: left; margin-left: 4%" class="form-control">
												<option value="" selected disabled>BULAN</option>
											</select>
											<select name="" id="" style="width: 30%; float: left; margin-left: 4%" class="form-control">
												<option value="" selected disabled>TAHUN</option>
											</select>
                                        </td>
                                        <td>
											<div class="text-center">
												<a class="btn btn-success" style="width: 100%" onclick="addRow()"><i class="fa fa-plus"></i></a>
											</div>
										</td>
                                    </tr>
                                </tbody>
                            </table>

						</div>
						
						<div
							id="divTableCode"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions" 
                            style="border-top: 1px solid black; display: none">

							<table id="codeTable" class="table table-striped table-bordered table-hover expTable">
                                <thead>
                                    <tr>
                                        <th style="width: 37%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;IMEI Tercatat</th>
                                        <th style="width: 37%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;IMEI Input</th>
                                    </tr>
                                </thead>

                                <tbody id="apprshowdata">
                                </tbody>
                            </table>

						</div>


						<div
							id="divTableCodeExp"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions" 
                            style="border-top: 1px solid black; display: none">

							<table id="codeTable" class="table table-striped table-bordered table-hover expTable">
                                <thead>
                                    <tr>
                                        <th style="width: 30%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;IMEI Tercatat</th>
										<th style="width: 30%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;IMEI Input</th>
										<th style="width: 25%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Kadaluarsa</th>
                                    </tr>
                                </thead>

                                <tbody id="apprshowdata">
                                
                                </tbody>
							</table>
							
						</div>

						</form>

                        <div
                            id="divBtnAksi"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions" 
                            style="border-top: 1px solid black; display: none">

                            <button class="btn btn-primary" onclick="simpanOs()"><i class="fa fa-floppy-o"></i>&nbsp;Simpan</button>
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
    <script type="text/javascript">
        var appr, pend;
		var expTable, codeTable, codeExpTable;
		var apprTab, pendTab;
		var speccode, expired;
		var idItem, idComp;

        $(document).ready(function(){
			expTable = $('#expTable').DataTable({
				"order" : [],
				"searching": false,
				"autoWidth" : false,
				"pageLength" : 3,
				"lengthChange": false
			});

			codeTable = $('#codeTable').DataTable({
				"order" : [],
				"searching": false,
				"autoWidth" : false,
				"pageLength" : 3,
				"lengthChange": false
			});

			codeExpTable = $('#codeExpTable').DataTable({
				"order" : [],
				"searching": false,
				"autoWidth" : false,
				"pageLength" : 3,
				"lengthChange": false
			});

            $('#monthPick').MonthPicker({
                Button: false
            });

            $('#nameItem').autocomplete({
				// "option", "appendTo", ".eventInsForm",
                source: baseUrl+'/penjualan/pemesanan-barang/get-item',
                minLength: 2,
                select: function(event, data){
                    $('#idItem').val(data.item.id);
                }
			})
			
			$('#osItemName').autocomplete({
				// "option", "appendTo", ".eventInsForm",
                source: baseUrl+'/penjualan/pemesanan-barang/get-item',
                minLength: 2,
                select: function(event, data){
                    $('#osItemId').val(data.item.id);
                }
            })

            $('.osCompName').autocomplete({
                source: baseUrl+'/man-penjualan/rencana-penjualan/auto-comp',
                minLength: 2,
                select: function(event, data){
                    $('#osCompId').val(data.item.id);
                }
            })

            setTimeout(function () {

				pendTab = $('#pendTable').DataTable({
					// "processing": true,
					// "serverSide": true,
					// "order": [],
					// "ajax": "{{ url('/inventory/opname-barang/pend') }}",
					// "columns":[
					// 	// {"data": "sp_nota"},
					// 	// {"data": "c_name"},
					// 	// {"data": "sp_update"},
					// 	// {"data": "aksi"}
					// ],
					// "autoWidth" : true,
					// "language" : dataTableLanguage,
					// "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					// "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					// "preDrawCallback" : function() {
					// 	// Initialize the responsive datatables helper once.
					// 	if (!responsiveHelper_dt_basic) {
					// 		responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#pendTable'), breakpointDefinition);
					// 	}
					// },
					// "rowCallback" : function(nRow) {
					// 	responsiveHelper_dt_basic.createExpandIcon(nRow);
					// },
					// "drawCallback" : function(oSettings) {
					// 	responsiveHelper_dt_basic.respond();
					// }
				});

			}, 500);

			setTimeout(function () {

				apprTab = $('#apprTable').DataTable({
					// "processing": true,
					// "serverSide": true,
					// "order": [],
					// "ajax": "{{ url('/inventory/opname-barang/appr') }}",
					// "columns":[
					// 	// {"data": "sp_nota"},
					// 	// {"data": "c_name"},
					// 	// {"data": "sp_update"},
					// 	// {"data": "aksi"}
					// ],
					// "autoWidth" : true,
					// "language" : dataTableLanguage,
					// "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					// "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
					// "preDrawCallback" : function() {
					// 	// Initialize the responsive datatables helper once.
					// 	if (!responsiveHelper_dt_basic) {
					// 		responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#apprTable'), breakpointDefinition);
					// 	}
					// },
					// "rowCallback" : function(nRow) {
					// 	responsiveHelper_dt_basic.createExpandIcon(nRow);
					// },
					// "drawCallback" : function(oSettings) {
					// 	responsiveHelper_dt_basic.respond();
					// }
				});

			}, 1000);

		});

		function addRow(){
			expTable.row.add([
				'<input type="text" class="form-control qty" name="qty[]" style="width: 100%">',
				'<select name="" id="" style="width: 20%; float: left" class="form-control"><option value="" selected disabled>TGL</option></select><select name="" id="" style="width: 40%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>BULAN</option></select><select name="" id="" style="width: 30%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>TAHUN</option></select>',
				'<div class="text-center"><button class="btn btn-success" style="width: 48%" onclick="addRow()"><i class="fa fa-plus"></i></button> <button class="btn btn-danger btnhapus" style="width: 48%"><i class="fa fa-minus"></i></button></div>'
			]).draw(false);
		}

		$('.expTable tbody').on( 'click', 'button.btnhapus', function () {
			expTable.row( $(this).parents('tr') ).remove().draw();
		});

		function cari2(){
			
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mencari Data ...');

			var status;
			var mp = $('#monthPick').val();
			var ci = $('#irpCompId').val();

			if($('#hr1').hasClass("active") == true){

				$('#apprTable').DataTable().destroy();

				$('#apprTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/man-penjualan/rencana-penjualan/pencarian') }}"+"?x=a&y="+mp+"&z="+ci,
					"columns":[
						{"data": "sp_nota"},
						{"data": "c_name"},
						{"data": "sp_update"},
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

			}else if($('#hr2').hasClass("active") == true){

				$('#pendTable').DataTable().destroy();
				
				$('#pendTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/man-penjualan/rencana-penjualan/pencarian') }}"+"?x=p&y="+mp+"&z="+ci,
					"columns":[
						{"data": "sp_nota"},
						{"data": "c_name"},
						{"data": "sp_update"},
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
			$('#irpCompId').val('');
			$('#overlay').fadeOut(200);
		}

		function cariTambah(){
			idItem = $('#idItem').val();
			idComp = $('#idComp').val();
			axios.post(baseUrl+'/inventory/opname-barang/cariItemStock', {idItem: idItem, idComp: idComp}).then((response) => {
				$('#osQtyS').val(response.data.data[0].qty);
				$('#divQtyHpp').css("display", "block");
				$('#osHpp').maskMoney({precision: 0, thousands: '.'});
				$('#osQtyR').maskMoney({precision: 0, thousands: '.'});

				speccode = response.data.data[0].i_specificcode;
				expired = response.data.data[0].i_expired;

			});
		}

		$('#aksiSelect').on('change', function (e) {
			if($('#aksiSelect').val() == '2'){
				var QtyS = $('#osQtyS').val();
				var QtyR = $('#osQtyR').val();
				var countT = parseInt(QtyR) - parseInt(QtyS);

				$('#divTableCode').css("display", "none");
				$('#divTableExp').css("display", "none");
				$('#divTableCodeExp').css("display", "none");

				codeTable.clear();
				expTable.clear();
				codeExpTable.clear();

				if(parseInt(QtyS) < parseInt(QtyR)){

					if(speccode == 'Y' && expired == 'N'){

						axios.post(baseUrl+'/inventory/opname-barang/get-stock-code', {idItem: idItem}).then((response) => {

							if(countT < QtyS){

								for(var a = 0; a < response.data.code.length; a++){

									if(a < countT){
										codeTable.row.add([
											'<td><input type="text" class="form-control imeiS" name="imeiS[]" value="'+response.data.code[a].sd_specificcode+'" style="width: 100%" readonly></td>',
											'<td><input type="text" class="form-control imeiI" name="imeiI[]" style="width: 100%"></td>'
										]).draw(false);
									}else{
										codeTable.row.add([
											'<td><input type="text" class="form-control imeiS" name="imeiS[]" value="'+response.data.code[a].sd_specificcode+'" style="width: 100%" readonly></td>',
											'<td><input type="text" class="form-control imeiI" name="imeiI[]" style="width: 100%" readonly></td>'
										]).draw(false);
									}									
								}

							}else if(countT > QtyS){

								for(var a = 0; a < countT; a++){

									if(a < QtyS){
										codeTable.row.add([
											'<td><input type="text" class="form-control imeiS" name="imeiS[]" value="'+response.data.code[a].sd_specificcode+'" style="width: 100%" readonly></td>',
											'<td><input type="text" class="form-control imeiI" name="imeiI[]" style="width: 100%"></td>'
										]).draw(false);
									}else{
										codeTable.row.add([
											'<td><input type="text" class="form-control imeiS" name="imeiS[]" style="width: 100%" readonly></td>',
											'<td><input type="text" class="form-control imeiI" name="imeiI[]" style="width: 100%" ></td>'
										]).draw(false);
									}
								}

							}else{

								codeTable.row.add([
									'<td><input type="text" class="form-control imeiS" name="imeiS[]" value="'+response.data.code[a].sd_specificcode+'" style="width: 100%" readonly></td>',
									'<td><input type="text" class="form-control imeiI" name="imeiI[]" style="width: 100%"></td>'
								]).draw(false);

							}
						});

						$('#divTableCode').css("display", "block");

					}else if(speccode == 'Y' && expired == 'Y'){

						for(var i = 0; i < countT; i++){
							codeTable.row.add([
								'<td><input type="text" class="form-control imeiS" name="imeiS[]" style="width: 100%"></td>',
                                '<td><input type="text" class="form-control imeiI" name="imeiI[]" style="width: 100%"></td>',
								'<td class="text-align-left"><select name="" id="" style="width: 20%; float: left" class="form-control"><option value="" selected disabled>TGL</option></select><select name="" id="" style="width: 40%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>BULAN</option></select><select name="" id="" style="width: 30%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>TAHUN</option></select></td>'
							]).draw(false);
						}

						$('#divTableCode').css("display", "block");

						$('#divTableCodeExp').css("display", "block");

					}else if(speccode == 'N' && expired == 'Y'){

						$('#divTableExp').css("display", "block");

					}

				}

			}else{
				$('#divTableCode').css("display", "none");
				$('#divTableExp').css("display", "none");
				$('#divTableCodeExp').css("display", "none");
			}

		});

		$('#tambahModal').on('hidden.bs.modal', function () {
			$('#idItem').val('');
			$('#nameItem').val('');
			$('#aksiSelect').val('');
			$('#osQtyS').val('');
			$('#osQtyR').val('');

			$('#divQtyHpp').css("display", "none");
			$('#divBtnAksi').css("display", "none");
			$('#divTableCode').css("display", "none");
			$('#divTableExp').css("display", "none");
			$('#divTableCodeExp').css("display", "none");
		});

		$('#osQtyR').blur(function(){
			var QtyS = $('#osQtyS').val();
			var QtyR = $('#osQtyR').val();
			if(QtyR != QtyS){
				$('#divAksi').css("display", "block");
			}else{
				$('#divAksi').css("display", "none");
			}

			$('#divBtnAksi').css("display", "block");
		});
		
        function tambah(){
            $('#tambahModal').modal('show');
        }

		function simpanOs(){
			var QtyS = $('#osQtyS').val();
			var QtyR = $('#osQtyR').val();
			var idItem = $('#osItemId').val();

			var ar = $()
			for (var i = 0; i < codeTable.rows()[0].length; i++) { 
				ar = ar.add(codeTable.row(i).node())
			}
			var data = ar.find('select,input,textarea').serialize() +'&qtyR='+QtyR+'&qtyS='+QtyS+'&idItem='+idItem;
			axios.post(baseUrl+'/inventory/opname-barang/tambah', data)
			.then((response) => {
				
			});
		}

        function edit(id){
            location.href = ('{{ url('/man-penjualan/rencana-penjualan/edit') }}/'+id);
        }

		function detil(id){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil Data...');

			axios.get(baseUrl+'/man-penjualan/rencana-penjualan/detail'+'/'+id).then((response) => {

				$('#spNota').text(response.data.sp.sp_nota);
				$('#spCabang').text(response.data.sp.c_name);

				for(var i=0; i<response.data.data.length; i++){

					table.row.add([
						i+1,
						response.data.data[i].i_nama,
						response.data.data[i].qty
					]).draw(false);
				}

				$('#overlay').fadeOut(200);
				$('#detilModal').modal('show');
			});
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

		function hapus(id){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan manghapus data Rencana Pembelian ini ?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menyimpan Perubahan Data...');

					axios.get(baseUrl+'/man-penjualan/rencana-penjualan/hapus'+'/'+id).then((response) => {
						if(response.data.status == 'hrpSukses'){
							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Berhasil",
								content : 'Data Rencana Penjualan '+response.data.data+' Berhasil Dihapus !',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});
							location.reload();
						}else{
							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Maaf, Data Rencana Penjualan "+response.data.data+" Gagal Dihapus ",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});
						}
					});
				}
			});
		}
    </script>
@endsection