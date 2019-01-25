@extends('main')

@section('title', 'Pembuatan Rencana Penjualan')

@section('extra_style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/MonthPicker.css') }}">
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
                    Manajemen Penjualan <span><i class="fa fa-angle-double-right"></i> Tambah Rencana Penjualan </span>
                </h1>
			</div>
			
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">
                <div class="page-title">
                    <a href="{{ url('man-penjualan/rencana-penjualan') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
                </div>
            </div>
		</div>

		
		<div class="row">

            <div class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

            <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false" role="widget">
                    
                    <header role="heading">
                        <div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                        </div>
                        <h2><strong>Form Tambah Rencana Penjualan</strong></h2>

                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <form id="trpForm" class="form-inline" role="form">
                                {{csrf_field()}}
                                <fieldset>
									<div class="row">
										<div class="col-sm-12 col-md-12 col-lg-12 no-padding">
											<div class="form-group col-md-12">
                                                <div class="col-md-7 inputGroupContainer">
													<div class="input-group" style="width: 100%">
														<span class="input-group-addon" style="width: 40px"><i class="fa fa-building"></i></span>
														<select class="select2" id="trpCompId" name="trpCompId">
															<option value="">=== PILIH OUTLET ===</option>
															@if(Auth::user()->m_comp == "PF00000001")
															@foreach($outlet as $toko)
																<option value="{{ $toko->c_id }}">{{ $toko->c_name }}</option>
															@endforeach
															@else
															@foreach($outlet as $toko)
																@if($toko->c_id == Auth::user()->m_comp)
																<option value="{{ $toko->c_id }}" selected>{{ $toko->c_name }}</option>
																@endif
															@endforeach
															@endif
														</select>
													</div>												
												</div>
												<label class="col-md-2"><strong>Rencana Untuk Bulan</strong></label>
												<div class="col-md-3">
													<input type="text" id="bulanRencana" name="bulanRencana" class="form-control" placeholder="MASUKKAN BULAN" style="width: 100%">                                       
												</div>
											</div>

											<div class="form-group col-md-12 padding-top-10">
												<div class="col-md-7 inputGroupContainer">
                                                    <div class="input-group" style="width: 100%">
														<span class="input-group-addon" style="width: 40px"><i class="fa fa-barcode"></i></span>
														<input type="hidden" id="trpItemId">														                                                        
													    <input type="text" class="form-control" id="trpItemNama" placeholder="Masukkan Nama/Kode Barang" style="text-transform: uppercase"/>
                                                    </div>                                                    
												</div>
												
												<div class="col-md-3 inputGroupContainer">
                                                    <div class="input-group" style="width: 100%">
                                                        <span class="input-group-addon" style="width: 40px"><i class="fa fa-sort-numeric-desc"></i></span>                                                        
													    <input type="number" class="form-control" id="trpQty" placeholder="Qty">
                                                    </div>                                                    
												</div>

												<div class="col-md-2">
													<a class="btn btn-success" id="addRow" style="width: 100%" onclick="tambah_row()"><i class="fa fa-plus"></i>Tambah</a>
												</div>
											</div>
										</div>
									</div>
									
                                    <div class="col-md-12">

                                        <table id="trpTable" class="table table-striped table-bordered table-hover trpTable" width="100%">
                                            <thead>
                                                <tr>
													<th data-hide="phone,tablet" style="width: 25%">Nama Outlet</th>
                                                    <th data-hide="phone,tablet" style="width: 45%">Nama Barang</th>													
                                                    <th data-hide="phone,tablet" style="width: 20%">Qty</th>
                                                    <th data-hide="phone,tablet" style="width: 10%">Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
									
									</div>
									
									<div class="col-md-12 no-padding">
										<div class="col-md-2">
											<label><b>KETERANGAN :</b></label>
										</div>

										<div class="col-md-10 inputGroupContainer">
											<div class="input-group" style="width: 100%">
												<textarea class="form-control" name="trpKet" id="trpKet" rows="2"></textarea>
											</div>
										</div>
									</div>
                                </fieldset>

								<div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-block btn-primary text-center" onclick="simpan_trp()">Simpan Rencana Penjualan</a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- end widget content -->
                    </div>
                    <!-- end widget div -->
                </div>
            <!-- end widget -->
			</div>
		</div>

    </div>
@endsection

@section('extra_script')
	<script src="{{ asset('template_asset/js/MonthPicker.js') }}"></script>
	<script type="text/javascript">

		var table;

		$(document).ready(function(){

			$('#bulanRencana').MonthPicker({
                Button: false
            });

			table = $('#trpTable').DataTable({
				"paging": false,
				"info": false,
				"searching": false
			});
			
			$( "#trpCompNama" ).autocomplete({
				source: baseUrl+'/man-penjualan/rencana-penjualan/auto-comp',
				minLength: 2,
				select: function(event, data) {
					$('#trpCompId').val(data.item.id);
					$('#trpCompNama').val(data.item.label);
					document.getElementById("trpCompNama").readOnly = true;
				}
			});

			$( "#trpItemNama" ).autocomplete({
				source: baseUrl+'/penjualan/pemesanan-barang/get-item',
				minLength: 2,
				select: function(event, data) {
					$('#trpItemId').val(data.item.id);
					$('#trpItemNama').val(data.item.label);
				}
			});

			var input = document.getElementById("trpQty");
			input.addEventListener("keyup", function(event) {
				event.preventDefault();
				if (event.keyCode === 13) {
					document.getElementById("addRow").click();
				}
			});
		});

		function tambah_row(){
			if($('#trpCompId').val() == ''){
				$.smallBox({
					title : "Gagal",
					content : "Maaf, Masukkan Data OUTLET Harus Diisi Dulu ",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});
				return false;
			}

			if($('#trpItemId').val() == ''){
				$.smallBox({
					title : "Gagal",
					content : "Maaf, Masukkan Data BARANG Harus Diisi Dulu ",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});
				return false;
			}

			if($('#trpQty').val() == ''){
				$('#trpQty').val(1);
			}

			var compId = $('#trpCompId').val();
			var compName = $('#trpCompId option:selected').text();
			var itemId =  $('#trpItemId').val();
			var itemName = $('#trpItemNama').val();
			var qty = $('#trpQty').val();

			table.row.add([
				compName+'<input type="hidden" name="idComp[]" class="idComp" value="'+compId+'">',
				itemName+'<input type="hidden" name="idItem[]" class="idItem" value="'+itemId+'">',
				'<input type="number" min="1" class="form-control qtyItem" style="width: 100%; text-align: right;" name="qtyItem[]" value="'+qty+'">',
				'<div class="text-center"><button type="button" class="btn btn-danger btn-circle btnhapus"><i class="fa fa-remove"></i></button></div>'		
			]).draw(false);

			var inputs = document.getElementsByClassName( 'idItem' ),
			names  = [].map.call(inputs, function( input ) {
				return input.value;
			});

			$( "#trpItemNama" ).autocomplete({
				source: function(request, response) {
					$.getJSON(baseUrl+'/penjualan/pemesanan-barang/get-item', { idItem: names, term: $("#trpItemNama").val() }, 
							response);
				},
				minLength: 2,
				select: function(event, data) {
					$('#trpItemId').val(data.item.id);
					$('#trpItemNama').val(data.item.label);
				}
			});


			$('#trpItemNama').val('');
			$('#trpQty').val('');
			$('#trpItemNama').focus();
		}

		$('.trpTable tbody').on( 'click', 'button.btnhapus', function () {
			table.row( $(this).parents('tr') ).remove().draw();
			var inputs = document.getElementsByClassName( 'idItem' ),
			names  = [].map.call(inputs, function( input ) {
				return input.value;
			});

			$( "#trpItemNama" ).autocomplete({
				source: function(request, response) {
					$.getJSON(baseUrl+'/penjualan/pemesanan-barang/get-item', { idItem: names, term: $("#trpItemNama").val() }, 
							response);
				},
				minLength: 2,
				select: function(event, data) {
					$('#trpItemId').val(data.item.id);
					$('#trpItemNama').val(data.item.label);
				}
			});
        });

		function simpan_trp(){

			if($('#trpCompId').val() == ''){
				$.smallBox({
					title : "Gagal",
					content : "Maaf, Data Nama CABANG Tidak Boleh Kosong ",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});
				return false;
			}

			if($('#bulanRencana').val() == ''){
				$.smallBox({
					title : "Gagal",
					content : "Maaf, Masukkan BULAN Tidak Boleh Kosong ",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});
				return false;
			}

			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Menyimpan Perubahan Data...');

			axios.post(baseUrl+'/man-penjualan/rencana-penjualan/add', $('#trpForm').serialize()).then((response) => {

				if(response.data.status == 'trpSukses'){

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Berhasil",
						content : 'Data Rencana Penjualan Berhasil Disimpan...!',
						color : "#739E73",
						timeout: 4000,
						icon : "fa fa-check bounce animated"
					});
					// window.open(" {{ url('/penjualan/pemesanan-barang/print?id=') }} "+ response.nota);
					location.reload();

				}else if(response.data.status == 'ada'){

					$('#overlay').fadeOut(200);
					var cabang = $('#trpCompNama').val()
					$.smallBox({
						title : "Gagal",
						content : "Maaf, Data Rencana Penjualan untuk outlet "+cabang+" Sudah Ada",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});

				}else{

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Maaf, Data Rencana Penjualan Gagal Disimpan ",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});

				}
			})
		}
	</script>
@endsection