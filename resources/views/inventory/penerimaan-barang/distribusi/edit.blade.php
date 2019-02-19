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
			<li>Home</li><li>Inventory</li><li>Penerimaan Barang Dari Distribusi</li>
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

					Inventory <span><i class="fa fa-angle-double-right"></i> Penerimaan Barang Dari Distribusi </span>

				</h1>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/inventory/penerimaan/distribusi') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

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

                                <h2><strong>Distribusi</strong></h2>
                            
                        </header>

                        <div>
                            
                            <div class="widget-body">

                                <form class="form-horizontal" method="post">
                                    {{ csrf_field() }}

                                    <fieldset>  

                                        <div class="row">

                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                                <div class="form-group">

                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Nota</label>

                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">

                                                        <div class="input-group">

                                                            <span class="input-group-addon"><i class="fa fa-building"></i></span>

                                                            <input type="text" class="form-control" readonly style="text-transform: uppercase" value="{{ $data->nota }}" />

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Dari Outlet</label>

                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">

                                                        <div class="input-group">

                                                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                                            <input type="text" class="form-control" style="text-transform: uppercase" readonly value="{{ $data->from }}" />

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Tujuan Outlet</label>

                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">

                                                        <div class="input-group">

                                                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                                            <input type="text" class="form-control" style="text-transform: uppercase" readonly value="{{ $data->destination }}" />

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

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="hapus()">
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

                                                            <th class="text-center"><i class="fa fa-fw fa-building txt-color-blue"></i>&nbsp;Kode</th>

                                                            <th class="text-center"><i class="fa fa-fw fa-cube txt-color-blue"></i>&nbsp;Status</th>

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
								Tutup
							</button>
							{{--<button type="button" id="simpan" class="btn btn-primary" onclick="simpan()" disabled>--}}
								{{--Simpan--}}
							{{--</button>--}}
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

			setTimeout(function () {

				aktif = $('#dt_active').dataTable({
					"processing": true,
					"serverSide": true,
					"orderable": false,
					"order": [],
					"ajax": "{{ url('/inventory/penerimaan/distribusi/get-item/'.$id) }}",
                    "columnDefs": [
                        { className: 'text-center', targets: [1, 2] }
                    ],
					"columns":[
						{"data": "item"},
						{"data": "sum_qty"},
						{"data": "sum_qty_received"},
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
		    aktif.api().ajax.reload();
		}

		function terima(id, item){
            if ( $.fn.DataTable.isDataTable('#dt_code') ) {
                $('#dt_code').DataTable().destroy();
            }
            var qty = 0, qtyReceived = 0;
			hapus();
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil Data...');
			var row = '';
			axios.get(baseUrl+'/inventory/penerimaan/distribusi/item-receive/'+id+'/'+item).then(response => {
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
                                        '<label class="col-md-4 control-label">Kuantitas yang sudah diterima</label>' +
                                        '<div class="col-md-8">' +
                                            '<div class="input-group">' +
                                                '<input type="text" readonly value="'+qtyReceived+'" name="qtyreceived" id="qtyreceived" class="qty form-control">'+
                                                '<span class="input-group-addon"><i class="fa fa-check"></i></span>' +
                                            '</div>' +
                                            '<span class="help-block"></span>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div id="error" class="form-group ">' +
                                        '<label class="col-md-4 control-label">Kode Spesifik</label>' +
                                        '<div class="col-md-8">' +
                                            '<div class="input-group">' +
                                                '<input type="hidden" value="'+response.data.id+'" name="idditribusi">'+
                                                '<input type="hidden" value="'+response.data.iddetail+'" name="iddetail">'+
                                                '<input type="hidden" value="'+response.data.dari+'" name="comp">'+
                                                '<input type="hidden" value="'+response.data.tujuan+'" name="destination">'+
                                                '<input type="hidden" value="'+response.data.itemId+'" name="iditem">'+
                                                '<input type="hidden" value="'+response.data.qty+'" name="qtydistribusi">'+
                                                '<input type="hidden" value="'+response.data.qtySisa+'" name="qtysisa">'+
                                                '<input type="text" id="kode" name="kode" class="kode form-control" style="text-transform: uppercase">' +
                                                '<span class="input-group-addon"><i class="fa fa-barcode" id="icon"></i></span>' +
                                            '</div>' +
                                            '<span id="message" class="help-block"></span>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-md-12 form-group">'+
                                        '<button class="btn btn-primary pull-right" type="button" id="simpan" onclick="simpan()">'+
                                            '<i class="fa fa-floppy-o"></i>'+
                                            '&nbsp;Simpan'+
                                        '</button>'+
                                    '</div>'+
                                '</fieldset>'+
                            '</div>';

                        $(".terima").append(row);
                        $("#kode").focus();
                        $("#tbl_kode").show();

                        tbl_code = $('#dt_code').dataTable({
                            "processing": true,
                            "serverSide": true,
                            "orderable": false,
                            "order": [],
                            "ajax": "{{ url('/inventory/penerimaan/distribusi/get-item-received/'.$id) }}",
                            "columns":[
                                {"data": "dd_specificcode"},
                                {"data": "status"},
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

                        $("#kode").on("keypress",function (event) {

                            if ($(this).val() != null || $(this).val() != ""){
                                $('#simpan').attr("disabled", false);
                            } else {
                                $('#simpan').attr("disabled", true);
                            }
                            if (event.which == 13){
                                simpan();
                            }

                        });
                        $("#kode").on("input", function (evt) {
                            evt.preventDefault();
                            axios.get(baseUrl+'/inventory/penerimaan/distribusi/item-receive/check/'+response.data.itemId+'/'+$("#kode").val()+'/'+response.data.dari+'/'+response.data.tujuan).then(resp => {
                                // console.log(resp.data);
                                if (resp.data == 0) {
                                    $("#error").removeClass("has-success");
                                    $("#error").addClass("has-error");
                                    $("#icon").removeClass("fa fa-barcode");
                                    $("#icon").removeClass("fa fa-check");
                                    $("#icon").addClass("glyphicon glyphicon-remove-circle");
                                    $("#message").html("Kode tidak ditemukan");
                                    $("#simpan").attr("disabled", true);
                                } else if (resp.data == 1) {
                                    $("#error").removeClass("has-error");
                                    $("#error").addClass("has-success");
                                    $("#icon").removeClass("fa fa-barcode");
                                    $("#icon").removeClass("glyphicon glyphicon-remove-circle");
                                    $("#icon").addClass("fa fa-check");
                                    $("#message").html("Kode ditemukan");
                                    $("#simpan").attr("disabled", false);
                                }
                            }).catch(error => {
                                if (error.response.status == 404) {
                                    $("#error").removeClass("has-success");
                                    $("#error").addClass("has-error");
                                    $("#icon").removeClass("fa fa-barcode");
                                    $("#icon").removeClass("fa fa-check");
                                    $("#icon").addClass("glyphicon glyphicon-remove-circle");
                                    $("#message").html("Kode tidak ditemukan");
                                    $("#simpan").attr("disabled", true);
                                }
                            });
                        })

					} else {
                        rows = null;
						row = '<div id="form_qty">'+
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
                                                '<input type="hidden" value="'+response.data.id+'" name="idditribusi">'+
                                                '<input type="hidden" value="'+response.data.iddetail+'" name="iddetail">'+
                                                '<input type="hidden" value="'+response.data.dari+'" name="comp">'+
                                                '<input type="hidden" value="'+response.data.tujuan+'" name="destination">'+
                                                '<input type="hidden" value="'+response.data.itemId+'" name="iditem">'+
                                                '<input type="hidden" value="'+response.data.qty+'" name="qtydistribusi">'+
                                                '<input type="hidden" value="'+response.data.qtySisa+'" name="qtysisa">'+
                                                '<input type="text" id="qty" name="qty" class="qty form-control">'+
                                                '<span class="input-group-addon"><i class="fa fa-cubes"></i></span>' +
                                            '</div>' +
                                            '<span class="help-block"></span>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-md-12 form-group">'+
                                        '<button class="btn btn-primary pull-right" type="button" id="simpan" onclick="simpan()">'+
                                            '<i class="fa fa-floppy-o"></i>'+
                                            '&nbsp;Simpan'+
                                        '</button>'+
                                    '</div>'+
                                '</fieldset>' +
								'</div>';

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
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: baseUrl + '/inventory/penerimaan/distribusi/item-receive/add',
				type: 'post',
				data: $('#form_qtyReceived').serialize(),
				success: function(response){
					if (response == 'Code not found') {
						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Peringatan!",
							content : "Kode tidak ditemukan!",
							color : "#A90329",
							timeout: 5000,
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
					} else if (response == "lengkapi data") {
						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Peringatan!",
							content : "Masukkan kuantitas barang yang diterima!",
							color : "#A90329",
							timeout: 5000,
							icon : "fa fa-times bounce animated"
						});
						$('#qty').focus();
                        $("#error").removeClass("has-success");
                        $("#error").addClass("has-error");
                        $("#icon").removeClass("fa fa-barcode");
                        $("#icon").removeClass("fa fa-check");
                        $("#icon").addClass("glyphicon glyphicon-remove-circle");
                        $("#message").html("Kode tidak ditemukan");
                        $("#simpan").attr("disabled", true);
					} else if (response == "false") {
						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Terjadi kesalahan",
							color : "#A90329",
							timeout: 5000,
							icon : "fa fa-times bounce animated"
						});
					} else {
						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Berhasil",
							content : 'Transaksi Anda berhasil...!',
							color : "#739E73",
							timeout: 5000,
							icon : "fa fa-check bounce animated"
						});
						// $('#myModal').modal('hide');
                        if (rows == "kode") {
                            tbl_code.api().ajax.reload();
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
					}
				}, error:function(x, e) {
					if (x.status == 0) {
						alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
					} else if (x.status == 404) {
						alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
					} else if (x.status == 500) {
						alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
					} else if (e == 'parsererror') {
						alert('Error.\nParsing JSON Request failed.');
					} else if (e == 'timeout'){
						alert('Request Time out. Harap coba lagi nanti');
					} else {
						alert('Unknow Error.\n' + x.responseText);
					}
				}
			})
			
		}

	</script>

@endsection
