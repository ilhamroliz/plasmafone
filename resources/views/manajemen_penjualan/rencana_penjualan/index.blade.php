@extends('main')

@section('title', 'Pembuatan Rencana Penjualan')

@section('extra_style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/MonthPicker.css') }}">
@endsection
    
<?php 
use App\Http\Controllers\PlasmafoneController as Plasma;
use Carbon\Carbon;
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
			<li>Home</li><li>Manajemen Penjualan</li><li>Rencana Pembelian Barang</li>
		</ol>

	</div>
	<!-- END RIBBON -->
@endsection

@section('main_content')
    <div id="content">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-sliders"></i>
                    Manajemen Penjualan <span><i class="fa fa-angle-double-right"></i> Pembuatan Rencana Penjualan </span>
                </h1>
            </div>

            @if(Plasma::checkAkses(26, 'insert') == true)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right padding-top-10">
                <button class="btn btn-success" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;Tambah Rencana Penjualan</button>
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
									<a data-toggle="tab" href="#hr1"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> Approved </span> </a>
								</li>

								<li>
									<a data-toggle="tab" href="#hr2"> <i style="color: #C79121;" class="fa fa-lg fa-align-justify"></i> <span class="hidden-mobile hidden-tablet"> Pending </span></a>
								</li>
							</ul>
                        </header>

                        <div>
                            <div class="widget-body no-padding">
								<form id="cariForm">
									<div class="col-md-12 no-padding padding-top-15">
										<div class="col-md-2">
											<div class="form-group">
												<input type="text" id="monthPick" name="monthPick" class="form-control" value="{{$month}}" placeholder="MASUKKAN BULAN">                                       
											</div>
										</div>
										@if(Auth::user()->m_comp != "PF00000001")
										<div class="col-md-4">
											<div class="form-group">
												<input type="hidden" id="irpCompId" name="irpCompId" value="{{ $outlet->c_id }}">
												<input type="text" class="form-control irpCompName" value="{{ $outlet->c_name }}" readonly>                                       
											</div>
										</div>
										@else
										<div class="col-md-4">
											<select class="select2" id="irpCompId" name="irpCompId">
												<option value="">Semua Outlet</option>
												@foreach($outlet as $toko)
													<option value="{{ $toko->c_id }}">{{ $toko->c_name }}</option>
												@endforeach
											</select>
										</div>
										@endif
										<div class="col-md-1">
											<a class="btn btn-primary" onclick="cari2()"><i class="fa fa-search"></i></a>
										</div>
									</div>
								</form>

                                <div class="tab-content padding-10">

                                    <div class="tab-pane fade in active" id="hr1">
										<table id="apprTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
													<th style="width: 20%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th style="width: 40%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Cabang</th>
													<th style="width: 20%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Update</th>
													<th style="width: 20%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="apprshowdata">
											</tbody>

										</table>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="hr2">
										<table id="pendTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
													<th style="width: 20%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th style="width: 40%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Cabang</th>
													<th style="width: 20%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Update</th>
													<th style="width: 20%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="pendshowdata">
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
		
		<!-- Modal untuk Detil Pemesanan -->
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

    </div>
@endsection

@section('extra_script')
<script src="{{ asset('template_asset/js/MonthPicker.js') }}"></script>
    <script type="text/javascript">
        var appr, pend;
		var table;
		var apprTab, pendTab;

        $(document).ready(function(){
			table = $('#drpTable').DataTable({
				"pageLength": 5,
				"lengthChange": false,
				"language": dataTableLanguage
			});

            $('#monthPick').MonthPicker({
                Button: false
			});
			
			// var date = {{ Carbon::now('Asia/Jakarta')->format('m/Y') }};
			// $('#monthPick').val(date);

            $('.irpCompName').autocomplete({
                source: baseUrl+'/man-penjualan/rencana-penjualan/auto-comp',
                minLength: 2,
                select: function(event, data){
                    $('#irpCompId').val(data.item.id);
                }
            })

            setTimeout(function () {

				apprTab = $('#apprTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/man-penjualan/rencana-penjualan/getApproved') }}",
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

			}, 500);

			setTimeout(function () {

				pendTab = $('#pendTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/man-penjualan/rencana-penjualan/getPending') }}",
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

			}, 1000);

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
		
        function tambah(){
            location.href = ('{{ url('/man-penjualan/rencana-penjualan/add') }}');
        }

        function edit(id){
            location.href = ('{{ url('/man-penjualan/rencana-penjualan/edit') }}/'+id);
        }

		function detil(id){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil Data...');

			var state = '';
			if($('#hr1').hasClass('active')){
				state = 'appr';
			}else if($('#hr2').hasClass('active')){
				state = 'pend';
			}

			axios.get(baseUrl+'/man-penjualan/rencana-penjualan/detail'+'/'+id+'?state='+state).then((response) => {

				$('#spNota').text(response.data.sp.sp_nota);
				$('#spCabang').text(response.data.sp.c_name);

				table.clear();
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