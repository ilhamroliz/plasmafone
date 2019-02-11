@extends('main')

@section('title', 'Inventory|Penerimaan Barang Dari Distribusi')

@section('extra_style')

@endsection

<?php 
use App\Http\Controllers\PlasmafoneController as Access;
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
			<li>Home</li><li>Inventory</li><li>Penerimaan Barang Dari Supplier</li>
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

					Inventory <span><i class="fa fa-angle-double-right"></i> Penerimaan Barang Dari Supplier </span>

				</h1>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/inventory/penerimaan/supplier') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

				</div>

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

                    <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

                        <header>

                                <h2><strong>Supplier</strong></h2>
                            
                        </header>

                        <div>
                            
                            <div class="widget-body">

                                <form class="form-horizontal" method="post">
                                    {{ csrf_field() }}

                                    <fieldset>  

                                        <div class="row">
                                            <input type="hidden" id="id" value="{{ $id }}">

                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                                <div class="form-group">

                                                    <label class="col-xs-4 col-lg-4 control-label text-left">No. Nota</label>

                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">

                                                        <div class="input-group">

                                                            <span class="input-group-addon"><i class="fa fa-building"></i></span>

                                                            <input type="text" class="form-control" readonly style="text-transform: uppercase" value="{{ $getData[0]->p_nota }}" />

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Nama Supplier</label>

                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">

                                                        <div class="input-group">

                                                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                                            <input type="text" class="form-control" style="text-transform: uppercase" readonly value="{{ $getData[0]->s_company }}" />

                                                        </div>

                                                    </div>

                                                </div>

                                            </article>
                                            
                                        </div>

                                    </fieldset>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

						<header>
							
                            <h2><strong>Daftar Item</strong></h2>

						</header>

						<div>
							
							<div class="widget-body no-padding">

								<table id="dt_active" class="table table-striped table-bordered table-hover" width="100%">

                                    <thead>		

                                        <tr>

                                            <th><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>

											<th><i class="fa fa-fw fa-cube txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Qty</th>
											
											<th><i class="fa fa-fw fa-cube txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Qty Diterima</th>

                                            <th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>

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

			<!-- end row -->

			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>

							<h4 class="modal-title" id="myModalLabel"><strong>Jumlah barang yang diterima</strong></h4>

						</div>
						<form id="form_qtyReceived">{{ csrf_field() }}
							<div class="modal-body">

								<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="text-center col-md-12 control-label" id="nama_item" style="font-weight:bold"></label>
											</div>
										</div>
								</div><br>
				
								<div class="row terima">
									
								</div>

                                <div class="row" id="tbl_kode" style="display: none;">

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                        <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

                                            <header>

                                                <h2><strong>Daftar kode yang sudah diterima</strong></h2>

                                            </header>

                                            <div>

                                                <div class="widget-body no-padding">

                                                    <table id="dt_code" class="table table-striped table-bordered table-hover" width="100%">

                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" width="70%"><i class="fa fa-fw fa-building txt-color-blue"></i>&nbsp;Kode</th>
                                                                <th class="text-center" width="30%"><i class="fa fa-fw fa-cube txt-color-blue"></i>&nbsp;Aksi</th>
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
						</form>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" onclick="hapus()">
								Batal
							</button>
							<button type="button" id="simpan" class="btn btn-primary" onclick="simpan()" disabled>
								Simpan
							</button>
						</div>

					</div><!-- /.modal-content -->

				</div><!-- /.modal-dialog -->

			</div>
            <!-- /.modal -->
            
            <!-- Modal -->
			<div class="modal fade" id="frontModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>

							<h4 class="modal-title" id="myModalLabel"><strong>Jumlah barang yang diterima</strong></h4>

						</div>
						<form id="form_qtyReceived">{{ csrf_field() }}
							<div class="modal-body">

								<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="text-center col-md-12 control-label" id="nama_item" style="font-weight:bold"><h2>Masukkan Jumlah Barang Yang Diterima</h2></label>
											</div>
										</div>
								</div><br>

                                <div class="row">

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                        <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                                            
                                            <section class="text-center">
                                                <label><h4 id="maksJumlah"></h4></label>
                                                <input type="hidden" id="idMaks">
                                                <input type="hidden" id="itemMaks">
                                            </section>
                                            <section class="">
                                                <input type="text" id="jumlah" class="form-control" style="text-align: center" placeholder="Masukkan Jumlah Disini">
                                            </section>

                                        </div>

                                    </div>
                                </div>
				
							</div>
						</form>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" onclick="hapus()">
								Batal
							</button>
							<button type="button" id="lanjutkan" class="btn btn-primary" onclick="terima()" disabled>
								Lanjutkan
							</button>
						</div>

					</div><!-- /.modal-content -->

				</div><!-- /.modal-dialog -->

			</div>
			<!-- /.modal -->

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
		var aktif, tbl_code, rows = null;

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

            $(document).ready( function() {
                $('#dt_code').DataTable({
                    "pageLength": 5,
                    "searching": false,
                    "lengthChange": false,
                    "autoWidth": false
                });
            });
            
			setTimeout(function () {

				aktif = $('#dt_active').DataTable({
					"processing": true,
					"serverSide": true,
					"orderable": false,
					"order": [],
					"ajax": "{{ url('/inventory/penerimaan/supplier/get-item?id='.$id) }}",
                    "columnDefs": [
                        { className: 'text-center', targets: [1, 2] }
                    ],
					"columns":[
						{"data": "i_nama"},
						{"data": "qty"},
						{"data": "qtyr"},
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

			}, 500);

        /* END BASIC */

		function refresh_tab(){
		    aktif.ajax.reload();
        }

        function fm(id, item){

            axios.get(baseUrl+'/inventory/penerimaan/supplier/getMaks'+'/'+id+'/'+item).then((response) => {

                $('#maksJumlah').html('Jumlah Maksimal Adalah '+response.data.maks);
                $('#idMaks').val(id);
                $('#itemMaks').val(item);

                $("#jumlah").on("keypress",function (event) {
                    if ((event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }                   
                });

                $("#jumlah").on("keyup",function (event) {
                    if ($("#jumlah").val() != ""){
                        $('#lanjutkan').attr("disabled", false);
                        if (event.which == 13){
                            $('#lanjutkan').click();
                        }
                    } else {
                        $('#lanjutkan').attr("disabled", true);
                    }
                });
                $('#frontModal').modal('show');

            });
        }

		function terima(){
            $('#frontModal').modal('hide');
            var qty = 0, qtyReceived = 0;
            var id = $('#idMaks').val();
            var item = $('#itemMaks').val();
			hapus();
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil Data...');
			var row = '';
			axios.get(baseUrl+'/inventory/penerimaan/supplier/item-receive/'+id+'/'+item).then(response => {
                console.log(response);
				if (response.data.status == 'Access denied') {

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
						color : "#A90329",
						timeout: 5000,
						icon : "fa fa-times bounce animated"
					});

				} else {

					if (response.data.qtySisa == null) {
						qty = 0;
					} else {
						qty = response.data.qtySisa;
					}

					if (response.data.sum_qtyReceived == null) {
						qtyReceived = 0;
					} else {
						qtyReceived = response.data.sum_qtyReceived;
					}

					if (response.data.specificcode == 'Y') {
                        rows = "kode";

						row = '<div id="form_qty">' +
                                '<fieldset>' +
                                    '<div class="form-group">' +
                                        '<label class="col-md-4 control-label">Nota Delivery Order</label>' +
                                        '<div class="col-md-8">' +
                                            '<div class="input-group">' +
                                                '<input type="text" name="notaDO" id="notaDO" class="notaDO form-control">'+
                                                '<span class="input-group-addon"><i class="fa fa-"></i></span>' +
                                            '</div>' +
                                            '<span class="help-block"></span>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div id="error" class="form-group ">' +
                                        '<label class="col-md-4 control-label">Kode Spesifik</label>' +
                                        '<div class="col-md-8">' +
                                            '<div class="input-group">' +
                                                '<input type="hidden" value="Y" name="status">'+
                                                '<input type="hidden" value="'+response.data.id+'" name="idpo">'+
                                                '<input type="hidden" value="'+response.data.iddetail+'" name="iddetail">'+
                                                '<input type="hidden" value="'+response.data.supplier+'" name="supplier">'+
                                                '<input type="hidden" value="'+response.data.itemId+'" name="iditem">'+
                                                '<input type="hidden" value="'+response.data.qty+'" name="qtysupplier">'+
                                                '<input type="text" id="kode" name="kode" class="kode form-control">' +
                                                '<span class="input-group-addon"><i class="fa fa-barcode" id="icon"></i></span>' +
                                            '</div>' +
                                            '<span id="message" class="help-block"></span>' +
                                        '</div>' +
                                    '</div>' +
                                '</fieldset>'+
                            '</div>';
                        
                        $(".terima").html(row);
                        $("#kode").focus();
                        $("#tbl_kode").show();

                        $('#kode').on('keyup', function(){

                            if (event.which == 13){
                                $('#dt_co').DataTable().row.add([
                                    '<div><input class="form-control"></div>',
                                    '<div><button class="btn btn-danger btn-circle"><i class="fa fa-close"></i></button></div>'
                                ]).draw();
                            }

                        });

					} else {
                        rows = null;
						{{--  row = '<div id="form_qty">'+
                                '<fieldset>' +
                                    '<div class="form-group">' +
                                        '<label class="col-md-4 control-label">Kuantitas yang sudah diterima</label>' +
                                        '<div class="col-md-8">' +
                                            '<div class="input-group">' +
                                                '<input type="text" readonly value="'+qtyReceived+'" name="qtyreceived" id="qty_received" class="qty form-control">'+
                                                '<span class="input-group-addon"><i class="fa fa-database"></i></span>' +
                                            '</div>' +
                                            '<span class="help-block"></span>' +
                                        '</div>' +
                                    '</div>'+
                                    '<div class="form-group">' +
                                        '<label class="col-md-4 control-label">Kuantitas</label>' +
                                        '<div class="col-md-8">' +
                                            '<div class="input-group">' +
                                                '<input type="hidden" value="N" name="status">'+
                                                '<input type="hidden" value="'+qtyReceived+'" name="qtyR">'+
                                                '<input type="hidden" value="'+response.data.id+'" name="idpo">'+
                                                '<input type="hidden" value="'+response.data.iddetail+'" name="iddetail">'+
                                                '<input type="hidden" value="'+response.data.supplier+'" name="supplier">'+
                                                '<input type="hidden" value="'+response.data.itemId+'" name="iditem">'+
                                                '<input type="hidden" value="'+response.data.qty+'" name="qtysupplier">'+
                                                '<input type="hidden" value="'+response.data.qtySisa+'" name="qtysisa">'+
                                                '<input type="text" id="qty" name="qty" class="qty form-control">'+
                                                '<span class="input-group-addon"><i class="fa fa-cubes"></i></span>' +
                                            '</div>' +
                                            '<span class="help-block"></span>' +
                                        '</div>' +
                                    '</div>' +
                                '</fieldset>' +
								'</div>';  --}}

                        $(".terima").append(row);
                        $("#qty").focus();
                        $("#tbl_kode").hide();
                        $(".qty").on("keypress",function (event) {
                            $(this).val($(this).val().replace(/[^\d].+/, ""));
                            if ((event.which < 48 || event.which > 57)) {
                                event.preventDefault();
                            }

                            if ($(this).val() != null || $(this).val() != ""){
                                $('#simpan').attr("disabled", false);
                            } else {
                                $('#simpan').attr("disabled", true);
                            }
                            if (event.which == 13){
                                simpan();
                            }

                        });

                        $(".qty").on("keyup", function (event){
                            event.preventDefault();
                            var input = parseInt($(this).val());

                            if (isNaN(input)){
                                input = 0;
                            }
                            if (input > parseInt(response.data.qtySisa)){
                                $(this).val(response.data.qtySisa);
                            }
                        });
					}

					$('#nama_item').html(response.data.nama_item);
					$('#overlay').fadeOut(200);
					$('#myModal').modal('show');

				}

				})
		}

		function hapus() {
			$('#form_qty').remove();
		}

		function qtyTerima(qtySisa) {
			var input = parseInt($("#qty").val());
			if (isNaN(input)){
				input = 0;
			}
			if (input > parseInt(qtySisa)){
				$("#qty").val(input);
			}
		}

		function simpan() {
            $('#overlay').fadeIn(200);
            
            axios.post(baseUrl+'/inventory/penerimaan/supplier/item-receive/add', $('#form_qtyReceived').serialize()).then((response) => {

                if(response.data.status == 'sukses'){

                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title : "Berhasil",
                        content : 'Transaksi Anda berhasil...!',
                        color : "#739E73",
                        timeout: 3000,
                        icon : "fa fa-check bounce animated"
                    });

                    if (rows == "kode") {
                        tbl_code.ajax.reload();
                        $("#kode").val('');
                        $("#qtyreceived").val(parseInt($("#qtyreceived").val()) + 1);
                        $("#error").removeClass("has-success");
                        $("#error").removeClass("has-error");
                        $("#icon").removeClass("fa fa-check");
                        $("#icon").removeClass("glyphicon glyphicon-remove-circle");
                        $("#icon").addClass("fa fa-barcode");
                        $("#message").html("");
                        $("#simpan").attr("disabled", true);
                    } else if (rows == null) {
                        $("#qty_received").val(parseInt($("#qty_received").val()) + 1);
                        $("#qty").val('');
                        $('#myModal').modal('hide');
                    }

                    refresh_tab();

                }else if(response.data.status == 'ada'){

                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title : "Peringatan!",
                        content : "Kode sudah ada!",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                    $('#kode').focus();
                    $("#error").removeClass("has-success");
                    $("#error").addClass("has-error");
                    $("#icon").removeClass("fa fa-barcode");
                    $("#icon").removeClass("fa fa-check");
                    $("#icon").addClass("glyphicon glyphicon-remove-circle");
                    $("#message").html("Kode tidak ditemukan");
                    $("#simpan").attr("disabled", true);

                }else{

                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title : "Gagal",
                        content : "Upsss. Terjadi kesalahan. Cobalah beberapa saat lagi ...",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });

                }

            })
			
		}

	</script>

@endsection
