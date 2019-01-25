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
                    Manajemen Penjualan <span><i class="fa fa-angle-double-right"></i> Edit Rencana Penjualan </span>
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
                        <h2><strong>Form Edit Rencana Penjualan</strong></h2>

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
                            <form id="erpForm" class="form-inline" role="form">
								{{csrf_field()}}
                                @foreach ($sp as $sales_plan)
                                <fieldset>
									<div class="row">
										<div class="col-sm-12 col-md-12 col-lg-12 no-padding">

											<div class="form-group col-md-12">
                                                <div class="col-md-7 inputGroupContainer">
                                                    <div class="input-group" style="width: 100%">
														<span class="input-group-addon" style="width: 40px"><i class="fa fa-building"></i></span>
														<input type="hidden" id="erpCompId" name="erpCompId" value="{{ $sales_plan->sp_comp }}">
														<input type="text" class="form-control" id="erpCompNama" value="{{ $sales_plan->c_name }}" placeholder="Masukkan Nama Cabang" style="text-transform: uppercase" readonly/>												
                                                    </div>													
                                                </div>
                                                
                                                <input type="hidden" id="sp_id" value="{{ $id }}">
                                                <input type="hidden" id="sp_nota" value="{{ $sales_plan->sp_nota }}">
                                                <label class="col-md-2"><h4><b>No. Nota :</b></h4></label>
                                                <div class="col-md-3 text-align-right">                                                   
                                                    <h4>{{ $sales_plan->sp_nota }}</h4>
                                                </div>                                                
											</div>

											<div class="form-group col-md-12 padding-top-10">
												<div class="col-md-7 inputGroupContainer">
                                                    <div class="input-group" style="width: 100%">
														<span class="input-group-addon" style="width: 40px"><i class="fa fa-barcode"></i></span>
														<input type="hidden" id="erpItemId">														                                                        
													    <input type="text" class="form-control" id="erpItemNama" placeholder="Masukkan Nama/Kode Barang" style="text-transform: uppercase"/>
                                                    </div>                                                    
												</div>
												
												<div class="col-md-3 inputGroupContainer">
                                                    <div class="input-group" style="width: 100%">
                                                        <span class="input-group-addon" style="width: 40px"><i class="fa fa-sort-numeric-desc"></i></span>                                                        
													    <input type="text" class="form-control" id="erpQty" placeholder="Qty">
                                                    </div>                                                    
												</div>

												<div class="col-md-2">
													<a class="btn btn-success" style="width: 100%" onclick="tambah_row()"><i class="fa fa-plus"></i>Tambah</a>
												</div>
											</div>
										</div>
									</div>
									
                                    <div class="col-md-12">

                                        <table id="erpTable" class="table table-striped table-bordered table-hover erpTable" width="100%">
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
                                            <a class="btn btn-block btn-primary text-center" onclick="simpan_erp()">Simpan Perubahan Rencana Penjualan</a>
                                        </div>
                                    </div>
                                </div>
								@endforeach
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
			table = $('#erpTable').DataTable({
                "searching": false,
                "paging": false,
                "info": false
            });

            var comp = $('#erpCompNama').val();
            var id = $('#sp_id').val();
            axios.get(baseUrl+'/man-penjualan/rencana-penjualan/edit-dt'+'/'+id).then((response) => {

                for(var i=0; i<response.data.data.length; i++){
                    table.row.add([
                        comp,
                        response.data.data[i].i_nama+'<input type="hidden" name="idItem[]" class="idItem" value="'+response.data.data[i].itemId+'">',
                        '<input type="number" class="form-control text-align-right erpQty" style="width: 100%" name="qtyItem[]" value="'+response.data.data[i].qty+'">',
                        '<div class="text-center"><button type="button" class="btn btn-danger btn-circle btnhapus"><i class="fa fa-remove"></i></button></div>'		
                    ]).draw(false);
                    $('.erpQty').maskMoney({precision: 0, thousands: '.'});
                
                    var inputs = document.getElementsByClassName( 'idItem' ),
                    names  = [].map.call(inputs, function( input ) {
                        return input.value;
                    });

                    $( "#erpItemNama" ).autocomplete({
                        source: function(request, response) {
                            $.getJSON(baseUrl+'/penjualan/pemesanan-barang/get-item', { idItem: names, term: $("#erpItemNama").val() }, 
                                    response);
                        },
                        minLength: 2,
                        select: function(event, data) {
                            $('#erpItemId').val(data.item.id);
                            $('#erpItemNama').val(data.item.label);
                        }
                    });
                }
                
            });            

            var input = document.getElementById("erpQty");
			input.addEventListener("keyup", function(event) {
				event.preventDefault();
				if (event.keyCode === 13) {
                    tambah_row();
				}
            });
            
		});

        function tambah_row(){
            if($('#erpItemId').val() == ''){
                $.smallBox({
                    title : "Gagal",
                    content : "Maaf, Data Item Harus Diisi untuk menambahkan Data ",
                    color : "#A90329",
                    timeout: 4000,
                    icon : "fa fa-times bounce animated"
                });
                return false;
            }
            if($('#erpQty').val() == ''){
                $($('#erpQty').val(1));
            }
			var compName = $('#erpCompNama').val();
			var itemId =  $('#erpItemId').val();
			var itemName = $('#erpItemNama').val();
			var qty = $('#erpQty').val();

			table.row.add([
				compName,
				itemName+'<input type="hidden" name="idItem[]" class="idItem" value="'+itemId+'">',
				'<input type="number" min="1" class="form-control qtyItem" style="width: 100%; text-align: right;" name="qtyItem[]" value="'+qty+'">',
				'<div class="text-center"><button type="button" class="btn btn-danger btn-circle btnhapus"><i class="fa fa-remove"></i></button></div>'		
            ]).draw(false);
            
            var inputs = document.getElementsByClassName( 'idItem' ),
			names  = [].map.call(inputs, function( input ) {
				return input.value;
			});

			$( "#erpItemNama" ).autocomplete({
				source: function(request, response) {
					$.getJSON(baseUrl+'/penjualan/pemesanan-barang/get-item', { idItem: names, term: $("#erpItemNama").val() }, 
							response);
				},
				minLength: 2,
				select: function(event, data) {
					$('#erpItemId').val(data.item.id);
					$('#erpItemNama').val(data.item.label);
				}
			});

            $('#erpItemId').val('');
			$('#erpItemNama').val('');
            $('#erpQty').val('');
            $('#erpItemNama').focus();
		}

        $('.erpTable tbody').on( 'click', 'button.btnhapus', function () {
            table.row( $(this).parents('tr') ).remove().draw();
            var inputs = document.getElementsByClassName( 'idItem' ),
			names  = [].map.call(inputs, function( input ) {
				return input.value;
			});

			$( "#erpItemNama" ).autocomplete({
				source: function(request, response) {
					$.getJSON(baseUrl+'/penjualan/pemesanan-barang/get-item', { idItem: names, term: $("#erpItemNama").val() }, 
							response);
				},
				minLength: 3,
				select: function(event, data) {
					$('#erpItemId').val(data.item.id);
					$('#erpItemNama').val(data.item.label);
				}
			});
        });

        function simpan_erp(){
            $('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Menyimpan Perubahan Data...');            

            var id = $('#sp_id').val();
            axios.post(baseUrl+'/man-penjualan/rencana-penjualan/edit'+'/'+id, $('#erpForm').serialize()).then((response) => {
                if(response.data.status == 'erpSukses'){
                    $('#overlay').fadeOut(200);
					$.smallBox({
						title : "Berhasil",
						content : 'Perubahan Data Rencana Penjualan Berhasil Disimpan...!',
						color : "#739E73",
						timeout: 4000,
						icon : "fa fa-check bounce animated"
					});
					// window.open(" {{ url('/penjualan/pemesanan-barang/print?id=') }} "+ response.nota);
					location.reload();
                } else{
                    $('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Maaf, Perubahan Data Rencana Penjualan Gagal Disimpan ",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});
                }
            })
        }
        
	</script>
@endsection