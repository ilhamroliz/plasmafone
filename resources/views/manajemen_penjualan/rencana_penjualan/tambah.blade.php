@extends('main')

@section('title', 'Pembuatan Rencana Penjualan')

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
														<input type="hidden" id="trpCompId" name="trpCompId">
													    <input type="text" class="form-control" id="trpCompNama" placeholder="Masukkan Nama Cabang" style="text-transform: uppercase"/>												
                                                    </div>													
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
													    <input type="text" class="form-control" id="trpQty" placeholder="Qty">
                                                    </div>                                                    
												</div>

												<div class="col-md-2">
													<a class="btn btn-success" style="width: 100%" onclick="tambah_row()"><i class="fa fa-plus"></i>Tambah</a>
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
	<script type="text/javascript">

		var table;

		$(document).ready(function(){

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
				}
			});

			$( "#trpItemNama" ).autocomplete({
				source: baseUrl+'/penjualan/set-harga/outlet/auto-CodeNItem',
				minLength: 2,
				select: function(event, data) {
					$('#trpItemId').val(data.item.id);
					$('#trpItemNama').val(data.item.label);
				}
			});
		});

		function tambah_row(){
			var compId = $('#trpCompId').val();
			var compName = $('#trpCompNama').val();
			var itemId =  $('#trpItemId').val();
			var itemName = $('#trpItemNama').val();
			var qty = $('#trpQty').val();

			table.row.add([
				compName+'<input type="hidden" name="idComp[]" class="idComp" value="'+compId+'">',
				itemName+'<input type="hidden" name="idItem[]" class="idItem" value="'+itemId+'">',
				'<input type="text" min="1" class="form-control qtyItem" style="width: 100%; text-align: right;" name="qtyItem[]" value="'+qty+'">',
				'<div class="text-center"><button type="button" class="btn btn-danger btn-circle btnhapus"><i class="fa fa-remove"></i></button></div>'		
			]).draw(false);

			$('#trpItemNama').val('');
			$('#trpQty').val('');
		}

		$('.trpTable tbody').on( 'click', 'button.btnhapus', function () {
            table.row( $(this).parents('tr') ).remove().draw();
        });

		function simpan_trp(){
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